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

    function getVideoByCategories($slug,$offset,$nb){
        $sql = 'SELECT categories.name, video.title ,video.id_user, video.shortTitle, video.url, video.description, posters.poster_xs, posters.poster_sm, posters.poster_lg
	            FROM categories
	            LEFT JOIN video ON categories.id = video.id_category
	            LEFT JOIN posters ON posters.id_video = video.id
	            WHERE categories.slug = :slug AND video.encoding = 1
	            ORDER BY date_created DESC
	            LIMIT :offset,:nb';

        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':offset', $offset, \PDO::PARAM_INT);
        $stmt->bindParam(':nb', $nb, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getVideoByCategoriesWithoutCurrent($slug,$id_video){
        $sql = 'SELECT categories.name, video.title ,video.id_user, video.shortTitle, video.url, video.description, posters.poster_xs, posters.poster_sm, posters.poster_lg
	            FROM categories
	            LEFT JOIN video ON categories.id = video.id_category
	            LEFT JOIN posters ON posters.id_video = video.id
	            WHERE categories.slug = :slug AND video.encoding = 1
	            AND video.id != :id_video
	            ORDER BY date_created DESC';
        $stmt = $this->dbh->prepare($sql);
        $stmt->bindParam(':slug', $slug);
        $stmt->bindParam(':id_video', $id_video);

        $stmt->execute();
        return $stmt->fetchAll();
    }

    function getTotalVideos(){
        $sql = 'SELECT count(*) as total FROM video';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();

    }
}

