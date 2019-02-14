<?php

/*
 |-----------------------------------------------------------------
 | Settings Controller
 |-----------------------------------------------------------------
 */

class Settings extends Controller
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
                'text' => 'System Setup',
                'url' => 'settings',
                'active' => null,
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => 'edit'
            ],
            [
                'text' => 'Service Setup',
                'url' => 'settings/service-setup',
                'active' => 'service-setup',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => 'add'
            ],
            [
                'text' => 'Drug Setup',
                'url' => 'settings/drug-setup',
                'active' => 'drug-setup',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => 'add'
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
        $data['title'] = 'System Setup';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/system-settings', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Service Setup
	 * --------------------------------------------
     *
     * @return void
	 */
    public function service_setup()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Check if user has access to this section
        $this->app->restrict_access('add');

        // View data
        $data['title'] = 'Service Setup';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/service-setup', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Drug Setup
	 * --------------------------------------------
     *
     * @return void
	 */
    public function drug_setup()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Check if user has access to this section
        $this->app->restrict_access('add');

        // View data
        $data['title'] = 'Drug Setup';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/drug-setup', $data);
        $this->load->view('templates/footer');
    }
}
