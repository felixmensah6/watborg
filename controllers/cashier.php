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
     * @return void
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
     * @param int $bill_id The bill id
     * @return void
	 */
    public function billing($bill_id = '')
    {
        // Check for an active session else redirect
        $this->app->check_active_session(2);

        // Load model
        $this->load->model('records-model');

        // Decrypted bill id
        $id = $this->security->decrypt_id($bill_id);

        // View data
        $data['title'] = ($bill_id != '') ? 'Bill Payment' : 'Guest Billing';
        $data['currency'] = $this->app->system('app_currency');
        $data['row'] = $this->records_model->bill_info($id);
        $data['bill_items'] = $this->records_model->bill_items_info('Bill', $id);

        // Select view depending on patient type
        $view = ($bill_id != '') ? 'bill-payment' : 'guest-billing';

        // Load view
        $this->load->view('templates/header');
        $this->load->view('pages/cashier/' . $view, $data);
        $this->load->view('templates/footer');
    }

    /**
	 * Daily Transactions
	 * --------------------------------------------
     *
     * @return void
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
            'bill_id' => function($value, $row, $num)
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
            'bill_debit' => function($value)
            {
                return number_format($value, 2);
            },
            'receipt_number' => null,
            'bill_date' => function($value)
            {
                return time_format($value, 'DD MMM. YYYY');
            },
            null => function($value)
            {
                $actions = '<a href="' . site_url('cashier/billing/') . $this->security->encrypt_id($value['bill_id']) . '" class="btn btn-default btn-xs">Pay Bill</a> ';

                return $actions;
            }
        ];

        $this->datatables->render_advance(
            $columns,
            'SELECT {TOTAL_ROWS} *
            FROM bills
            WHERE {SEARCH_COLUMN} AND bill_status = 0
            ORDER BY {ORDER_COLUMN} {ORDER_DIR} {LIMIT_ROWS}'
        );
    }
}
