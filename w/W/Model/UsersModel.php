<?php

namespace W\Model;

//IDENTIFICATION CLASS
class UsersModel extends Model {

	//CONTRUCT
	public function __construct(){
		$app = getApp();
		$this->setTable($app->getConfig('security_user_table'));
		$this->dbh = ConnectionModel::getDbh();
	}

	//RETRIEVE USER WITH USERNAME OR EMAIL
	public function getUserByUsernameOrEmail($usernameOrEmail) {

		$app = getApp();

		$sql = 'SELECT * FROM ' . $this->table . 
			   ' WHERE ' . $app->getConfig('security_username_property') . ' = :username' . 
			   ' OR ' . $app->getConfig('security_email_property') . ' = :email LIMIT 1';

		$dbh = ConnectionModel::getDbh();
		$sth = $dbh->prepare($sql);
		$sth->bindValue(':username', $usernameOrEmail);
		$sth->bindValue(':email', $usernameOrEmail);
		
		if($sth->execute()) {
			$foundUser = $sth->fetch();
			if($foundUser){
				return $foundUser;
			}
		}
		return false;
	}

	//CHECK IF EMAIL IS IN DATABASE
	public function emailExists($email) {

	   $app = getApp();

	   $sql = 'SELECT ' . $app->getConfig('security_email_property') . ' FROM ' . $this->table .
	          ' WHERE ' . $app->getConfig('security_email_property') . ' = :email LIMIT 1';

	   $dbh = ConnectionModel::getDbh();
	   $sth = $dbh->prepare($sql);
	   $sth->bindValue(':email', $email);

	   if($sth->execute()) {
	       $foundUser = $sth->fetch();
	       if($foundUser){
	           return true;
	       }
	   }
	   return false;
	}

	//CHECK IF USERNAME IS IN DATABASE
	public function usernameExists($username) {

	    $app = getApp();

	    $sql = 'SELECT ' . $app->getConfig('security_username_property') . ' FROM ' . $this->table .
	           ' WHERE ' . $app->getConfig('security_username_property') . ' = :username LIMIT 1';

	    $dbh = ConnectionModel::getDbh();
	    $sth = $dbh->prepare($sql);
	    $sth->bindValue(':username', $username);
	    if($sth->execute()) {
	        $foundUser = $sth->fetch();
	        if($foundUser){
	            return true;
	        }
	    }
	    return false;
	}
}