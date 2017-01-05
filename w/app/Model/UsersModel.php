<?php
namespace Model;

use \W\Model\UsersModel as UModel;

class UsersModel extends UModel {

    public function findVideoById($id, $limit = null) {

        if (!is_numeric($id)) {
            return false;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' 
        LEFT JOIN posters ON posters.id_video = video.id
        WHERE id_user  = :id_user AND encoding = 1 ORDER BY date_created DESC';

        if($limit != null) {
            $sql .= ' LIMIT '.$limit.'';
        }

        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_user', $id);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function findVideoByComment($id, $limit = null) {

        if(!is_numeric($id)) {
            return false;
        }

        $sql = 'SELECT comments.content, comments.date_posted, comments.id_video, users.id AS id_user ,video.title, video.url, video.title, video.shortTitle,posters.poster_sm
                FROM comments
                LEFT JOIN posters ON comments.id_video = posters.id_video
                LEFT JOIN users ON comments.id_user = users.id
                LEFT JOIN video ON comments.id_video = video.id
                WHERE :id_user = comments.id_user AND encoding = 1 ORDER BY date_posted DESC';

        if($limit != null) {
            $sql .= ' LIMIT '.$limit.'';
        }

        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_user', $id);
        $sth->execute();

        return $sth->fetchAll();
    }

}

