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

    /**
     * Fetch Drug Data
     * --------------------------------------------
     *
     * @param string $drug_id The drug id
     * @return array
     */
    public function drug_info($drug_id)
    {
        return $this->db
                    ->columns('*')
                    ->from('drugs')
                    ->where('drug_id = ?')
                    ->select([$drug_id]);
    }

    /**
     * Create Drug
     * --------------------------------------------
     *
     * @return void
     */
    public function insert_drug()
    {
        $values = func_get_args();
        $this->db
             ->table('drugs')
             ->columns([
                 'drug_name',
                 'drug_cost'
             ], true)
             ->insert($values);
    }

    /**
     * Update Drug
     * --------------------------------------------
     *
     * @return void
     */
    public function update_drug()
    {
        $values = func_get_args();
        $this->db
             ->table('drugs')
             ->set([
                 'drug_name' => '?',
                 'drug_cost' => '?'])
             ->where('drug_id = ?')
             ->update($values);
    }

    /**
     * Delete Drug
     * --------------------------------------------
     *
     * @param int $drug_id The drug id
     * @return void
     */
    public function delete_drug($drug_id)
    {
        $this->db
             ->table('drugs')
             ->where('drug_id = ?')
             ->delete([$drug_id]);
    }

    /**
     * Fetch Occupation Data
     * --------------------------------------------
     *
     * @param string $occupation_id The occupation id
     * @return array
     */
    public function occupation_info($occupation_id)
    {
        return $this->db
                    ->columns('*')
                    ->from('occupations')
                    ->where('occupation_id = ?')
                    ->select([$occupation_id]);
    }

    /**
     * Occupation Exists
     * --------------------------------------------
     *
     * @param string $value The WHERE clause value
     * @return void
     */
    public function occupation_exists($value)
    {
        return $this->db->row_count(
            'SELECT occupation_name FROM occupations WHERE occupation_name = ?',
            [$value]
        );
    }

    /**
     * Create Occupation
     * --------------------------------------------
     *
     * @return void
     */
    public function insert_occupation()
    {
        $values = func_get_args();
        $this->db
             ->table('occupations')
             ->columns([
                  'occupation_name'
             ], true)
             ->insert($values);
    }

    /**
     * Update Occupation
     * --------------------------------------------
     *
     * @return void
     */
    public function update_occupation()
    {
        $values = func_get_args();
        $this->db
             ->table('occupations')
             ->set(['occupation_name' => '?'])
             ->where('occupation_id = ?')
             ->update($values);
    }

    /**
     * Delete Occupation
     * --------------------------------------------
     *
     * @param int $occupation_id The occupation id
     * @return void
     */
    public function delete_occupation($occupation_id)
    {
        $this->db
             ->table('occupations')
             ->where('occupation_id = ?')
             ->delete([$occupation_id]);
    }
}
