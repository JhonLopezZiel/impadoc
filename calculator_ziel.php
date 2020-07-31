<?php

/**
 * Plugin Name: Calculadora de Materiales Ziel Soluciones de Negocio
 * Plugin URI: http://www.ziel.com.co/
 * Description: Este plugin calcula la cantidad de material para utilizar en acabados internos y externos del hogar.
 * Version: 1.0.0
 * Author: Ziel Soluciones de Negocio y Tecnologia
 * Author URI: http://www.ziel.com.co/
 * Requires at least: 4.0
 * Tested up to: 4.3
 *
 * Text Domain: Calculadora Ziel Soluciones de Negocio.
 * Domain Path: /languages/
 */


defined( 'ABSPATH' ) or die( '¡Ziel Soluciones de Tecnologia!' );


//Archivos Migration Table
require plugin_dir_path( __FILE__ ) . 'Migration/index.php';
//Archivos administrador
require plugin_dir_path( __FILE__ ) . 'Controller/administrador/form.php';
//Archivos administrador
require plugin_dir_path( __FILE__ ) . 'Controller/shortcode/index.php';



//Estilos del Interfaz Administrador
function custom_admin_styles() {
    wp_enqueue_style('custom-styles', plugins_url('/css/styles.css', __FILE__ ));
}
//Ejecucion de la funcion 
add_action('admin_enqueue_scripts', 'custom_admin_styles');

