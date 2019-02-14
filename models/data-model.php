<?php

/*
 |-----------------------------------------------------------------
 | Data Model
 |-----------------------------------------------------------------
 */

class Data_Model extends Model
{
    /**
     * Fetch Services
     * --------------------------------------------
     *
     * @param string $query The search keyword
     * @return array
     */
    public function services($query)
    {
        // Fetch data from db
        return $this->db
                    ->columns('*')
                    ->from('services')
                    ->where('service_name LIKE ?')
                    ->order('service_name')
                    ->select_all(['%' . $query . '%']);
    }

    /**
     * Fetch Occupations
     * --------------------------------------------
     *
     * @param string $query The search keyword
     * @return array
     */
    public function occupations($query)
    {
        // Fetch data from db
        return $this->db
                    ->columns(['occupation_name'])
                    ->from('occupations')
                    ->where('occupation_name LIKE ?')
                    ->order('occupation_name')
                    ->select_all(['%' . $query . '%']);
    }

    /**
     * Fetch Districts
     * --------------------------------------------
     *
     * @param string $query The search keyword
     * @return array
     */
    public function districts($query)
    {
        // Fetch data from db
        return $this->db
                    ->columns(['district_name'])
                    ->from('districts')
                    ->where('district_name LIKE ?')
                    ->order('district_name')
                    ->select_all(['%' . $query . '%']);
    }

    /**
     * Fetch Localities
     * --------------------------------------------
     *
     * @param string $query The search keyword
     * @return array
     */
    public function localities($query)
    {
        // Fetch data from db
        return $this->db
                    ->columns(['locality_name'])
                    ->from('localities')
                    ->where('locality_name LIKE ?')
                    ->order('locality_name')
                    ->select_all(['%' . $query . '%']);
    }
}
