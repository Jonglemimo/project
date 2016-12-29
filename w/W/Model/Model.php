<?php

namespace W\Model;

//BASE MODEL
abstract class Model {

	protected $table;
	protected $primaryKey = 'id';
	protected $dbh;

	public function __construct() {
		$this->setTableFromClassName();
		$this->dbh = ConnectionModel::getDbh();
	}

	private function setTableFromClassName() {
		$app = getApp();

		if(empty($this->table)) {
			$className = (new \ReflectionClass($this))->getShortName();
			$tableName = str_replace('Model', '', $className);
			$tableName = ltrim(strtolower(preg_replace('/[A-Z]/', '_$0', $tableName)), '_');
		} else {
			$tableName = $this->table;
		}

		$this->table = $app->getConfig('db_table_prefix') . $tableName;

		return $this;
	}

	//DEFINE TABLE NAME
	public function setTable($table) {
		$this->table = $table;
		return $this;
	}

	//TABLE RETURN
	public function getTable() {
		return $this->table;
	}

	//DEFINE PRIMARY KEY
	public function setPrimaryKey($primaryKey) {
		$this->primaryKey = $primaryKey;
		return $this;
	}

	//RETURN PRIMARY KEY
	public function getPrimaryKey(){
		return $this->primaryKey;
	}

	//RETRIEVE TABLE LINE WITH ACCOUNT NAME
	public function find($id) {
		if (!is_numeric($id)) {
			return false;
		}

		$sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = :id LIMIT 1';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		$sth->execute();

		return $sth->fetch();
	}

    //RETRIEVE NEXT LINE AFTER ACCOUNT NAME
    public function findNext($id) {
        if (!is_numeric($id)) {
            return false;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = (SELECT MIN(id) FROM ' . $this->table . ' WHERE id > :id ) LIMIT 1';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();

        return $sth->fetch();
    }

    //RETRIEVE LAST LINE AFTER ACCOUNT NAME
    public function findPrevious($id) {
        if (!is_numeric($id)){
            return false;
        }

        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey .'  = (SELECT MAX(id) FROM ' . $this->table . ' WHERE id < :id ) LIMIT 1';
        $sth = $this->dbh->prepare($sql);
        $sth->bindValue(':id', $id);
        $sth->execute();

        return $sth->fetch();
    }

    //RETRIEVE ALL TABLE LINES
	public function findAll($orderBy = '', $orderDir = 'ASC', $limit = null, $offset = null) {

		$sql = 'SELECT * FROM ' . $this->table;
		if (!empty($orderBy)){

			if(!preg_match('#^[a-zA-Z0-9_$]+$#', $orderBy)) {
				die('Error: invalid orderBy param');
			}
			$orderDir = strtoupper($orderDir);
			if($orderDir != 'ASC' && $orderDir != 'DESC') {
				die('Error: invalid orderDir param');
			}
			if ($limit && !is_int($limit)){
				die('Error: invalid limit param');
			}
			if ($offset && !is_int($offset)){
				die('Error: invalid offset param');
			}

			$sql .= ' ORDER BY '.$orderBy.' '.$orderDir;
			if($limit){
				$sql .= ' LIMIT '.$limit;
				if($offset){
					$sql .= ' OFFSET '.$offset;
				}
			}
		}

		$sth = $this->dbh->prepare($sql);
		$sth->execute();

		return $sth->fetchAll();
	}

	//DOING A RESEARCH
	public function search(array $search, $operator = 'OR', $stripTags = true) {

		$operator = strtoupper($operator);
		if($operator != 'OR' && $operator != 'AND') {
			die('Error: invalid operator param');
		}

        $sql = 'SELECT * FROM ' . $this->table.' WHERE';
                
		foreach($search as $key => $value) {
			$sql .= " `$key` LIKE :$key ";
			$sql .= $operator;
		}
		if($operator == 'OR') {
			$sql = substr($sql, 0, -3);
		}
		elseif($operator == 'AND') {
			$sql = substr($sql, 0, -4);
		}

		$sth = $this->dbh->prepare($sql);

		foreach($search as $key => $value) {
			$value = ($stripTags) ? strip_tags($value) : $value;
			$sth->bindValue(':'.$key, '%'.$value.'%');
		}
		if(!$sth->execute()) {
			return false;
		}
        return $sth->fetchAll();
	}

	//DELETE A LINE
	public function delete($id) {
		if (!is_numeric($id)) {
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey .' = :id LIMIT 1';
		$sth = $this->dbh->prepare($sql);
		$sth->bindValue(':id', $id);
		return $sth->execute();
	}

	//ADD A LINE
	public function insert(array $data, $stripTags = true) {

		$colNames = array_keys($data);
		$colNamesEscapes = $this->escapeKeys($colNames);
		$colNamesString = implode(', ', $colNamesEscapes);

		$sql = 'INSERT INTO ' . $this->table . ' (' . $colNamesString . ') VALUES (';
		foreach($data as $key => $value){
			$sql .= ":$key, ";
		}

		$sql = substr($sql, 0, -2);
		$sql .= ')';

		$sth = $this->dbh->prepare($sql);
		foreach($data as $key => $value) {
			$value = ($stripTags) ? strip_tags($value) : $value;
			$sth->bindValue(':'.$key, $value);
		}

		if (!$sth->execute()) {
			return false;
		}
		return $this->find($this->lastInsertId());
	}

	//EDIT THE LINE
	public function update(array $data, $id, $stripTags = true) {
		if (!is_numeric($id)) {
			return false;
		}
		
		$sql = 'UPDATE ' . $this->table . ' SET ';
		foreach($data as $key => $value) {
			$sql .= "`$key` = :$key, ";
		}
		$sql = substr($sql, 0, -2);
		$sql .= ' WHERE ' . $this->primaryKey .' = :id';
		$sth = $this->dbh->prepare($sql);

		foreach($data as $key => $value) {
			$value = ($stripTags) ? strip_tags($value) : $value;
			$sth->bindValue(':'.$key, $value);
		}
		$sth->bindValue(':id', $id);

		if(!$sth->execute()) {
			return false;
		}
		return $this->find($id);
	}

	//RETURN
	public function lastInsertId() {
		return $this->dbh->lastInsertId();
	}

	//ESCAPE KEYS
	private function escapeKeys($datas) {
		return array_map(function($val) {
			return '`'.$val.'`';
		}, $datas);
	}	
}