<?php

/*
 |-----------------------------------------------------------------
 | Session Library
 |-----------------------------------------------------------------
 |
 | Reusable session functions
 |
 */

class Session
{
    /**
     * Constructor
     * --------------------------------------------
     *
     * @return void
     */
    public function __construct()
    {
        // Check and start session
    	if(session_status() !== PHP_SESSION_ACTIVE)
        {
    		// Start session
    		session_start();
    	}

        // Create class properties with session names
        // and assign session values to them
        foreach ($_SESSION as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

    /**
     * Set Session Variable
     * --------------------------------------------
     *
     * @param array $variable The session variable
     * @return void
     */
    public function set($variable = [])
    {
        // Create new session Variables
        foreach ($variable as $key => $value)
        {
            $_SESSION[$key] = $value;
        }
    }

    /**
     * Check for a Session Variable
     * --------------------------------------------
     *
     * @param array $name The session variable name
     * @param array $redirect The url to redirect to
     * @param array $inverse Change or reverse condition
     * @return mixed
     */
    public function check($name, $redirect = null, $inverse = false)
    {
        if($redirect === null)
        {
            return (isset($_SESSION[$name])) ? true : false;
        }
        else
        {
            if($inverse === false)
            {
                return (isset($_SESSION[$name])) ? header("Location: " . $redirect) : true;
            }
            else
            {
                return (!isset($_SESSION[$name])) ? header("Location: " . $redirect) : true;
            }
        }
    }

    /**
     * Set Magic Method
     * --------------------------------------------
     *
     * @param array $key The session name
     * @param array $value The session value
     * @return void
     */
    public function __set($key, $value)
    {
        // Create property
        $this->{$key} = $value;

        // Create new session Variable
        $_SESSION[$key] = $value;
    }

    /**
     * Get Magic Method
     * --------------------------------------------
     *
     * @param array $key The session name
     * @return void
     */
    public function __get($key)
    {
        trigger_error("The {$key} session variable does not exist");
    }

    /**
     * Delete Session Variable
     * --------------------------------------------
     *
     * @param string $key The session name
     * @return void
     */
    public function unset($key)
    {
        // Delete session variable if is set
        if(isset($_SESSION[$key]))
        {
            unset($_SESSION[$key]);
        }
    }

    /**
     * Get Session ID
     * --------------------------------------------
     *
     * @return string
     */
    public function session_id()
    {
        return session_id();
    }

    /**
     * Regenerate Session ID
     * --------------------------------------------
     *
     * @return string
     */
    public function regenerate_id()
    {
        return session_regenerate_id();
    }

    /**
     * Destroy Session
     * --------------------------------------------
     *
     * @return void
     */
    public function destroy()
    {
        // Delete session value if is set
        if(isset($_SESSION))
        {
            $_SESSION = [];
            session_destroy();
        }
    }
}
