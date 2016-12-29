<?php
namespace Controller;

use W\Controller\Controller;
use Model\VideoModel;

class VideoController extends Controller
{
	
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

        $errors = array();

        if(isset($_POST['addMovie'])){

            if(empty($_POST['pictureTitle'])){
                $errors['pictureTitle'] = true;
            }else{
                $pictureTitle = trim($_POST['pictureTitle']);
            }

            if(empty($_POST['pictureUrl'])){
                $errors['pictureUrl'] = true;
            }

            if(empty($_POST['videoTitle'])){
                $errors['videoTitle'] = true;
            }else{
                $videoTitle = trim($_POST['videoTitle']);
            }

            if(empty($_POST[''])){

            }

        }else{
            $this->show('upload/form');
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


}