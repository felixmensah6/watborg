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
                'text' => 'Register Patient',
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
        $data['title'] = 'Register Patient';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/records/register-patient', $data);
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

    /**
	 * Patient Registration
	 * --------------------------------------------
     *
     * @return void
	 */
    public function patient_registration()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Check if form was submitted
        if($this->input->post('submit'))
        {
            // Post data
            $hospital_number = $this->input->post('hospital_number');
            $patient_type = $this->input->post('patient_type');
            $firstname = $this->input->post('firstname', 'string');
    		$lastname = $this->input->post('lastname', 'string');
            $gender = $this->input->post('gender');
            $marrital_status = $this->input->post('marrital_status');
            $birthday = $this->input->post('birthday');
            $occupation = $this->input->post('occupation');
            $religion = $this->input->post('religion');
    		$address = $this->input->post('address', 'string');
    		$phone = $this->input->post('phone', 'int');
    		$district = $this->input->post('district');
            $locality = $this->input->post('locality');
            $relative_name = $this->input->post('relative_name', 'string');
            $relative_phone = $this->input->post('relative_phone', 'int');
            $service = $this->input->post('service');
            $service = ($service != null) ? $service : null;

            // Validate
            $this->input->validate($patient_type, "Type of Patient", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($lastname, "Surname", "required|min_length[3]|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_name),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );
            $this->input->validate($firstname, "Other Names", "required|min_length[3]|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_name),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );
            $this->input->validate($gender, "Gender", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($marrital_status, "Marrital Status", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($birthday, "Date of Birth", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($occupation, "Occupation", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($religion, "Religion", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($address, "Home Address", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($phone, "Phone No.", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($locality, "Locality", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($relative_name, "Next of Kin Name", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($relative_phone, "Next of Kin Phone No.", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($service, "Services", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            // Format date to yyyy-mm-dd
            $birthday = time_format($birthday, 'YYYY-MM-DD');

            // Set current date and time
            //$now = date("Y-m-d H:i:s");

            // Insert new user
            //$this->user_model->insert_user($username, $password, $title, $firstname, $lastname, $email, $role, $now, $privilege_create, $privilege_update, $privilege_trash, $temp_password);

            // Show alert message
            echo $this->app->alert('success', $this->app_lang->add_patient_success);
        }
    }
}
