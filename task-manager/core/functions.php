<?php

spl_autoload_register(function ($class_name) {
	$file_name = DIR . strtolower(str_replace('\\', DIRECTORY_SEPARATOR, $class_name)) . '.php';
	if (file_exists($file_name)) {
		require_once $file_name;
	} else {
		throw new Exception('Unable to load "' . $class_name . '". File does not exists('. $class_name .'.php).');
	}
});

function clearPostData($filter_fields){
	$result = [];
	foreach($filter_fields as $field_name){
		$result[$field_name] = isset($_POST[$field_name]) ? htmlspecialchars(trim((string)$_POST[$field_name])) : '';
	}
	return $result;
}

function composeUrlParams($params){
	return http_build_query(array_merge($_GET, $params));
}

function getTaskOrderedColClass($col, $order){
	return $order['by'] === $col ? 'ordered ' . $order['direction'] : '';
}

function getTaskOrderedColDirection($col, $order){
	return $order['by'] === $col && $order['direction'] === 'asc' ? 'desc' : 'asc';
}