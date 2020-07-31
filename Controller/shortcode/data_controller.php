<?php


global $wpdb, $table_prefix;
$path = $_SERVER['DOCUMENT_ROOT'];
if(!isset($wpdb))
{
	include_once $path . '/wp-config.php';
	include_once $path . '/wp-load.php';
	include_once $path . '/wp-includes/wp-db.php';
	include_once $path . '/wp-includes/pluggable.php';
}

/**
* 
*/
class Class_wpdb
{
	private $_wpdb;
	private $_table_name; 

	function __construct()
	{
		global $wpdb;
		$this->_wpdb = $wpdb;	
    	$this->_table_name = $this->_wpdb->prefix . 'calculator_ziel'; 
	}

	public function ConsultarOption(){

		$query = $this->_wpdb->get_results($this->_wpdb->prepare("SELECT name_option FROM $this->_table_name"), ARRAY_A);
		
		return $query;
	}
}