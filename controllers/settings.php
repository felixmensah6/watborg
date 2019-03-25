<?php

/*
 |-----------------------------------------------------------------
 | Settings Controller
 |-----------------------------------------------------------------
 */

class Settings extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return string
	 */
    public function index()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(1);

        // View data
        $data['title'] = 'System Setup';

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
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Service Setup';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/service-setup', $data);
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
        $this->app->check_active_session(2);

        // View data
        $data['currency'] = $this->app->system('app_currency');

        // Load view
        $this->load->view('pages/settings/add-service', $data);
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
        $this->app->check_active_session(2);

        // Decrypted service id
        $id = $this->security->decrypt_id($service_id);

        // View data
        $data['currency'] = $this->app->system('app_currency');
        $data['row'] = $this->settings_model->service_info($id);
        $data['service_id'] = $service_id;

        // Load view
        $this->load->view('pages/settings/edit-service', $data);
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
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Drug Setup';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/drug-setup', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Edit Drug
	 * --------------------------------------------
     *
     * @param int $drug_id The drug id
     * @return void
	 */
    public function edit_drug($drug_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Decrypted drug id
        $id = $this->security->decrypt_id($drug_id);

        // View data
        $data['currency'] = $this->app->system('app_currency');
        $data['row'] = $this->settings_model->drug_info($id);
        $data['drug_id'] = $drug_id;

        // Load view
        $this->load->view('pages/settings/edit-drug', $data);
    }

    /**
	 * Add Drug
	 * --------------------------------------------
     *
     * @return void
	 */
    public function add_drug()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['currency'] = $this->app->system('app_currency');

        // Load view
        $this->load->view('pages/settings/add-drug', $data);
    }

    /**
	 * Occupation Setup
	 * --------------------------------------------
     *
     * @return void
	 */
    public function occupation_setup()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Occupation Setup';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/occupation-setup', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Add Occupation
	 * --------------------------------------------
     *
     * @return void
	 */
    public function add_occupation()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load view
        $this->load->view('pages/settings/add-occupation');
    }

    /**
	 * Edit Occupation
	 * --------------------------------------------
     *
     * @param int $occupation_id The occupation id
     * @return void
	 */
    public function edit_occupation($occupation_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Decrypted occupation id
        $id = $this->security->decrypt_id($occupation_id);

        // View data
        $data['row'] = $this->settings_model->occupation_info($id);
        $data['occupation_id'] = $occupation_id;

        // Load view
        $this->load->view('pages/settings/edit-occupation', $data);
    }

    /**
	 * District Setup
	 * --------------------------------------------
     *
     * @return void
	 */
    public function district_setup()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'District Setup';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/district-setup', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Add District
	 * --------------------------------------------
     *
     * @return void
	 */
    public function add_district()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load view
        $this->load->view('pages/settings/add-district');
    }

    /**
	 * Edit District
	 * --------------------------------------------
     *
     * @param int $district_id The district id
     * @return void
	 */
    public function edit_district($district_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Decrypted district id
        $id = $this->security->decrypt_id($district_id);

        // View data
        $data['row'] = $this->settings_model->district_info($id);
        $data['district_id'] = $district_id;

        // Load view
        $this->load->view('pages/settings/edit-district', $data);
    }

    /**
	 * Locality Setup
	 * --------------------------------------------
     *
     * @return void
	 */
    public function locality_setup()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Locality Setup';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/settings/locality-setup', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Add Locality
	 * --------------------------------------------
     *
     * @return void
	 */
    public function add_locality()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load view
        $this->load->view('pages/settings/add-locality');
    }

    /**
	 * Edit Locality
	 * --------------------------------------------
     *
     * @param int $locality_id The locality id
     * @return void
	 */
    public function edit_locality($locality_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Decrypted locality id
        $id = $this->security->decrypt_id($locality_id);

        // View data
        $data['row'] = $this->settings_model->locality_info($id);
        $data['locality_id'] = $locality_id;

        // Load view
        $this->load->view('pages/settings/edit-locality', $data);
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
        $this->app->check_active_session(2);

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
            'service_cost' => function($value)
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
	 * Load Drugs into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_drugs()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'drug_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'drug_name' => function($value)
            {
                return ucwords($value);
            },
            'drug_cost' => function($value)
            {
                return number_format($value, 2);
            },
            null => function($value)
            {
                $actions = '<button data-url="' . site_url('settings/edit-drug/') . $this->security->encrypt_id($value['drug_id']) . '" data-title="Edit Drug" class="btn btn-default btn-xs load-modal">Edit</button> ';

                $actions .= '<button data-target="'. site_url('settings/delete-drug/') . $this->security->encrypt_id($value["drug_id"]) .'" data-type="'.ucwords($value["drug_name"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render('drugs', $columns);
    }

    /**
	 * Load Occupations into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_occupations()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'occupation_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'occupation_name' => function($value)
            {
                return ucwords($value);
            },
            null => function($value)
            {
                $actions = '<button data-url="' . site_url('settings/edit-occupation/') . $this->security->encrypt_id($value['occupation_id']) . '" data-title="Edit Occupation" class="btn btn-default btn-xs load-modal">Edit</button> ';

                $actions .= '<button data-target="'. site_url('settings/delete-occupation/') . $this->security->encrypt_id($value["occupation_id"]) .'" data-type="'.ucwords($value["occupation_name"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render('occupations', $columns);
    }

    /**
	 * Load Disricts into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_districts()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'district_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'district_name' => function($value)
            {
                return ucwords($value);
            },
            'region' => null,
            null => function($value)
            {
                $actions = '<button data-url="' . site_url('settings/edit-district/') . $this->security->encrypt_id($value['district_id']) . '" data-title="Edit District" class="btn btn-default btn-xs load-modal">Edit</button> ';

                $actions .= '<button data-target="'. site_url('settings/delete-district/') . $this->security->encrypt_id($value["district_id"]) .'" data-type="'.ucwords($value["district_name"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render('districts', $columns);
    }

    /**
	 * Load Localities into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_localities()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'locality_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'locality_name' => function($value)
            {
                return ucwords($value);
            },
            null => function($value)
            {
                $actions = '<button data-url="' . site_url('settings/edit-locality/') . $this->security->encrypt_id($value['locality_id']) . '" data-title="Edit Locality" class="btn btn-default btn-xs load-modal">Edit</button> ';

                $actions .= '<button data-target="'. site_url('settings/delete-locality/') . $this->security->encrypt_id($value["locality_id"]) .'" data-type="'.ucwords($value["locality_name"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render('localities', $columns);
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
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $service = $this->input->post('service_name', 'string');
    		$category = $this->input->post('service_category', 'string');
    		$cost = $this->input->post('service_cost');

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
            $this->input->validate($cost, "Service Cost", "required|min_value[0.01]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_value" => $this->app->alert('danger', $this->app_lang->minimum_value)
                ]
            );

            if($service != null && $this->settings_model->service_exists($service) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $service);
            }
            else
            {
                // Insert service
                $this->settings_model->insert_service($service, $category, $cost);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->insert_success);
            }
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
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $service = $this->input->post('service_name', 'string');
    		$category = $this->input->post('service_category', 'string');
    		$cost = $this->input->post('service_cost');

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
            $this->input->validate($cost, "Service Cost", "required|min_value[0.01]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_value" => $this->app->alert('danger', $this->app_lang->minimum_value)
                ]
            );

            // Decrypted service id
            $id = $this->security->decrypt_id($service_id);

            // Update service
            $this->settings_model->update_service($service, $category, $cost, $id);

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
        $this->app->check_active_session(2);

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt service id
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

    /**
	 * Create Drug
	 * --------------------------------------------
     *
     * @return void
	 */
    public function create_drug()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $drug = $this->input->post('drug_name', 'string');
    		$cost = $this->input->post('drug_cost');

            // Validate
            $this->input->validate($drug, "Drug Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($cost, "Drug Cost", "required|min_value[0.01]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_value" => $this->app->alert('danger', $this->app_lang->minimum_value)
                ]
            );

            if($drug != null && $this->settings_model->drug_exists($drug) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $drug);
            }
            else
            {
                // Insert drug
                $this->settings_model->insert_drug($drug, $cost);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->insert_success);
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Update Drug
	 * --------------------------------------------
     *
     * @param int $drug_id The drug id
     * @return void
	 */
    public function update_drug($drug_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $drug = $this->input->post('drug_name', 'string');
    		$cost = $this->input->post('drug_cost');

            // Validate
            $this->input->validate($drug, "Drug Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($cost, "Drug Cost", "required|min_value[0.01]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_value" => $this->app->alert('danger', $this->app_lang->minimum_value)
                ]
            );

            // Decrypted drug id
            $id = $this->security->decrypt_id($drug_id);

            // Udate drug
            $this->settings_model->update_drug($drug, $cost, $id);

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
	 * Delete Drug
	 *
     * @param int $drug_id The drug id
     * @return void
	 */
    public function delete_drug($drug_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt drug id
            $drug_id = $this->security->decrypt_id($drug_id);

            // delete record
            $this->settings_model->delete_drug($drug_id);

            // Show alert message
            echo $this->app_lang->delete_success;
        }
        else
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
    }

    /**
	 * Create Occupation
	 * --------------------------------------------
     *
     * @return void
	 */
    public function create_occupation()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $occupation = $this->input->post('occupation_name', 'string', null, 'capitalized');

            // Validate
            $this->input->validate($occupation, "Occupation Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            if($occupation != null && $this->settings_model->occupation_exists($occupation) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $occupation);
            }
            else
            {
                // Insert occupation
                $this->settings_model->insert_occupation($occupation);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->insert_success);
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Update Occupation
	 * --------------------------------------------
     *
     * @param int $occupation_id The occupation id
     * @return void
	 */
    public function update_occupation($occupation_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $occupation = $this->input->post('occupation_name', 'string', null, 'capitalized');

            // Validate
            $this->input->validate($occupation, "Occupation Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            if($occupation != null && $this->settings_model->occupation_exists($occupation) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $occupation);
            }
            else
            {
                // Decrypted occupation id
                $id = $this->security->decrypt_id($occupation_id);

                // Update occupation
                $this->settings_model->update_occupation($occupation, $id);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->update_success);
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 *----------------------------
	 * Delete Occupation
	 *
     * @param int $occupation_id The occupation id
     * @return void
	 */
    public function delete_occupation($occupation_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt occupation id
            $occupation_id = $this->security->decrypt_id($occupation_id);

            // delete record
            $this->settings_model->delete_occupation($occupation_id);

            // Show alert message
            echo $this->app_lang->delete_success;
        }
        else
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
    }

    /**
	 * Create District
	 * --------------------------------------------
     *
     * @return void
	 */
    public function create_district()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $district = $this->input->post('district_name', 'string');
    		$region = $this->input->post('region', 'string');

            // Validate
            $this->input->validate($district, "District Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($region, "Region", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            if($district != null && $this->settings_model->district_exists($district) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $district);
            }
            else
            {
                // Insert district
                $this->settings_model->insert_district($district, $region);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->insert_success);
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Update District
	 * --------------------------------------------
     *
     * @param int $service_id The service id
     * @return void
	 */
    public function update_district($district_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $district = $this->input->post('district_name', 'string');
    		$region = $this->input->post('region', 'string');

            // Validate
            $this->input->validate($district, "District Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($region, "Region", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            // Decrypted district id
            $id = $this->security->decrypt_id($district_id);

            // Update district
            $this->settings_model->update_district($district, $region, $id);

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
	 * Delete District
	 *
     * @param int $district_id The district id
     * @return void
	 */
    public function delete_district($district_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt district id
            $district_id = $this->security->decrypt_id($district_id);

            // delete record
            $this->settings_model->delete_district($district_id);

            // Show alert message
            echo $this->app_lang->delete_success;
        }
        else
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
    }

    /**
	 * Create Locality
	 * --------------------------------------------
     *
     * @return void
	 */
    public function create_locality()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $locality = $this->input->post('locality_name', 'string', null, 'capitalized');

            // Validate
            $this->input->validate($locality, "Locality Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            if($locality != null && $this->settings_model->locality_exists($locality) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $locality);
            }
            else
            {
                // Insert locality
                $this->settings_model->insert_locality($locality);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->insert_success);
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Update Locality
	 * --------------------------------------------
     *
     * @param int $locality_id The locality id
     * @return void
	 */
    public function update_locality($locality_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $locality = $this->input->post('locality_name', 'string', null, 'capitalized');

            // Validate
            $this->input->validate($locality, "Locality Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            if($locality != null && $this->settings_model->locality_exists($locality) == 1)
            {
                // Show alert message
                echo sprintf($this->app->alert('danger', $this->app_lang->name_exists), $locality);
            }
            else
            {
                // Decrypted locality id
                $id = $this->security->decrypt_id($locality_id);

                // Update locality
                $this->settings_model->update_locality($locality, $id);

                // Show alert message
                echo $this->app->alert('success', $this->app_lang->update_success);
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 *----------------------------
	 * Delete Locality
	 *
     * @param int $locality_id The locality id
     * @return void
	 */
    public function delete_locality($locality_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt locality id
            $locality_id = $this->security->decrypt_id($locality_id);

            // delete record
            $this->settings_model->delete_locality($locality_id);

            // Show alert message
            echo $this->app_lang->delete_success;
        }
        else
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
    }
}
