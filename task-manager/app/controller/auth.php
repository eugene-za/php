<?php

namespace app\controller;

use app\model;
use core\Session;
use core\validator;

class Auth extends \core\Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * /auth page(login)
	 */
	function index()
	{
		if (!isset($_SESSION['login'])) {
			// Set defaults
			$this->page_data['page_title'] = 'Login';
			$this->page_data['page_header'] = 'Login Page';

			// If isset POST REQUEST
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				$this->validator = new Validator();

				// Get needed fields from POST REQUEST and clear they from spaces
				$post_data = clearPostData(['login','password']);

				// Validate fields
				foreach ($post_data as $k => $v) {
					$this->page_data['errors'][$k] = $this->validator->check($k, $v);
				}

				// If form has not validator errors
				if (!$this->page_data['errors']['login']
					&& !$this->page_data['errors']['password']
				) {

					// Prepare POST inputs
					$post_data['login'] = filter_var($post_data['login'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
					$post_data['password'] = md5($post_data['password'] . \core\App::$config['password_salt']);

					// Check if admin (Login and Password combination) exists in DB
					$result = $this->auth->checkPasswordMatch($post_data['login'], $post_data['password']);

					if($result){

						// Set success message
						Session::set_flash('page_alerts', ['success' => 'Hello, ' . $post_data['login'] . '.']);

						// Login
						Session::set('is_admin', TRUE);

						// Redirect to host page
						header('Location: ' . HOST);
						exit;

					} else {
						$this->page_data['page_alerts']['danger'] = 'Login and Password combination does not exists.';
					}

				} else {
					$this->page_data['page_alerts']['danger'] = 'Your inputs have errors.';
				}


				// Set previous user inputs as default values
				$this->page_data['values'] = $post_data;
			} else {
				$this->page_data['values'] = ['login' => ''];
				$this->page_data['errors'] = ['login' => '', 'password' => ''];
			}

			$this->view->render('auth/login', $this->page_data);
		} else {
			header('Location: /');
		}
	}

	/**
	 * /auth/logout page(action)
	 */
	function logout()
	{
		// Set success message
		Session::set('is_admin', FALSE);
		Session::set_flash('page_alerts', ['success' => 'You have logged out. Good Luck.']);

		// Redirect to referrer of host page
		header('Location: ' . (!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : HOST));
		exit;
	}

}
