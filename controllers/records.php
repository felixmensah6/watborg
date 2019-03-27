<?php

/*
 |-----------------------------------------------------------------
 | Records Controller
 |-----------------------------------------------------------------
 */

class Records extends Controller
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
        $data['title'] = 'Register Patient';
        $data['currency'] = $this->app->system('app_currency');

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
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Patient Records';

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
        $this->app->check_active_session(2);

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
                show_http_response(404, 'Patient number <b>'.$query.'</b> was not found. Would you like to register this number?');
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
        $this->app->check_active_session(2);

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
            $total_cost = 0;

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
                $attendance_id = $this->records_model->insert_attendance('Old', $date, $patient_id, $current_user, $datetime, $datetime);

                // Update patient last attendance date
                $this->records_model->update_last_attendance($date, $datetime, $patient_id);

                // Insert bills
                $bill_id = $this->records_model->insert_bills($date, '0', '0', '0', $auto_hosp_number, $patient_name, $phone, $locality, 'Patient', $attendance_id, '0', $datetime, $datetime);

                // Insert service bills
                foreach ($service as $value)
                {
                    // Fetch service details
                    $row = $this->settings_model->service_info($value);

                    // Insert bill items
                    $this->records_model->insert_bill_items($date, 'Service', 'Bill', $row['service_name'], $row['service_cost'], '0', $attendance_id, $bill_id, $current_user, $datetime, $datetime);

                    // Add the service cost
                    $total_cost += $row['service_cost'];
                }

                // Update the the bill with total cost and receipt number
                $this->records_model->update_bill($total_cost, $this->app->receipt_number($bill_id), $bill_id);

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
                $attendance_id = $this->records_model->insert_attendance('New', $date, $patient_id, $current_user, $datetime, $datetime);

                // Insert bills
                $bill_id = $this->records_model->insert_bills($date, '0', '0', '0', $auto_hosp_number, $patient_name, $phone, $locality, 'Patient', $attendance_id, '0', $datetime, $datetime);

                // Insert service bills
                foreach ($service as $value)
                {
                    // Fetch service details
                    $row = $this->settings_model->service_info($value);

                    // Insert bill items
                    $this->records_model->insert_bill_items($date, 'Service', 'Bill', $row['service_name'], $row['service_cost'], '0', $attendance_id, $bill_id, $current_user, $datetime, $datetime);

                    // Add the service cost
                    $total_cost += $row['service_cost'];
                }

                // Update the the bill with total cost and receipt number
                $this->records_model->update_bill($total_cost, $this->app->receipt_number($bill_id), $bill_id);

                // Show alert message
                echo '<h6 class="text-success mb-3">Registration was successful!</h6>' .
                     '<dl class="row mb-0">' .
                     '<dt class="col-sm-3">Hosp. Number:</dt>' .
                     '<dd class="col-sm-9">' . $auto_hosp_number . '</dd>' .
                     '<dt class="col-sm-3">Patient Name:</dt>' .
                     '<dd class="col-sm-9">' . ucwords($firstname . ' ' . $lastname) . '</dd>' .
                     '<dt class="col-sm-3">Date of Birth:</dt>' .
                     '<dd class="col-sm-9">' . time_format($birthday, 'DD/MM/YYYY') . '</dd>' .
                     '<dt class="col-sm-3">Address:</dt>' .
                     '<dd class="col-sm-9">' . $locality . '</dd>' .
                     '<dt class="col-sm-3">Date:</dt>' .
                     '<dd class="col-sm-9 mb-0">' . time_format($date, 'DD/MM/YYYY') . '</dd>' .
                     '</dl>';
            }
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Load Patients into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_patients()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'patient_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'hospital_number' => null,
            'firstname' => function($value)
            {
                return ucwords($value);
            },
            'lastname' => function($value)
            {
                return ucwords($value);
            },
            'gender' => null,
            'birthday' => function($value)
            {
                return get_age($value);
            },
            'phone' => null,
            'updated_at' => function($value)
            {
                return timeago($value);
            },
            null => function($value)
            {
                $actions = '<a href="' . site_url('records/patient-profile/') . $this->security->encrypt_id($value['patient_id']) . '" class="btn btn-default btn-xs">More</a> ';

                $actions .= '<a href="' . site_url('records/edit-patient/') . $this->security->encrypt_id($value['patient_id']) . '" class="btn btn-default btn-xs">Edit</a> ';

                $actions .= '<button data-target="'. site_url('records/delete-patient/') . $this->security->encrypt_id($value["patient_id"]) .'" data-type="'.ucwords($value["firstname"].' '.$value["lastname"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render('patients', $columns);
    }
}
