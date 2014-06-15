<?php


class ShareMysql
{
	static $conn = null;

	static function connect()
	{
		if (self::$conn == null) {
			$config = ShareConfig();
			$server = $config['DB_CONFIG'][0];
			$username = $config['DB_CONFIG'][1];
			$password = $config['DB_CONFIG'][2];
			$conn = mysql_connect($server, $username, $password);
			if (!$conn) {
				ShareError('Could not connect: ' . mysql_error());
			}
			self::$conn = $conn;
		}
	}

	static function close()
	{
		mysql_close(self::$conn);
	}

	static function insertSql($table, $vals)
	{
		$fields = array_keys($vals);
		$values = array_values($vals);

		$sql = "insert into {$table} (`". implode('`,`', $fields) ."`) values ('". implode("','", $values) ."'); "; 
		return $sql;
	}
	
	static function execSql($sql)
	{
		self::connect();
		$re = mysql_query($sql, self::$conn);
		if (!$re) {
			$err = sprintf('MySQL Error [%s] [%s] [%s]', $sql, mysql_errno(self::$conn) ,mysql_error(self::$conn));
		}
		self::close();
		return true;
	}
}