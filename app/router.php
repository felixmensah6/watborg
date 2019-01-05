<?php

/*
 |-----------------------------------------------------------------
 | Router Class
 |-----------------------------------------------------------------
 |
 | Performs all web or URL routing functions
 |
 */

class Router {


    /**
	 * Routes array
     * --------------------------------------------
     *
	 * @var array
	 */
    protected $_routes = [];

    /**
	 * Default controller
     * --------------------------------------------
     *
	 * @var string
	 */
    protected $_controller = 'welcome';

    /**
	 * Default method
     * --------------------------------------------
     *
	 * @var string
	 */
    protected $_method = 'index';

    /**
	 * Default parameters
     * --------------------------------------------
     *
	 * @var string
	 */
    protected $_params = [];

    /**
	 * Default errors route
     * --------------------------------------------
     *
	 * @var string
	 */
    protected $_errors = 'errors/index';

    /**
	 * File extension
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_ext = ".php";

    /**
	 * Controllers Path
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_controllers_path = CONTROLLERS_PATH;

    /**
	 * Constructor
	 * --------------------------------------------
     *
     * @return void
	 */
    public function __construct($routes = [])
    {
        // Include routes
        include BASEPATH . DS . 'routes.php';

        // Assign routes array to routes property
        $this->_routes = $route;

        // Assign url array to $url variable
        $url = $this->parse_url();

        // Assign remapped url array to $remap variable
        $remap = $this->remap();

        // If url or remap array is empty, use default controller
        if(!empty($remap[0]))
        {
            // Check if controller file exists
            if(file_exists($this->_controllers_path . $remap[0] . $this->_ext))
            {
                $this->_controller = $remap[0];
                unset($remap[0]);
            }
            else
            {
                // Show page not found error
                $this->_controller = $this->default_route($this->route_finder('page-not-found'), 0);
                $this->_method = $this->default_route($this->route_finder('page-not-found'), 1);
            }
        }
        elseif(!empty($url[0]))
        {
            // Check if controller file exists
            if(file_exists($this->_controllers_path . $url[0] . $this->_ext))
            {
                $this->_controller = $url[0];
                unset($url[0]);
            }
            else
            {
                // Show page not found error
                $this->_controller = $this->default_route($this->route_finder('page-not-found'), 0);
                $this->_method = $this->default_route($this->route_finder('page-not-found'), 1);
            }
        }
        else
        {
            // Assign default controller value to controller property
            $this->_controller = $this->default_route($this->route_finder('default-controller'), 0);
        }

        // Include required controller
        require_once $this->_controllers_path . $this->_controller . $this->_ext;

        // Format controller name to use underscore
        $this->_controller = str_replace("-", "_", $this->_controller);

        // Instantiate controller class
        $this->_controller = new $this->_controller;

        // Check if url or remap method is set
        if(isset($remap[1]))
        {
            // Format method name to use underscore
            $remap[1] = str_replace("-", "_", $remap[1]);

            // Check if remap method exists
            if(method_exists($this->_controller, $remap[1]))
            {
                $this->_method = $remap[1];
                unset($remap[1]);
            }
            else
            {
                // Show page not found error
                $error_controller = $this->default_route($this->route_finder('page-not-found'), 0);
                $this->_controller = new $error_controller;
                $this->_method = $this->default_route($this->route_finder('page-not-found'), 1);
            }
        }
        elseif(isset($url[1]))
        {
            // Format method name to use underscore
            $url[1] = str_replace("-", "_", $url[1]);

            // Check if url method exists
            if(method_exists($this->_controller, $url[1]))
            {
                $this->_method = $url[1];
                unset($url[1]);
            }
            else
            {
                // Show page not found error
                $error_controller = $this->default_route($this->route_finder('page-not-found'), 0);
                $this->_controller = new $error_controller;
                $this->_method = $this->default_route($this->route_finder('page-not-found'), 1);
            }
        }

        // Check if URl has contents
        $this->_params = $url ? array_values($url) : [];

        // Format method name to use underscore
        $this->_method = str_replace("-", "_", $this->_method);

        // Call the controller and method
        call_user_func_array([$this->_controller, $this->_method], $this->_params);
    }

    /**
	 * Default Route
	 * --------------------------------------------
     *
     * @param string $route The route to use
     * @param int $key The index of the route url
     * @return array
	 */
    private function default_route($route, $key)
    {
        // Load default route from routes array
        if($route != '')
        {
            // Create array from route value
            $url = explode('/', filter_var(rtrim($route, '/'), FILTER_SANITIZE_URL));

            // Add the default method as second index if no method is provided in route
            array_push($url, $this->_method);
            return $url[$key];
        }
        else
        {
            // Create array from route value
            $url = explode('/', filter_var(rtrim($this->_errors, '/'), FILTER_SANITIZE_URL));
            return $url[$key];
        }
    }

    /**
	 * Parse URL
	 * --------------------------------------------
     *
     * @return array
	 */
    private function parse_url()
    {
        // Create an array from the url, trim and sanitize values
        if(isset($_GET['url']))
        {
            return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
    }

    /**
	 * Route Finder
	 * --------------------------------------------
     *
     * @return string
	 */
    private function route_finder($key)
    {
        // Get route value by key
        return $this->_routes[$key];
    }

    /**
	 * Remap Routes
	 * --------------------------------------------
     *
     * @param array $routes The associative array of routes
     * @return array
	 */
    private function remap()
    {
        $url = (isset($_GET['url'])) ? implode(" ", $this->parse_url()) : null;
        $regex = [
            ':any' => '[^\/]+',
            ':let' => '[a-z]+',
            ':num' => '[0-9]+'
        ];
        $target = null;

        // Loop through routes and execute conditions provided
        foreach ($this->_routes as $key => $value)
        {
            $pattern = str_replace("/", " ", $key);
            $pattern = strtr($pattern, $regex);

            // Match regex pattern against url for a match
            if(preg_match("/" . $pattern . "/", $url, $match))
            {
                if(strlen($match[0]) === strlen($url))
                {
                    $target = preg_replace("/" . $pattern . "/", $value, $url);
                    $target = str_replace(" ", "/", $target);
                    break;
                }
            }
        }

        // Return an array of new routes
        return explode('/', filter_var(rtrim($target, '/'), FILTER_SANITIZE_URL));
    }
}
