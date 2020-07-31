<?php



//Verificacion de Clases 
if (!class_exists('WP_List_Table')) {
    require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
}

//Lista de Administradores de la interfaz
class Custom_List_Table extends WP_List_Table
{ 
    function __construct()
    {
        global $status, $page;

        parent::__construct(array(
            'singular' => 'Medida Calculadora',
            'plural'   => 'Medidas de Calculadoras',
        ));
    }

    function column_default($item, $column_name)
    {
        return $item[$column_name];
    }

    function column_name($item)
    {

        $actions = array(
            'edit' => sprintf('<a href="?page=calculator_form&id=%s">%s</a>', $item['id'], __('Editar', 'wpbc')),
            'delete' => sprintf('<a href="?page=%s&action=delete&id=%s">%s</a>', $_REQUEST['page'], $item['id'], __('Eliminar', 'wpbc')),
        );

        return sprintf('%s %s',
            $item['name_option'],
            $this->row_actions($actions)
        );
    }


    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="id[]" value="%s" />',
            $item['id']
        );
    }

    function get_columns()
    {        
        $columns = array(
            'cb'            => '<input type="checkbox" />', 
            'name'          => __('Opciones', 'wpbc'),
            'url_json'      => __('Url JSON', 'wpbc'),
        );
        return $columns;
    }

    function get_sortable_columns()
    {
        $sortable_columns = array(
            'name'          => array('Opciones', true),
            'url_json'      => array('Url JSON', true),
        );
        return $sortable_columns;
    }

    function get_bulk_actions()
    {
        $actions = array(
            'delete' => 'Delete'
        );
        return $actions;
    }

    function process_bulk_action()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'calculator_ziel'; 

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
            }
        }
    }

    function prepare_items()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'calculator_ziel'; 

        $per_page = 10; 

        $columns = $this->get_columns();
        $hidden = array();
        $sortable = $this->get_sortable_columns();
        
        $this->_column_headers = array($columns, $hidden, $sortable);
       
        $this->process_bulk_action();

        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");

        $paged = isset($_REQUEST['paged']) ? max(0, intval($_REQUEST['paged']) - 1) : 0;
        $orderby = (isset($_REQUEST['orderby']) && in_array($_REQUEST['orderby'], array_keys($this->get_sortable_columns()))) ? $_REQUEST['orderby'] : 'id';
        $order = (isset($_REQUEST['order']) && in_array($_REQUEST['order'], array('asc', 'desc'))) ? $_REQUEST['order'] : 'asc';

        $this->items = $wpdb->get_results($wpdb->prepare("SELECT * FROM $table_name ORDER BY $orderby $order LIMIT %d OFFSET %d", $per_page, $paged), ARRAY_A);

        $this->set_pagination_args(array(
            'total_items' => $total_items, 
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page) 
        ));
    }
}

//Panel Administrativo del Plugin
function wpbc_admin_menu()
{
    add_menu_page('Calculadora de Material', 'Calculadora de Material', 'activate_plugins', 'admin', 'calculator_page_handler');
 
    add_submenu_page('admin','Calculadora de Material', 'Todos', 'activate_plugins', 'admin', 'calculator_page_handler');   
 
    add_submenu_page('admin', 'Calculadora de Material', 'Nuevo', 'activate_plugins', 'calculator_form', 'calculator_form_page_handler');
}
add_action('admin_menu', 'wpbc_admin_menu');
