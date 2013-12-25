<?php
class DBFactory
{
	public static function getMysqlConnexionWithPDO()
{
	$db=new PDO('mysql:host=localhost;dbname=news','root','');
	$db->setAttribute(PDO::AFTER_ERRMODE,PDO::ERRMODE_EXCEPTION);
	return $db;
}
	public static function getMysqlConnexionWithMySQLi(){
		return new MYSQLi('localhost','root','','news');
	}
}
