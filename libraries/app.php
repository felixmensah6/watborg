<?php

/*
 |-----------------------------------------------------------------
 | App Library
 |-----------------------------------------------------------------
 |
 | Reusable code for the entire application
 |
 */

class App
{
    /**
     * Constructor
     * --------------------------------------------
     *
     * @return void
     */
    public function __construct()
    {
        // Load classes
        $this->uri = new Uri;
        $this->session = new Session;
        $this->db = new Database;
    }

    /**
     * Check for Active Session
     * --------------------------------------------
     *
     * @return array
     */
    public function check_active_session()
    {
        // Check if already logged in and redirect
        $this->session->check("user_id", site_url("login"), true);
    }

    /**
     * Sidebar Menu
     * --------------------------------------------
     *
     * @param array $list An array of the menu list
     * @param string $active The currently selected menu
     * @param string $role The user role
     * @return string
     */
    public function sidebar($list, $active, $role)
    {
        // ul start tag
        $build = '<ul class="sidebar-nav">';

        // Count menu groups
        $total_groups = count($list);

        // Loop and display menu groups
        for($i = 0; $i < $total_groups; $i++)
        {
            // Menu group ul start tag
            $build .= '<ul>';

            // Check if user has access to this section
            if(in_array($role, $list[$i]['roles']))
            {
                // Display menu group
                $build .= '<li class="sidebar-nav-group">' . $list[$i]['group'] . '</li>';
            }

            // Count menus
            $total_menus = count($list[$i]['menu']);

            // Loop and display menus
            for($x = 0; $x < $total_menus; $x++)
            {
                // Add active class to active menu
                $is_active = ($active == $list[$i]['menu'][$x]['url']) ? 'active ' : '';

                // Check if user has access to this section
                if(in_array($role, $list[$i]['menu'][$x]['roles']))
                {
                    // Display menus
                    $build .= '<li><a href="' . site_url($list[$i]['menu'][$x]['url']) . '" class="' . $is_active . '' . $list[$i]['menu'][$x]['class'] . '" ' . $list[$i]['menu'][$x]['attributes'] . '><i class="' . $list[$i]['menu'][$x]['icon'] . '"></i> ' . $list[$i]['menu'][$x]['text'] . '</a></li>';
                }
            }

            // Menu group ul closing tag
            $build .= '</ul>';
        }

        // ul closing tag
        $build .= '</ul>';

        // Display full menu
        return $build;
    }

    /**
     * Page Menu
     * --------------------------------------------
     *
     * @param array $list An array of the menu list
     * @return string
     */
    public function page_menu($list)
    {
        // Count list array
        $count = count($list);

        // Current page
        $current = $this->uri->segment(2);

        // start tags
        $build = '<div class="nav-scroller" id="page-nav"><nav class="ns-nav"><div class="ns-content">';

        // Loop through menu array
        for($i = 0; $i < $count; $i++)
        {
            // Add active css class
            $active = ($current == $list[$i]['active']) ? ' active' : null;

            // Check if user has the privilege to access this section
            if($list[$i]['privilege'] == null || $this->privileges($list[$i]['privilege']) == 1)
            {
                if($list[$i]['visible'] !== null && $list[$i]['visible'] == $current)
                {
                    $build .= '<a href="' . site_url($list[$i]['url']) . '" class="ns-item' . $active . '">' . $list[$i]['text'] . '</a>';
                }
                elseif($list[$i]['visible'] == null)
                {
                    $build .= '<a href="' . site_url($list[$i]['url']) . '" class="ns-item' . $active . '">' . $list[$i]['text'] . '</a>';
                }
            }

        }

        // closing tags
        $build .= '</nav><button class="ns-btn ns-btn-left" aria-label="Scroll left"><i class="icon-chevron-left"></i></button><button class="ns-btn ns-btn-right" aria-label="Scroll right"><i class="icon-chevron-right"></i></button><div class="ns-border"></div></div>';

        return $build;
    }

    /**
	 * User Privileges
	 * --------------------------------------------
     *
     * @return string $key The privileges array key
     * @return bool $switch Switch between statements
     * @return mixed
	 */
    public function privileges($key = null, $switch = false)
    {
        $privileges = [
            'add' => $this->session->privilege_create,
            'edit' => $this->session->privilege_update,
            'trash' => $this->session->privilege_trash,
            'delete' => $this->session->privilege_delete,
        ];

        if($switch == true)
        {
            // Return true if key exists and value is 1 else false
            return (array_key_exists($key, $privileges) && $privileges[$key] == 1) ? true : false;
        }
        else
        {
            // Return array if key is null else string
            return ($key == null) ? $privileges : $privileges[$key];
        }
    }

    /**
     * Service Categories
     * --------------------------------------------
     *
     * @return array
     */
    public function service_categories()
    {
        $categories = [
            'Records' => 'Records',
            'Special Examinations' => 'Special Examinations',
            'Surgical Procedures' => 'Surgical Procedures',
            'Injections' => 'Injections'
        ];

        return $categories;
    }

