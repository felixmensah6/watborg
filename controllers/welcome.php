<?php

/*
 |-----------------------------------------------------------------
 | Welcome Controller
 |-----------------------------------------------------------------
 */

class Welcome extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return string
	 */
    public function index($name = '', $age = '')
    {
        // View data
        $data['title'] = 'Unity Framework';
        $data['name'] = $name;
        $data['age'] = $age;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('welcome', $data);
        $this->load->view('templates/footer');
    }
}
