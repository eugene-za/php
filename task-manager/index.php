<?php

define("URI", $_SERVER['REQUEST_URI']);
define("HOST", $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST']);
define("DIR", __DIR__ . DIRECTORY_SEPARATOR);

require 'core/functions.php';

$app = new core\App();
