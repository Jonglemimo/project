<?php

namespace Model;

use \W\Model\UsersModel as UModel;

class RecoveryTokenModel extends UModel {

    function createToken($id_user,$token) {
        $sql = 'INSERT INTO recoveryTokens
                (id_user,token)
                VALUES (:id_user,:token)';

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':id_user', $id_user);
        $sth->bindParam(':token', $token);
        $sth->execute();
    }

    function getIdFromToken($token) {

        $sql = 'SELECT id_user
            FROM recoveryTokens
            WHERE token = :token';

        $sth = $this->dbh->prepare($sql);
        $sth->bindParam(':token',$token);
        $sth->execute();

        return $sth->fetchColumn();
    }

    public function deleteToken($id) {
        if (!is_numeric($id)) {
            return false;
        }

        $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey .' = :id_user';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id_user', $id);
        return $sth->execute();
    }
}

