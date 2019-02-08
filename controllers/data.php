<?php

/*
 |-----------------------------------------------------------------
 | Data Controller
 |-----------------------------------------------------------------
 */

class Data extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return string
	 */
    public function index()
    {
        
    }

    /**
	 * Fetch Districts
	 * --------------------------------------------
     *
     * @return void
	 */
    public function districts()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Load model
        $this->load->model('data-model');
        $query = $this->input->get('q');
        echo $this->data_model->districts($query);
    }

    /**
	 * Fetch Localities
	 * --------------------------------------------
     *
     * @return void
	 */
    public function localities()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Load model
        $this->load->model('data-model');
        $query = $this->input->get('q');
        echo $this->data_model->localities($query);
    }
}
