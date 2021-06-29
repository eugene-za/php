<?php

namespace app\controller;

use app\model;
use core\Session;
use core\validator;

class Task extends \core\Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->model = new model\Task;
	}

	/**
	 * Total tasks pages counter
	 * @return int
	 */
	private function _calculate_pages_count()
	{
		return (int)ceil($this->model->get_count() / \core\App::$config['tasks_count_per_page']);
	}

	/**
	 * /task page
	 */
	public function index()
	{
		// Set defaults
		$this->page_data['page_title'] = 'List';
		$this->page_data['page_header'] = 'Tasks List';

		// Set tasks count
		$tasks_count_per_page = \core\App::$config['tasks_count_per_page'];

		// Set requested page
		$page = isset($_GET['page']) && (int)$_GET['page'] > 0 ? (int)$_GET['page'] : 1;
		$from_task = ($page - 1) * $tasks_count_per_page;

		// Set ordering
		$order = ['by' => 'id', 'direction' => 'asc'];

		if(isset($_GET['order'])){
			switch(strtolower($_GET['order'])){
				case 'name' :
					$order['by'] = 'name';
					break;
				case 'email' :
					$order['by'] = 'email';
					break;
				case 'status' :
					$order['by'] = 'status';
			}
		}

		if(isset($_GET['dir'])){
			if(strtolower($_GET['dir']) === 'desc' ){
				$order['direction'] = 'desc';
			}
		}

		$this->page_data['order'] = $order;

		// Get tasks
		$this->page_data['tasks_list'] = $this->model->get($tasks_count_per_page, $from_task, $order);

		// If tasks_list is empty
		if (!$this->page_data['tasks_list']) {
			$this->page_data['page_alerts']['danger'] = 'No tasks to show.';
		}

		// Set parameters for pagination
		$this->page_data['current_page'] = $page;
		$this->page_data['pages_count'] = $this->_calculate_pages_count();

		// Render template
		$this->view->render('task/list', $this->page_data);
	}

	/**
	 * /task/create page
	 */
	public function create()
	{
		// Set defaults
		$this->page_data['page_title'] = 'Create';
		$this->page_data['page_header'] = 'Create Task';

		// If isset POST REQUEST
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {

			$this->validator = new Validator();

			// Get needed fields from POST REQUEST and clear they from spaces
			$post_data = clearPostData(['name','email','text']);

			// Validate fields
			foreach ($post_data as $k => $v) {
				$this->page_data['errors'][$k] = $this->validator->check($k, $v);
			}

			// If form has not errors
			if (!$this->page_data['errors']['name']
				&& !$this->page_data['errors']['email']
				&& !$this->page_data['errors']['text']
			) {

				// Prepare POST inputs
				$filter_rules = [
					'name' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
					'email' => FILTER_SANITIZE_EMAIL,
					'text' => FILTER_SANITIZE_FULL_SPECIAL_CHARS
				];
				$post_data = filter_var_array($post_data, $filter_rules);

				// Save task to DB
				$result = $this->model->create($post_data);

				// If returns added task ID
				if (is_numeric($result)) {

					// Set success message
					Session::set_flash('page_alerts', ['success' => 'Task #' . $result . ' was created.']);

					// Redirect to last page
					$last_page = $this->_calculate_pages_count();

					header('Location: ' . HOST . ($last_page > 1 ? '?page=' . $last_page : ''));
					exit;

				} else {
					$this->page_data['page_alerts']['danger'] = 'Your inputs can not be saved: ' . $result;
				}
			} else {
				$this->page_data['page_alerts']['danger'] = 'Your inputs have errors.';
			}

			// Set previous user inputs as default values
			$this->page_data['values'] = $post_data;
		} else {
			$this->page_data['values'] = ['name' => '', 'email' => '', 'text' => ''];
			$this->page_data['errors'] = ['name' => '', 'email' => '', 'text' => ''];
		}

		// Render template
		$this->view->render('task/form', $this->page_data);
	}

	/**
	 * /task/edit page
	 */
	public function edit()
	{
		// Check if logged as Admin
		if(!$this->auth->is_admin()){
			Session::set_flash('page_alerts', ['danger' => 'You must be logged as Admin for this action.']);

			// Redirect to host page
			header('Location: ' .  HOST);
			exit;
		}

		// Set defaults
		$this->page_data['page_title'] = 'Edit';
		$this->page_data['page_header'] = 'Edit Task';

		if(isset($_GET['id'])
			&& (int)$_GET['id']
			&& $task = $this->model->get_task((int)$_GET['id'])){

				$this->page_data['is_edit'] = TRUE;

				if ($_SERVER['REQUEST_METHOD'] === 'POST') {

					$this->validator = new Validator();

					// Get needed fields from POST REQUEST and clear they from spaces
					$post_data = clearPostData(['text', 'status']);
					$post_data['status'] = $post_data['status'] === '1' ? '1' : '0';

					// Validate fields
					$this->page_data['errors']['text'] = $this->validator->check('text', $post_data['text']);

					// If form has not errors
					if (!$this->page_data['errors']['text']) {

						// Prepare POST inputs
						$post_data['text'] = filter_var($post_data['text'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

						// Is model errors
						$is_errors = FALSE;
						// Success and Errors flash messages
						$flash_messages = [];

						if($task['text'] !== $post_data['text']){
							// Update text
							$text_rows_affected = $this->model->update_text($task['id'], $post_data['text']);
							if($text_rows_affected === 1){
								$flash_messages['success'][] = 'Text of task #' . $task['id'] . ' was updated.';
							} else {
								$is_errors = TRUE;
								$flash_messages['success'][] = 'Text of task #' . $task['id'] . ' was not updated.';
							}
						}

						if($task['status'] !== $post_data['status']){
							// Update status
							$status_rows_affected = $this->model->update_status($task['id'], $post_data['status']);
							if($status_rows_affected === 1){
								$flash_messages['success'][] = 'Status of task #' . $task['id'] . ' was updated.';
							} else {
								$is_errors = TRUE;
								$flash_messages['danger'][] = 'Status of task #' . $task['id'] . ' was not updated.';
							}
						}

						// Set flash messages
						Session::set_flash('page_alerts', $flash_messages);

						// If returns added task ID
						if (!$is_errors) {
							// Redirect to host page
							header('Location: ' . HOST);
							exit;

						} else {
							$this->page_data['page_alerts']['danger'] = 'Your inputs can not be saved.';
						}
					} else {
						$this->page_data['page_alerts']['danger'] = 'Your inputs have errors.';
					}

					// Set previous user inputs as default values
					$this->page_data['values'] = $post_data;
				} else {
					$this->page_data['values'] = $task;
					$this->page_data['errors'] = ['name' => '', 'email' => '', 'text' => ''];

					// Render template
					$this->view->render('task/form', $this->page_data);
				}
			} else {
				$error_controller = new Error();
				$error_controller->not_found('Task not exists in Database.');
			}

	}

}