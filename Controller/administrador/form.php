<?php


//Archivos Form Controller
require plugin_dir_path( __FILE__ ) . 'form_controller.php';
//Validation Form Controller
require plugin_dir_path( __FILE__ ) . 'validation_form.php';



function calculator_page_handler()
{
    global $wpdb;

    $table = new Custom_List_Table();
    $table->prepare_items();
    //echo "<pre>";
    //print_r(get_class_methods($table));

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'wpbc'), count($_REQUEST['id'])) . '</p></div>';
    }
?>

    <div class="wrap">

        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Calculadora', 'wpbc')?> 
                <a class="add-new-h2"
                     href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=calculator_form');?>"><?php _e('Nuevo', 'wpbc')?></a>
        </h2>
        <?php echo $message; ?>

        <form id="admin-table" method="POST">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
            <?php $table->display() ?>
        </form>

    </div>
<?php
}


function calculator_form_page_handler()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'calculator_ziel'; 

    $message = '';
    $notice = '';

    $default = array(
        'id'            => 0,
        'name_option'   => '',
        'url_json'      => '',
    );


    if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        
        $item = shortcode_atts($default, $_REQUEST);     
        $item_valid = wpbc_validate_required($item);//Validacion de Datos        
        
        if ($item_valid === true) { 
            $item['name_option'] = strtoupper($item['name_option']); 
            if ($item['id'] == 0) {
                $result = $wpdb->insert($table_name, $item);
                $item['id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('El Registro a sido Guardado', 'wpbc');
                } else {
                    $notice = __('Error en la información, por favor Verificar', 'wpbc');
                }
            } else {
                $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
                if ($result) {
                    $message = __('El registro fue actualizado con Exito.', 'wpbc');
                } else {
                    $notice = __('Error en la actulizacion, Por favor Verificar.', 'wpbc');
                }
            }
        } else {            
            $notice = $item_valid;//Captura el Error y/o Mensaje de Validacion 
        }
    }
    else {
        
        $item = $default;
        if (isset($_REQUEST['id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'wpbc');
            }
        }
    }
    //LLamada al formulario de Registrar nuevo Administrador
    add_meta_box('calculator_form_meta_box', 'Registro Nuevo', 'calculator_form_meta_box_handler', 'Calculadora', 'normal', 'default');

    ?>
<div class="wrap">
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <h2><?php _e('Calculadora', 'wpbc')?> 
        <a class="add-new-h2"
            href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=admin');?>">
        <?php _e('Todos', 'wpbc')?></a>
    </h2>

    <?php if (!empty($notice)): ?>
        <div id="notice" class="error"><p><?php echo $notice ?></p></div>
    <?php endif;?>
    <?php if (!empty($message)): ?>
        <div id="message" class="updated"><p><?php echo $message ?></p></div>
    <?php endif;?>

    <form id="form" method="POST">
        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
        
        <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>

        <div class="metabox-holder" id="poststuff">
            <div id="post-body">
                <div id="post-body-content">
                    
                    <?php do_meta_boxes('Calculadora', 'normal', $item); ?>
                    <input type="submit" value="<?php _e('Grabar', 'wpbc')?>" id="submit" class="button-primary" name="submit">
                </div>
            </div>
        </div>
    </form>
</div>
<?php
}

function calculator_form_meta_box_handler($item)
{
    ?>
<tbody >
		
	<div class="formdatabc">		
		
        <form >
    		<div class="form2bc">
                <p>			
        		    <label for="name_option"><?php _e('Nombre de Opciones:', 'wpbc')?></label>
        		<br>	
                    <input id="name_option" name="name_option" type="text" value="<?php echo esc_attr($item['name_option'])?>"
                            required>
        		</p><p>	
                    <label for="url_json"><?php _e('Apellidos:', 'wpbc')?></label>
        		<br>
        		    <input id="url_json" name="url_json" type="text" value="<?php echo esc_attr($item['url_json'])?>"
                            required>
                </p>
            </div>
    	</form>
	</div>
</tbody>
<?php
}
