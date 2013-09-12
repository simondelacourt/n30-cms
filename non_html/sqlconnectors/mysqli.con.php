<?php

/**
 * n30-cms mysql connector
 * (C) 2008 CT.Studios
 * version: 0.3.1
 */
class sql
{
	public $connection;
	public $q_count = 0;
	public $connected = false;
	public $version = 0.3;
	public function __construct ()
	{
	}
	public function __destruct ()
	{
		if ($this->connected)
		{
			@mysqli_close($this->connection);
		}
	}
	/**
	 * Connect function
	 *
	 * @param string $host
	 * @param string $user
	 * @param string $password
	 * @param int $port
	 * @param string $path
	 * @param boolean $persistant
	 * @return mysql connection
	 */
	public function connect ($host, $user, $password, $port = 3306, $path = NULL, $persistant = false)
	{
		$this->connection = @new mysqli($host, $user, $password);
		/* check connection */
		if (mysqli_connect_errno())
		{
			$this->connected = false;
			throw new sqlException('MySQL Error: ' . @mysqli_connect_error());
		} else
		{
			$this->connected = true;
			return (true);
		}
	}
	/**
	 * select your database
	 *
	 * @param string $db
	 * @return boolean
	 */
	public function select_db ($db)
	{
		if ($this->connected)
		{
			$this->connection->select_db($db);
			if (mysqli_errno($this->connection))
			{
				$this->connected = false;
				throw new sqlException('MySQL Error: ' . mysqli_error($this->connection));
			} else
			{
				$this->connected = true;
				return (true);
			}
		} else
		{
			return (false);
		}
	}
	/**
	 * execute a query
	 *
	 * @param string $query
	 * @param boolean $die
	 * @return mysql resultset
	 */
	public function query ($query, $die = true)
	{
		if ($this->connected)
		{
			$res = $this->connection->query($query);
			if (mysqli_errno($this->connection))
			{
				throw new sqlException('MySQL Error: ' . mysqli_error($this->connection), $query);
			} else
			{
				$this->q_count ++;
				return ($res);
			}
		} else
		{
			throw new sqlException('MySQL Error: no connection');
		}
	}
	/**
	 * fetch a row
	 *
	 * @param string $query
	 * @return array
	 */
	public function fetch_row ($query)
	{
		$QE = $this->query($query);
		return (mysqli_fetch_row($QE));
	}
	/**
	 * fetch data assoc
	 *
	 * @param resorce $data
	 * @return array
	 */
	public function fetch_assoc (&$data)
	{
		return (@mysqli_fetch_assoc($data));
	}
	/**
	 * fetch an array (needs to be renamed, ambigous)
	 *
	 * @param string $query
	 * @return array
	 */
	public function fetch_multiarray ($query)
	{
		$ret = array();
		$QE = $this->query($query);
		while ($res = $this->fetch_assoc($QE))
		{
			$ret[] = $res;
		}
		return ($ret);
	}
	/**
	 * fetches multi array (deprecated)
	 *
	 * @param unknown_type $query
	 * @return unknown
	 */
	public function fetch_array ($query)
	{
		return ($this->fetch_multiarray($query));
	}
	/**
	 * list amount of records
	 *
	 * @param resource $data
	 * @return int
	 */
	public function num_rows (&$data)
	{
		return (@mysqli_num_rows($data));
	}
	/**
	 * @return int
	 */
	public function insert_id ()
	{
		return (mysqli_insert_id($this->connection));
	}

	/**
	 * escape string
	 *
	 * @param string $string
	 * @return string
	 */
	public function escape_string ($string)
	{
		return ($this->connection->real_escape_string($string));
	}
}

/**
 * MySQLi Exception
 */
class sqlException extends Exception
{
	public $mode = 'sqlexception';
	public $query;
	public $debuginfo;
	public $mdata;
	public $title = 'SQL Exception';
	public function __construct ($message, $query = '', $code = 0)
	{
		$this->query = $query;
		$this->mdata = $this->message;
		$this->debuginfo = "<p><strong>Query:</strong> " . $query . "</p>";
		parent::__construct($message, $code);
	}
	public function explainError ()
	{
		return ($this->message);
	}
}
?>