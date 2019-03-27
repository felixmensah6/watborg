<?php

/*
 |-----------------------------------------------------------------
 | Records Model
 |-----------------------------------------------------------------
 */

class Records_Model extends Model
{
    /**
     * Fetch Patient Data with Hospital Number
     * --------------------------------------------
     *
     * @param string $hospital_number The hospital number
     * @return array
     */
    public function patient_hosp_info($hospital_number)
    {
        return $this->db
                    ->columns('*')
                    ->from('patients')
                    ->where('hospital_number = ?')
                    ->select([$hospital_number]);
    }

    /**
 	  * Create New Patient
 	  * --------------------------------------------
      *
      * @return void
 	  */
     public function insert_patient()
     {
         $values = func_get_args();
         $this->db
              ->table('patients')
              ->columns([
                  'hospital_number',
                  'firstname',
                  'lastname',
                  'gender',
                  'marrital_status',
                  'birthday',
                  'phone',
                  'address',
                  'occupation',
                  'religion',
                  'district',
                  'locality',
                  'relative_name',
                  'relative_phone',
                  'last_attendance',
                  'created_at',
                  'updated_at'
              ], true)
              ->insert($values);

          return $this->db->last_Insert_Id();
     }

     /**
      * Update Last Attendance
      * --------------------------------------------
      *
      * @param string $date The attendance date
      * @param string $datetime The date and time record was updated
      * @param string $id The patient id
      * @return void
      */
     public function update_last_attendance($date, $datetime, $id)
     {
         $this->db
              ->table('patients')
              ->set([
                  'last_attendance' => '?',
                  'updated_at' => '?'
              ])
              ->where('patient_id = ?')
              ->update([$date, $datetime, $id]);
     }

    /**
 	  * Create Attendance
 	  * --------------------------------------------
      *
      * @return void
 	  */
     public function insert_attendance()
     {
         $values = func_get_args();
         $this->db
              ->table('attendance')
              ->columns([
                  'attendance_type',
                  'attendance_date',
                  'patient_id',
                  'created_by',
                  'created_at',
                  'updated_at'
              ], true)
              ->insert($values);

          return $this->db->last_Insert_Id();
     }

    /**
 	  * Patient Exists
 	  * --------------------------------------------
      *
      * @param string $value The WHERE clause value
      * @return void
 	  */
     public function patient_exists($value)
     {
         return $this->db->row_count(
                    'SELECT hospital_number FROM patients WHERE hospital_number = ?',
                    [$value]
                );
     }

     /**
  	  * Create Bills
  	  * --------------------------------------------
       *
       * @return void
  	  */
      public function insert_bills()
      {
          $values = func_get_args();
          $this->db
               ->table('bills')
               ->columns([
                   'bill_date',
                   'bill_debit',
                   'bill_credit',
                   'bill_status',
                   'hospital_number',
                   'patient_name',
                   'patient_phone',
                   'patient_locality',
                   'patient_type',
                   'attendance_id',
                   'receipt_number',
                   'created_at',
                   'updated_at'
               ], true)
               ->insert($values);

           return $this->db->last_Insert_Id();
      }

      /**
       * Update Bill
       * --------------------------------------------
       *
       * @param int $debit The total debit
       * @param int $receipt The receipt number
       * @param int $id The patient id
       * @return void
       */
      public function update_bill($debit, $receipt, $id)
      {
          $this->db
               ->table('bills')
               ->set([
                   'bill_debit' => '?',
                   'receipt_number' => '?'
               ])
               ->where('bill_id = ?')
               ->update([$debit, $receipt, $id]);
      }

     /**
  	  * Create Bill Items
  	  * --------------------------------------------
       *
       * @return void
  	  */
      public function insert_bill_items()
      {
          $values = func_get_args();
          $this->db
               ->table('bill_items')
               ->columns([
                   'bill_item_date',
                   'bill_item_category',
                   'bill_item_type',
                   'bill_item_description',
                   'bill_item_debit',
                   'bill_item_credit',
                   'attendance_id',
                   'bill_id',
                   'created_by',
                   'created_at',
                   'updated_at'
               ], true)
               ->insert($values);
      }

      /**
       * Fetch Bill Data
       * --------------------------------------------
       *
       * @param int $bill_id The bill id
       * @return array
       */
      public function bill_info($bill_id)
      {
          return $this->db
                      ->columns('*')
                      ->from('bills')
                      ->where('bill_id = ?')
                      ->select([$bill_id]);
      }

      /**
       * Fetch Bill Item Data
       * --------------------------------------------
       *
       * @param string $type Whether is a Bill or Payment
       * @param int $bill_id The bill id
       * @return array
       */
      public function bill_items_info($type, $bill_id)
      {
          return $this->db
                      ->columns('*')
                      ->from('bill_items')
                      ->where('bill_item_type = ? AND bill_id = ?')
                      ->select_all([$type, $bill_id]);
      }
}
