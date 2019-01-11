<?php

/*
 |-----------------------------------------------------------------
 | Dashboard Controller
 |-----------------------------------------------------------------
 */

class Dashboard extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return string
	 */
    public function index()
    {
        // View data
        $data['title'] = 'Dashboard';
        $data['data'] = $this->user_model->login_user_info('lisema');

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/dashboard', $data);
        $this->load->view('templates/footer');
    }
}
