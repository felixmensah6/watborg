<?php

/*
 |-----------------------------------------------------------------
 | Datatables Library
 |-----------------------------------------------------------------
 |
 | Reusable datatable functions
 |
 */

class Datatables
{
    /**
     * Datatables drawer
     * --------------------------------------------
     *
     * @var int
     */
 	protected $_draw = 0;

    /**
     * Datatables filter offset
     * --------------------------------------------
     *
     * @var int
     */
 	protected $_start = 0;

    /**
     * Datatables limit
     * --------------------------------------------
     *
     * @var int
     */
 	protected $_limit = 10;

    /**
     * Datatables order column
     * --------------------------------------------
     *
     * @var int
     */
 	protected $_order_column = 0;

    /**
     * Datatables order direction
     * --------------------------------------------
     *
     * @var string
     */
 	protected $_order_dir = "asc";

    /**
     * Datatables search
     * --------------------------------------------
     *
     * @var string
     */
 	protected $_search = "";

    /**
     * Datatables JSON string
     * --------------------------------------------
     *
     * @var string
     */
 	protected $_json = [];

    /**
     * Database driver
     * --------------------------------------------
     *
     * @var string
     */
 	protected $_driver;

    /**
     * Database connection
     * --------------------------------------------
     *
     * @var object
     */
 	protected $_db;

    /**
     * Datatables table name
     * --------------------------------------------
     *
     * @var string
     */
 	protected $_table = "";

    /**
     * Datatables table columns
     * --------------------------------------------
     *
     * @var array
     */
 	protected $_columns = [];


    /**
	 * Constructor
	 * --------------------------------------------
     *
     * @return void
	 */
    public function __construct()
    {
        // Only display records if its not being viewed directly through the browser
    	if(isset($_GET["draw"]) && is_numeric($_GET["draw"]))
        {
            // Check if draw is available
    		$this->_draw = (isset($_GET["draw"]) && is_numeric($_GET["draw"])) ? (int) $_GET["draw"] : $this->_draw;
            // Check if start is available
    		$this->_start = (isset($_GET["start"]) && is_numeric($_GET["start"])) ? (int) $_GET["start"] : $this->_start;

            // Check if limit is available
    		$this->_limit = (isset($_GET["length"]) && is_numeric($_GET["length"])) ? (int) $_GET["length"] : $this->_limit;

            // Check if order column is available
    		$this->_order_column = (isset($_GET["order"][0]["column"]) && is_numeric($_GET["order"][0]["column"])) ? (int) $_GET["order"][0]["column"] : $this->_order_column;

            // Check if order direction is available
    		$this->_order_dir = (isset($_GET["order"][0]["dir"])) ? $_GET["order"][0]["dir"] : $this->_order_dir;

            // Check if search is available
    		$this->_search = (isset($_GET["search"]["value"])) ? filter_var($_GET["search"]["value"], FILTER_SANITIZE_STRING) : $this->_search;
        }

        // Database connection
        $this->_db = new Database;

        // Current database driver
        $this->_driver = env('DB_DRIVER');
    }


    /**
	 * Render Datatable
	 * --------------------------------------------
     *
     * @param string $table The db table
     * @param array $columns An array of table columns
     * @param int $limit The number of records to fetch
     * @return string
	 */
    public function render($table, $columns = [], $limit = null)
    {
        // Datatables table name
        $this->_table = $table;

        // Only if db is mysql
        if($this->_driver == 'mssql')
        {
            $limit = ($limit === null) ? $this->_limit : $limit;
            $this->_start = 0;
        }
        else
        {
            $limit = ($limit === null) ? $this->_start . ', ' . $this->_limit : $limit;
        }

        // loop through columns and create column array from key
        foreach ($columns as $key => $value)
        {
            ($key != null) ? $this->_columns[] = $key : null;
        }

        // Total number of columns
        $column_count = count($this->_columns);

        // Check for only searchable columns
        $searchable = [];
        for ($i = 0; $i < $column_count; $i++)
        {
            if(isset($_GET["columns"][$i]["searchable"]) && $_GET["columns"][$i]["searchable"] == "true")
            {
                $searchable[] = $this->_columns[$i];
            }
        }

        // Build multi-search query from column list
		$search_list = implode(" LIKE '%".$this->_search."%' OR ", $searchable) . " LIKE '%".$this->_search."%'";

        // SQL statement
        if($this->_driver == 'mssql')
        {
            $sql = "SELECT COUNT(*) OVER () totalrows, *
    				FROM {$this->_table}
    				WHERE ({$search_list})
    				ORDER BY {$this->_columns[$this->_order_column]} {$this->_order_dir}
                    OFFSET {$this->_start} ROWS
                    FETCH NEXT {$limit} ROWS ONLY";
        }
        else
        {
            $sql = "SELECT SQL_CALC_FOUND_ROWS *
    				FROM {$this->_table}
    				WHERE ({$search_list})
    				ORDER BY {$this->_columns[$this->_order_column]} {$this->_order_dir}
    				LIMIT {$limit}";
        }

		// Prepare query and execute
		$statement = $this->_db->prepare($sql);
		$statement->execute();
        $row = $statement->fetchAll();

		// Get the actual total number of records before filtering
		if($this->_driver == 'mssql')
        {
            $totalrows = $this->_db->query($sql)->fetch()["totalrows"];
            $totalrows = ($totalrows == null) ? 0 : $totalrows;
        }
        else
        {
            $totalrows = $this->_db->query("SELECT FOUND_ROWS() as totalrows")->fetch()["totalrows"];
        }

        // Count number of rows
        $count = count($row);

		// Output upper part of JSON formatted object
		echo '
		{
		  "draw": '.$this->_draw.',
		  "recordsTotal": '.$totalrows.',
		  "recordsFiltered": '.$totalrows.',
		  "data": ';

        // Return JSON formatted objects
        for ($i = 0; $i < $count; $i++)
        {
            // Store row numbers
    		$num = $this->_start + 1 + $i;

            $formatted = [];

            foreach ($columns as $name => $format)
            {
                if($name != null && $format != null)
                {
                    $formatted[] = $format($row[$i][$name], $row[$i], $num);
                }
                elseif($name == null && $format != null)
                {
                    $formatted[] = $format($row[$i], $num);
                }
                else
                {
                    $formatted[] = $row[$i][$name];
                }
            }

            $this->_json[] = $formatted;
  		}

        // Output JSON formatted objects
        echo json_encode($this->_json, JSON_UNESCAPED_SLASHES);

        // Output lower part of JSON formatted object
  		echo '
  		} ';

    }


