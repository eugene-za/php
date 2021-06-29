<?php

namespace core;
use app\model;

class Controller
{
	protected $model;
	protected $view;
	protected $session;
	protected $page_data;
	protected $validator;

	function __construct()
	{
		$this->session = new Session();
		$this->view = new View;
		$this->auth = new model\Auth;
		// Set $is_admin for View
		$this->page_data['is_admin'] = $this->auth->is_admin();
		$this->page_data['page_alerts'] = $this->session->get_flash('page_alerts') ?: [];
	}

}
