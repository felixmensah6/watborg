<?php

/*
 |-----------------------------------------------------------------
 | Autoload Class
 |-----------------------------------------------------------------
 |
 | Auto loads classes
 |
 */

class Autoload
{
	/**
	 * Constructor
	 * --------------------------------------------
	 *
	 * @return void
	 */
	public function __construct() {
		spl_autoload_register(array($this, 'autoloader'));
	}

	/**
	 * Autoloader
	 * --------------------------------------------
	 *
	 * @param string $class The class name
	 * @return void
	 */
     private function autoloader($class)
     {
		$class = strtolower($class) . '.php';
		$class = str_replace("_", "-", $class);
        $class_directories = AUTOLOAD_PATH;

		foreach ($class_directories as $location)
        {
			if(file_exists($location.$class)) {
				require $location.$class;
			}
		}
	}
}
