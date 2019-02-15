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
                'roles' => [1]
            ],
            [
                'text' => 'Service Setup',
                'url' => 'settings/service-setup',
                'active' => 'service-setup',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'roles' => [1]
            ],
            [
                'text' => 'Drug Setup',
                'url' => 'settings/drug-setup',
                'active' => 'drug-setup',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'roles' => [1]
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

        // View data
        $data['title'] = 'Drug Setup';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/drug-setup', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Add Service
	 * --------------------------------------------
     *
     * @return void
	 */
    public function add_service()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Load view
        $this->load->view('pages/settings/add-service');
    }

    /**
	 * Edit Service
	 * --------------------------------------------
     *
     * @param int $service_id The service id
     * @return void
	 */
    public function edit_service($service_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Decrypted service id
        $id = $this->security->decrypt_id($service_id);

        // View data
        $data['row'] = $this->settings_model->service_info($id);
        $data['service_id'] = $service_id;

        // Load view
        $this->load->view('pages/settings/edit-service', $data);
    }

    /**
	 * Load Services into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_services()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Load library
        $this->load->library('datatables');

        $columns = [
            'service_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'service_name' => function($value)
            {
                return ucwords($value);
            },
            'service_category' => null,
            'service_price' => function($value)
            {
                return number_format($value, 2);
            },
            null => function($value)
            {
                $actions = '<button data-url="' . site_url('settings/edit-service/') . $this->security->encrypt_id($value['service_id']) . '" data-title="Edit Service" class="btn btn-default btn-xs load-modal">Edit</button> ';

                $actions .= '<button data-target="'. site_url('settings/delete-service/') . $this->security->encrypt_id($value["service_id"]) .'" data-type="'.ucwords($value["service_name"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render('services', $columns);
    }

    /**
	 * Create Service
	 * --------------------------------------------
     *
     * @return void
	 */
    public function create_service()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $service = $this->input->post('service_name', 'string');
    		$category = $this->input->post('service_category', 'string');
    		$price = $this->input->post('service_price');

            // Validate
            $this->input->validate($service, "Service Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($category, "Service Category", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($price, "Service Price", "required|min_value[0.01]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_value" => $this->app->alert('danger', $this->app_lang->minimum_value)
                ]
            );

            // Insert service
            $this->settings_model->insert_service($service, $category, $price);

            // Show alert message
            echo $this->app->alert('success', $this->app_lang->insert_success);
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Update Service
	 * --------------------------------------------
     *
     * @param int $service_id The service id
     * @return void
	 */
    public function update_service($service_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $service = $this->input->post('service_name', 'string');
    		$category = $this->input->post('service_category', 'string');
    		$price = $this->input->post('service_price');

            // Validate
            $this->input->validate($service, "Service Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($category, "Service Category", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($price, "Service Price", "required|min_value[0.01]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_value" => $this->app->alert('danger', $this->app_lang->minimum_value)
                ]
            );

            // Decrypted service id
            $id = $this->security->decrypt_id($service_id);

            // Insert service
            $this->settings_model->update_service($service, $category, $price, $id);

            // Show alert message
            echo $this->app->alert('success', $this->app_lang->update_success);
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 *----------------------------
	 * Delete Service
	 *
     * @param int $service_id The service id
     * @return void
	 */
    public function delete_service($service_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt user id
            $service_id = $this->security->decrypt_id($service_id);

            // delete record
            $this->settings_model->delete_service($service_id);

            // Show alert message
            echo $this->app_lang->delete_success;
        }
        else
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
    }
}
