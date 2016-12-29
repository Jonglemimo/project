<?php

namespace W\Model;

use \PDO;
use \PDOException;

//HANDLING CONNECTION TO DATABASE
class ConnectionModel {

	private static $dbh;

	//CREATE A CONNEXION OR RETURN IT IF EXIST
	public static function getDbh() {
		if(!self::$dbh) {
			self::setNewDbh();
		}
		return self::$dbh;
	}

	//CREATE A NEW CONNEXION ON DATABASE
	public static function setNewDbh() {

		$app = getApp();
		
		try {
		    self::$dbh = new PDO('mysql:host='.$app->getConfig('db_host').';dbname='.$app->getConfig('db_name'), $app->getConfig('db_user'), $app->getConfig('db_pass'), array(
		        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
		        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
		        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
		    ));
		} catch (PDOException $e) {
		    echo 'Erreur de connexion : ' . $e->getMessage();
		}
	}
}