<?php

	//Get, generacion del Token para poder gestionar las Apis
	add_action( 'rest_api_init', function () {
	  register_rest_route( 'combo-product/', '/all/', array(
	    'methods' => WP_REST_Server::READABLE,
	    'callback' => 'getComboProductAll',
	  ) );
	} );

	function getComboProductAll(WP_REST_Request $request_data) {
		// Fetching values from API
		global $wpdb;
	    $table_name = $wpdb->prefix . 'calculator_ziel'; 
		$data = $request_data->get_params();
	    if(empty($data['tipo_superficie']) || empty($data['tipo_acabado']) || empty($data['actividad'])){
	        return json_encode('No se encontraron Datos para la busqueda');
	    }


	    /*
		$data['password'] = wpbc_encrypt_password($data);	
		$user = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name WHERE email = %s AND password = %s ", $data['email'], $data['password']), ARRAY_A);
		$hash = password_hash($user[0]['email'], PASSWORD_DEFAULT);
		$wpdb->update($table_name, 
		    // Datos que se remplazarán
		    array( 
		      'token' => "Beader_".$hash
		    ),
		    // Cuando el ID del campo es igual al número 1
		    array( 'id' => $user[0]['id'] )
	  	);
		echo json_encode(array('email'=> $user[0]['email'],'hash'=>$hash));
		*/
	}
?>