<?php

namespace Controller;

use Model\VideoModel;
use Services\ImageManagerService;
use Services\HelperService;
use \Model\CategoriesModel;


class VideoController extends \Controller\DefaultController {
	private $uploadTmp   = false;
    private $usersFolder = false;
    private $videoModel  = false;
    private $categoriesModel = false;

	public function __construct() {
        $ds = DIRECTORY_SEPARATOR;
        $this->videoModel = new VideoModel();
        $this->categoriesModel = new CategoriesModel();
        $this->uploadTmp  = dirname(dirname(dirname(__FILE__))).$ds.'tmp';

        if(isset($_SESSION['user'])) {
            $this->usersFolder = dirname(dirname(dirname(__FILE__))).$ds.'public'.$ds.'assets'.DIRECTORY_SEPARATOR.'users'.$ds.$_SESSION['user']['id'];
            if(!file_exists($this->usersFolder)){
                mkdir($this->usersFolder,0755);
            }
        }
    }

    public function search() {


		if (!empty($_POST['search'])) {
			$search = trim($_POST['search']);
			$result = $this->videoModel->getVideosSearch($search);
		} else {
			$search = NULL;
			$result = $this->videoModel->getVideos();
		}
		
		$this->show('video/displayVideo', ['videos' => $result]);
	}

    public function switchSearch(){
        $this->show('video/search');
    }

