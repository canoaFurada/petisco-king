<?php

require 'environment.php';

$config = array();

if (ENVIRONMENT == 'development') {
	define("BASE_URL", "http://ifespplanodeestudo.xyz/");
	define("BASE_URL_STUDENT", "http://ifespplanodeestudo.xyz/");
	$config['dbname'] = 'ifesp_plano_estudo';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'user';
	$config['dbpass'] = 'root';
	$config['charset']  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
} else {
	
	define("BASE_URL", "http://ifespplanodeestudo.xyz/");
	define("BASE_URL_STUDENT", "http://ifespplanodeestudo.xyz/");
	$config['dbname'] = 'ifesp_plano_estudo';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'user';
	$config['dbpass'] = 'root';
	$config['charset']  = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
}

global $db;

try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass'], $config['charset']);

} catch (PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;

}