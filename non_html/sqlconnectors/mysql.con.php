<?php

/**
 * n30-cms mysql connector
 * (C) 2008 CT.Studios
 * version: 0.3
 */
class sql
{
	private $connection;
	public $q_count = 0;
	public $connected = false;
	public $version = 0.3;
	public function connect ($host, $user, $password, $port = 3306, $path = NULL, $persistant = false)
	{
		if ($path == NULL and $port == 3306)
		{
			if ($persistant == true)
			{
				$this->connection = @mysql_pconnect($host, $user, $password) or die(mysql_error());
			} else
			{
				$this->connection = @mysql_connect($host, $user, $password) or die(mysql_error());
			}
		}
		$this->connected = true;
	}
	public function __destruct ()
	{
		if ($this->connected)
		{
			mysql_close();
		}
	}
	public function select_db ($db)
	{
		@mysql_select_db($db, $this->connection) or die(mysql_error());
	}
	public function query ($query, $die = TRUE)
	{
		if (isset($this->connection))
		{
			if ($die == TRUE)
			{
				$res = mysql_query($query, $this->connection) or die($this->errMsg('query', array('error' => mysql_error() , 'query' => $query)));
			} else
			{
				$res = mysql_query($query, $this->connection) or ($res = false);
			}
		} else
		{
			switch ($die)
			{
				case true:
					die('No connection');
					break;
				case false:
					$res = false;
					break;
			}
		}
		$this->q_count ++;
		return ($res);
	}
	public function fetch_row ($query)
	{
		$QE = $this->query($query);
		return (mysql_fetch_row($QE));
	}
	public function fetch_assoc (&$data)
	{
		return (@mysql_fetch_assoc($data));
	}
	public function num_rows (&$data)
	{
		return (@mysql_num_rows($data));
	}
	public function insert_id ()
	{
		return (mysql_insert_id($this->connection));
	}
	public function fetch_array ($query)
	{
		$ret = array();
		$QE = $this->query($query);
		while ($res = $this->fetch_assoc($QE))
		{
			$ret[] = $res;
		}
		return ($ret);
	}
	public function errMsg ($type, $error)
	{
		switch ($type)
		{
			case 'query':
				die($this->formatError('Error in query', 'The query: <br \>' . $error['query'] . ' contains the following errors:<br \>' . $error['error']));
				break;
		}
	}
	public function formatError ($title, $comment)
	{
		return ('<html><head><title>' . $title . '</title</head><body>' . $comment . '</body></html>');
	}
	public function escape_string ($string)
	{
		return (mysql_escape_string($string));
	}
}
?>