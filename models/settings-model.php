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
                  'service_cost'
              ], true)
              ->insert($values);
     }

     /**
 	   * Update Service
 	   * --------------------------------------------
       *
       * @return void
 	   */
     public function update_service()
     {
         $values = func_get_args();
         $this->db
              ->table('services')
              ->set([
                 'service_name' => '?',
                 'service_category' => '?',
                 'service_cost' => '?'])
              ->where('service_id = ?')
              ->update($values);
     }


     /**
      * Delete Service
      * --------------------------------------------
      *
      * @param int $service_id The service id
      * @return void
      */
     public function delete_service($service_id)
     {
         $this->db
              ->table('services')
              ->where('service_id = ?')
              ->delete([$service_id]);
     }
}
