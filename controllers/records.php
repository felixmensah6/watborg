<?php

/*
 |-----------------------------------------------------------------
 | Records Controller
 |-----------------------------------------------------------------
 */

class Records extends Controller
{
    /**
	 * Page Menu List
	 * --------------------------------------------
     *
     * @return array
	 */
    public function page_menu_list()
    {
        $menu = [
            [
                'text' => 'Receive Patient',
                'url' => 'records',
                'active' => null,
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => 'add'
            ],
            [
                'text' => 'Patient Records',
                'url' => 'records/patient-records',
                'active' => 'patient-records',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => null
            ]
        ];

        return $menu;
    }

    /**
	 * Index
	 * --------------------------------------------
     *
     * @return string
	 */
    public function index()
    {
        // View data
        $data['title'] = 'Receive Patient';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/records/receive-patient', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Patient Records
	 * --------------------------------------------
     *
     * @return void
	 */
    public function patient_records()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();
        
        // Check if user has access to this section
        $this->app->restrict_access('add');

        // View data
        $data['title'] = 'Patient Records';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/records/patient-records', $data);
        $this->load->view('templates/footer');
    }
}
