<?php

namespace Model;

use \W\Model\Model;

class VideoModel extends Model {

	function getVideos() {

		$sql = 'SELECT *, SUM(stars)/ COUNT(*) as note
				FROM votesusers
				INNER JOIN video
				WHERE video.id = id_video
				GROUP BY id_video
				ORDER BY note DESC, title';

		$stmt = $this->dbh->prepare($sql);
		$stmt->execute();
		return $stmt->fetchAll();
	}


	function getVideosSearch($search){

		$sql = 'SELECT *, SUM(stars)/ COUNT(*) as note
				FROM votesusers
				INNER JOIN video
				WHERE video.id = id_video 
				AND (video.description LIKE :search OR video.title LIKE :search)
				GROUP BY id_video
				ORDER BY note DESC, title';
		$search = '%'.$search.'%';
		$stmt = $this->dbh->prepare($sql);
		$stmt->bindParam(':search' , $search);
		$stmt->execute();
		return $stmt->fetchAll();
	}


	function getVideo($url){
		$sql = 'SELECT video.url ,video.title, video.description , video.date_created, video.poster, users.username, SUM(stars)/ COUNT(*) as note
				FROM votesusers
				INNER JOIN video
				INNER JOIN users
				WHERE video.shortTitle = :url 
				AND video.id_user = users.id';
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
        $sql = 'SELECT title, shortTitle, url, posters.poster_xs,posters.poster_sm,posters.poster_lg
	            FROM video
	            LEFT JOIN posters on video.id = posters.id_video
	            WHERE id_user = :id_user AND (encoding = 0 OR encoding = 2)
	            ORDER BY date_created DESC';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':id_user' , $id);
        $stmt->execute();
        return $stmt->fetchAll();
    }



}