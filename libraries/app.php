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

            // Display menu group
            $build .= '<li class="sidebar-nav-group">' . $list[$i]['group'] . '</li>';

            // Count menus
            $total_menus = count($list[$i]['menu']);

            // Loop and display menus
            for($x = 0; $x < $total_menus; $x++)
            {
                // Add active class to active menu
                $is_active = ($active == $list[$i]['menu'][$x]['url']) ? 'active ' : '';

                // Display menus
                $build .= '<li><a href="' . site_url($list[$i]['menu'][$x]['url']) . '" class="' . $is_active . '' . $list[$i]['menu'][$x]['class'] . '" ' . $list[$i]['menu'][$x]['attributes'] . '><i class="' . $list[$i]['menu'][$x]['icon'] . '"></i> ' . $list[$i]['menu'][$x]['text'] . '</a></li>';
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
     * User Roles
     * --------------------------------------------
     *
     * @param string $key The role number or key
     * @return array
     */
    public function user_roles($key = null)
    {
        $roles = [
            '1' => 'Administrator',
            '2' => 'Doctor',
            '3' => 'Nurse',
            '4' => 'Accountant',
            '5' => 'Cashier',
            '6' => 'Records'
        ];

        return ($key != null) ? $roles[$key] : $roles;
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

            return '<div class="alert ' . $type . '" role="alert" data-auto-close="10"><div class="alert-content"><p>' . $message . '</p></div></div>';
        }
        else
        {
            if($type == 'success')
            {
                return '<p class="text-success"><i class="icon-check-circle mr-1"></i>' . $message . '</p>';
            }
            else
            {
                return '<p class="text-danger"><i class="icon-times-circle mr-1"></i>' . $message . '</p>';
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

}
