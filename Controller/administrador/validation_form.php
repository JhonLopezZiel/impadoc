<?php 

//Validacion de Datos
function wpbc_validate_required($item)
{
    $messages = array();

    if (empty($item['name_option'])) $messages[] = __('Nombre de Opciones es Requerido', 'wpbc');
    if (empty($item['url_json'])) $messages[] = __('Url de Json Requerido', 'wpbc');
    
    if (empty($messages)) return true;
    return implode('<br />', $messages);
}


	

?> 