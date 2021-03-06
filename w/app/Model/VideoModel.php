<?php

namespace Model;

use \PDO;
use \W\Model\Model;

class VideoModel extends Model {

    function countVideos(){
        $sql = 'SELECT count(*) as total
				FROM video
				WHERE video.encoding = 1
				ORDER BY date_created DESC, title';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();
    }

	function getVideos($offset,$nb) {

		$sql = 'SELECT *,video.id_user as userId 
				FROM video
				INNER JOIN posters
				WHERE video.id = posters.id_video
				AND video.encoding = 1
				ORDER BY date_created DESC, title
				LIMIT :offset, :nb';
		$stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':offset' , $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':nb' , $nb, \PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}

    function countVideosSearch($search){

        $sql = 'SELECT count(*) as total
				FROM video
				WHERE video.encoding = 1
				AND (video.description LIKE :search OR video.title LIKE :search)
				ORDER BY date_created DESC, title';
        $search = '%'.$search.'%';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':search' , $search);
        $stmt->execute();
        return $stmt->fetch();
    }


    function getVideosSearch($search,$offset,$nb){

		$sql = 'SELECT *,video.id_user as userId 
				FROM video
				INNER JOIN posters
				WHERE video.id = posters.id_video
				AND video.encoding = 1
				AND (video.description LIKE :search OR video.title LIKE :search)
				ORDER BY date_created DESC, title
				LIMIT :offset, :nb';
		$search = '%'.$search.'%';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(':search' , $search);
		$stmt->bindParam(':offset' , $offset, \PDO::PARAM_INT);
		$stmt->bindParam(':nb' , $nb, \PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
	}


	function getVideo($url){
		$sql = 'SELECT video.id,video.url ,video.title, video.description , video.date_created, video.shortTitle, users.username, video.id_user as userId , posters.poster_lg, categories.slug
				FROM video
				LEFT JOIN users ON video.id_user = users.id
				LEFT JOIN categories ON video.id_category = categories.id
				LEFT JOIN posters ON posters.id_video = video.id
				WHERE video.shortTitle = :url';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(':url', $url);
		$stmt->execute();
		return $stmt->fetch();
	}

	public function exist($search)
    {
        $sql = 'SELECT COUNT(*)
				FROM video 
				WHERE shortTitle = :search';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        if (count($stmt->fetch()) > 0) {
            return true;
        } else {
            return false;
        }
    }

	function fileExist($file){
	    $sql = 'SELECT *
	            FROM video
	            WHERE url = :file or poster = :file';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':file' , $file);
        $stmt->execute();
        return;

    }


    function getWhileEncoding($id){
        $sql = 'SELECT video.id, title, shortTitle, url, posters.poster_xs,posters.poster_sm,posters.poster_lg,encoding
	            FROM video
	            LEFT JOIN posters on video.id = posters.id_video
	            WHERE id_user = :id_user AND (encoding = 0 OR encoding = 2)
	            ORDER BY date_created ASC';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id_user' , $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getPosterByIdVideo($id){
        $sql = 'SELECT *
	            FROM posters
	            WHERE posters.id_video = :id
	            LIMIT 1';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id' , $id);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findVideoByShort($shortTitle){
    	$sql = 'SELECT * , video.id as idVideo 
    			FROM video 
    			WHERE shortTitle = :short';
    	$stmt = $this->dbh->prepare($sql);
    	$stmt->bindParam(':short' ,$shortTitle);
    	$stmt->execute();
    	return $stmt->fetch();
    }

    public function voteExist($idUser, $idVideo){
    	$sql = 'SELECT * 
    			FROM votesusers
    			WHERE id_users = :idUser
    			AND id_video = :idVideo';
    	$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(':idUser' , $idUser );
		$stmt->bindParam(':idVideo' , $idVideo );
		$stmt->execute();
		return $stmt->fetch();
    }

    public function vote($idUser , $idVideo, $stars){
    	$sql = "INSERT INTO votesusers (id, stars, id_users, id_video)
    			VALUES (NULL ,?, ? , ? )";
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(1 , $stars );
		$stmt->bindValue(2 , $idUser );
		$stmt->bindValue(3 , $idVideo );
		$stmt->execute();
		return ;
    }

    public function updateVote($idUser , $idVideo, $stars){
    	$sql = "UPDATE votesusers 
    			SET stars = :stars
    			WHERE id_users = :idUser 
    			AND id_video = :idVideo";
    	$stmt = $this->dbh->prepare($sql);
		$stmt->bindValue(':stars' , $stars );
		$stmt->bindValue(':idUser' , $idUser );
		$stmt->bindValue(':idVideo' , $idVideo );
		$stmt->execute();
    }

    public function getNote($idVideo){
    	$sql = 'SELECT *, SUM(stars)/ COUNT(*) as note
    			FROM votesusers
    			WHERE id_video = :idVideo
    			GROUP BY id_video';
    	$stmt = $this->dbh->prepare($sql);
    	$stmt->bindValue(':idVideo' , $idVideo );
    	$stmt->execute();
    	$result = $stmt->fetch();
    	return $result['note'];
    }

    public function updateNote($idVideo){
    	$note = $this->getNote($idVideo);
    	$sql = 'UPDATE video 
    			SET note = :note
    			WHERE video.id = :idVideo';
    	$stmt = $this->dbh->prepare($sql);
    	$stmt->bindValue(':note' , $note );
    	$stmt->bindValue(':idVideo' , $idVideo );
    	$stmt->execute();
    }
}