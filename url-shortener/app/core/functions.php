<?php

/**
 * Get config from file
 * @param string $key Key that stores the required config
 * @return mixed If key was specified returns the required config, else returns all configs
 */
function config(string $key = ''): mixed
{
    static $arr;

    if (!$arr) {
        $arr = require APP_DIR . 'config.php';
    }

    return $key ? $arr[$key] : $arr;
}


/**
 * Construct and get site URL
 * @param string $path If a relative path is specified, it is concatenated with the hostname
 * @return string If no path was specified only the hostname is returned
 */
function siteURL(string $path = ''): string
{
    return config('host') . $path;
}