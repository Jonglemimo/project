<?php
namespace Controller;

use W\Controller\Controller;
use Model\VideoModel;
use Services\ImageManagerService;

class VideoController extends Controller
{
	private $uploadTmp = false;
	private $videosFolder = false;
	private $imagesFolder = false;

	public function __construct()
    {
        $ds = DIRECTORY_SEPARATOR;
        $this->uploadTmp = dirname(dirname(dirname(__FILE__))).$ds.'tmp';
        $this->videosFolder = dirname(dirname(dirname(__FILE__))).$ds.'public'.$ds.'assets'.$ds.'uploads'.$ds.'videos';
        $this->imagesFolder = dirname(dirname(dirname(__FILE__))).$ds.'public'.$ds.'assets'.$ds.'uploads'.$ds.'images';

    }

    function search()
	{
		$videos = new VideoModel();

		if (!empty($_POST['search'])) {
			$search = trim($_POST['search']);
			$result = $videos->getVideoSearch($search);
		} else {
			$search = NULL;
			$result = $videos->getVideo();
		}

		
		$this->show('video/displayVideo', ['videos' => $result]);

	}
 
    public function uploadForm(){

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

        if(isset($_POST['formUpload'])){
            print_r($_POST);
            die;
        }

        if(!empty($_POST)){

            header('Content-Type: application/json');
            echo json_encode($this->validateForm());
            die;
        }

        $this->show('upload/form');

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
            rename($image,$this->imagesFolder.DIRECTORY_SEPARATOR.basename($image));
            rename($video,$this->videosFolder.DIRECTORY_SEPARATOR.basename($video));

            $videoModel->setTable('video');
            $videoModel->insert([
                'title' => $title,
                'description' => $description,
                'url' => basename($video),
                'poster' => basename($image),
                'id_user' => $_SESSION['user']['id']
            ]);


                $outputMin = $this->imagesFolder.DIRECTORY_SEPARATOR.'min'.DIRECTORY_SEPARATOR.basename($image);
                $outputMedium = $this->imagesFolder.DIRECTORY_SEPARATOR.'medium'.DIRECTORY_SEPARATOR.basename($image);
                $outputLarge = $this->imagesFolder.DIRECTORY_SEPARATOR.'large'.DIRECTORY_SEPARATOR.basename($image);

                $fullpath = $this->imagesFolder.DIRECTORY_SEPARATOR.basename($image);

                $imageResize->resize( $fullpath ,null, 250, 200,false, $outputMin, false);
                $imageResize->resize($fullpath, null, 450, 400,false, $outputMedium, false);
                $imageResize->resize($fullpath, null, 1200, 1000,false, $outputLarge, false);


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

}