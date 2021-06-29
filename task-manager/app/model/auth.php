<?php

namespace app\model;

use core\Session;

class Auth extends \core\Model
{

	/**
	 * Check if admin is logged id
	 * @return bool
	 */
	public function is_admin(){
		return (bool)Session::get('is_admin');
	}

	/**
	 * Check if login and password combination is exists
	 * @param string $login
	 * @param string $password
	 * @return string
	 */
	function checkPasswordMatch($login, $password)
	{
		$sql = 'SELECT count(*) AS `count` FROM `admins` WHERE `login` = :login AND `password` = :password';
		$stmt = $this->db->prepare($sql);
		$stmt->bindParam(':login', $login, \PDO::PARAM_STR);
		$stmt->bindParam(':password', $password, \PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
	}
}
