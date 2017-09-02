<?php

namespace pviojo\DB;

class DB{

	private $conn = null;

	function __construct($config){
		//Set default config
		$config = array_merge(['schema'=>'', 'charset'=>'utf8'], $config);

		$dsn = $config['driver'] . ":host=" . $config['host'] . ";dbname=" . $config['schema'] . ";charset=" . $config['charset'];

		$this->conn = new \PDO($dsn, $config['username'], $config['password']);
	}

	function queryFirst($query, $parameters = []){
		$data = $this->query($query, $parameters);
		if(empty($data)){
			return [];
		}
		return $data[0];
	}

	function query($query, $parameters = []){
		$stm = $this->conn->prepare($query);
		$stm->execute($parameters);
		if(empty($stm)){
			return [];
		}
		$stm->setFetchMode(\PDO::FETCH_ASSOC);
		return $stm->fetchAll();
	}

}
