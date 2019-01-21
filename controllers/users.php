<?php

/*
 |-----------------------------------------------------------------
 | Users Controller
 |-----------------------------------------------------------------
 */

class Users extends Controller
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
                'text' => 'User Accounts',
                'url' => 'users',
                'active' => null,
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => null
            ],
            [
                'text' => 'Add User',
                'url' => 'users/add-user',
                'active' => 'add-user',
                'class' => null,
                'attributes' => null,
                'visible' => null,
                'privilege' => 'add'
            ],
            [
                'text' => 'Edit User',
                'url' => 'users/edit-user/' . $this->uri->segment(3),
                'active' => 'edit-user',
                'class' => null,
                'attributes' => null,
                'visible' => 'edit-user',
                'privilege' => 'edit'
            ],
            [
                'text' => 'Reset Password',
                'url' => 'users/reset-password/' . $this->uri->segment(3),
                'active' => 'reset-password',
                'class' => null,
                'attributes' => null,
                'visible' => 'reset-password',
                'privilege' => 'edit'
            ]
        ];

        return $menu;
    }

    /**
	 * Index
	 * --------------------------------------------
     *
     * @return void
	 */
    public function index()
    {
        // View data
        $data['title'] = 'User Accounts';
        $data['page_menu_list'] = $this->page_menu_list();

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
        // Check if user has access to this section
        $this->app->restrict_access('add');

        // View data
        $data['title'] = 'Add User';
        $data['page_menu_list'] = $this->page_menu_list();

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
        // Check if user has access to this section
        $this->app->restrict_access('edit');

        // Decrypted user id
        $user_id = $this->security->decrypt_id($userid);

        // View data
        $data['title'] = 'Edit User';
        $data['page_menu_list'] = $this->page_menu_list();
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
        // Check if user has access to this section
        $this->app->restrict_access('edit');

        // Decrypted user id
        $user_id = $this->security->decrypt_id($userid);

        // View data
        $data['title'] = 'Reset Password';
        $data['page_menu_list'] = $this->page_menu_list();
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
        // Check if form was submitted
        if($this->input->post('submit'))
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
        // Check if form was submitted
        if($this->input->post('submit'))
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
        // Check if form was submitted
        if($this->input->post('submit'))
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
    }

    /**
	 * Load Users into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_users()
    {
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
            'role' => function($value)
            {
                return $this->app->user_roles($value);
            },
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

        $this->datatables->render('users', $columns);
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
        // Check if user has access to this section
        if($this->app->restrict_access('trash', true))
        {
            show_http_response(404, $this->app_lang->action_denied);
        }
        else
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
    }
}
