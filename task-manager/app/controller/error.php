<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 09.01.2020
 * Time: 17:29
 */

namespace app\controller;

class Error extends \core\Controller
{
	/**
	 * @param string $error
	 */
	function not_found($error = NULL){
		if($error) $this->page_data['page_alerts']['danger'] = $error;
		$this->page_data['page_title'] = '404';
		$this->page_data['page_header'] = 'Page not found';

		$this->view->render('error/404', $this->page_data);
	}
}
