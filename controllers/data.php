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
	 * Fetch Services
	 * --------------------------------------------
     *
     * @return void
	 */
    public function services()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Load model
        $this->load->model('data-model');

        $query = $this->input->get('q');
        $services = $this->data_model->services($query);

        // Loop and format results to json
        foreach($services as $row)
        {
            $json[] = [
                'id' => $row['service_id'],
                'text' => $row['service_name'],
                'category' => $row['service_category'],
                'price' => number_format($row['service_price'], 2)
                ];
        }

        echo json_encode(['results' => $json]);
    }

    /**
	 * Fetch Occupations
	 * --------------------------------------------
     *
     * @return void
	 */
    public function occupations()
    {
        // Check for an active session else redirect
        $this->app->check_active_session();

        // Load model
        $this->load->model('data-model');

        $query = $this->input->get('q');
        $occupations = $this->data_model->occupations($query);

        // Loop and format results to json
        foreach($occupations as $row)
        {
            $json[] = [
                'id' => $row['occupation_name'],
                'text' => $row['occupation_name']
                ];
        }

        echo json_encode(['results' => $json]);
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
        $districts = $this->data_model->districts($query);

        // Loop and format results to json
        foreach($districts as $row)
        {
            $json[] = [
                'id' => $row['district_name'],
                'text' => $row['district_name']
                ];
        }

        echo json_encode(['results' => $json]);
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
        $localities = $this->data_model->localities($query);

        // Loop and format results to json
        foreach($localities as $row)
        {
            $json[] = [
                'id' => $row['locality_name'],
                'text' => $row['locality_name']
                ];
        }

        echo json_encode(['results' => $json]);
    }
}
