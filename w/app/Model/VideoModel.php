<?php

namespace Model;

use \W\Model\Model;

class VideoModel extends Model {

	function getVideo() {

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

	function getVideoSearch($search) {
		
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

}