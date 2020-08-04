<?php

    
    //Archivos Data Controller
    require plugin_dir_path( __FILE__ ) . 'data_controller.php';
    //Validation Form Controller
    //require plugin_dir_path( __FILE__ ) . 'validation_form.php';


    add_action( 'wp_enqueue_scripts', function() {
        wp_enqueue_script('vue','https://cdn.jsdelivr.net/npm/vue', null, null, true); 
        wp_enqueue_script('axios','https://unpkg.com/axios@0.19.2/dist/axios.min.js', null, null, true); 
        wp_enqueue_script('progressbar','https://cdn.jsdelivr.net/npm/vue-progressbar@0.7.5/dist/vue-progressbar.min.js', null, null, true); 
        // change to vue.min.js for production
        wp_enqueue_script('main',plugins_url('/calculator_ziel/controller/shortcode/assets/js/main.js'), 'vue', null, true);
    
    });

    function shortcodeCalculator( $atts , $content = null) {
        
        $data = new Api_Consult();
        $option = $data->ConsultarOption();
        $tipo_superficie = array();
        $tipo_acabado = array();
        $actividad = array();

        foreach ($option as $key => $value) {
            $array = explode(",", $value['name_option']);
            array_push($tipo_superficie,trim($array[0]));
            array_push($tipo_acabado,trim($array[1]));
            array_push($actividad,trim($array[2]));    
        }
        $tipo_superficie = array_values(array_unique($tipo_superficie));   
        $tipo_acabado = array_values(array_unique($tipo_acabado)); 
        $actividad = array_values(array_unique($actividad)); 

    ?>
<div class="cart-container container page-wrapper page-checkout">
    <div class="woocommerce">
        <div class="row pt-0 ">
            <div class="large-12 col">
                <div id="customer_details">
                    <div class="clear">
                        <h4>CALCULADORA</h4>
                        <div id="app" class="woocommerce-billing-fields">
                            <div v-bind:style="styleObject">
                                <div>{{ styleObject }}</div>
                            </div>
                            <div class="woocommerce-billing-fields__field-wrapper">
                                {{ $data }}    
                                <span v-for="e in errors">{{ e }}</span>
                                <template v-if="step == 1">
                                    <p class="form-row form-row-wide address-field update_totals_on_change validate-required" 
                                        data-priority="40">
                                        <label for="tipo_superficie">
                                            TIPO SUPERFICIE
                                            <abbr class="required" title="required">*</abbr>
                                        </label>
                                        <span class="woocommerce-input-wrapper">
                                            <select v-model="form.tipo_superficie" 
                                                class="country_to_state country_select  select2-hidden-accessible">
                                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                                <?php 
                                                    foreach ($tipo_superficie as $key => $value) {
                                                        echo "<option value='".strtoupper($value)."'>".strtoupper($value)."</option>";
                                                    }
                                                ?>                                      
                                            </select>
                                        </span>
                                    </p>
                                    <p class="form-row form-row-wide address-field update_totals_on_change validate-required" 
                                        data-priority="40">
                                        <label for="tipo_acabado">
                                            TIPO ACABADO
                                            <abbr class="required" title="required">*</abbr>
                                        </label>
                                        <span class="woocommerce-input-wrapper">
                                            <select v-model="form.tipo_acabado" 
                                                class="country_to_state country_select  select2-hidden-accessible">
                                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                                <?php 
                                                    foreach ($tipo_acabado as $key => $value) {
                                                        echo "<option value='".strtoupper($value)."'>".strtoupper($value)."</option>";
                                                    }
                                                ?>                                      
                                            </select>
                                        </span>
                                    </p>
                                    <p class="form-row form-row-wide address-field update_totals_on_change validate-required" 
                                        data-priority="40">
                                        <label for="actividad">
                                            ACTIVIDAD
                                            <abbr class="required" title="required">*</abbr>
                                        </label>
                                        <span class="woocommerce-input-wrapper">
                                            <select v-model="form.actividad" 
                                                class="country_to_state country_select  select2-hidden-accessible">
                                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                                <?php 
                                                    foreach ($actividad as $key => $value) {
                                                        echo "<option value='".strtoupper($value)."'>".strtoupper($value)."</option>";
                                                    }
                                                ?>                                      
                                            </select>
                                        </span>
                                    </p>
                                </template>
                                <template v-if="step == 2">
                                    <p class="form-row form-row-wide" data-priority="30">
                                        <label for="medida" class="">
                                            UNIDAD DE METROS (m2)
                                        </label>
                                        <span class="woocommerce-input-wrapper">
                                            <input type="text" class="input-text " v-model="form.medida" >
                                        </span>
                                    </p>
                                </template>
                                <template v-if="step == 3">
                                    <p class="form-row form-row-wide address-field update_totals_on_change validate-required" 
                                        data-priority="40">
                                        <label for="materiales">
                                            MATERIALES
                                            <abbr class="required" title="required">*</abbr>
                                        </label>
                                        <span class="woocommerce-input-wrapper">
                                            <select v-model="form.materiales" 
                                                class="country_to_state country_select  select2-hidden-accessible" >
                                                <option value="">SELECCIONE UNA OPCIÓN</option>
                                                <option v-for="(materialOption, index) in materialsOptions" v-bind:value="materialOption.combo" >{{materialOption.combo}}</option>
                                            </select>
                                        </span>
                                    </p>
                                </template>
                                <template v-if="step == 4">
                                    <div class="cart-wrapper sm-touch-scroll">
                                        <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Producto</th>
                                                    <th>Metros(M2)</th>
                                                    <th>Cantidad Producto</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(item,index) in resultTable"
                                                class="woocommerce-cart-form__cart-item cart_item">
                                                    <td v-text="index"></td>
                                                    <td v-text="form.medida"></td>
                                                    <td v-text="item + ' KG'"></td>
                                                    <td v-text="Math.ceil(form.medida * item) +' KG'"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </template>
                            </div>
                            <div id="payment" class="woocommerce-checkout-payment">
                                <div class="form-row place-order">
                                    <button @click.prevent="prevStep" v-if="step != 1" type="submit"
                                        class="button-continue-shopping button primary is-outline">     
                                        Atras
                                    </button>
                                    <button @click.prevent="nextStep" v-if="step != totalSteps && step < totalSteps-1" type="submit"
                                        class="button primary wc-backward" data-value="Siguiente">     
                                        Siguiente
                                    </button>
                                    <button @click.prevent="sendStep" v-if="step == 3" type="submit"
                                        class="button primary wc-backward" data-value="Confirmar">     
                                        Confirmar
                                    </button>
                                </div>
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