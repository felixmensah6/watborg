<?php

/*
 |-----------------------------------------------------------------
 | Input Library
 |-----------------------------------------------------------------
 |
 | Reusable input functions
 |
 */

class Input
{
    /**
     * Input field name
     * --------------------------------------------
     *
     * @var string
     */
 	protected $_field;

   /**
    * Input label
    * --------------------------------------------
    *
    * @var string
    */
   protected $_label;

   /**
    * Input validation error
    * --------------------------------------------
    *
    * @var string
    */
   protected $_error;

   /**
    * Http response header
    * --------------------------------------------
    *
    * @var string
    */
   protected $_http_response = "HTTP/1.1 404 Not Found";

   /**
    * Ajax request
    * --------------------------------------------
    *
    * @var string
    */
   protected $_ajax;

   /**
    * Constructor
    * --------------------------------------------
    *
    * @return void
    */
   public function __construct()
   {

   }

    /**
     * POST Input
     * --------------------------------------------
     *
     * @param string $name The input name
     * @param string $rules The sanitization rules
     * @param string $default The default value
     * @param string $case The change case of returned string
     * @return mixed
     */
    public function post($name, $rules = null, $default = null, $case = null)
    {
        // Check if it is set else return default
        $name = (isset($_POST[$name])) ? $_POST[$name] : $default;

        // Trim whitespaces
        $name = (is_array($name)) ? array_map('trim', $name) : trim($name);

        // Sanitize String and return
        return $this->sanitize($name, $rules, $case);
    }


    /**
     * GET Input
     * --------------------------------------------
     *
     * @param string $name The input name
     * @param string $rules The sanitization rules
     * @param string $default The default value
     * @param string $case The change case of returned string
     * @return mixed
     */
    public function get($name, $rules = null, $default = null, $case = null)
    {
        // Check if it is set else return default
        $name = (isset($_GET[$name])) ? $_GET[$name] : $default;

        // Trim whitespaces
        $name = (is_array($name)) ? array_map('trim', $name) : trim($name);

        // Sanitize String and return
        return $this->sanitize($name, $rules, $case);
    }


    /**
     * FILE Input
     * --------------------------------------------
     *
     * @param string $name The files input name
     * @param string $type The files input type
     * @return mixed
     * @example files('image_file', 'tmp_name')
     */
    public function file($name, $type = null)
    {
        // Check if it is set else return null
        if($type == null)
        {
            return (isset($_FILES[$name])) ? $_FILES[$name] : null;
        }
        else
        {
            return (isset($_FILES[$name][$type])) ? $_FILES[$name][$type] : null;
        }
    }


    /**
     * Required
     * --------------------------------------------
     *
     * @param void $dummy Just a dummy parameter
     * @return string
     */
    public function required($dummy)
    {
        if(is_array($this->_field))
        {
            if(!count($this->_field) > 0)
            {
                if($this->_error != null)
                {
                    ($this->_ajax) ? header($this->_http_response) : null;
                    exit(sprintf($this->_error['required'], $this->_label));
                }
            }
        }
        else
        {
            if(!strlen($this->_field) > 0 && empty($this->_field) && $this->_field == "" && $this->_field == null)
            {
                if($this->_error != null)
                {
                    ($this->_ajax) ? header($this->_http_response) : null;
                    exit(sprintf($this->_error['required'], $this->_label));
                }
            }
        }
    }

