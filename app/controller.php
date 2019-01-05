<?php

/*
 |-----------------------------------------------------------------
 | Controller Class
 |-----------------------------------------------------------------
 |
 | Main controller class which extends all other controllers
 |
 */

class Controller
{
    /**
	 * File extension
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_ext = ".php";

    /**
	 * Models path
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_models_path = MODELS_PATH;

    /**
	 * Views path
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_views_path = VIEWS_PATH;

	/**
	 * Helpers path
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_helpers_path = HELPERS_PATH;

	/**
	 * Language path
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_language_path = LANGUAGE_PATH;

	/**
	 * Libraries path
     * --------------------------------------------
	 *
	 * @var string
	 */
	protected $_libraries_path = LIBRARIES_PATH;

	/**
	 * Constructor
	 * --------------------------------------------
	 *
     * @return void
	 */
    public function __construct()
	{
		// Assign instance of the controller object
		$this->load = $this;

		// Include bootstrap
        include BASEPATH . DS . 'bootstrap.php';

		// Load bootstrap models
		foreach ($bootstrap['model'] as $value)
		{
			$this->load->model($value);
		}

		// Load bootstrap libraries
		foreach ($bootstrap['library'] as $value)
		{
			$this->load->library($value);
		}

		// Load bootstrap helpers
		foreach ($bootstrap['helper'] as $value)
		{
			$this->load->helper($value);
		}
    }

    /**
	 * Model
	 * --------------------------------------------
	 *
	 * @param string $model The model class name
     * @return object
	 */
    protected function model($model)
	{
        if(file_exists($this->_models_path . $model . $this->_ext))
		{
            // Include the required model
            require_once $this->_models_path . $model . $this->_ext;

			// Format method name to use underscore
            $model = str_replace("-", "_", $model);

            // Return the model object
            return $this->{$model} = new $model;
        }
		else
		{
            trigger_error("Model {$model} does not exist");
        }
    }

    /**
	 * View
	 * --------------------------------------------
	 *
	 * @param string $view The view class name
	 * @param array $data A data array of values to parse to the view
     * @return void
	 */
    protected function view($view, $data = [])
	{
        // Create variables with $data array key names and assign values
        // to them to be accessed like normal variables from the view file
        foreach ($data as $key => $value)
		{
        	${$key} = $value;
        }

		// Include healper files
		$this->helper();

        if(file_exists($this->_views_path . $view . $this->_ext))
		{
            // Include the required view
            require_once $this->_views_path . $view . $this->_ext;
        }
		else
		{
			trigger_error("View {$view} does not exist");
        }
    }

	/**
	 * Helpers
	 * --------------------------------------------
	 *
	 * @param mixed $helper The helper name
     * @return void
	 */
    protected function helper($helper = null)
	{
        if($helper !== null && is_string($helper))
		{
			if(file_exists($this->_helpers_path . $helper . $this->_ext))
			{
				// Include the required model
	            require_once $this->_helpers_path . $helper . $this->_ext;
			}
			else
			{
				trigger_error("Helper {$helper} does not exist");
			}
        }
		elseif($helper !== null && is_array($helper))
		{
			foreach ($helper as $filename)
			{
				if(file_exists($this->_helpers_path . $filename . $this->_ext))
				{
					// Include the required helper
		            require_once $this->_helpers_path . $filename . $this->_ext;
				}
				else
				{
					trigger_error("Helper {$filename} does not exist");
				}
			}
        }
    }

	/**
	 * Libraries
	 * --------------------------------------------
	 *
	 * @param string $library The library class name
     * @return object
	 */
    protected function library($library)
	{
		if(is_string($library))
		{
			if(file_exists($this->_libraries_path . $library . $this->_ext))
			{
	            // Include the required library
	            require_once $this->_libraries_path . $library . $this->_ext;

				// Format method name to use underscore
	            $library = str_replace("-", "_", $library);

	            // Return the library object
	            $this->{$library} = new $library;
	        }
			else
			{
	            trigger_error("Library {$library} does not exist");
	        }
		}
		elseif(is_array($library))
		{
			foreach ($library as $filename)
			{
				if(file_exists($this->_libraries_path . $filename . $this->_ext))
				{
					// Include the required library
		            require_once $this->_libraries_path . $filename . $this->_ext;

					// Return the library object
		            $this->{$filename} = new $filename;
				}
				else
				{
					trigger_error("Library {$filename} does not exist");
				}
			}
		}
    }

	/**
	 * Language
	 * --------------------------------------------
	 *
	 * @param string $language The language file name
     * @return object
	 */
    public function language($language)
	{
        if(file_exists($this->_language_path . $language . $this->_ext))
		{
            // Include the required model
            include $this->_language_path . $language . $this->_ext;

			// Format method name to use underscore
			$language = str_replace("-", "_", $language);

			// Create object
			$this->{$language} = new stdClass;

			// Create class properties with session names
            // and assign session values to them
            foreach ($lang as $key => $value)
			{
                $this->{$language}->{$key} = $value;
            }
        }
		else
		{
            trigger_error("Language {$language} does not exist");
        }
    }
}
