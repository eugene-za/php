<?php
namespace core;

use PDO;

class Model
{

	// Database instance
	public $db;

	function __construct()
	{
		try {
			$this->db = new PDO('mysql:host=' . App::$config['database']['hostname']
				. ';dbname=' . App::$config['database']['dbname'],
				App::$config['database']['username'],
				App::$config['database']['password'],
				[PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
		} catch (\PDOException $e) {
			die('Database error: ' . $e->getMessage());
		}
	}

}
