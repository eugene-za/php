<?php

return [
	'default_controller' => 'task',
	'default_action' => 'index',
	'database' => [
		'hostname' => 'localhost',
		'dbname' => 'task',
		'username' => 'root',
		'password' => 'root'
	],
	'tasks_count_per_page' => 3,
	'password_salt' => '!a@b#c$d%e^f&g*h(i)'
];
