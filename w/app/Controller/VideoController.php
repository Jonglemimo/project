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
			$result = $videos->getVideoSearch($search);
		} else {
			$search = NULL;
			$result = $videos->getVideo();
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


}