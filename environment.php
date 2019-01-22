<?php

/*
 |-----------------------------------------------------------------
 | Environment
 |-----------------------------------------------------------------
 |
 | Reads and coverts environment values to understandable values
 | specifically an array to be used by the application.
 |
 */

 /**
  * System Start Time
  * --------------------------------------------
  * This sets the system start time used to calculate
  * the script execution time.
  */
 define("SYSTEM_START_TIME" , microtime(true));

/**
 * Root Directory Path
 * --------------------------------------------
 * This defines the full path to the root directory
 */
define('BASEPATH' , __DIR__);

/**
 * Directory Separator
 * --------------------------------------------
 * This defines the directory separator for different platforms
 */
define('DS' , DIRECTORY_SEPARATOR);

/**
 * Application Core Path
 * --------------------------------------------
 * The path to application core classes directory
 */
define('APP_PATH' , BASEPATH . DS . 'app' . DS);

/**
 * Public Path
 * --------------------------------------------
 * The path to public directory
 */
define('PUBLIC_PATH' , BASEPATH . DS . 'public' . DS);

/**
 * Controllers Path
 * --------------------------------------------
 * The path to controllers directory
 */
define('CONTROLLERS_PATH' , BASEPATH . DS . 'controllers' . DS);

/**
 * Models Path
 * --------------------------------------------
 * The path to models directory
 */
define('MODELS_PATH' , BASEPATH . DS . 'models' . DS);

/**
 * Vews Path
 * --------------------------------------------
 * The path to views directory
 */
define('VIEWS_PATH' , BASEPATH . DS . 'views' . DS);

/**
 * Helpers Path
 * --------------------------------------------
 * The path to helpers directory
 */
define('HELPERS_PATH' , BASEPATH . DS . 'helpers' . DS);

/**
 * Language Path
 * --------------------------------------------
 * The path to language directory
 */
define('LANGUAGE_PATH' , BASEPATH . DS . 'language' . DS);

/**
 * Libraries Path
 * --------------------------------------------
 * The path to libraries directory
 */
define('LIBRARIES_PATH' , BASEPATH . DS . 'libraries' . DS);

/**
 * Database Path
 * --------------------------------------------
 * The path to database directory
 */
define('DATABASE_PATH' , BASEPATH . DS . 'database' . DS);

/**
 * Class Autoload Path
 * --------------------------------------------
 * The paths to search for class files for autoloading
 */
define('AUTOLOAD_PATH' , [
    APP_PATH,
    CONTROLLERS_PATH,
    MODELS_PATH,
    LIBRARIES_PATH,
    HELPERS_PATH,
    DATABASE_PATH
]);

/**
 * Environment Function
 * --------------------------------------------
 * Function to return environment values by key
 *
 * @param string $key
 * @return string env(value)
 */
function env($key = null)
{
    // Load the environment file
    $env_file = file(BASEPATH . DS . '.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Set the environment array
    $env = [];

    // Loop through environment file and match patterns as key and value
    // and store themin the $env array.
    foreach ($env_file as $line) {
        preg_match('/([^\s]*?)\s?=\s?(([^"]*?)$)/',$line, $matches);
        $env[$matches[1]] = $matches[2];
    }

    // Return string if key is provided else an array of all env values
    return ($key != null) ? $env[$key] : $env;
}

/*
 * DEBUGGING CONFIGURATION
 * --------------------------------------------
 *
 * Display errors development mode and log
 * errors in production mode
 */
error_reporting(E_ALL);

switch (env('APP_ENV'))
{
    case 'development':

        // Display errors do not log
        ini_set('display_errors', true);
        ini_set('log_errors', false);
        break;

    case 'production':

        // Log errors do not display
        ini_set('display_errors', false);
        ini_set('log_errors', true);
        break;

    default:

        // Display and log errors
        ini_set('display_errors', true);
        ini_set('log_errors', true);
        break;
}
