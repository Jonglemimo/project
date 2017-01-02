<?php

namespace Model;

use W\Model\Model;

class CategoriesModel extends Model
{
    function getCategories(){
        $sql = 'SELECT *
	            FROM categories';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getVideoByCategories($category){
        $sql = 'SELECT title, shortTitle, url, posters.poster_xs,posters.poster_sm,posters.poster_lg
	            FROM categories
	            LEFT JOIN posters ON video.id = posters.id_video
	            LEFT JOIN categoryVideo ON categories.id = categoryVideo.id_category
	            LEFT JOIN video ON categoryVideo.id_video = video.id
	            WHERE categories.name = :category AND encoding = 0
	            ORDER BY date_created DESC';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':category', $category);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

