<?php 

namespace Model;

use \PDO;
use \W\Model\Model;
use Model\VideoModel;

/**
* 
*/
class CommentsModel extends VideoModel
{
	
	function postComment($text, $idVideo, $idUser)
	{
		$sql = 'INSERT INTO comments(content, id_user ,id_video) 
				VALUES (?, ?, ?) ';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1 , $text );
		$stmt->bindValue(2 , $idUser );
		$stmt->bindValue(3 , $idVideo );
		$stmt->execute();
	}

	public function getCommentsByVideo($idVideo){
		$sql = 'SELECT content, date_posted, username, users.avatar, users.id
				FROM comments
				INNER JOIN users ON id_user = users.id 
				WHERE id_video = :idVideo
				ORDER BY date_posted DESC';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':idVideo' , $idVideo );
		$stmt->execute();
		return $stmt->fetchAll();
	}
}