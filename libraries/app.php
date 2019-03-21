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
     * @param array $layer The URL segment to use for matching
     * @return array
     */
    public function check_active_session($layer = null)
    {
        if($layer == null)
        {
            // Check if already logged in and redirect
            $this->session->check("user_id", site_url("login"), true);
        }
        else
        {
            // Check if already logged in and redirect
            $this->session->check("user_id", site_url("login"), true);

            // Page to match
            $page = $this->uri->segment($layer);

            // Fetch result from db
            $result = $this->db->columns('page_roles')->from('page_controls')->where('page_slug = ?')->select([$page]);

            // Build array from page roles
            $roles = explode(',', $result['page_roles']);

            // Check if user has access and redirect
            if(!in_array($this->session->role_level, $roles))
            {
                // Stop execution and redirect
                exit(redirect(site_url("access-denied")));
            }
        }
    }

    /**
     * Sidebar Menu
     * --------------------------------------------
     *
     * @param string $role The user role
     * @return string
     */
    public function sidebar($role)
    {
        // Fetch menu groups
        $menu_groups = $this->db->columns('*')->from('menu_groups')->order('menu_group_order')->select_all();

        // ul start tag
        $build = '<ul class="sidebar-nav">';

        // Current page
        $active = $this->uri->segment(1);

        // Menu group ul start tag
        $build .= '<ul>';

        // Loop and display menu groups
        foreach ($menu_groups as $group)
        {
            // Check if user has access to this section
            if(in_array($role, explode(',', $group['menu_group_roles'])))
            {
                // Display menu group
                $build .= '<li class="sidebar-nav-group">' . $group['menu_group_name'] . '</li>';

                // Fetch menus
                $menus = $this->db->columns('*')->from('menus')->where('menu_group_id = ?')->order('menu_order')->select_all([$group['menu_group_id']]);

                // Loop and display menus
                foreach ($menus as $menu)
                {
                    // Add active class to active menu
                    $is_active = ($active == $menu['menu_url']) ? 'active ' : '';

                    // Fetch submenus
                    $submenus = $this->db->columns('*')->from('submenus')->where('menu_id = ?')->order('submenu_order')->select_all([$menu['menu_id']]);

                    // Check if user has access to this section
                    if(in_array($role, explode(',', $menu['menu_roles'])))
                    {
                        // Check if menu is a parent menu
                        if($menu['menu_parent'] == 1)
                        {
                            // Loop through submenus
                            foreach ($submenus as $submenu)
                            {
                                // Check if user has access to this section
                                if(in_array($role, explode(',', $submenu['submenu_roles'])))
                                {
                                    // Get the first segment of the url for matching
                                    $active_menu = explode('/', $submenu['submenu_url']);

                                    // Add active class to active menu
                                    $is_active = ($active == $active_menu[0]) ? 'active ' : '';

                                    // Display menus
                                    $build .= '<li><a href="' . site_url($submenu['submenu_url']) . '" class="' . $is_active . $menu['menu_class'] . '" ' . $menu['menu_attributes'] . '><i class="' . $menu['menu_icon'] . '"></i> ' . $menu['menu_name'] . '</a></li>';
                                    break;
                                }
                            }
                        }
                        else
                        {
                            // Display menus
                            $build .= '<li><a href="' . site_url($menu['menu_url']) . '" class="' . $is_active . $menu['menu_class'] . '" ' . $menu['menu_attributes'] . '><i class="' . $menu['menu_icon'] . '"></i> ' . $menu['menu_name'] . '</a></li>';
                        }
                    }
                }
            }
        }

        // Menu group ul closing tag
        $build .= '</ul>';

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
     * @param string $role The user role
     * @return string
     */
    public function page_menu($role)
    {
        // Parent page
        $parent = $this->uri->segment(1);

        // Current page
        $current = $this->uri->segment(2);

        // Current page parameter
        $param = ($this->uri->segment(3) != '') ? '/'.$this->uri->segment(3) : '';

        // start tags
        $build = '<div class="nav-scroller" id="page-nav"><nav class="ns-nav"><div class="ns-content">';

        // Fetch submenus
        $submenus = $this->db->columns('*')->from('submenus')->select_all();

        // Loop through submenus
        foreach ($submenus as $submenu)
        {
            // Get the first segment of the url for matching
            $submenu_parent = explode('/', $submenu['submenu_url']);

            if($parent == $submenu_parent[0])
            {
                // Add active css class
                $active = ($current == $submenu['submenu_active']) ? ' active' : null;

                // Check if user has access to this section
                if(in_array($role, explode(',', $submenu['submenu_roles'])))
                {
                    // Display menu
                    if($submenu['submenu_visible'] != null && $submenu['submenu_visible'] == $current)
                    {
                        $build .= '<a href="' . site_url($submenu['submenu_url'] . $param) . '" class="ns-item' . $active . '">' . $submenu['submenu_name'] . '</a>';
                    }
                    elseif($submenu['submenu_visible'] == null)
                    {
                        $build .= '<a href="' . site_url($submenu['submenu_url']) . '" class="ns-item' . $active . '">' . $submenu['submenu_name'] . '</a>';
                    }
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
                          ->where('role_level <> 1')
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
    // public function occupations($key = null)
    // {
    //     $occupations = $this->db->columns(['occupation_id', 'occupation_name'])
    //                       ->from('occupations')
    //                       ->order('occupation_name')
    //                       ->select_all(null, PDO::FETCH_KEY_PAIR);
    //
    //     return ($key != null) ? $occupations[$key] : $occupations;
    // }

    /**
	 * Alert Message
	 * --------------------------------------------
     *
	 * @param string $type The type of alert
	 * @param string $message Alert message
	 * @param string $text Text only alert
	 * @param int $auto_close_delay Seconds to auto close alert
	 * @return string
	 */
	public function alert($type, $message, $text = false, $auto_close_delay = 10)
    {
        if($text == false)
        {
            $type = ($type == null) ? '' : ' alert-' . $type;

            return '<div class="alert alert-dismissible ' . $type . '" role="alert" data-auto-close="' . $auto_close_delay . '"><div class="alert-content"><p>' . $message . '</p></div><button type="button" class="close" data-dismiss="alert"><span>×</span></button></div>';
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
	 * Deny Action
	 * --------------------------------------------
     *
     * @param string $key The privileges array key
     * @return void
	 */
    public function deny_action($key)
    {
        // Privileges array
        $privileges = [
            'add' => $this->session->privilege_create,
            'edit' => $this->session->privilege_update,
            'trash' => $this->session->privilege_trash,
            'delete' => $this->session->privilege_delete,
        ];

        if($privileges[$key] != 1)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
	 * Assign Hospital Number
     * --------------------------------------------
	 *
	 * @param string $action The action to be perfomed
     * @return mixed
	 */
    public function hospital_number($action = null)
    {
        // Variables
        $db = new Database;
        $row = function($row_id) use ($db)
        {
            $query = $db->columns('value')
                        ->from('system_settings')
                        ->where('id = ?')
                        ->select([$row_id]);
            return $query['value'];
        };
        $number = $row('next_hospital_number');
        $year = $row('hospital_number_year');
        $current_year = date('Y');

        // Update next number and year if system year changes
        if($current_year != $year && $current_year > $year)
        {
            $db->table('system_settings')
               ->set(['value' => '?'])
               ->where('id = ?')
               ->update_all([
                   [$current_year, 'hospital_number_year'],
                   ['1', 'next_hospital_number']
               ]);
        }

        switch ($action)
        {
            case 'INCREMENT':
                $db->table('system_settings')
                    ->set(['value' => 'value + 1'])
                    ->where('id = ?')
                    ->update(['next_hospital_number']);
                break;

            default:
                $updated_number = $row('next_hospital_number');
                $updated_year = $row('hospital_number_year');
                $updated_year = '01-01-' . $updated_year;
                return $updated_number . '/' . date('y', strtotime($updated_year));
                break;
        }
    }

    /**
	 * Fetch System Values
	 * --------------------------------------------
     *
	 * @param string $row The row id
	 */
    public function system($row)
    {
        $db = new Database;
        $query = $db->columns('value')
                    ->from('system_settings')
                    ->where('id = ?')
                    ->select([$row]);
        return $query['value'];
    }
}
