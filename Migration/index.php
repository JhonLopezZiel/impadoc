<?php


//Creacion de Tabla Para Manejo Administrativo del Plugin
global $db_version;
$db_version = '1.1.0';

function install_pluggin()
{
    global $wpdb;
    global $db_version;

    $table_name = $wpdb->prefix . 'calculator_ziel';//Nombre de la Tabla 

    $sql = "CREATE TABLE " . $table_name . " (
		id int(11) NOT NULL AUTO_INCREMENT,
		name_option VARCHAR (250) NOT NULL,
		url_json VARCHAR (250) NOT NULL,
		PRIMARY KEY  (id)
    );";

    require_once(ABSPATH.'wp-admin/includes/upgrade.php');
    dbDelta($sql);

    add_option('db_version', $db_version);

    $installed_ver = get_option('db_version');
    if ($installed_ver != $db_version) {
        $sql = "CREATE TABLE " . $table_name . " (
			id int(11) NOT NULL AUTO_INCREMENT,
			name_option VARCHAR (250) NOT NULL,
			url_json VARCHAR (250) NOT NULL,
			PRIMARY KEY  (id)
	    );";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}
//Ejecucion de la funcion 
register_activation_hook(__FILE__, 'install_pluggin');

//Datos de Tabla en Instalacion
function install_data()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'calculator_ziel'; 
}
register_activation_hook(__FILE__, 'install_data');

//Actualizacion de las tablas por cambio de Versiones
function update_db_check()
{
    global $db_version;
    if (get_site_option('db_version') != $db_version) {
        install_pluggin();
    }
}
add_action('plugins_loaded', 'update_db_check');


