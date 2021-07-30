<?php

define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);
const APP_DIR = ROOT_DIR . 'app/';

require APP_DIR . 'autoload.php';
require APP_DIR . 'core/functions.php';

try {
    require APP_DIR . 'core/router.php';
} catch (PDOException $e) {
    (new controllers\Page())->error('Caught error code: ' . $e->getCode());
}
