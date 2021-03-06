<?php

class MySQLDB{
	protected $servername;
	protected $username;
	protected $password;
	protected $dbname;
	protected $db_connection;

	public function __construct()
	{
		$ini_array = parse_ini_file("properties.ini");
		$this->servername = $ini_array['servername'];
		$this->username = $ini_array['username'];
		$this->password = $ini_array['password'];
		$this->dbname = $ini_array['dbname'];
	}
	
	public function openConnection()
	{	
		//create connection
		$this->db_connection = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

		//check connection
		if ($this->db_connection->connect_error)
		{
			die ('Could not connect to'.$this->servername.' server');
		}
	}

	public function executeSelectQuery ($sql, $values)
	{
		echo implode("|", $values);
		//escape strings
		$sql = str_replace(array_keys($values), $this->escapeString(array_values($values)), $sql);
		echo $sql;
		$this -> openConnection();
		$query_result = $this -> db_connection -> query($sql);
		$result = [];
		if ($query_result->num_rows > 0)
		{
			while ($row = $query_result -> fetch_assoc())
			{
				$result[] = $row;
			}
		}
		$this -> closeConnection();
		return $result;
	}
	public function executeNonSelectQuery ($sql)
	{
		$this->openConnection();
		$query_result = $this->db_connection->query($sql); // TRUE / FALSE
		$this->closeConnection();
		return $query_result;
	}
	public function closeConnection()
	{
		$this->db_connection->close();
	}
	public function escapeString ($str) {
		$this->openConnection();
		return $this->db_connection->escape_string($str);
	}
}