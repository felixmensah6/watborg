<?php

/*
 |-----------------------------------------------------------------
 | Data Model
 |-----------------------------------------------------------------
 */

class Data_Model extends Model
{
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
        $results = $this->db->columns(['district_id', 'district_name'])
                          ->from('districts')
                          ->where('district_name LIKE ?')
                          ->order('district_name')
                          ->limit(10)
                          ->select_all(['%' . $query . '%']);

        // Rename array keys
        $districts = array_map(function($district) {
            return array(
                'id' => $district['district_id'],
                'text' => $district['district_name']
            );
        }, $results);

        // Encode array to json format
        $json = json_encode(['results' => $districts]);

        // Return json encoded results
        return $json;
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
        $results = $this->db->columns(['locality_id', 'locality_name'])
                          ->from('localities')
                          ->where('locality_name LIKE ?')
                          ->order('locality_name')
                          ->limit(10)
                          ->select_all(['%' . $query . '%']);

        // Rename array keys
        $localities = array_map(function($locality) {
            return array(
                'id' => $locality['locality_id'],
                'text' => $locality['locality_name']
            );
        }, $results);

        // Encode array to json format
        $json = json_encode(['results' => $localities]);

        // Return json encoded results
        return $json;
    }
}
