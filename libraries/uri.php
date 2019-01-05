<?php

/*
 |-----------------------------------------------------------------
 | URI Library
 |-----------------------------------------------------------------
 |
 | Reusable URI functions
 |
 */

class Uri
{
    /**
	 * URI Segments
	 * --------------------------------------------
     *
     * @param int $index The uri index/position
     * @return mixed
	 */
    public function segment(int $index = null)
    {
        // Create an array from the url, trim and sanitize values
        if(isset($_GET['url']))
        {
            // Create an arrray from the uri
            $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));

            // Count the array keys
            $count = count($url);

            // Add an empty value at the beginning
            // so that the indexing can start from 1
            array_unshift($url, "");

            // Delete the 0 index array key
            unset($url[0]);

            if($index === null)
            {
                return $url;
            }
            elseif($index !== null && ($index >= 1 && $index <= $count))
            {
                return $url[$index];
            }
            else
            {
                return false;
            }
        }
    }

    /**
	 * Routed URI Segments
	 * --------------------------------------------
     *
     * @param int $index The uri index/position
     * @return mixed
	 */
    public function routed_segment(int $index = null)
    {
        // Convert array to string
        $url = (isset($_GET['url'])) ? implode(" ", $this->segment()) : null;
        $regex = [
            ':any' => '[^\/]+',
            ':let' => '[a-z]+',
            ':num' => '[0-9]+'
        ];
        $target = null;
        $routes = new Config('routes', 'route');

        // Loop through routes and execute conditions provided
        foreach ($routes->get_all() as $key => $value)
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

        // Create array of new routes
        $routed = explode('/', filter_var(rtrim($target, '/'), FILTER_SANITIZE_URL));

        // Count the array keys
        $count = count($routed);

        // Add an empty value at the beginning
        // so that the indexing can start from 1
        array_unshift($routed, "");

        // Delete the 0 index array key
        unset($routed[0]);

        if($index === null)
        {
            return $routed;
        }
        elseif($index !== null && ($index >= 1 && $index <= $count))
        {
            return $routed[$index];
        }
        else
        {
            return false;
        }
    }
}
