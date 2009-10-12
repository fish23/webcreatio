<?php

// get time (with microseconds) on start of application
list($usec, $sec) = explode(' ', microtime());
$mtime_start = (float) $sec + (float) $usec;

// absolute filesystem path to the web root
define('WWW_DIR', dirname(__FILE__));

// absolute filesystem path to the application root
define('APP_DIR', WWW_DIR . '/../app');

// absolute filesystem path to the libraries
define('LIBS_DIR', WWW_DIR . '/../libs');

// load bootstrap file
require APP_DIR . '/bootstrap.php';

// print running time of application (in miliseconds) within html comment
list($usec, $sec) = explode(' ', microtime());
echo('<!-- running time: '.round(((float) $sec + (float) $usec - $mtime_start) * 1000, 3).' ms -->');
