<?php

/*
 |-----------------------------------------------------------------
 | Model Class
 |-----------------------------------------------------------------
 |
 | Interacts with database and the controller
 |
 */

class Model
{
	/**
	 * Constructor
	 * --------------------------------------------
     *
     * @return void
	 */
    public function __construct()
    {
		// Assign instance of the database object
		$db = new Database;
		$this->db = $db;
    }
}
