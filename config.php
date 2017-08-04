<?php

define('APP_BASE_PATH', __DIR__);
define('DB_HOSTNAME', 'localhost');
define('DB_DATABASE', 'vitcseb');
define('DB_USER', 'root');
define('DB_PASSWORD', '78421n');
define('DEBUG_MODE', true);

/*The debug mode is set to true in developing mode */

if (DEBUG_MODE) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(~E_ALL);
}

/*
 * File paths
 */
define('BASE_CONTROLLER_FOLDER', __DIR__ . '/app/Controllers/');
define('BASE_MODEL_FOLDER', __DIR__ . '/app/Models/');
define('LIB_FOLDER', __DIR__ . '/lib/');
