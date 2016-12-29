<?php

namespace Controller;

use W\Controller\Controller;
use Model\VideoModel;
use Services\ImageManagerService;


class VideoController extends Controller
{
	private $uploadTmp   = false;
    private $usersFolder = false;
    private $ffmpegBin   = false;
    private $ffprobeBin  = false;

	public function __construct()
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->uploadTmp = dirname(dirname(dirname(__FILE__))).$ds.'tmp';

        if(isset($_SESSION['user'])){
            $this->usersFolder = dirname(dirname(dirname(__FILE__))).$ds.'public'.$ds.'assets'.DIRECTORY_SEPARATOR.'users'.$ds.$_SESSION['user']['id'];
            if(!file_exists($this->usersFolder)){
                mkdir($this->usersFolder,0755);
            }

            putenv('TMPDIR='.dirname(dirname(dirname(__FILE__))).$ds.'php-tmp');

            $os = new \Tivie\OS\Detector();
            $ffmpegPath = dirname(dirname(dirname(__FILE__))).$ds.'bin';
            if($os->getType() == 33){
                //OSX
                $this->ffmpegBin = $ffmpegPath.$ds.'osx'.$ds.'ffmpeg';
                $this->ffprobeBin = $ffmpegPath.$ds.'osx'.$ds.'ffprobe';
            }else if($os->getType() == 10){
                if(PHP_INT_SIZE == 8){
                    // Windows 64
                    $this->ffmpegBin = $ffmpegPath.$ds.'windows'.$ds.'64'.$ds.'ffmpeg.exe';
                    $this->ffprobeBin = $ffmpegPath.$ds.'windows'.$ds.'64'.$ds.'ffprobe.exe';

                }else{
                    // Windows 32
                    $this->ffmpegBin = $ffmpegPath.$ds.'windows'.$ds.'32'.$ds.'ffmpeg.exe';
                    $this->ffprobeBin = $ffmpegPath.$ds.'windows'.$ds.'32'.$ds.'ffprobe.exe';
                }
            }else{
                //unknown
            }
        }
    }

    function search()
	{

		$videos = new VideoModel();

		if (!empty($_POST['search'])) {
			$search = trim($_POST['search']);
			$result = $videos->getVideosSearch($search);
		} else {
			$search = NULL;
			$result = $videos->getVideos();
		}
		
		$this->show('video/displayVideo', ['videos' => $result]);
	}

    public function uploadForm(){

	    $videoModel = new VideoModel();

        if(!isset($_SESSION['user'])){
            $this->redirectToRoute('default_home');
        }

        if(isset($_FILES['files'])){
            $info = ['success' => false, 'file' => false, 'type' => false];
            $name = $_FILES['files']['name'][0];
            $destination = $this->handleDuplicate($this->uploadTmp.DIRECTORY_SEPARATOR.$name);
            if(move_uploaded_file($_FILES['files']['tmp_name'][0], $destination)){
                $info['success'] = true;
                $info['file'] = basename($destination);
                $info['type'] = $this->getType($destination);
            }
            header('Content-Type: application/json');
            echo json_encode($info);
            die;
        }

        if(!empty($_POST)){

            header('Content-Type: application/json');
            echo json_encode($this->validateForm());
            die;
        }
        $videoEncoding = $videoModel->getWhileEncoding($_SESSION['user']['id']);
        $this->show('upload/form', ['videoEncoding' => $videoEncoding]);

    }

    private function validateForm(){

        $videoModel = new VideoModel();
        $imageResize = new ImageManagerService();

        $errors = array();

        if (empty($_POST['title'])) {
            $errors['title'] = 'Vous devez entrer un titre';

        } elseif (strlen($_POST['title']) < 5) {
            $errors['title'] = 'Votre titre est trop court';
        } else {
            $title = $_POST['title'];
        }

        //vérification lastname

        if (empty($_POST['description'])) {
            $errors['description'] = 'Vous devez entrer une description';

        } elseif (strlen($_POST['description']) < 20) {
            $errors['description'] = 'Votre description est trop courte';
        } else {
            $description = $_POST['description'];
        }

        if (empty($_POST['video'])) {
            $errors['video'] =  'Vous devez upload une vidéo';
        } elseif (!file_exists($this->uploadTmp.DIRECTORY_SEPARATOR.$_POST['video'])) {
            $errors['video'] = 'La vidéo est introuvable';
        } else {
            $video = $this->uploadTmp.DIRECTORY_SEPARATOR.$_POST['video'];
        }

        if (empty($_POST['image'])) {
            $errors['image'] =  'Vous devez upload une image';

        } elseif (!file_exists($this->uploadTmp.DIRECTORY_SEPARATOR.$_POST['image'])) {
            $errors['image'] = 'Votre image est introuvable';
        } else {
            $image = $this->uploadTmp.DIRECTORY_SEPARATOR.$_POST['image'];
        }

        if(count($errors) == 0){
            $shortTitle = uniqid();
            $output = $this->usersFolder.DIRECTORY_SEPARATOR.$shortTitle.DIRECTORY_SEPARATOR;

            if(!file_exists($output)){
                mkdir($output,0755);

            }

            rename($image,$output.basename($image));
            rename($video,$output.basename($video));




            $videoModel->setTable('video');

            $lastVideo = $videoModel->insert([
                'url' => basename($video),
                'title' => $title,
                'description' => $description,
                'shortTitle' => $shortTitle,
                'id_user' => $_SESSION['user']['id']
            ]);

            $imageInfo = pathinfo($image);


            $outputMin = $output.$imageInfo['filename'].'.xs.'.$imageInfo['extension'];
            $outputMedium = $output.$imageInfo['filename'].'.sm.'.$imageInfo['extension'];
            $outputLarge = $output.$imageInfo['filename'].'.lg.'.$imageInfo['extension'];

            $fullpath = $output.basename($image);

            $imageResize->resize($fullpath ,null, 180, 135,false, $outputMin, false);
            $imageResize->resize($fullpath, null, 320, 240,false, $outputMedium, false);
            $imageResize->resize($fullpath, null, 1200, 1000,false, $outputLarge, false);

            $videoModel->setTable('posters');
            $videoModel->insert([
                'id_video'  => $lastVideo['id'],
                'poster_xs' => $imageInfo['filename'].'.xs.'.$imageInfo['extension'],
                'poster_sm' => $imageInfo['filename'].'.sm.'.$imageInfo['extension'],
                'poster_lg' => $imageInfo['filename'].'.lg.'.$imageInfo['extension']

            ]);

            unlink($fullpath);

            return array('success' => true, 'errors' => $errors);
        }else{
            return array('success' => false, 'errors' => $errors);
        }
    }

    private function getType($file){
        $type = mime_content_type($file);

        if(preg_match('/image/',$type)){
            return 'image';
        }elseif (preg_match('/video/',$type)){
            return 'video';
        }else {
            return 'unknown';
        }
    }

    private function handleDuplicate($file){

        if(file_exists($file)){
            $info = pathinfo($file);
            $name = $info['filename'].'-'.uniqid().'.'.$info['extension'];

            return $this->uploadTmp.DIRECTORY_SEPARATOR.$name;


        }else {
            return $file;
        }
    }


    public function watch(){
        if (isset($_GET['video'])) {
            $url = $_GET['video'];
            //Tentative de vérification
            $video = new VideoModel();
            if($video->exist($url)){ // renvois toujours TRUE sans raison
                $this->watchVideo($url);
            } else {
                $this->redirectToRoute('default_home');
            }
        } else {
            $this->redirectToRoute('default_home');
        }
    }

    public function watchVideo($url){
        $video = new VideoModel();
        $result = $video->getVideo($url);
        $this->show('video/watch', ['video' => $result]);
    }


    private function transcode(){

        if(!$this->ffprobeBin || !$this->ffmpegBin){
            return false;
        }
        $ffmpeg = \FFMpeg\FFMpeg::create(array(
            'ffmpeg.binaries' => $this->ffmpegBin,
            'ffprobe.binaries' => $this->ffprobeBin
        ));

        $test = '/Users/Helda/Sites/Formation/Cours/group-project/project/w/public/users/2/586428ddc76d0/Scream.Queens.2015.VOSTFR.S02E10.HDTV.XViD-EXTREME.avi';

        $output = dirname($test).DIRECTORY_SEPARATOR.'test.webm';

        $video = $ffmpeg->open($test);
        $video->save(new \FFMpeg\Format\Video\WebM(), $output);

    }


}