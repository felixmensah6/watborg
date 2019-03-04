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
 	  * Create Attendance
 	  * --------------------------------------------
      *
      * @return void
 	  */
     public function insert_attendance()
     {
         $values = func_get_args();
         $this->db
              ->table('patient_attendance')
              ->columns([
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
      * @return void
 	  */
     public function patient_exists($id)
     {
         return $this->db->row_count(
                    'SELECT hospital_number FROM patients WHERE hospital_number = ?',
                    [$id]
                );
     }

     /**
  	  * Create Service Bills
  	  * --------------------------------------------
       *
       * @return void
  	  */
      public function insert_service_bills()
      {
          $values = func_get_args();
          $this->db
               ->table('service_bills')
               ->columns([
                   'bill_type',
                   'bill_description',
                   'bill_date',
                   'patient_id',
                   'patient_name',
                   'patient_type',
                   'attendance_id',
                   'reference_number',
                   'debit',
                   'credit',
                   'created_by',
                   'created_at',
                   'updated_at'
               ], true)
               ->insert($values);
      }
}
