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

	static function getAll($sql)
	{
		
		$query = self::_query($sql);
		
		$arr = array();
		while ($row = mysql_fetch_assoc($query)) {
			$arr[] = $row;
		}

		self::close();
		return $arr;
	}

	static function getOne($sql)
	{
		self::connect();
		$query = self::_query($sql);

		$res = '';
		
		$row = mysql_fetch_row($query);
		if ($row !== false)	{
			$res = $row[0];
		} else {
			$res = '';
		}

		self::close();
		return $res;
	}

	static function execSql($sql, $insertid=true)
	{
		self::connect();
		self::_query($sql);

		$res = true;
		if ($insertid) {
			$res = mysql_insert_id(self::$conn);
		}
		self::close();
		return $res;
	}

	static function _query($sql)
	{
		self::connect();
		$re = mysql_query($sql, self::$conn);
		if ($re == false) {
			$err = sprintf('MySQL Error [%s] [%s] [%s]', mysql_errno(self::$conn) ,mysql_error(self::$conn), $sql);
			ShareError($err);
		}
		return $re;
	}
}

class ShareMysqlTool
{
	static function insertSql($table, $vals)
	{
		$fields = array_keys($vals);
		$values = array_values($vals);

		foreach ($values as $k=>$v) {
			$values[$k] = self::escape_string($v);
		}

		$sql = "insert into {$table} (`". implode('`,`', $fields) ."`) values ('". implode("','", $values) ."'); "; 
		return $sql;
	}
	
	static function escape_string($str)
	{
		return mysql_real_escape_string($str);
	}
	
	static function querySql($table, $where)
	{
		$arr = array("1=1");
		foreach ($where as $k=>$v) {
			$arr[] = " $k = '". self::escape_string($v) . "' ";
		}

		$sql = "select * from {$table} where ". implode(' and ', $arr) . ";"; 
		return $sql;
	}
}