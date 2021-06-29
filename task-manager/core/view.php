<?php

namespace core;

class View
{
	/**
	 * Template renderer
	 * @param string $name
	 * @param array $vars_array
	 * @param bool|true $use_template
	 */
	public function render($name, $vars_array, $use_template = true)
	{
		extract($vars_array);
		if ($use_template) require DIR . 'app/view/template/header.php';
		require DIR . 'app/view/'  . $name . '.php';
		if ($use_template) require DIR . 'app/view/template/footer.php';
	}
}
