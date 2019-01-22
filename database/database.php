<?php

/*
 |-----------------------------------------------------------------
 | Environment
 |-----------------------------------------------------------------
 |
 | Reusable database query methods
 |
 */

class Database
{
    /**
	 * Database host
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_host;

    /**
	 * Database username
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_user;

    /**
	 * Database password
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_pass;

    /**
	 * Database driver
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_driver;

    /**
	 * Database name
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_db;

    /**
	 * Database connection port
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_port;

    /**
	 * Database name prefix
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_prefix;

    /**
	 * Database connection socket
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_socket;

    /**
	 * Database character set
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_charset;

    /**
	 * Database connection
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_conn;

	/**
	 * Query builder
     * --------------------------------------------
     *
	 * @var string
	 */
	protected $_query;

    /**
	 * Constructor
	 * --------------------------------------------
     *
     * @return object
	 */
    public function __construct($db = null)
    {
 		// Start connection
 		$this->connect($db);
 	}


    /**
     * Database Connection
     * --------------------------------------------
     *
     * @return object
     */
    public function connect($db = null)
    {
        // Assign parameters to properties
        $this->_driver = env('DB_DRIVER');
        $this->_host = env('DB_HOST');
        $this->_db = ($db == null) ? env('DB_NAME') : $db;
        $this->_user = env('DB_USERNAME');
        $this->_pass = env('DB_PASSWORD');
        $this->_prefix = env('DB_PREFIX');
        $this->_port = env('DB_PORT');
        $this->_socket = env('DB_SOCKET');
        $this->_charset = env('DB_CHARSET');

    	try
        {
        	if($this->_driver == "mysql")
            {
        		// Connection for MySQL
        		if(empty($this->_socket))
                {
        			$dsn = "$this->_driver:host=$this->_host;port=$this->_port;dbname=$this->_prefix$this->_db;charset=$this->_charset";
        		}
                else
                {
        			$dsn = "$this->_driver:unix_socket=$this->_socket;dbname=$this->_prefix$this->_db;charset=$this->_charset";
        		}

        		$options = [
        			PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        			PDO::ATTR_EMULATE_PREPARES   => false,
        		];

        		$this->_conn = new PDO($dsn, $this->_user, $this->_pass, $options);
        	}
            elseif($this->_driver == "mssql")
            {
        		// Connection for SQL Server
        		$this->_conn = new PDO("sqlsrv:Server=$this->_host;Database=$this->_db", $this->_user, $this->_pass);
        	}
    	}
        catch(PDOException $e)
        {
    		// Use Custom Error class to display error on a nicer looking error page
    		Error_Handler::exception($e);
        }
    }

	/**
	 * Prepared Statement
	 * --------------------------------------------
     *
	 * @param string $statement The SQL statement to run
	 * @return array
	 */
	public function prepare($statement)
    {
		return $this->_conn->prepare($statement);
	}

	/**
	 * Query Statements
	 * --------------------------------------------
     *
	 * @param string $statement the SQL statement to run
	 * @return array
	 */
	public function query($statement)
    {
		return $this->_conn->query($statement);
	}

	/**
	 * Row Count
	 * --------------------------------------------
     *
	 * @param string $statement SQL statement with placeholders
	 * @param array $parameters An array of values
	 * @return int
	 */
	public function row_count($statement, $parameters)
    {
		$sql = $this->_conn->prepare($statement);
		$sql->execute($parameters);
		return $sql->rowCount();
	}


	/**
	 * Last Inserted Row ID
	 * --------------------------------------------
     *
	 * @return string $table The table name (SQL Server Only)
	 * @return int
	 */
	public function last_Insert_Id($table = null)
    {
		return $this->_conn->lastInsertId($table);
	}

	/**
	 * Reset Auto Index
	 * --------------------------------------------
     *
	 * @return string $table The table name
	 * @return void
	 */
	public function reset_auto_index($table)
    {
		$this->query("ALTER TABLE {$table} AUTO_INCREMENT = 1");
	}

