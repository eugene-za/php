<?php

namespace core;

class App
{
	public static $config = [];

	function __construct()
	{
		// Set up App configs
		self::$config = require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
		$this->route();
	}

	/**
	 * Route client request
	 */
	private function route()
	{
		$url_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
		$routes = explode('/', trim($url_path, '/'));

		$controller_name = '\app\controller\\' . (array_shift($routes) ?: self::$config['default_controller']);
		$action_name = array_shift($routes) ?: self::$config['default_action'];

		try {
			$controller = new $controller_name;
			if (!method_exists($controller, $action_name)) {
				throw new \Exception('Action ' . $action_name . ' does not described.');
			}
			call_user_func_array([$controller, $action_name], $routes);
		} catch (\Exception $e) {
			$controller = new \app\controller\error;
			$controller->not_found("PHP error: " . $e->getMessage());
		}
	}
}
