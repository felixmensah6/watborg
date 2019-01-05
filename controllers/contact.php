<?php

/*
 |-----------------------------------------------------------------
 | Contact Controller
 |-----------------------------------------------------------------
 */

class Contact extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return void
	 */
    public function index()
    {
        // View data
        $data['title'] = 'Contact - Unity Framework';

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('contact');
        $this->load->view('templates/footer');
    }

    /**
	 * COntact Form
	 * --------------------------------------------
     *
     * @return void
	 */
    public function form()
    {
        // View data
        $data['title'] = 'Contact Form - Unity Framework';

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('contact-form');
        $this->load->view('templates/footer');
    }
}
