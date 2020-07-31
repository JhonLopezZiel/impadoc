<?php

    
    //Archivos Data Controller
    require plugin_dir_path( __FILE__ ) . 'data_controller.php';
    //Validation Form Controller
    //require plugin_dir_path( __FILE__ ) . 'validation_form.php';


    add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_script('vue','https://cdn.jsdelivr.net/npm/vue', null, null, true); 
        wp_enqueue_script('axios','https://unpkg.com/axios@0.19.2/dist/axios.min.js', null, null, true); 
        // change to vue.min.js for production
        wp_enqueue_script('main',plugins_url('/calculator_ziel/controller/shortcode/assets/js/main.js'), 'vue', null, true);
    
    });

    function shortcodeCalculator( $atts , $content = null) {
  
        $data = new Class_wpdb();
        $option = $data->ConsultarOption();
        $tipo_superficie = array();
        $tipo_acabado = array();
        $actividad = array();

        foreach ($option as $key => $value) {
            $array = explode(",", $value['name_option']);
            array_push($tipo_superficie,$array[0]);
            array_push($tipo_acabado,$array[1]);
            array_push($actividad,$array[2]);    
        }
        $tipo_superficie = array_values(array_unique($tipo_superficie));   
        $tipo_acabado = array_values(array_unique($tipo_acabado));   
        $actividad = array_values(array_unique($actividad)); 

    ?>
<div class="cart-container container page-wrapper page-checkout">
    <div class="woocommerce">
        <div class="row pt-0 ">
            <div class="large-12 col  ">
                <div id="customer_details">
                    <div class="clear">
                        <h4>CALCULADORA</h4>
                         <div class="woocommerce-billing-fields">
                            <div class="woocommerce-billing-fields__field-wrapper">
                                <p class="form-row form-row-wide address-field update_totals_on_change validate-required" id="billing_country_field" data-priority="40">
                                    <label for="billing_country" class="">
                                        TIPO SUPERFICIE
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <span class="woocommerce-input-wrapper">
                                        <select name="billing_country" id="billing_country" 
                                            class="country_to_state country_select  select2-hidden-accessible" autocomplete="country" tabindex="-1" aria-hidden="true">
                                            <option value="">SELECCIONE UNA OPCIÓN</option>
                                            <?php 
                                                foreach ($tipo_superficie as $key => $value) {
                                                    echo "<option value='".strtoupper($value)."'>".strtoupper($value)."</option>";
                                                }
                                            ?>                                      
                                        </select>
                                    </span>
                                </p>
                                <p class="form-row form-row-wide address-field update_totals_on_change validate-required" id="billing_country_field" data-priority="40">
                                    <label for="billing_country" class="">
                                        TIPO ACABADO
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <span class="woocommerce-input-wrapper">
                                        <select name="billing_country" id="billing_country" 
                                            class="country_to_state country_select  select2-hidden-accessible" autocomplete="country" tabindex="-1" aria-hidden="true">
                                            <option value="">SELECCIONE UNA OPCIÓN</option>
                                            <?php 
                                                foreach ($tipo_acabado as $key => $value) {
                                                    echo "<option value='".strtoupper($value)."'>".strtoupper($value)."</option>";
                                                }
                                            ?>                                      
                                        </select>
                                    </span>
                                </p>
                                <p class="form-row form-row-wide address-field update_totals_on_change validate-required" id="billing_country_field" data-priority="40">
                                    <label for="billing_country" class="">
                                        ACTIVIDAD
                                        <abbr class="required" title="required">*</abbr>
                                    </label>
                                    <span class="woocommerce-input-wrapper">
                                        <select name="billing_country" id="billing_country" 
                                            class="country_to_state country_select  select2-hidden-accessible" autocomplete="country" tabindex="-1" aria-hidden="true">
                                            <option value="">SELECCIONE UNA OPCIÓN</option>
                                            <?php 
                                                foreach ($actividad as $key => $value) {
                                                    echo "<option value='".strtoupper($value)."'>".strtoupper($value)."</option>";
                                                }
                                            ?>                                      
                                        </select>
                                    </span>
                                </p>
                                <p class="form-row form-row-wide" id="billing_company_field" 
                                    data-priority="30">
                                    <label for="billing_company" class="">
                                        CANTIDAD DE METROS (m2)
                                    </label>
                                    <span class="woocommerce-input-wrapper">
                                        <input type="text" class="input-text " placeholder="" value="" >
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <?php
    }

    add_shortcode ('CalculatorMaterialZiel', 'shortcodeCalculator');

?>