	/**
	 * Begin Transaction
	 * --------------------------------------------
     *
	 */
    public function begin_transaction()
    {
    	$this->_conn->beginTransaction();
    }

	/**
	 * Commit Transaction
	 * --------------------------------------------
     *
	 */
    public function commit_transaction()
    {
    	$this->_conn->commit();
    }

	/**
	 * Rollback Transaction
	 * --------------------------------------------
     *
	 */
    public function rollback_transaction()
    {
    	$this->_conn->rollback();
    }

	/**
	 * Table Name
	 * --------------------------------------------
     *
	 * @param string $table The table name
	 * @return object
	 */
	public function table($table)
    {
        $this->_query .= $table;
        return $this;
    }

	/**
	 * Table Name for Select Statements
	 * --------------------------------------------
     *
	 * @param string $table The table name
	 * @return object
	 */
	public function from($table)
    {
        $this->_query .= " FROM " . $table;
        return $this;
    }

	/**
	 * Column Names
	 * --------------------------------------------
     *
	 * @param mixed $columns The column names
	 * @param bool $is_insert Set to true for insert queries
	 * @return object
	 */
    public function columns($columns, $is_insert = false)
    {
		if($is_insert == false)
        {
			if(is_array($columns))
            {
				$this->_query .= implode(", ", $columns);
			}
            else
            {
				$this->_query .= $columns;
			}
		}
        else
        {
			if(is_array($columns))
            {
				$this->_query .= " (" . implode(", ", $columns) . ") VALUES (";
				$this->_query .=implode(', ', array_fill(0, count($columns), '?')) . ")";
			}
            else
            {
				$this->_query .= " (" . $columns . ") VALUES (?)";
			}
		}

        return $this;
    }

	/**
	 * Where filter
	 * --------------------------------------------
     *
	 * @param mixed $where The columns to filter
	 * @param string $separator AND / OR clause
	 * @param string $prefix Custom clause
	 * @return object
	 */
	public function where($where, $separator = null, $prefix = null)
    {
		$this->_query .= " WHERE ";
		$prefix = " " . $prefix;

		if(is_array($where))
        {
			$this->_query .= $prefix . " (";

			$where_list = "";

			foreach ($where as $value)
            {
				$where_list .= " " . $value . " " . $separator;
			}

			$this->_query .= ($separator == "AND") ? substr($where_list, 0, -4) : substr($where_list, 0, -3);
			$this->_query .= ")";
		}
        else
        {
			$this->_query .= $prefix . " " . $where;
		}

        return $this;
    }

	/**
	 * Set
	 * --------------------------------------------
     *
	 * @param array $values Column name and values
	 * @return object
	 */
	public function set($values = [])
    {
		$this->_query .= " SET ";
		$value_list = "";

		foreach ($values as $key => $value)
        {
			$value_list .= $key . " = " . $value . ", ";
		}

		$this->_query .= substr($value_list, 0, -2);
        return $this;
    }

	/**
	 * Group By Columns
	 * --------------------------------------------
     *
	 * @param mixed $columns The column names
	 * @return object
	 */
	public function group($columns)
    {
		if(is_array($columns))
        {
			$this->_query .= " GROUP BY " . implode(", ", $columns);
		}
        else
        {
			$this->_query .= " GROUP BY " . $columns;
		}

        return $this;
    }

	/**
	 * Order By Columns
	 * --------------------------------------------
     *
	 * @param mixed $columns The column names
	 * @param string $direction ASC or DESC order
	 * @return object
	 */
	public function order($columns, $direction = "ASC")
    {
		if(is_array($columns))
        {
			$this->_query .= " ORDER BY " . implode(", ", $columns) . " " . $direction;
		}
        else
        {
			$this->_query .= " ORDER BY " . $columns . " " . $direction;
		}

        return $this;
    }

