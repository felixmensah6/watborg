<?php

/*
 |-----------------------------------------------------------------
 | Initialize Application
 |-----------------------------------------------------------------
 |
 | Application initialization is done here by reading all config
 | variables provided and loading classes necessary for the
 | application to function properly.
 |
 */

// Include environment
require_once 'environment.php';

// Include and initialize autoloader
require_once 'app/autoloader.php';
$autoloader = new Autoload;

// Initialize Router
$router = new Router;