    public function uploadForm() {


        if(!isset($_SESSION['user'])) {
            $this->redirectToRoute('default_home');
        }

        if(isset($_FILES['files'])) {
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

        if(!empty($_POST)) {

            header('Content-Type: application/json');
            echo json_encode($this->validateForm());
            die;
        }

        $videoEncoding = $this->videoModel->getWhileEncoding($_SESSION['user']['id']);
        $categories = $this->categoriesModel->getCategories();

        if(count($videoEncoding) > 0){

            $this->show('upload/form', ['videoEncoding' => $videoEncoding, 'categories' => $categories]);
        } else {
            $this->show('upload/form', ['categories' => $categories]);
        }
    }

    private function validateForm() {

        $imageResize = new ImageManagerService();

        $errors = array();

        if (empty($_POST['title'])) {
            $errors['title'] = 'Vous devez entrer un titre';

        } elseif (strlen($_POST['title']) < 5) {
            $errors['title'] = 'Votre titre est trop court';
        } else {
            $title = $_POST['title'];
        }

        //vérification description

        if (empty($_POST['description'])) {
            $errors['description'] = 'Vous devez entrer une description';

        } elseif (strlen($_POST['description']) < 20) {
            $errors['description'] = 'Votre description est trop courte';
        } else {
            $description = $_POST['description'];
        }

        if(empty($_POST['category'])){
            $errors['category'] = 'Vous devez entrer une catégorie';

        } else {
            $category = $_POST['category'];
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

        if(count($errors) == 0) {
            $shortTitle = uniqid();
            $output = $this->usersFolder.DIRECTORY_SEPARATOR.$shortTitle.DIRECTORY_SEPARATOR;

            if(!file_exists($output)){
                mkdir($output,0755);
            }

            rename($image,$output.basename($image));
            rename($video,$output.basename($video));

            $this->videoModel->setTable('video');

            $lastVideo = $this->videoModel->insert([
                'url' => basename($video),
                'title' => $title,
                'description' => $description,
                'shortTitle' => $shortTitle,
                'id_category' => $category,
                'id_user' => $_SESSION['user']['id']
            ]);

            $imageInfo = pathinfo($image);


            $outputMin = $output.$imageInfo['filename'].'.xs.'.$imageInfo['extension'];
            $outputMedium = $output.$imageInfo['filename'].'.sm.'.$imageInfo['extension'];
            $outputLarge = $output.$imageInfo['filename'].'.lg.'.$imageInfo['extension'];

            $fullpath = $output.basename($image);

            $imageResize->resize($fullpath ,null, 200, 170,false, $outputMin, false);
            $imageResize->resize($fullpath, null, 320, 240,false, $outputMedium, false);
            $imageResize->resize($fullpath, null, 1200, 1000,false, $outputLarge, false);

            $this->videoModel->setTable('posters');

            $this->videoModel->insert([
                'id_video'  => $lastVideo['id'],
                'poster_xs' => $imageInfo['filename'].'.xs.'.$imageInfo['extension'],
                'poster_sm' => $imageInfo['filename'].'.sm.'.$imageInfo['extension'],
                'poster_lg' => $imageInfo['filename'].'.lg.'.$imageInfo['extension']

            ]);

            //todo transcode
            unlink($fullpath);

            return array('success' => true, 'errors' => $errors);
        } else {
            return array('success' => false, 'errors' => $errors);
        }
    }



/*    private function startTranscoding(){

        $ch = curl_init();

// set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $this->url('cron_transcode'));
        curl_setopt($ch, CURLOPT_HEADER, 0);

// grab URL and pass it to the browser
        curl_exec($ch);

// close cURL resource, and free up system resources
        curl_close($ch);
    }*/


    public function getType($file){

        $type = mime_content_type($file);

        if(preg_match('/image/',$type)){
            return 'image';
        } elseif (preg_match('/video/',$type)){
            return 'video';
        } else {
            return 'unknown';
        }
    }


    public function handleDuplicate($file){

        $helper = new HelperService();
        $info = pathinfo($file);

        if(file_exists($file)){

            $name = $helper->create_slug($info['filename'].'-'.uniqid()).'.'.$info['extension'];
            return $this->uploadTmp.DIRECTORY_SEPARATOR.$name;

        } else {

            $name = $helper->create_slug($info['filename']).'.'.$info['extension'];
            return $this->uploadTmp.DIRECTORY_SEPARATOR.$name;
        }
    }

    public function watch($shortTitle) {
        if(isset($shortTitle)){
            $video = $this->videoModel->getVideo($shortTitle);
            $videoByCategories = $this->categoriesModel->getVideoByCategoriesWithoutCurrent($video['slug'],$vi);
            if(isset($video) && !empty($video)){
                $this->show('video/watch', ['video' => $video, 'videoByCategories' => $videoByCategories]);
            }else{
                $this->redirectToRoute('default_home');
            }
        }else{
            $this->redirectToRoute('default_home');
        }


/*        if (isset($_GET['video'])) {
            $url = $_GET['video'];
            //Tentative de vérification

            if($this->videoModel->exist($url)){ // renvois toujours TRUE sans raison
                $this->watchVideo($url);
            } else {
                $this->redirectToRoute('default_home');
            }
        } else {
            $this->redirectToRoute('default_home');
        }*/
    }


    public function watchVideo($url){

        $result = $this->videoModel->getVideo($url);

        $this->show('video/watch', ['video' => $result]);
    }

    public function deleteVideoById() {


        require_once __DIR__.'/../../vendor/perchten/rmrdir/src/rmrdir.php';


        if(isset($_POST['id']) && is_numeric($_POST['id'])) {

            $idVideo = $_POST['id'];

            $this->videoModel->setTable('posters');
            $poster = $this->videoModel->getPosterByIdVideo($idVideo);
            $deletePoster = $this->videoModel->delete($poster['id']);

            if($deletePoster) {

                $this->videoModel->setTable('video');
                $video = $this->videoModel->find($idVideo);


                $path =  __DIR__ . ''.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR.$video['id_user'].DIRECTORY_SEPARATOR.$video['shortTitle'];

                $deleteVideo = $this->videoModel->delete($idVideo);

                if($deleteVideo) {

                   rmrdir($path);
                    $this->showJson(['sucess' => true]);
                } else {
                    $this->showJson(['sucess' => false]);
                }
            } else {
                $this->showJson(['sucess' => false]);
            }

        } else {
            $this->redirectToRoute('default_home');
        }
    }

    public function editVideo ($id) {

        if(!isset($_SESSION['user'])) {
            $this->redirectToRoute('default_home');
        }

        if(!empty($id) && is_numeric($id)) {

            $this->videoModel->setTable('video');
            $video = $this->videoModel->find($id);

            if($video){


                $this->videoModel->setTable('categories');
                $currentCategory = $this->videoModel->find($video['id_category']);
                $categories = $this->categoriesModel->getCategories();


                $infoVideo = array(
                    'video'  => $video,
                    'currentCategory' => $currentCategory,
                    'categories'      => $categories
                );

                if(!empty($_POST)){

                    header('Content-Type: application/json');
                    echo json_encode($this->validateEditVideo($id));
                    die;

                }

                $this->show('video/edit', ['infoVideo' => $infoVideo] );
            } else {
                $this->redirectToRoute('default_home');
            }

        } else {
            $this->redirectToRoute('default_home');
        }
    }

    private function validateEditVideo($id) {
        $errors = array();

        if (empty($_POST['title'])) {
            $errors['title'] = 'Vous devez entrer un titre';

        } elseif (strlen($_POST['title']) < 5) {
            $errors['title'] = 'Votre titre est trop court';
        } else {
            $title = $_POST['title'];
        }

        //vérification description
        if (empty($_POST['description'])) {
            $errors['description'] = 'Vous devez entrer une description';

        } elseif (strlen($_POST['description']) < 20) {
            $errors['description'] = 'Votre description est trop courte';
        } else {
            $description = $_POST['description'];
        }

        if(!is_numeric($_POST['category'])) {
            $errors['category'] = 'Cette catégory n\'est pas valide';

        }else{
            $this->categoriesModel->setTable('categories');

            if(!$this->categoriesModel->find($_POST['category'])){


                $errors['category'] = 'Cette catégory n\'est pas valide';
            }
        }

        if(empty($_POST['category'])) {
            $errors['category'] = 'Vous devez entrer une catégorie';

        } else {
            $category = $_POST['category'];
        }

        $this->videoModel->setTable('video');
        if(count($errors) == 0){
            $this->videoModel->update([
                'title' => $title,
                'description' => $description,
                'id_category' => $category
            ],$id);

            return array('success' => true, 'errors' => $errors);
        } else {
            return array('success' => false, 'errors' => $errors);
        }
    }

    public function getVote(){
        if (isset($_SESSION['user']['id'])) {
            if (!empty($_POST['shortTitle'])) {
                $vote = new VideoModel();
                $idVideo = $this->getIdVideo($_POST['shortTitle']);
                $voteExist = $vote->voteExist($_SESSION['user']['id'], $idVideo);
                if (isset($voteExist['stars'])) {
                    $stars = $voteExist['stars'];
                    $this->showJson(['vote' => $stars]);
                } else {
                    $this->showJson(['vote' => 0]);
                } 
            } 
        }
    }

    public function vote(){
        if (isset($_SESSION['user']['id'])) {
            if (!empty($_POST['shortTitle'])) {
                $vote = new VideoModel();
                $idVideo = $this->getIdVideo($_POST['shortTitle']);
                $voteExist = $vote->voteExist($_SESSION['user']['id'], $idVideo);
                if (count($voteExist) > 1 ) {
                    $this->showJson(['response' => '<p class="what">Vous avez déjà voté pour cette vidéo</p>' ,'change' => true, 'vote' => $_POST['stars']]);
                } else {

                  
                    $vote->vote($_SESSION['user']['id'] , $idVideo , $_POST['stars']);
                    $this->updateNote($idVideo);
                    $this->showJson(['response' => '<p class="correct">Votre vote a bien été enregistré</p>' , 'change' => false]);
                } 
            } else {
                $this->showJson(['response' => false]);
            }
        } else {
            $this->showJson(['response' => '<p class="meh">Veuillez vous connecter</p>' , 'change' => false]);
        }
        
    }

    public function updateVote(){
        $vote = new VideoModel();

        $idVideo = $this->getIdVideo($_POST['shortTitle']);
        $vote->updateVote($_SESSION['user']['id'] , $idVideo , $_POST['stars']);
        $this->updateNote($idVideo);
        $note = $this->getNote($idVideo);
        $this->showJson(['response' => '<p class="correct">Modification de vote enregistrée</p>']);

    }

    public function updateNote($idVideo){
        $note = new VideoModel();
        $note->updateNote($idVideo);
    }

    public function getNote(){
        $note = new VideoModel();
        $idVideo = $this->getIdVideo($_POST['shortTitle']);
        $getNote = $note->getNote($idVideo);
        $this->showJson(['note' => $getNote]);
    }

    public function getIdVideo($shortTitle){
        $find = new videoModel();
        $video = $find->findVideoByShort($_POST['shortTitle']);
        $idVideo = $video['idVideo'];
        return $idVideo;
    }
}