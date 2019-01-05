<?php

class Errors extends Controller
{
    /**
     * Default 404 Error Page
     * --------------------------------------------
     */
    public function index()
    {
        echo '<h3>Page not found!</h3>';
    }

    /**
     * Routed 404 Not Found Page
     * --------------------------------------------
     */
    public function page_not_found()
    {
        echo '<h3>Custom Page not found!</h3>';
    }
}
