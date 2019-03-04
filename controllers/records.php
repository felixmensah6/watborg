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
                'roles' => [1, 6]
            ],
            [
                'text' => 'Patient Records',
                'url' => 'records/patient-records',
                'active' => 'patient-records',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'roles' => [1, 6]
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
        // Check for an active session else redirect
        $this->app->check_active_session([1, 6]);

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
        $this->app->check_active_session([1, 6]);

        // View data
        $data['title'] = 'Patient Records';
        $data['page_menu_list'] = $this->page_menu_list();

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/records/patient-records', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Search for Patient
	 * --------------------------------------------
     *
     * @return void
	 */
    public function search_patient()
    {
        // Check for an active session else redirect
        $this->app->check_active_session([1, 6]);

        // Load model
        $this->load->model('records-model');

        // Check if form was submitted
        if($this->input->post('query'))
        {
            // Post data
            $query = $this->input->post('query', 'string');

            // Fetch patient data
            $row = $this->records_model->patient_hosp_info($query);

            // Search for patient
            if($this->records_model->patient_exists($query) == 1)
            {
                $json = [
                    'hospital_number' => $row['hospital_number'],
                    'lastname' => $row['lastname'],
                    'firstname' => $row['firstname'],
                    'gender' => $row['gender'],
                    'marrital_status' => $row['marrital_status'],
                    'birthday' => time_format($row['birthday'], 'DD/MM/YYYY'),
                    'occupation' => $row['occupation'],
                    'religion' => $row['religion'],
                    'address' => $row['address'],
                    'phone' => $row['phone'],
                    'district' => $row['district'],
                    'locality' => $row['locality'],
                    'relative_name' => $row['relative_name'],
                    'relative_phone' => $row['relative_phone'],
                    'age' => get_age($row['birthday'])
                    ];

                echo json_encode($json);
            }
            else
            {
                show_http_response(404, 'Patient number '.$query.' was not found. Would you like to register this number?');
            }
        }
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
        $this->app->check_active_session([1, 6]);

        // Load model
        $this->load->model('records-model');
        $this->load->model('settings-model');

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $hospital_number = $this->input->post('hospital_number');
            $firstname = $this->input->post('firstname', 'string');
    		$lastname = $this->input->post('lastname', 'string');
            $gender = $this->input->post('gender');
            $marrital_status = $this->input->post('marrital_status');
            $birthday = $this->input->post('birthday');
            $occupation = $this->input->post('occupation');
            $religion = $this->input->post('religion');
    		$address = $this->input->post('address', 'string');
    		$phone = $this->input->post('phone');
    		$district = $this->input->post('district');
            $locality = $this->input->post('locality');
            $relative_name = $this->input->post('relative_name', 'string');
            $relative_phone = $this->input->post('relative_phone');
            $service = $this->input->post('service');
            $service = ($service != null) ? $service : null;

            // Validate
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
            $this->input->validate($phone, "Phone No.", "required|min_length[10]|valid_number",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->minimum_value),
                    "valid_number" => $this->app->alert('danger', $this->app_lang->valid_number)
                ]
            );
            $this->input->validate($locality, "Locality", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($relative_name, "Next of Kin Name", "required|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );
            $this->input->validate($relative_phone, "Next of Kin Phone No.", "required|min_length[10]|valid_number",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->minimum_value),
                    "valid_number" => $this->app->alert('danger', $this->app_lang->valid_number)
                ]
            );
            $this->input->validate($service, "Services", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            // Prepare new variables
            $birthday = time_format($birthday, 'YYYY-MM-DD');
            $datetime = date("Y-m-d H:i:s");
            $date = date("Y-m-d");
            $current_user = ucwords($this->app->user_info('firstname') . ' ' . $this->app->user_info('lastname'));
            $auto_hosp_number = $this->app->hospital_number();
            $reference = $this->security->generate_unique_int(15);
            $patient_name = ucwords($firstname . ' ' . $lastname);

            // Ensure that future hospital numbers are not used
            if($hospital_number != null)
            {
                // Convert into arrays
                $new_num = explode('/', $hospital_number);
                $auto_num = explode('/', $auto_hosp_number);

                if($new_num[0] >= $auto_num[0] && $new_num[1] >= $auto_num[1])
                {
                    show_http_response(404, $this->app->alert('danger', $this->app_lang->rejected_hosp_number));
                }
                else
                {
                    $auto_hosp_number = $hospital_number;
                }
            }

            // Check if patient exists
            if($hospital_number != null && $this->records_model->patient_exists($hospital_number) == 1)
            {
                // Fetch patient id
                $patient_id = $this->records_model->patient_hosp_info($hospital_number)['patient_id'];

                // Insert new attendance
                $attendance_id = $this->records_model->insert_attendance($date, $patient_id, $current_user, $datetime, $datetime);

                // Insert service bills
                foreach ($service as $value)
                {
                    // Fetch service details
                    $row = $this->settings_model->service_info($value);

                    // Insert bills
                    $this->records_model->insert_service_bills('Bill', $row['service_name'], $date, $patient_id, $patient_name, 'Patient', $attendance_id, $reference, $row['service_cost'], '0', $current_user, $datetime, $datetime);
                }

                // Show alert message
                echo '<h6 class="text-success mb-3">Registration was successful!</h6>';
            }
            else
            {
                // Insert new patient
                $patient_id = $this->records_model->insert_patient($auto_hosp_number, $firstname, $lastname, $gender, $marrital_status, $birthday, $phone, $address, $occupation, $religion, $district, $locality, $relative_name, $relative_phone, $date, $datetime, $datetime);

                // Update hospital number only if number was automatically generated
                if($hospital_number == null)
                {
                    $this->app->hospital_number('INCREMENT');
                }

                // Insert new attendance
                $attendance_id = $this->records_model->insert_attendance($date, $patient_id, $current_user, $datetime, $datetime);

                // Insert service bills
                foreach ($service as $value)
                {
                    // Fetch service details
                    $row = $this->settings_model->service_info($value);

                    // Insert bills
                    $this->records_model->insert_service_bills('Bill', $row['service_name'], $date, $patient_id, $patient_name, 'Patient', $attendance_id, $reference, $row['service_cost'], '0', $current_user, $datetime, $datetime);
                }

                // Show alert message
                echo '<h6 class="text-success mb-3">Registration was successful!</h6>' .
                     '<dl class="row mb-0">' .
                     '<dt class="col-sm-3">Patient Name:</dt>' .
                     '<dd class="col-sm-9">' . ucwords($firstname . ' ' . $lastname) . '</dd>' .
                     '<dt class="col-sm-3">Hosp. Number:</dt>' .
                     '<dd class="col-sm-9">' . $auto_hosp_number . '</dd>' .
                     '<dt class="col-sm-3">Date of Birth:</dt>' .
                     '<dd class="col-sm-9 mb-0">' . time_format($birthday, 'DD-MM-YYYY') . '</dd>' .
                     '</dl>';
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }
}
