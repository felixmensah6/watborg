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
     * Service Exists
     * --------------------------------------------
     *
     * @param string $value The WHERE clause value
     * @return void
     */
    public function service_exists($value)
    {
        return $this->db->row_count(
            'SELECT service_name FROM services WHERE service_name = ?',
            [$value]
        );
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
     * Drug Exists
     * --------------------------------------------
     *
     * @param string $value The WHERE clause value
     * @return void
     */
    public function drug_exists($value)
    {
        return $this->db->row_count(
            'SELECT drug_name FROM drugs WHERE drug_name = ?',
            [$value]
        );
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

    /**
     * Fetch District Data
     * --------------------------------------------
     *
     * @param string $district_id The district id
     * @return array
     */
    public function district_info($district_id)
    {
        return $this->db
                    ->columns('*')
                    ->from('districts')
                    ->where('district_id = ?')
                    ->select([$district_id]);
    }

    /**
     * District Exists
     * --------------------------------------------
     *
     * @param string $value The WHERE clause value
     * @return void
     */
    public function district_exists($value)
    {
        return $this->db->row_count(
            'SELECT district_name FROM districts WHERE district_name = ?',
            [$value]
        );
    }

    /**
     * Create District
     * --------------------------------------------
     *
     * @return void
     */
    public function insert_district()
    {
        $values = func_get_args();
        $this->db
             ->table('districts')
             ->columns([
                 'district_name',
                 'region'
             ], true)
             ->insert($values);
    }

    /**
     * Update District
     * --------------------------------------------
     *
     * @return void
     */
    public function update_district()
    {
        $values = func_get_args();
        $this->db
             ->table('districts')
             ->set([
                 'district_name' => '?',
                 'region' => '?'
             ])
             ->where('district_id = ?')
             ->update($values);
    }

    /**
     * Delete District
     * --------------------------------------------
     *
     * @param int $district_id The district id
     * @return void
     */
    public function delete_district($district_id)
    {
        $this->db
             ->table('districts')
             ->where('district_id = ?')
             ->delete([$district_id]);
    }

    /**
     * Fetch Locality Data
     * --------------------------------------------
     *
     * @param string $locality_id The locality id
     * @return array
     */
    public function locality_info($locality_id)
    {
        return $this->db
                    ->columns('*')
                    ->from('localities')
                    ->where('locality_id = ?')
                    ->select([$locality_id]);
    }

    /**
     * Locality Exists
     * --------------------------------------------
     *
     * @param string $value The WHERE clause value
     * @return void
     */
    public function locality_exists($value)
    {
        return $this->db->row_count(
            'SELECT locality_name FROM localities WHERE locality_name = ?',
            [$value]
        );
    }

    /**
     * Create Locality
     * --------------------------------------------
     *
     * @return void
     */
    public function insert_locality()
    {
        $values = func_get_args();
        $this->db
             ->table('localities')
             ->columns([
                  'locality_name'
             ], true)
             ->insert($values);
    }

    /**
     * Update Locality
     * --------------------------------------------
     *
     * @return void
     */
    public function update_locality()
    {
        $values = func_get_args();
        $this->db
             ->table('localities')
             ->set(['locality_name' => '?'])
             ->where('locality_id = ?')
             ->update($values);
    }

    /**
     * Delete Locality
     * --------------------------------------------
     *
     * @param int $locality_id The locality id
     * @return void
     */
    public function delete_locality($locality_id)
    {
        $this->db
             ->table('localities')
             ->where('locality_id = ?')
             ->delete([$locality_id]);
    }
}
