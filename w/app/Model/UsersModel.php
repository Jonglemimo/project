<?php
namespace Model;

use \W\Model\UsersModel as UModel;

class UsersModel extends UModel
{

    function createToken($id_user,$token){
        $sql = 'INSERT INTO recoveryTokens
                (id_user,token)
                VALUES (:id_user,:token)';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id_user',$id_user);
        $sth->bindParam(':token',$token);
        $sth->execute();
    }

    public function findVideoById($id, $limit = null)
    {
        if (!is_numeric($id)){
            return false;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id_user  = :id_user ORDER BY date_created DESC';
        if($limit != null){
            $sql .= ' LIMIT '.$limit.'';
        }
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_user', $id);
        $sth->execute();

        return $sth->fetchAll();
    }

    public function findVideoByComment($id,$limit = null)
    {
        if(!is_numeric($id)){
            return false;
        }

        $sql = 'SELECT content, date_posted, id_video, video.url, video.title
                FROM comments
                LEFT JOIN video ON comments.id_video = video.id
                LEFT JOIN users ON comments.id_user = users.id
                WHERE :id_user = comments.id_user ORDER BY date_posted DESC';

        if($limit != null){
            $sql .= ' LIMIT '.$limit.'';
        }
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_user', $id);
        $sth->execute();

        return $sth->fetchAll();
    }

    function getIdFromToken($token){
        $sql = 'SELECT id_user
                FROM recoveryTokens
                WHERE token = :token';
        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':token',$token);
        $sth->execute();
        return $sth->fetchColumn();
    }

    public function deleteToken($id)
    {
        if (!is_numeric($id)){
            return false;
        }

        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey .' = :id_user';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_user', $id);
        return $sth->execute();
    }
}