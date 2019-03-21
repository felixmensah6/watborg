<?php

/*
 |-----------------------------------------------------------------
 | Users Controller
 |-----------------------------------------------------------------
 */

class Users extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return void
	 */
    public function index()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(1);

        // View data
        $data['title'] = 'Manage Users';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/users/manage-users', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Add User
	 * --------------------------------------------
     *
     * @return void
	 */
    public function add_user()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Add User';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/users/add-user', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Edit User
	 * --------------------------------------------
     *
     * @param int $userid The user's id
     * @return void
	 */
    public function edit_user($userid = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Decrypted user id
        $user_id = $this->security->decrypt_id($userid);

        // View data
        $data['title'] = 'Edit User';
        $data['row'] = $this->user_model->user_info($user_id);
        $data['userid'] = $userid;

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/users/edit-user', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Reset Password
	 * --------------------------------------------
     *
     * @param int $userid The user's id
     * @return void
	 */
    public function reset_password($userid = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Decrypted user id
        $user_id = $this->security->decrypt_id($userid);

        // View data
        $data['title'] = 'Reset Password';
        $data['row'] = $this->user_model->user_info($user_id);
        $data['userid'] = $userid;

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/users/reset-password', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Create User
	 * --------------------------------------------
     *
     * @return void
	 */
    public function create_user()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('add') && $this->input->post('submit'))
        {
            // Post data
            $title = $this->input->post('title');
            $firstname = $this->input->post('firstname', 'string');
    		$lastname = $this->input->post('lastname', 'string');
            $email = $this->input->post('email', 'email', null, 'lowercase');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $role = $this->input->post('role');
    		$privilege_create = $this->input->post('privilege_create', null, 0);
    		$privilege_update = $this->input->post('privilege_update', null, 0);
    		$privilege_trash = $this->input->post('privilege_trash', null, 0);
            $temp_password = $this->input->post('temp_password');

            // Validate
            $this->input->validate($title, "Title", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($firstname, "First Name", "required|min_length[3]|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_name),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );
            $this->input->validate($lastname, "Last Name", "required|min_length[3]|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_name),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );
            $this->input->validate($username, "Username", "required|min_length[3]|valid_username|is_unique[users.username]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_username_password),
                    "valid_username" => $this->app->alert('danger', $this->app_lang->valid_username),
                    "is_unique" => $this->app->alert('danger', $this->app_lang->name_exists),
                ]
            );

            // Only validate if input is not empty
            if($email != null)
            {
                $this->input->validate($email, "Email", "valid_email",
                    [
                        "valid_email" => $this->app->alert('danger', $this->app_lang->invalid)
                    ]
                );
            }

            $this->input->validate($password, "Password", "required|min_length[8]|valid_password[low]|matches[confirm_password]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_username_password),
                    "matches" => $this->app->alert('danger', $this->app_lang->password_match),
                    "valid_password" => $this->app->alert('danger', $this->app_lang->valid_password)
                ]
            );
            $this->input->validate($role, "User Role", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($temp_password, "Enforce Password Change", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            // Hash password
            $password = $this->security->password_hash($password);

            // Set current date and time
            $now = date("Y-m-d H:i:s");

            // Insert new user
            $this->user_model->insert_user($username, $password, $title, $firstname, $lastname, $email, $role, $now, $privilege_create, $privilege_update, $privilege_trash, $temp_password);

            // Show alert message
            echo $this->app->alert('success', $this->app_lang->add_user_success);
        }
        else
        {
            // Show alert message
            echo $this->app->alert('danger', $this->app_lang->action_denied);
        }
    }

    /**
	 * Update User
	 * --------------------------------------------
     *
     * @param int $userid The user's id
     * @return void
	 */
    public function update_user($userid = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $title = $this->input->post('title');
            $firstname = $this->input->post('firstname', 'string');
    		$lastname = $this->input->post('lastname', 'string');
            $email = $this->input->post('email', 'email', null, 'lowercase');
            $role = $this->input->post('role');
    		$privilege_create = $this->input->post('privilege_create', null, 0);
    		$privilege_update = $this->input->post('privilege_update', null, 0);
    		$privilege_trash = $this->input->post('privilege_trash', null, 0);
    		$locked = $this->input->post('locked', null, 0);

            // Validate
            $this->input->validate($title, "Title", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );
            $this->input->validate($firstname, "First Name", "required|min_length[3]|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_name),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );
            $this->input->validate($lastname, "Last Name", "required|min_length[3]|valid_name",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_name),
                    "valid_name" => $this->app->alert('danger', $this->app_lang->valid_name)
                ]
            );

            // Only validate if input is not empty
            if($email != null)
            {
                $this->input->validate($email, "Email", "valid_email",
                    [
                        "valid_email" => $this->app->alert('danger', $this->app_lang->invalid)
                    ]
                );
            }

            $this->input->validate($role, "User Role", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            // Decrypted user id
            $user_id = $this->security->decrypt_id($userid);

            // Update user
            $this->user_model->update_user_account($title, $firstname, $lastname, $email, $role, $privilege_create, $privilege_update, $privilege_trash, 3, $locked, $user_id);

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
	 * Update Password
	 * --------------------------------------------
     *
     * @param int $userid The user's id
     * @return void
	 */
    public function update_password($userid = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if form was submitted and if access is allowed
        if($this->app->deny_action('edit') && $this->input->post('submit'))
        {
            // Post data
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');
            $temp_password = $this->input->post('temp_password');

            // Validate
            $this->input->validate($password, "Password", "required|min_length[8]|valid_password[low]|matches[confirm_password]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_username_password),
                    "matches" => $this->app->alert('danger', $this->app_lang->password_match),
                    "valid_password" => $this->app->alert('danger', $this->app_lang->valid_password)
                ]
            );
            $this->input->validate($temp_password, "Enforce Password Change", "required",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required)
                ]
            );

            // Decrypted user id
            $user_id = $this->security->decrypt_id($userid);

            // Hash password
            $password = $this->security->password_hash($password);

            // Update user
            $this->user_model->set_password($password, $temp_password, $user_id);

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
	 * Load Users into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_users()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'user_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'title' => null,
            'firstname' => function($value)
            {
                return ucwords($value);
            },
            'lastname' => function($value)
            {
                return ucwords($value);
            },
            'username' => null,
            'role_name' => null,
            'login_date' => function($value)
            {
                return ($value != null) ? timeago($value) : 'Pending';
            },
            'locked' => function($value)
            {
                return $this->app->account_status($value, 0);
            },
            null => function($value)
            {
                $actions = '<a href="' . site_url('users/edit-user/') . $this->security->encrypt_id($value['user_id']) . '" class="btn btn-default btn-xs">Edit</a> ';

                $actions .= '<a href="' . site_url('users/reset-password/') . $this->security->encrypt_id($value['user_id']) . '" class="btn btn-default btn-xs">Reset</a> ';

                $actions .= '<button data-target="'. site_url('users/delete-user/') . $this->security->encrypt_id($value["user_id"]) .'" data-type="'.ucwords($value["firstname"].' '.$value["lastname"]).'" class="delete-record btn btn-default btn-xs">Delete</button>';

                return $actions;
            }
        ];

        $this->datatables->render_advance(
            $columns,
            'SELECT {TOTAL_ROWS} U.user_id, U.title, U.firstname, U.lastname, U.username, R.role_name, U.login_date, U.locked
            FROM users U
            INNER JOIN roles R
            ON U.role_id = R.role_level
            WHERE {SEARCH_COLUMN} AND role_level <> 1
            ORDER BY {ORDER_COLUMN} {ORDER_DIR} {LIMIT_ROWS}',
            ['U.', 'R.']
        );
    }

    /**
	 *----------------------------
	 * Delete User Process
	 *
     * @param int $userid The user's id
     * @return void
	 */
    public function delete_user($userid = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Check if user has access to this action
        if($this->app->deny_action('delete'))
        {
            // Decrypt user id
            $user_id = $this->security->decrypt_id($userid);

            // Prevent user from deleting their own account
            if($user_id == $this->session->user_id)
            {
                show_http_response(404, $this->app_lang->delete_own_account);
            }
            else
            {
                // delete user
                $this->user_model->delete_user($user_id);

                // Show alert message
                echo $this->app_lang->delete_success;
            }
        }
        else
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
    }
}