    /**
     * User Titles
     * --------------------------------------------
     *
     * @return array
     */
    public function user_titles()
    {
        $titles = [
            'Mr.' => 'Mr.',
            'Mrs.' => 'Mrs.',
            'Miss' => 'Miss',
            'Dr.' => 'Dr.'
        ];

        return $titles;
    }

    /**
     * Marrital Status
     * --------------------------------------------
     *
     * @return array
     */
    public function marrital_status()
    {
        $status = [
            'Single' => 'Single',
            'Married' => 'Married',
            'Divorced' => 'Divorced',
            'Widowed' => 'Widowed'
        ];

        return $status;
    }

    /**
     *  Religion
     * --------------------------------------------
     *
     * @return array
     */
    public function religion()
    {
        $status = [
            'Christian' => 'Christian',
            'Muslim' => 'Muslim',
            'Traditional' => 'Traditional',
            'Other' => 'Other',
            'None' => 'None'
        ];

        return $status;
    }

    /**
     * User Roles
     * --------------------------------------------
     *
     * @param string $key The role number or key
     * @return array
     */
    public function user_roles($key = null)
    {
        $roles = $this->db->columns(['role_level', 'role_name'])
                          ->from('roles')
                          ->select_all(null, PDO::FETCH_KEY_PAIR);

        return ($key != null) ? $roles[$key] : $roles;
    }

    /**
     * Occupations
     * --------------------------------------------
     *
     * @param string $key The role number or key
     * @return array
     */
    public function occupations($key = null)
    {
        $occupations = $this->db->columns(['occupation_id', 'occupation_name'])
                          ->from('occupations')
                          ->order('occupation_name')
                          ->select_all(null, PDO::FETCH_KEY_PAIR);

        return ($key != null) ? $occupations[$key] : $occupations;
    }

    /**
	 * Alert Message
	 * --------------------------------------------
     *
	 * @param string $type The type of alert
	 * @param string $message Alert message
	 * @param string $text Text only alert
	 * @return string
	 */
	public function alert($type, $message, $text = false)
    {
        if($text == false)
        {
            $type = ($type == null) ? '' : ' alert-' . $type;

            return '<div class="alert ' . $type . '" role="alert" data-auto-close="15"><div class="alert-content"><p>' . $message . '</p></div></div>';
        }
        else
        {
            switch ($type)
            {
                case 'success':
                    return '<p class="text-success"><i class="icon-check-circle mr-1"></i>' . $message . '</p>';
                    break;

                case 'danger':
                    return '<p class="text-danger"><i class="icon-times-circle mr-1"></i>' . $message . '</p>';
                    break;

                case 'warning':
                    return '<p class="text-warning"><i class="icon-exclamation-triangle mr-1"></i>' . $message . '</p>';
                    break;

                default:
                    return '<p class="text-primary"><i class="icon-info-circle mr-1"></i>' . $message . '</p>';
                    break;
            }
        }
	}

    /**
	 * Account Status
	 * --------------------------------------------
     *
	 * @param string $value The value to match
	 * @param string $match The matching or existing value
	 * @return string
	 */
    public function account_status($value, $match)
    {
        if($value == $match)
        {
            return '<span class="badge badge-success">Active</span>';
        }
        else
        {
            return '<span class="badge badge-danger">Locked</span>';
        }
    }

    /**
	 * Checkbox Checked
	 * --------------------------------------------
     *
	 * @param mixed $value the value to compare
	 * @param mixed $match where to compare
	 * @return string
	 */
	public function is_checked($value, $match){

		if($value == $match){

			echo "checked";

		}
	}

    /**
	 * Fetch Active User's Info from Database
	 * --------------------------------------------
     *
	 * @param string $column The column name
	 */
    public function user_info($column)
    {
        $query = $this->db->columns([
                        'U.title',
                        'U.firstname',
                        'U.lastname',
                        'R.role_name'
                    ])
                    ->from('users U')
                    ->join('roles R')
                    ->on('U.role_id = R.role_id')
                    ->where('user_id = ?')
                    ->select([$this->session->user_id]);
        return $query[$column];
    }

    /**
	 * Restrict Access
	 * --------------------------------------------
     *
     * @return string $key The privileges array key
     * @return bool $return Return true or false instead of redirecting
     * @return array $role The role array
     * @return bool $ajax Set to true to redirect with javascript
     * @return void
	 */
    public function restrict_access($key, $return = false, $role = null, $ajax = false)
    {
        // Privileges array
        $privileges = [
            'add' => $this->session->privilege_create,
            'edit' => $this->session->privilege_update,
            'trash' => $this->session->privilege_trash,
            'delete' => $this->session->privilege_delete,
        ];

        $redirect_url = site_url('access-denied');

        if($role == null && $privileges[$key] == 0)
        {
            if($ajax === true)
            {
                exit('<script>window.location = "' . $redirect_url . '";</script>');
            }
            elseif($return === true)
            {
                return true;
            }
            else
            {
                header("Location: " . $redirect_url);
            }
        }
        elseif(is_array($role) && !in_array($key, $role))
        {
            if($ajax === true)
            {
                exit('<script>window.location = "' . $redirect_url . '";</script>');
            }
            elseif($return === true)
            {
                return true;
            }
            else
            {
                header("Location: " . $redirect_url);
            }
        }
    }
}
