<?php

namespace core;

class Session
{
	public function __construct(){
		$this->start();
		// Preparing flash messages
		self::set('flash', self::get('wait_flash'));
		self::set('wait_flash', NULL);
	}

	/**
	 * Start session
	 */
	private function start(){
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 */
	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public static function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	/**
	 * @param string $key
	 * @param string|array $value
	 */
	public static function set_flash($key, $value)
	{
		self::set('wait_flash', [$key => $value]);
	}

	/**
	 * @param string $key
	 * @return mixed
	 */
	public static function get_flash($key)
	{
		return isset(self::get('flash')[$key]) ? self::get('flash')[$key] : NULL;
	}
}
