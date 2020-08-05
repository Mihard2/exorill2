<?php
/**
 (c) copyright:  http://www.ryviu.com
 Author: Ryviu
**/

class ryviu_settings{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'load_admin_style' ) );
    }


    public function load_admin_style() {
        wp_enqueue_style( 'ryviu-admin-style', RYVIU_URL_ASSETS . 'css/ryviu-admin.css', false, time() );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Ryviu', 
            'Ryviu', 
            'manage_options', 
            'ryviu-setting-admin', 
            array( $this, 'create_admin_page' )
        );
    }
    
    public static function get_option( $name ){
        $options = get_option( 'ryviu_settings_reviews' );
        
        if(is_array($options) && isset($options[$name])){
            return $options[$name];
        }else{
            return '';
        }
    }
        
    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'ryviu_settings_reviews' );
        ?>
        <div class="wrap">
            
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'ryviu_option_group' );
                do_settings_sections( 'ryviu-setting-admin' );
                
                echo '<div class="info">
                <strong>Priority</strong>: Used to specify the order in which the functions associated with a particular action are executed. Lower numbers correspond with earlier execution, and functions with the same priority are executed in the order in which they were added to the action.
            </div>';
            
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {        
        register_setting(
            'ryviu_option_group', // Option group
            'ryviu_settings_reviews', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'Ryviu Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'ryviu-setting-admin' // Page
        );  
   
        foreach ($this->fields_settings() as $field) {
            add_settings_field(
                $field['name'], // name
                $field['title'], // Title 
                array( $this, $field['name'].'_callback' ), // Callback
                'ryviu-setting-admin', // Page
                'setting_section_id' // Section           
            );  
        }
    }

    public function fields_settings(){
        return array(
            array(
                'name' => 'custom_tab_title',
                'title' => 'Title reviews tab'
            ),
            array(
                'name' => 'position_display_widget',
                'title' => 'Star rating on product page'
            ),
            array(
                'name' => 'position_display',
                'title' => 'Review box on product page'
            ),
            array(
                'name' => 'active_reviews_tab',
                'title' => 'Default active review tab'
            ),
            array(
                'name' => 'position_display_widget_in_loop',
                'title' => 'Star rating on collection page'
            ),
            array(
                'name' => 'question_and_answer',
                'title' => 'Question and Answer'
            ),
            array(
                'name' => 'wordpress_theme',
                'title' => 'Wordpress Theme'
            ),
            array(
                'name' => 'data_rocket_status',
                'title' => 'Cloudfare CDN & Data Rocket'
            )
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        
        $fields_setting = $this->fields_settings();
        
        $fields_setting[] = array(
            'name' => 'priority_position_display',
            'title' => 'Priority position'
        );
        
        $fields_setting[] = array(
            'name' => 'priority_position_display_widget',
            'title' => 'Priority position'
        );
        
        $fields_setting[] = array(
            'name' => 'priority_position_display_widget_in_loop',
            'title' => 'Priority position'
        );
        
        foreach($fields_setting as $field){
            if( isset( $input[$field['name']] ) ){
                if(is_numeric($input[$field['name']])){
                    $new_input[$field['name']] = absint( $input[$field['name']] );
                }else{
                    $new_input[$field['name']] = sanitize_text_field( $input[$field['name']] );
                }
            }
        }
        
        flush_rewrite_rules();
        
        return $new_input;
    }

    /** 
     * Print the Section text
     */
    public function print_section_info(){
        print 'Enter your settings below:';
    }

    /** 
     * Get the settings option array and print one of its values
     */
    public function custom_tab_title_callback(){
        $trace_fn = debug_backtrace();
        $name = str_replace('_callback', '', $trace_fn[0]["function"] );
        
        $this->input_field($name);
    } 
     
    public function position_display_callback(){
        $trace_fn = debug_backtrace();
        $name = str_replace('_callback', '', $trace_fn[0]["function"] );
        
        $this->select_field($name);
    }
    
    public function position_display_widget_callback(){
        $trace_fn = debug_backtrace();
        $name = str_replace('_callback', '', $trace_fn[0]["function"] );
        
        $this->select_field($name);
    }
    
    public function position_display_widget_in_loop_callback(){
        $trace_fn = debug_backtrace();
        $name = str_replace('_callback', '', $trace_fn[0]["function"] );
        
        $this->select_field($name);
    }
    
    public function input_field($name){
        $val = isset($this->options[$name])? $this->options[$name] : 'Reviews (%total_number%)';
        
        echo '<input type="text" name="ryviu_settings_reviews['.$name.'] aria-describedby="custom-tab-title" value="'.$val.'" class="regular-text">';
        echo '<p class="description" id="custom-tab-title">This text will show in reviews the tab on the product page. Use (%total_number%) to display the total number of reviews.</p>';
    }
    
    public function select_field($name){
        $select = isset($this->options[$name])? $this->options[$name] : 1;
        $priority_select = isset($this->options['priority_'.$name])?$this->options['priority_'.$name] : 10;

        echo '<select id="position_display" class="ryviu_settings_reviews" name="ryviu_settings_reviews['.$name.']">';
        foreach (ryviu_display_position_hook($name) as $key => $data) {
            echo '<option value="'. $key .'" '. selected($select, $key) .'>'. $data['title'] .'</option>';
        }
        echo '</select>';
        
        echo '<span class="priority-label">Priority</span><select name="ryviu_settings_reviews[priority_'.$name.']">'; 
        foreach([10, 15, 20, 25, 30, 35, 40, 45, 50, 55, 60, 65, 70, 75, 80] as $priority){
            echo '<option value="'. $priority .'" '. selected($priority_select, $priority) .'>'. $priority .'</option>';
        }
        echo '</select>';
        
        $p_display = 'none';
        if($select == 10){
            $p_display = 'block';
        }
        echo '<p class="custom_position_display_reviews" style="display:'.$p_display.';">'. $this->__($name) .'</p>';
    }

    public function data_rocket_status_callback(){
        $trace_fn = debug_backtrace();
        $name = str_replace('_callback', '', $trace_fn[0]["function"] );
        $status = isset($this->options[$name])? $this->options[$name]: 0;

        echo '<div class="nice_fields"><ul class="tg-list">
            <li class="tg-list-item">
                <input class="tgl tgl-light" id="cb1" type="checkbox" '.checked( $status, 'on', false ).' name="ryviu_settings_reviews['.$name.']"/>
                <label class="tgl-btn" for="cb1"></label>
            </li></ul> <span>Enable this option when your site using Cloudfare CDN and Data Rocket</span></div>';
    }

    public static function __($name){
        $__ = array(
            'position_display' => __('Add our PHP code or Shortcode anywhere in the single product page: <code><input class="medium-text" type="text" readonly="readonly" value="<?php do_action( \'ryviu_display_review\' ); ?>" style="min-width: 315px;color: #000;" /><input class="medium-text" type="text" readonly="readonly" value="[ryviu_widget]" style="min-width: 315px;color: #000;" /></code>', 'ryviu' ),
            'position_display_widget' => __('Add our PHP code or Shortcode anywhere in the single product page: <code><input class="medium-text" type="text" readonly="readonly" value="<?php do_action( \'ryviu_display_total_review\' ); ?>" style="min-width: 360px;color: #000;" /><input class="medium-text" type="text" readonly="readonly" value="[ryviu_widget_total]" style="min-width: 360px;color: #000;" /></code>', 'ryviu'),
            'position_display_widget_in_loop' => __('Add this code to anywhere in loop category product page: <code><input class="medium-text" type="text" readonly="readonly" value="<?php do_action( \'ryviu_display_review_total_in_loop\' ); ?>" style="min-width: 400px;color: #000;" /><input class="medium-text" type="text" readonly="readonly" value="[ryviu_widget_colection]" style="min-width: 360px;color: #000;" /></code>', 'ryviu')
        );
        
        return $__[$name];
    }
    public function wordpress_theme_callback(){  
        $select = $this->options['wordpress_theme'];

        echo '<select id="wordpress_theme" class="ryviu_settings_reviews" name="ryviu_settings_reviews[wordpress_theme]">';
        
        $themes = array('default' => 'Default', 'ocean' => 'Ocean');
        
        foreach ($themes as $key => $data) {
            echo '<option value="'. $key .'" '. selected($select, $key) .'>'. $data .'</option>';
        }
        echo '</select>';
        
        echo '<p class="description">Fix conflicts with some themes. List of themes: Ocean</p>';
    }
    /** 
     * Get the settings option array and print one of its values
     */
    public function active_reviews_tab_callback(){  
        $select = $this->options['active_reviews_tab'];

        echo '<select id="active_reviews_tab" class="ryviu_settings_reviews" name="ryviu_settings_reviews[active_reviews_tab]">';
        foreach (array('1' => 'Yes', '0' => 'No') as $key => $data) {
            echo '<option value="'. $key .'" '. selected($select, $key) .'>'. $data .'</option>';
        }
        echo '</select>';
        
        echo '<p class="description">Active reviews tab when view product (Apply for Replace default reviews)</p>';
    }
    
    public function question_and_answer_callback(){        
        $select = $this->options['question_and_answer'];

        echo '<select id="question_and_answer" class="ryviu_settings_reviews" name="ryviu_settings_reviews[question_and_answer]">';
        foreach (array('1' => 'Yes', '0' => 'No') as $key => $data) {
            echo '<option value="'. $key .'" '. selected($select, $key) .'>'. $data .'</option>';
        }
        echo '</select>';
        
        echo '<p class="description">Show Question and Answer on the default position (Only support premium accounts)</p>';
        echo '<p class="custom_position_display_reviews">Add our PHP code or Shortcode anywhere in the single product page: <code><input class="medium-text" type="text" readonly="readonly" value="<?php do_action( \'ryviu_question_and_answer\' ); ?>" style="min-width: 315px;color: #000;" /><input class="medium-text" type="text" readonly="readonly" value="[ryviu_question_and_answer]" style="min-width: 315px;color: #000;" /></code></p>';
        
        
    }
    
    public function enable_ajax_add_to_cart_callback(){
        $select = 0;
        
        if($this->options['enable_ajax_add_to_cart']){
            $select = $this->options['enable_ajax_add_to_cart'];
        }
        
        echo '<select id="position_display" class="ryviu_settings_reviews" name="ryviu_settings_reviews[enable_ajax_add_to_cart]">';
        foreach (array('1' => 'Yes', '0' => 'No') as $key => $data) {
            echo '<option value="'. $key .'" '. selected($select, $key) .'>'. $data .'</option>';
        }
        echo '</select>';
        
        echo '<p>This option will replace default add to cart by ajax';
    }
}

if( is_admin() ){
   new ryviu_settings();
}