	/**
	 * Limit Rows
	 * --------------------------------------------
     *
	 * @param int $limit Rows to return
	 * @param int $offset Rows limit offset
	 * @return object
	 * NOTE: For limit() to work for SQL Server, you must
	 * include an order by clause in your sql statement
	 */
	public function limit($limit, $offset = null)
    {
		if($this->_driver == "mssql")
        {
			if($offset == null)
            {
				$this->_query .= " OFFSET 0 ROWS FETCH NEXT " . $limit . " ROWS ONLY ";
			}
            else
            {
				$this->_query .= " OFFSET " . $offset . " ROWS FETCH NEXT " . $limit . " ROWS ONLY ";
			}
		}
        else
        {
			if($offset == null)
            {
				$this->_query .= " LIMIT " . $limit;
			}
            else
            {
				$this->_query .= " LIMIT " . $limit . ", " . $offset;
			}
		}

        return $this;
    }

	/**
	 * Join
	 * --------------------------------------------
     *
	 * @param string $table The table name
	 * @return object
	 */
	public function join($table)
    {
        $this->_query .= " INNER JOIN " . $table;
        return $this;
    }

	/**
	 * Join On
	 * --------------------------------------------
     *
	 * @param string $columns The join columns
	 * @return object
	 */
	public function on($columns)
    {
        $this->_query .= " ON " . $columns;
        return $this;
    }

	/**
	 * Sub-Queries
	 * --------------------------------------------
     *
	 * @param string $statement The sub-query statement
	 * @return object
	 */
	public function sub($statement)
    {
        $this->_query .= " ( " . $statement . " ) ";
        return $this;
    }

	/**
	 * Select One Row
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @param string $fetch_mode PDO fetch mode constant without quotes
	 * @return array
	 */
    public function select($parameters = null, $fetch_mode = null)
    {
		$sql = $this->_conn->prepare("SELECT " . $this->_query);
		$sql->execute($parameters);
		$this->_query = null;
		return $sql->fetch($fetch_mode);
    }

	/**
	 * Select Multiple Rows
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @param string $fetch_mode PDO fetch mode constant without quotes
	 * @return string
	 */
    public function select_all($parameters = null, $fetch_mode = null)
    {
		$sql = $this->_conn->prepare("SELECT " . $this->_query);
		$sql->execute($parameters);
		$this->_query = null;
		return $sql->fetchAll($fetch_mode);
    }

	/**
	 * Update Row
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @return int
	 */
    public function update($parameters = null)
    {
		$sql = $this->_conn->prepare('UPDATE ' . $this->_query);
		$sql->execute($parameters);
		$this->_query = null;
		return $sql->rowCount();
    }

	/**
	 * Update Multiple Rows
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @return int
	 */
    public function update_all($parameters)
    {
		// Begin Transaction
		$this->_conn->beginTransaction();

		$sql = $this->_conn->prepare('UPDATE ' . $this->_query);
		$affected = null;

		foreach ($parameters as $value)
        {
			$sql->execute($value);
			$affected += $sql->rowCount();
		}

		// Commit Transaction
		$this->_conn->commit();

		$this->_query = null;
		return $affected;
    }

	/**
	 * Insert Row
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @return void
	 */
    public function insert($parameters)
    {
		$sql = $this->_conn->prepare('INSERT INTO ' . $this->_query);
		$sql->execute($parameters);
		$this->_query = null;
    }

	/**
	 * Insert Multiple Rows
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @return int
	 */
    public function insert_all($parameters)
    {
		$parameters = ($parameters == null) ? null : $parameters;
		$affected = null;

		// Begin Transaction
		$this->_conn->beginTransaction();

		$sql = $this->_conn->prepare('INSERT INTO ' . $this->_query);

		foreach ($parameters as $values)
        {
			$sql->execute($values);
			$affected += $sql->rowCount();
		}

		// Commit Transaction
		$this->_conn->commit();

		$this->_query = null;
		return $affected;
    }

	/**
	 * Delete Row
	 * --------------------------------------------
     *
	 * @param array $parameters The parameters to execute
	 * @return int
	 */
    public function delete($parameters = null){
		$sql = $this->_conn->prepare('DELETE FROM ' . $this->_query);
		$sql->execute($parameters);
		$this->_query = null;
		return $sql->rowCount();
    }
}
