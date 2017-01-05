<?php

namespace Controller;


use W\Controller\Controller;
use \Model\UsersModel;
use Model\VideoModel;
use Model\CommentsModel;

/**
* 
*/
class CommentsController extends \Controller\DefaultController
{
	public function postComment(){
		$text = htmlspecialchars($_POST['text']);
		$shortTitle = $_POST['shortTitle'];
		$idUser = $_SESSION['user']['id'];
		$comment = new CommentsModel();
		$video = $comment->findVideoByShort($shortTitle);
		$idVideo = $video['idVideo'];
		$comment->postComment($text, $idVideo, $idUser);
		$this->showJson(['result' => 'succes']);
	}

	public function getVideoComment(){
		$shortTitle = $_POST['shortTitle'];
		$comment = new CommentsModel();
		$video = $comment->findVideoByShort($shortTitle);
		$idVideo = $video['idVideo'];
		$allComment = $comment->getCommentsByVideo($idVideo);
		$this->show('comment/displayComments', ['comments' => $allComment]);
	}

	public function getPersonnalComment($idUser){

	}
}