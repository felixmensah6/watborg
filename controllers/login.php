<?php

/*
 |-----------------------------------------------------------------
 | Login Controller
 |-----------------------------------------------------------------
 */

class Login extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return void
	 */
    public function index()
    {
        // Check if already logged in and redirect
        $this->session->check("user_id", site_url());

        // Load view
        $this->load->view('pages/auth/login');
    }

    /**
	 * Authenticate Login
	 * --------------------------------------------
     *
     * @return void
	 */
    public function authenticate()
    {
        // Check if form was submitted
        if($this->input->post('submit'))
        {
            // Post data
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Validate
            $this->input->validate($username, "Username", "required|min_length[3]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required, true),
                    "min_length" => $this->app->alert('danger', $this->app_lang->invalid_login, true)
                ]
            );
            $this->input->validate($password, "Password", "required|min_length[8]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required, true),
                    "min_length" => $this->app->alert('danger', $this->app_lang->invalid_login, true)
                ]
            );

            // fetch user data as row
            $row = $this->user_model->login_user_info($username);

            if($row['login_attempts'] === 0 || $row['locked'] === 1)
            {
                // Update account lock if login attempts limit is reached
                $this->user_model->update_lock_status($username);

                // Show error if account is locked
                show_http_response(404, $this->app->alert('danger', $this->app_lang->account_locked, true));
            }
            elseif($username === $row['username'] && !$this->security->password_verify($password, $row['password']))
            {
                //  Update the login attempts
                $this->user_model->update_login_attempts($username);

                // Show error if password is invalid
                show_http_response(404, $this->app->alert('danger', sprintf($this->app_lang->login_attempts, ($row['login_attempts'] - 1)), true));
            }
            elseif($username === $row['username'] && $this->security->password_verify($password, $row['password']))
            {
                // Generate new session id
                $this->session->regenerate_id();

                // Set session variables
                $this->session->set([
                    'user_id' => $row['user_id'],
                    'username' => $row['username'],
                    'role_level' => $row['role_id'],
                    'privilege_create' => $row['privilege_create'],
                    'privilege_update' => $row['privilege_update'],
                    'privilege_trash' => $row['privilege_trash'],
                    'privilege_delete' => $row['privilege_delete'],
                    'log_activities' => $row['log_activities'],
                    'temp_password' => $row['temp_password']
                ]);

                // Set current date and time
                $now = date("Y-m-d H:i:s");

                if($row['temp_password'] == 1)
                {
                    // Redirect on successful login
                    echo '<script>window.location = "' . site_url('change-password') . '";</script>';
                }
                else
                {
                    // Update login time and reset login attempts if login is successful
                    $this->user_model->reset_login_flags($now, $username);

                    // Redirect on successful login
                    echo js_redirect(site_url());
                }
            }
            else
            {
                // Show error if all the above conditions return false
                show_http_response(404, $this->app->alert('danger', $this->app_lang->invalid_login, true));
            }
        }
    }

    /**
	 * Change Password
	 * --------------------------------------------
     *
     * @return void
	 */
    public function change_password()
    {
        // Check if password was changed and redirect
        if($this->session->temp_password == 0)
        {
            redirect(site_url());
        }
        else
        {
            // Load view
            $this->load->view('pages/auth/change-password');
        }
    }

    /**
	 * Authenticate Login
	 * --------------------------------------------
     *
     * @return void
	 */
    public function set_password()
    {
        // Check if form was submitted
        if($this->input->post('submit'))
        {
            // Post data
            $password = $this->input->post('password');
            $confirm_password = $this->input->post('confirm_password');

            // Validate
            $this->input->validate($password, "Password", "required|min_length[8]|valid_password[low]|matches[confirm_password]",
                [
                    "required" => $this->app->alert('danger', $this->app_lang->required, true),
                    "min_length" => $this->app->alert('danger', $this->app_lang->short_username_password, true),
                    "matches" => $this->app->alert('danger', $this->app_lang->password_match, true),
                    "valid_password" => $this->app->alert('danger', $this->app_lang->valid_password, true)
                ]
            );

            // Hash password
            $password = $this->security->password_hash($password);

            // Update old password
            $this->user_model->set_password($password, 0, $this->session->user_id);

            // Reset temp password session value to 0
            $this->session->set(['temp_password' => 0]);

            // Redirect on successful login
            show_http_response(404, $this->app->alert('success', sprintf($this->app_lang->password_change . js_redirect(site_url(), 3), 3), true));
        }
    }

    /**
	 * Logout
	 * --------------------------------------------
     *
     * @return void
	 */
    public function logout()
    {
        // Destroy session
        $this->session->destroy();

        // Redirect to login page
        redirect(site_url());
    }
}
