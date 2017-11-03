<?php

class db
{	
	static $mysqli;

	static public function connectdb()
	{
		self::$mysqli = new mysqli('localhost', 'root', '', 'sender');
	
	}
	static public function disconnectdb()
	{
		self::$mysqli->close();
	}
	static public function querydb($query)
	{
		db::connectdb();
		$result = self::$mysqli->query($query);
		db::disconnectdb();
		return $result;
	}
}

?>