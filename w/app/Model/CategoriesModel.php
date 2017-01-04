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

    function getVideoByCategories($slug){
        $sql = 'SELECT categories.name, video.title,video.id_user, video.shortTitle, video.url, video.description, posters.poster_xs, posters.poster_sm, posters.poster_lg
	            FROM categories
	            LEFT JOIN video ON categories.id = video.id_category
	            LEFT JOIN posters ON posters.id_video = video.id
	            WHERE categories.slug = :slug AND video.encoding = 1
	            ORDER BY date_created DESC';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

