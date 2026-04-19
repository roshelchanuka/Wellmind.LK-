<?php

/**
 * WellMind.LK - Laravel XAMPP Proxy
 * This file allows you to click the 'final project' folder in XAMPP 
 * and have it automatically load the public website.
 */

$uri = urldecode(
    parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)
);

// If we are exactly at the project root, go to public/
if ($uri === '/final project/' || $uri === '/final%20project/') {
    header('Location: public/');
    exit;
}

// Otherwise, let the public index handle it
require_once __DIR__.'/public/index.php';
