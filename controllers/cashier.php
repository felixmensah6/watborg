<?php

/*
 |-----------------------------------------------------------------
 | Cashier Controller
 |-----------------------------------------------------------------
 */

class Cashier extends Controller
{
    /**
	 * Index
	 * --------------------------------------------
     *
     * @return string
	 */
    public function index()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(1);

        // View data
        $data['title'] = 'Pending Bills';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/cashier/pending-bills', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Billing
	 * --------------------------------------------
     *
     * @return string
	 */
    public function billing()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Patient Billing';
        $data['currency'] = $this->app->system('app_currency');

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/cashier/billing', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Daily Transactions
	 * --------------------------------------------
     *
     * @return string
	 */
    public function daily_transactions()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // View data
        $data['title'] = 'Daily Transactions';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/cashier/daily-transactions', $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Load Pending Bills into Table
	 * --------------------------------------------
     *
     * @return void
	 */
    public function display_pending_bills()
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load library
        $this->load->library('datatables');

        $columns = [
            'bill_summary_id' => function($value, $row, $num)
            {
                return $num++;
            },
            'hospital_number' => null,
            'patient_name' => function($value)
            {
                return ucwords($value);
            },
            'patient_phone' => null,
            'patient_type' => null,
            'debit' => function($value)
            {
                return number_format($value, 2);
            },
            'credit' => function($value)
            {
                return number_format($value, 2);
            },
            'bill_summary_date' => function($value)
            {
                return time_format($value, 'DD MMM. YYYY');
            },
            null => function($value)
            {
                $actions = '<a href="' . site_url('records/patient-profile/') . $this->security->encrypt_id($value['bill_summary_id']) . '" class="btn btn-default btn-xs">Pay Bill</a> ';

                return $actions;
            }
        ];


        $this->datatables->render_advance(
            $columns,
            'SELECT {TOTAL_ROWS} *
            FROM bill_summaries
            WHERE {SEARCH_COLUMN} AND paid_status = 0
            ORDER BY {ORDER_COLUMN} {ORDER_DIR} {LIMIT_ROWS}'
        );
    }
}
