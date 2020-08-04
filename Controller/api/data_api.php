<?php

	if(empty($_GET)){
		return;
	}	
	$action = $_GET["action"];
	$tipo_superficie = trim(str_replace("'", "", $_GET["tipo_superficie"]));
	$tipo_acabado = trim(str_replace("'", "", $_GET["tipo_acabado"]));
	$actividad = trim(str_replace("'", "", $_GET["actividad"]));

	switch ($action) {
		case 'comboMaterial':

			global $wpdb, $table_prefix;
			$path = $_SERVER['DOCUMENT_ROOT'];

			if(!isset($wpdb))
			{
				include_once $path . '/famouscali/wp-config.php';
				include_once $path . '/famouscali/wp-load.php';
				include_once $path . '/famouscali/wp-includes/wp-db.php';
				include_once $path . '/famouscali/wp-includes/pluggable.php';
				return;
			}
			
			$table_name = $wpdb->prefix . 'calculator_ziel';
			$query = "SELECT url_json FROM $table_name WHERE name_option LIKE '".$tipo_superficie.",%".$tipo_acabado.",%".$actividad."';";
			$result = $wpdb->get_results($query, ARRAY_A);

			echo json_encode($result);
			
			break;
		
		default:
			
			break;
	}
	
?>