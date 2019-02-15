<?php

/*
 |-----------------------------------------------------------------
 | Settings Model
 |-----------------------------------------------------------------
 */

class Settings_Model extends Model
{
    /**
     * Fetch Services Data
     * --------------------------------------------
     *
     * @param string $service_id The service id
     * @return array
     */
    public function service_info($service_id)
    {
        return $this->db
                    ->columns('*')
                    ->from('services')
                    ->where('service_id = ?')
                    ->select([$service_id]);
    }

    /**
 	  * Create Service
 	  * --------------------------------------------
      *
      * @return void
 	  */
     public function insert_service()
     {
         $values = func_get_args();
         $this->db
              ->table('services')
              ->columns([
                  'service_name',
                  'service_category',
                  'service_price'
              ], true)
              ->insert($values);
     }
}