    /**
     * Minimum Length
     * --------------------------------------------
     *
     * @param int $length The min string length
     * @return string
     */
    public function min_length($length)
    {
        if(strlen($this->_field) < $length)
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['min_length'], $this->_label, $length));
            }
        }
    }

    /**
     * Validate Name
     * --------------------------------------------
     *
     * @param void $dummy Just a dummy parameter
     * @return string
     */
    public function valid_name($dummy)
    {
        if(!preg_match("/^[A-Za-z- ]+$/", $this->_field))
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['valid_name'], $this->_label));
            }
        }
    }

    /**
     * Validate Number
     * --------------------------------------------
     *
     * @param void $dummy Just a dummy parameter
     * @return string
     */
    public function valid_number($dummy)
    {
        if(!preg_match("/^[0-9]+$/", $this->_field))
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['valid_number'], $this->_label));
            }
        }
    }


    /**
     * Validate Password Strength
     * --------------------------------------------
     *
     * @param void $level Strength level: low, medium, high
     * @return string
     *
     * low: At least 1 lowercase letter and 1 number
     * medium: At least 1 lowercase, 1 uppercase letter and 1 number
     * high: At least 1 lowercase, 1 uppercase letter, 1 number and 1 special character
     */
    public function valid_password($level)
    {
        $level = strtolower($level);
        $strength = [
            'low' => '^\S*(?=\S*[a-z])(?=\S*[\d])\S*$',
            'medium' => '^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$',
            'high' => '^\S*(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$'
        ];

        if(!preg_match("/" . $strength[$level] . "/", $this->_field))
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['valid_password'], $this->_label));
            }
        }
    }

    /**
     * Validate Username
     * --------------------------------------------
     *
     * @param void $dummy Just a dummy parameter
     * @return string
     */
    public function valid_username($dummy)
    {
        if(!preg_match("/^[A-Za-z0-9]+$/", $this->_field))
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['valid_username'], $this->_label));
            }
        }
    }

    /**
     * Validate Email
     * --------------------------------------------
     *
     * @param void $dummy Just a dummy parameter
     * @return string
     */
    public function valid_email($dummy)
    {
        if(!filter_var($this->_field, FILTER_VALIDATE_EMAIL))
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['valid_email'], $this->_label));
            }
        }
    }

    /**
     * Maximum Length
     * --------------------------------------------
     *
     * @param int $length The max string length
     * @return string
     */
    public function max_length($length)
    {
        if(strlen($this->_field) > $length)
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['max_length'], $this->_label, $length));
            }
        }
    }

    /**
     * Maximum File Size
     * --------------------------------------------
     *
     * @param int $size The max file size
     * @return string
     */
    public function max_size($size)
    {
        if($this->_field > $size)
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['max_size'], $this->_label, number_format($size / 1048567, 2)));
            }
        }
    }

    /**
     * Match Strings
     * --------------------------------------------
     *
     * @param string $string The string to match
     * @return string
     */
    public function matches($string)
    {
        $request = $_SERVER['REQUEST_METHOD'];

        if($request == 'POST')
        {
            $string = $_POST[$string];
        }
        elseif($request == 'GET')
        {
            $string = $_GET[$string];
        }

        if($this->_field != $string)
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['matches'], $this->_label));
            }
        }
    }

    /**
     * Is Unique
     * --------------------------------------------
     *
     * @param string $string The db_table.db_column
     * @return string
     */
    public function is_unique($string)
    {
        $values = explode(".", $string);
        $table = $values[0];
        $column = $values[1];
        $db = new Database;

        $count = $db->row_count(
            "SELECT {$column}
            FROM {$table}
            WHERE {$column} = :{$column}",
            ["{$column}" => $this->_field]
        );

        if($count == 1)
        {
            ($this->_ajax) ? header($this->_http_response) : null;
            exit(sprintf($this->_error['is_unique'], $this->_label));
        }
    }

    /**
     * Valid File Type
     * --------------------------------------------
     *
     * @param string $string File types separated by dot
     * @return string
     */
    public function valid_file($string)
    {
        $types = [
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'mp3' => 'audio/mpeg',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'pdf' => 'application/pdf',
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'csv' => 'application/vnd.ms-excel'
        ];
        $file_type = explode(".", $string);
        $selected_types = [];

        foreach($file_type as $ext)
        {
            $selected_types[] = $types[$ext];
        }

        if(!in_array($this->_field, $selected_types))
        {
            ($this->_ajax) ? header($this->_http_response) : null;
            exit(sprintf($this->_error['valid_file'], $this->_label));
        }
    }

    /**
     * Minimum Value
     * --------------------------------------------
     *
     * @param int $number The min number
     * @return string
     */
    public function min_value($number)
    {
        if($this->_field < $number)
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['min_value'], $this->_label, $number));
            }
        }
    }

    /**
     * Maximum Value
     * --------------------------------------------
     *
     * @param int $number The max number
     * @return string
     */
    public function max_value($number)
    {
        if($this->_field > $number)
        {
            if($this->_error != null)
            {
                ($this->_ajax) ? header($this->_http_response) : null;
                exit(sprintf($this->_error['max_value'], $this->_label, $number));
            }
        }
    }

    /**
     * Validation
     * --------------------------------------------
     *
     * @param string $field The name of the input field
     * @param string $label A human readable name for the field
     * @param string $rules The validation rule
     * @param array $error A user defined error message for rules
     * @param bool $ajax Turn off when not using ajax requests
     * @return string
     *
     * @example
     * validate(
     *      'user',
     *      'Username',
     *      'required|min_length[6]',
     *      [
     *          'required' => 'You did not provide a %s',
     *          'min_length' => 'Your %s cannot be less than %d'
     *      ])
     */
    public function validate($field, $label, $rules, $error = null, $ajax = true)
    {
        // Variables
        $this->_field = $field;
        $this->_label = $label;
        $this->_error = $error;
        $this->_ajax = $ajax;
        $rules = explode("|", $rules);
        $regex = "/\[([^\]]+)\]/";

        foreach ($rules as $value)
        {
            $function = preg_replace($regex, "", $value);
            preg_match($regex, $value, $matches);
            $param = (array_key_exists(1, $matches)) ? $matches[1] : null;

            // Check if method exists
            if(method_exists($this, $function))
            {
                $this->{$function}($param);
            }
            else
            {
                trigger_error("The validation rule {$function} does not exist");
            }
        }
    }

    /**
     * Sanitize
     * --------------------------------------------
     *
     * @param string $name The input name
     * @param string $rules The sanitization rules
     * @param string $case The change case of returned string
     * @return string
     */
    public function sanitize($name, $rules = null, $case = null)
    {
        // Break rules into an array
        $rules = ($rules != null) ? explode("|", $rules) : ['default'];

        // Sanitization filters
        $filters = [
            'string' => FILTER_SANITIZE_STRING,
            'int' => FILTER_SANITIZE_NUMBER_INT,
            'float' => FILTER_SANITIZE_NUMBER_FLOAT,
            'chars' => FILTER_SANITIZE_SPECIAL_CHARS,
            'full_chars' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
            'email' => FILTER_SANITIZE_EMAIL,
            'encode' => FILTER_SANITIZE_ENCODED,
            'quote' => FILTER_SANITIZE_MAGIC_QUOTES,
            'url' => FILTER_SANITIZE_URL,
            'default' => FILTER_DEFAULT
        ];

        // Loop through rules and apply filters
        foreach ($rules as $rule)
        {
            if(array_key_exists($rule, $filters))
            {
                if(is_array($name))
                {
                    $name = filter_var_array($name, $filters[$rule]);
                }
                else
                {
                    $name = filter_var($name, $filters[$rule]);
                }
            }
            else
            {
                trigger_error("The {$rule} sanitization rule does not exist");
            }
        }

        // Apply string casing
        switch ($case)
        {
            case 'lowercase':
                return (is_array($name)) ? array_map('strtolower', $name) : strtolower($name);
                break;

            case 'capitalized':
                if(is_array($name)) {
                    return array_map(function($name){
                        return ucwords(strtolower($name));
                    }, $name);
                }else{
                    return ucwords(strtolower($name));
                }
                break;

            case 'uppercase':
                return (is_array($name)) ? array_map('strtoupper', $name) : strtoupper($name);
                break;

            default:
                return $name;
                break;
        };
    }
}
