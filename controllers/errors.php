<?php

class Errors extends Controller
{
    /**
     * Default 404 Error Page
     * --------------------------------------------
     *
     * @return void
     */
    public function index()
    {
        // Load view
        $this->load->view('pages/404');
    }

    /**
     * Access Denied Page
     * --------------------------------------------
     *
     * @return void
     */
    public function access_denied()
    {
        // Load view
        $this->load->view('pages/access-denied');
    }
}