    /**
	 * Render Datatable
	 * --------------------------------------------
     *
     * @param array $columns An array of table columns
     * @param string $sql The SQl statement
     * @param array $remove Column prefixes to remove
     * @param int $limit The number of records to fetch
     * @param array $params An array of prepared statement values
     * @return string
	 */
    public function render_advance($columns = [], $sql, $remove = null, $limit = null, $params = null)
    {
        // Only if db is mysql
        if($this->_driver == 'mssql')
        {
            $limit = ($limit === null) ? $this->_limit : $limit;
            $this->_start = 0;
        }
        else
        {
            $limit = ($limit === null) ? $this->_start . ', ' . $this->_limit : $limit;
        }

        // loop through columns and create column array from key
        foreach ($columns as $key => $value)
        {
            ($key != null) ? $this->_columns[] = $key : null;
        }

        // Total number of columns
        $column_count = count($this->_columns);

        // Check for only searchable columns
        $searchable = [];
        for ($i = 0; $i < $column_count; $i++)
        {
            if(isset($_GET["columns"][$i]["searchable"]) && $_GET["columns"][$i]["searchable"] == "true")
            {
                $searchable[] = $this->_columns[$i];
            }
        }

        // Build multi-search query from column list
		$search_list = implode(" LIKE '%".$this->_search."%' OR ", $searchable) . " LIKE '%".$this->_search."%'";

        // SQL statement
        if($this->_driver == 'mssql')
        {
            $syntax = [
                'TOTAL_ROWS' => 'COUNT(*) OVER () totalrows,',
                'SEARCH_COLUMN' => '(' . $search_list . ')',
                'ORDER_COLUMN' => $this->_columns[$this->_order_column],
                'ORDER_DIR' => $this->_order_dir,
                'LIMIT_ROWS' => ' OFFSET' . $this->_start . 'ROWS FETCH NEXT' . $limit . 'ROWS ONLY'
            ];
        }
        else
        {
            $syntax = [
                'TOTAL_ROWS' => 'SQL_CALC_FOUND_ROWS',
                'SEARCH_COLUMN' => '(' . $search_list . ')',
                'ORDER_COLUMN' => $this->_columns[$this->_order_column],
                'ORDER_DIR' => $this->_order_dir,
                'LIMIT_ROWS' => ' LIMIT ' . $limit
            ];
        }

        foreach($syntax as $key => $value)
        {
            $sql = str_replace('{'.$key.'}', $value, $sql);
        }

		// Prepare query and execute
		$statement = $this->_db->prepare($sql);
		$statement->execute($params);
        $row = $statement->fetchAll();

		// Get the actual total number of records before filtering
		if($this->_driver == 'mssql')
        {
            $totalrows = $this->_db->query($sql)->fetch()["totalrows"];
            $totalrows = ($totalrows == null) ? 0 : $totalrows;
        }
        else
        {
            $totalrows = $this->_db->query("SELECT FOUND_ROWS() as totalrows")->fetch()["totalrows"];
        }

        // Count number of rows
        $count = count($row);

		// Output upper part of JSON formatted object
		echo '
		{
		  "draw": '.$this->_draw.',
		  "recordsTotal": '.$totalrows.',
		  "recordsFiltered": '.$totalrows.',
		  "data": ';

        // Return JSON formatted objects
        for ($i = 0; $i < $count; $i++)
        {
            // Store row numbers
    		$num = $this->_start + 1 + $i;

            $formatted = [];

            foreach ($columns as $name => $format)
            {
                $name = str_replace($remove, '', $name);

                if($name != null && $format != null)
                {
                    $formatted[] = $format($row[$i][$name], $row[$i], $num);
                }
                elseif($name == null && $format != null)
                {
                    $formatted[] = $format($row[$i], $num);
                }
                else
                {
                    $formatted[] = $row[$i][$name];
                }
            }

            $this->_json[] = $formatted;
  		}

        // Output JSON formatted objects
        echo json_encode($this->_json, JSON_UNESCAPED_SLASHES);

        // Output lower part of JSON formatted object
  		echo '
  		} ';
    }
}
