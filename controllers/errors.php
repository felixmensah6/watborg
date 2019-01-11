<?php

class Errors extends Controller
{
    /**
     * Default 404 Error Page
     * --------------------------------------------
     */
    public function index()
    {
        // Load view
        $this->load->view('pages/404');
    }
}
