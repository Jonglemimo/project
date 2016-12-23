<?php
namespace Controller;

use W\Controller\Controller;
use \Model\VideoModel;

class UploadController extends Controller
{
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