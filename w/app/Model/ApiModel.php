<?php

namespace Model;

use W\Model\Model;

class ApiModel extends Model
{
    public function checkCurrentTranscoding()
    {
        $sql = 'SELECT id
	            FROM video
	            WHERE encoding = 2';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return count($stmt->fetchAll()) > 0;

    }

    public function getNextNotTranscoded()
    {
        $sql = 'SELECT id, url, id_user, shortTitle
                FROM video
                WHERE encoding = 0 
                ORDER BY date_created ASC
                LIMIT 1';
        $stmt = $this->dbh->prepare($sql);
        $stmt->execute();
        return $stmt->fetch();

    }
}