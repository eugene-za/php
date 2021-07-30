<?php
/**
 * This file parses the user's request and launches the required controller.
 */

/** Parsing the client request */
$requestParts = explode(
    '/',
    trim(
        parse_url($_SERVER['REQUEST_URI'])['path'],
        '/'
    )
);

/** Loading the appropriate controller */
list($controller, $method, $parameters) = '' !== $requestParts[0]
    ? (isset($_REQUEST['hits'])
        ? ['Url', 'hits', [$requestParts[0]]] // Client requests the hits count
        : ['Url', 'redirect', [$requestParts[0]]]) // Client follows shorten link
    : (isset($_REQUEST['assets'])
        ? ['Page', 'assets', [$_REQUEST['assets']]] // Client requests assets
        : ('POST' === $_SERVER['REQUEST_METHOD']
            ? [
                'Url',
                'create',
                [json_decode(file_get_contents("php://input"), true)['url']]
            ] // Client requests a new short URL creating
            : ['Page', 'index', []])); // Client requests the Index page

(new ('controllers\\' . $controller))->$method(...$parameters);
