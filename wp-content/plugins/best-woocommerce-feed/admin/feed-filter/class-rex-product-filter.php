<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://rextheme.com
 * @since      1.1.10
 *
 * @package    Rex_Product_Filter
 * @subpackage Rex_Product_Feed/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines all the Filter for Products
 *
 * @package    Rex_Product_Filter
 * @subpackage Rex_Product_Feed/admin
 * @author     RexTheme <info@rextheme.com>
 */



class Rex_Product_Filter {


    /**
     * The Feed Attributes.
     *
     * @since    1.1.10
     * @access   protected
     * @var      Rex_Product_Filter    attributes    Feed Attributes.
     */
    protected $product_meta_keys;


    /**
     * The Feed Condition.
     *
     * @since    1.1.10
     * @access   protected
     * @var      Rex_Product_Filter    condition    Feed Condition.
     */
    protected $condition;


    /**
     * The Feed Condition Then.
     *
     * @since    1.1.10
     * @access   protected
     * @var      Rex_Product_Filter    then    Feed Condition Then.
     */
    protected $then;


    /**
     * The Feed Rules
     *
     * @since    3.5
     * @access   protected
     * @var      Rex_Product_Filter    then    Feed Condition Then.
     */
    protected $rules;


    /**
     * The Feed Filter Mappings Attributes and associated value and other constraints.
     *
     * @since    1.1.10
     * @access   protected
     * @var      Rex_Product_Filter    filter_mappings    Feed Filter mapping for template generation.
     */
    protected $filter_mappings;

    /**
     * The Product Object
     *
     * @since    1.1.10
     * @access   protected
     * @var      Rex_Product_Filter    product    Product Object.
     */
    protected $product;


    /**
     * Set the filter and condition.
     *
     * @since    1.1.10
     * @param bool $feed_filter
     */
    public function __construct( $feed_filter = false ){
        $this->init_feed_filter_mappings( $feed_filter );
        $this->init_product_meta_keys();
        $this->init_product_filter_condition();
        $this->init_product_filter_then();
    }



    /**
     * Initialize Filter from feed post_meta.
     *
     * @since    1.1.10
     * @param string $feed_filter The Conditions Of Feeds
     */
    protected function init_feed_filter_mappings( $feed_filter ){
        if ( !empty($feed_filter) && $feed_filter ) {
            $this->filter_mappings = $feed_filter;
        }else {
            $this->init_default_filter_mappings();
        }
    }


    /**
     * Get Filter Attributes
     * @return array $attributes
     */
    protected function getFilterAttribute () {
        $attributes = array(
            'Primary Attributes'        => array(
                'id'                        => 'Product Id',
                'title'                     => 'Product Title',
                'description'               => 'Product Description',
                'short_description'         => 'Product Short Description',
                'featured_image'            => 'Featured Image',
                'product_cats'              => 'Product Categories',
                'sku'                       => 'SKU',
                'availability'              => 'Availability',
                'quantity'                  => 'Quantity',
                'price'                     => 'Reguler Price',
                'sale_price'                => 'Sale price',
                'weight'                    => 'Weight',
                'width'                     => 'Width',
                'height'                    => 'Height',
                'length'                    => 'Length',
                'rating_total'              => 'Total Rating',
                'rating_average'            => 'Average Rating',
                'product_tags'              => 'Tags',
                'sale_price_dates_from'     => 'Sale Start Date',
                'sale_price_dates_to'       => 'Sale End Date',
            ),
        );

        return $attributes;
    }


    /**
     * Initialize Product Meta Attributes
     *
     * @since    1.1.10
     */
    protected function init_product_meta_keys(){
        $this->product_meta_keys  = $this->getFilterAttribute();
    }


    /**
     * Initialize Product Filter Condition
     *
     * @since    1.1.10
     */
    protected function init_product_filter_condition(){
        $this->condition = array(
            '' => array(
                'contain'                  => 'Contains',
                'dn_contain'               => 'Does not contain',
                'equal_to'                 => 'Is equal to',
                'nequal_to'                => 'Is not equal to',
                'greater_than'             => 'Greater than',
                'greater_than_equal'       => 'Greater than or equal to',
                'less_than'                => 'Less than',
                'less_than_equal'          => 'Less than or equal to',
            )
        );
    }


    /**
     * Initialize Product Filter Then
     *
     * @since    1.1.10
     */
    protected function init_product_filter_then(){
        $this->then = array(
            '' => array(
                'inc'       => 'Include Only',
                'exc'       => 'Exclude',
            )
        );
    }




    /**
     * Initialize Default Filter Mappings with Attributes.
     *
     * @since    1.1.10
     */
    protected function init_default_filter_mappings(){
        $this->filter_mappings = array(
            array(
                'if'        => '',
                'condition' => '',
                'value'     => '',
                'then'      => 'exclude',
            ),
        );
    }


    /**
     * Return the filter_mappings
     *
     * @since    1.1.10
     */
    public function getFilterMappings(){
        return $this->filter_mappings;
    }



    /**
     * Print attributes as select dropdown.
     *
     * @since    1.0.0
     * @param $key
     * @param $name
     * @param string $selected
     */
    public function printSelectDropdown( $key, $name, $selected = '' ){

        if ( $name === 'if' ) {
            $items = $this->product_meta_keys;
        }elseif ( $name === 'condition' ) {
            $items = $this->condition;
        }elseif ( $name === 'then' ) {
            $items = $this->then;
        }else{
            return;
        }

        echo '<select name="ff['.$key.'][' . esc_attr( $name ) . ']" >';
        if($name === 'rules')
            echo "<option value='or'>Please Select</option>";
        else
            echo "<option value=''>Please Select</option>";

        foreach ($items as $groupLabel => $group) {
            if ( !empty($groupLabel)) {
                echo "<optgroup label='$groupLabel'>";
            }

            foreach ($group as $key => $item) {
                if ( $selected == $key ) {
                    echo "<option value='$key' selected='selected'>$item</option>";
                }else{
                    echo "<option value='$key'>$item</option>";
                }
            }

            if ( !empty($groupLabel)) {
                echo "</optgroup>";
            }
        }

        echo "</select>";
    }



    /**
     * Print Prefix input.
     *
     * @since    1.0.0
     * @param $key
     * @param string $name
     * @param string $val
     */
    public function printInput( $key, $name = '', $val = '' ){
        echo '<input type="text" name="ff['.$key.'][' . esc_attr( $name ) . ']" value="' . esc_attr( $val ) . '"">';
    }



    /**
     * Return the  product is allowed or not
     * @param WC_Product $product
     * @param $filter_mappings
     * @return bool
     */
    public static function allowedProduct( WC_Product $product, $filter_mappings ){

        $allowed = 0;
        $temp = [];
        foreach ($filter_mappings as $key=>$value) {
            $subject = self::getSubject($value['if'], $product);
            switch ($value['condition']){
                case($value['condition'] = "contain"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'exc') {
                        $temp[$key]['allowed'] = 0;
                    }elseif (!preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'exc') {
                        $temp[$key]['allowed'] = 1;
                    }elseif (preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'inc') {
                        $temp[$key]['allowed'] = 1;
                    }elseif (!preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'inc') {
                        $temp[$key]['allowed'] = 0;
                    }
                    break;
                case($value['condition'] = "dn_contain"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'exc') {
                        $allowed = 1;
                    }elseif (!preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'exc') {
                        $allowed = 0;
                    }elseif (preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'inc') {
                        $allowed = 0;
                    }elseif (!preg_match('/'.$value['value'].'/', $subject) && $value['then'] == 'inc') {
                        $allowed = 1;
                    }
                    break;
                case($value['condition'] = "equal_to"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (($value['value'] == $subject)  && $value['then'] == 'exc') {
                        $temp[$key]['allowed'] = 0;
                    }elseif (($value['value'] != $subject) && $value['then'] == 'exc') {
                        $temp[$key]['allowed'] = 1;
                    }elseif (($value['value'] == $subject) && $value['then'] == 'inc') {
                        $temp[$key]['allowed'] = 1;
                    }elseif (($value['value'] != $subject) && $value['then'] == 'inc') {
                        $temp[$key]['allowed'] = 0;
                    }
                    break;
                case($value['condition'] = "nequal_to"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (($value['value'] == $subject)  && $value['then'] == 'exc') {
                        $allowed = 1;
                    }elseif (($value['value'] != $subject)  && $value['then'] == 'exc') {
                        $allowed = 0;
                    }elseif (($value['value'] == $subject) && $value['then'] == 'inc') {
                        $allowed = 0;
                    }elseif (($value['value'] != $subject) && $value['then'] == 'inc') {
                        $allowed = 1;
                    }
                    break;
                case($value['condition'] = "greater_than"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (is_numeric($value['value']) && is_numeric($subject)) {
                        if (((float) $subject > (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (((float) $subject <= (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (((float)$subject > (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (((float)$subject <= (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }elseif ($value['if'] == 'sale_price_dates_from' || $value['if'] == 'sale_price_dates_to'){
                        if ($subject) {
                            if (strtotime($subject) > strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 0;
                            }elseif (strtotime($subject) <= strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) > strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) <= strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 0;
                            }
                        }else{
                            $allowed = 0;
                        }
                    }else {
                        if (($subject > $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (($subject <= $value['value']) && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (($subject > $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (($subject <= $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }

                    break;
                case($value['condition'] = "greater_than_equal"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (is_numeric($value['value']) && is_numeric($subject)) {
                        if (((float) $subject >= (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (((float) $subject < (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (((float)$subject >= (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (((float)$subject < (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }elseif ($value['if'] == 'sale_price_dates_from' || $value['if'] == 'sale_price_dates_to'){
                        if ($subject) {
                            if (strtotime($subject) >= strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 0;
                            }elseif (strtotime($subject) < strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) >= strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) < strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 0;
                            }
                        }else{
                            $allowed = 0;
                        }
                    }else {
                        if (($subject >= $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (($subject < $value['value']) && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (($subject >= $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (($subject < $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }

                    break;
                case($value['condition'] = "less_than"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (is_numeric($value['value']) && is_numeric($subject)) {
                        if (((float) $subject < (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (((float) $subject >= (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (((float)$subject < (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (((float)$subject >= (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }elseif ($value['if'] == 'sale_price_dates_from' || $value['if'] == 'sale_price_dates_to'){
                        if ($subject) {
                            if (strtotime($subject) < strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 0;
                            }elseif (strtotime($subject) >= strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) < strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) >= strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 0;
                            }
                        }else{
                            $allowed = 0;
                        }
                    }else {
                        if (($subject < $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (($subject >= $value['value']) && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (($subject < $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (($subject >= $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }
                    break;
                case($value['condition'] = "less_than_equal"):
                    $temp[$key]['rules'] = $value['rules'];
                    if (is_numeric($value['value']) && is_numeric($subject)) {
                        if (((float) $subject <= (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (((float) $subject > (float) $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (((float)$subject <= (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (((float)$subject > (float) $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }elseif ($value['if'] == 'sale_price_dates_from' || $value['if'] == 'sale_price_dates_to'){
                        if ($subject) {
                            if (strtotime($subject) <= strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 0;
                            }elseif (strtotime($subject) > strtotime($value['value']) && $value['then'] == 'exc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) <= strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 1;
                            }elseif (strtotime($subject) > strtotime($value['value']) && $value['then'] == 'inc') {
                                $allowed = 0;
                            }
                        }else{
                            $allowed = 0;
                        }
                    }else {
                        if (($subject <= $value['value'])  && $value['then'] == 'exc') {
                            $allowed = 0;
                        }elseif (($subject > $value['value']) && $value['then'] == 'exc') {
                            $allowed = 1;
                        }elseif (($subject <= $value['value']) && $value['then'] == 'inc') {
                            $allowed = 1;
                        }elseif (($subject > $value['value']) && $value['then'] == 'inc') {
                            $allowed = 0;
                        }
                    }
                    break;
                default:
                    break;
            }
        }


        $filter_length = count($temp);


        $relation_array = [];
        foreach ($temp as $key=>$t) {
            if(($key+1) >= $filter_length ) {
                if( $filter_length%2 ==! 0) {
                    if(!($filter_length > 1)) {
                        $relation_array[] = array(
                            'relation' => $t['rules'],
                            'value' => array($t['allowed']),
                        );
                    }else if($filter_length == 1) {
                        $relation_array[] = array(
                            'relation' => $t['rules'],
                            'value' => array($t['allowed']),
                        );
                    }
                }
            }else {
                if(array_key_exists('allowed', $temp[$key+1])) {
                    $relation_array[] = array(
                        'relation' => $t['rules'],
                        'value' => array($t['allowed'], $temp[$key+1]['allowed']),
                    );
                }

            }
        }


        foreach ($relation_array as $key => $relation) {
            if($relation['relation'] == 'or') {
                if(in_array(1, $relation['value'])) {
                    $allowed = 1;
                    break;
                }else {
                    $allowed = 0;
                }
            }elseif ($relation['relation'] == 'and') {
                if(in_array(0, $relation['value'])) {
                    $allowed = 0;
                    break;
                }else {
                    $allowed = 1;
                }
            }
        }


        if ($allowed) {
            return true;
        }else {
            return false;
        }

    }



    public static function createFilterQueryParams($filter_mappings) {
        global $wpdb;
        $prefix = $wpdb->prefix;
        $filter_args = array();
        $sql = '';
        $tax_query = array();

        foreach ($filter_mappings as $key => $filter) {

            $if = $filter['if'];
            $then = $filter['then'];
            $condition = $filter['condition'];
            $value = $filter['value'];

            switch ($if) {

                //PRODUCT ID
                case 'id':
                    if($then == 'inc') {
                        if($condition == 'equal_to' ) {
                            $filter_args['post__in'][] = $value;
                        }
                        elseif ($condition == 'nequal_to') {
                            $filter_args['post__not_in'][] = $value;
                        }
                        elseif ($condition == 'greater_than') {
                            $filter_args['post__greater_than'] = $value;
                        }
                        elseif ($condition == 'greater_than_equal') {
                            $filter_args['post__greater_than_equal'] = $value;
                        }
                        elseif ($condition == 'less_than') {
                            $filter_args['post__less_than'] = $value;
                        }
                        elseif ($condition == 'less_than_equal') {
                            $filter_args['post__less_than_equal'] = $value;
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'equal_to' ) {
                            $filter_args['post__not_in'][] = $value;
                        }
                        elseif ($condition == 'nequal_to') {
                            $filter_args['post__in'][] = $value;
                        }
                        elseif ($condition == 'greater_than') {
                            $filter_args['post__less_than'] = $value;
                        }
                        elseif ($condition == 'greater_than_equal') {
                            $filter_args['post__less_than_equal'] = $value;
                        }
                        elseif ($condition == 'less_than') {
                            $filter_args['post__greater_than'] = $value;
                        }
                        elseif ($condition == 'less_than_equal') {
                            $filter_args['post__greater_than_equal'] = $value;
                        }
                    }
                    break;


                //PRODUCT TITLE
                case 'title':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $filter_args['title_contain'][] = $value;
                        }elseif ($condition == 'dn_contain') {
                            $filter_args['title_dn_contain'][] = $value;
                        }elseif ($condition == 'equal_to') {
                            $filter_args['title_equal_to'][] = $value;
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['title_nequal_to'][] = $value;
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $filter_args['title_dn_contain'][] = $value;
                        }elseif ($condition == 'dn_contain') {
                            $filter_args['title_contain'][] = $value;
                        }elseif ($condition == 'equal_to') {
                            $filter_args['title_nequal_to'][] = $value;
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['title_equal_to'][] = $value;
                        }
                    }
                    break;


                //PRODUCT DESCRIPTION
                case 'description':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $filter_args['description_contain'][] = $value;
                        }elseif ($condition == 'dn_contain') {
                            $filter_args['description_dn_contain'][] = $value;
                        }elseif ($condition == 'equal_to') {
                            $filter_args['description_equal_to'][] = $value;
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['description_nequal_to'][] = $value;
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $filter_args['description_dn_contain'][] = $value;
                        }elseif ($condition == 'dn_contain') {
                            $filter_args['description_contain'][] = $value;
                        }elseif ($condition == 'equal_to') {
                            $filter_args['description_nequal_to'][] = $value;
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['description_equal_to'][] = $value;
                        }
                    }
                    break;


                //PRODUCT SHORT DESCRIPTION
                case 'short_description':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $filter_args['sdescription_contain'][] = $value;
                        }elseif ($condition == 'dn_contain') {
                            $filter_args['sdescription_dn_contain'][] = $value;
                        }elseif ($condition == 'equal_to') {
                            $filter_args['sdescription_equal_to'][] = $value;
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['sdescription_nequal_to'][] = $value;
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $filter_args['sdescription_dn_contain'][] = $value;
                        }elseif ($condition == 'dn_contain') {
                            $filter_args['sdescription_contain'][] = $value;
                        }elseif ($condition == 'equal_to') {
                            $filter_args['sdescription_nequal_to'][] = $value;
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['sdescription_equal_to'][] = $value;
                        }
                    }
                    break;


                //PRODUCT FEATURED IMAGE ID
                case 'featured_image':
                    if($then == 'inc') {
                        if($condition == 'equal_to' ) {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_thumbnail_id',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_thumbnail_id',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'equal_to' ) {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_thumbnail_id',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_thumbnail_id',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT AVAILABILITY
                case 'availability':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock_status',
                                    'value'     => $value,
                                    'compare'   => 'LIKE',
                                ),
                            );

                        }elseif ($condition == 'dn_contain') {
                            $filter_args['meta_query'][] = array(

                                array(
                                    'key'       => '_stock_status',
                                    'value'     => $value,
                                    'compare'   => 'NOT LIKE',
                                ),
                            );
                        }elseif ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(

                                array(
                                    'key'       => '_stock_status',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(

                                array(
                                    'key'       => '_stock_status',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }
                    }
                    elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock_status',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_stock_status',
                                    'value' => $value,
                                    'compare'   => 'NOT LIKE',
                                )

                            );

                        }elseif ($condition == 'dn_contain') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock_status',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_stock_status',
                                    'value' => $value,
                                    'compare'   => 'LIKE',
                                )
                            );
                        }elseif ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock_status',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_stock_status',
                                    'value' => $value,
                                    'compare'   => '!=',
                                )
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock_status',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_stock_status',
                                    'value' => $value,
                                    'compare'   => '=',
                                )
                            );
                        }
                    }
                    break;

                //PRODUCT AVAILABILITY
                case 'sku':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sku',
                                    'value'     => $value,
                                    'compare'   => 'LIKE',
                                ),
                            );

                        }elseif ($condition == 'dn_contain') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sku',
                                    'value'     => $value,
                                    'compare'   => 'NOT LIKE',
                                ),
                            );
                        }elseif ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sku',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sku',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sku',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_sku',
                                    'value' => $value,
                                    'compare'   => 'NOT LIKE',
                                )

                            );

                        }elseif ($condition == 'dn_contain') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sku',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_sku',
                                    'value' => $value,
                                    'compare'   => 'LIKE',
                                )
                            );
                        }elseif ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sku',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_sku',
                                    'value' => $value,
                                    'compare'   => '!=',
                                )
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sku',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key' => '_sku',
                                    'value' => $value,
                                    'compare'   => '=',
                                )
                            );
                        }
                    }
                    break;


                //PRODUCT QUANTITY
                case 'quantity':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_stock',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_stock',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT PRICE
                case 'price':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT SALE PRICE
                case 'sale_price':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_price',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT WEIGHT
                case 'weight':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_weight',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_weight',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),

                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_weight',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_weight',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_weight',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_weight',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT WIDTH
                case 'width':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_width',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_width',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_width',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_width',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_weight',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_width',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_width',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT HEIGHT
                case 'height':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_height',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_height',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_height',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_height',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_height',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_width',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_height',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_height',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT LENGTH
                case 'length':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_length',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_length',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_length',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_length',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_length',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_length',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_length',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT RATTING TOTAL
                case 'rating_total':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_review_count',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_review_count',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_review_count',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_review_count',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_review_count',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_review_count',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_review_count',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;



                //PRODUCT RATTING AVERAGE
                case 'rating_average':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_average_rating',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_average_rating',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_average_rating',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_average_rating',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_average_rating',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_wc_average_rating',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_wc_average_rating',
                                    'value'     => $value,
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT SALE PRICE DATE FROM
                case 'sale_price_dates_from':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_from',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_from',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_from',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_from',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_from',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_from',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_from',
                                    'value'     => strtotime($value),
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT SALE PRICE DATE TO
                case 'sale_price_dates_to':
                    if($then == 'inc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '<=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '>=',
                                ),
                            );
                        }
                    }

                    elseif ($then == 'exc') {
                        if ($condition == 'equal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_to',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '!=',
                                ),
                            );
                        }elseif ($condition == 'nequal_to') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_to',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '=',
                                ),
                            );
                        }elseif ($condition == 'greater_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_to',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '>',
                                ),
                            );
                        }elseif ($condition == 'greater_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_to',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '>=',
                                ),
                            );
                        }elseif ($condition == 'less_than') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_to',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '<',
                                ),
                            );
                        }elseif ($condition == 'less_than_equal') {
                            $filter_args['meta_query'][] = array(
                                'relation' => 'OR',
                                array(
                                    'key' => '_sale_price_dates_to',
                                    'compare' => 'NOT EXISTS',
                                    'value' => ''
                                ),
                                array(
                                    'key'       => '_sale_price_dates_to',
                                    'value'     => strtotime($value),
                                    'compare'   => '<=',
                                ),
                            );
                        }
                    }
                    break;


                //PRODUCT CATEGORIES
                case 'product_cats':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $tax_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_contain_query,
                                'operator'       =>   'IN',
                            );
                        }elseif ($condition == 'dn_contain') {
                            $tax_not_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_not_contain_query,
                                'operator'       =>   'NOT IN',
                            );
                        }elseif ($condition == 'equal_to') {
                            $tax_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_equal_query,
                                'operator'       =>   'IN',
                            );
                        }elseif ($condition == 'nequal_to') {
                            $tax_not_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_not_equal_query,
                                'operator'       =>   'NOT IN',
                            );
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $tax_not_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_not_contain_query,
                                'operator'       =>   'NOT IN',
                            );
                        }elseif ($condition == 'dn_contain') {
                            $tax_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_contain_query,
                                'operator'       =>   'IN',
                            );
                        }elseif ($condition == 'equal_to') {
                            $tax_not_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_not_equal_query,
                                'operator'       =>   'NOT IN',
                            );
                        }elseif ($condition == 'nequal_to') {
                            $tax_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_cat',
                                'field'          =>  'name',
                                'terms'          =>   $tax_equal_query,
                                'operator'       =>   'IN',
                            );
                        }
                    }



                    break;


                //PRODUCT TAGS
                case 'product_tags':
                    if($then == 'inc') {
                        if($condition == 'contain' ) {
                            $tag_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_contain_query,
                                'operator'       =>   'IN',
                            );
                        }elseif ($condition == 'dn_contain') {
                            $tag_not_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_not_contain_query,
                                'operator'       =>   'NOT IN',
                            );
                        }elseif ($condition == 'equal_to') {
                            $tag_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_equal_query,
                                'operator'       =>   'IN',
                            );
                        }elseif ($condition == 'nequal_to') {
                            $tag_not_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_not_equal_query,
                                'operator'       =>   'NOT IN',
                            );
                        }
                    }elseif ($then == 'exc') {
                        if($condition == 'contain' ) {
                            $tag_not_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_not_contain_query,
                                'operator'       =>   'NOT IN',
                            );
                        }elseif ($condition == 'dn_contain') {
                            $tag_contain_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_contain_query,
                                'operator'       =>   'IN',
                            );
                        }elseif ($condition == 'equal_to') {
                            $tag_not_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_not_equal_query,
                                'operator'       =>   'NOT IN',
                            );
                        }elseif ($condition == 'nequal_to') {
                            $tag_equal_query[] = $value;
                            $filter_args['tax_query'][] = array(
                                'taxonomy'       =>  'product_tag',
                                'field'          =>  'name',
                                'terms'          =>   $tag_equal_query,
                                'operator'       =>   'IN',
                            );
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        return array(
            'args' => $filter_args
        );
    }


    /**
     * Get the product attribute
     * @param $key
     * @param WC_Product $product
     * @return string
     */
    public static function getSubject( $key, WC_Product $product ){
        switch ( $key ) {
            case 'id':
                return $product->get_id(); break;

            case 'sku':
                return $product->get_sku(); break;

            case 'title':
                return $product->get_title(); break;

            case 'price':
                return number_format((float)$product->get_regular_price(), 2, '.', '');
                break;

            case 'featured_image':
                return wp_get_attachment_url(  $product->get_image_id() ); break;

            case 'sale_price':

                if ($product->get_sale_price()) {
                    return number_format((float)$product->get_sale_price(), 2, '.', '');
                }
                break;

            case 'description':
                if ($product->post->post_parent) {
                    $_product = wc_get_product( $product->post->post_parent );
                    $_product_desc =  $_product->get_description();
                    return $_product_desc;
                }else{
                    return $product->get_description();
                }
                break;

            case 'short_description':
                if ($product->post->post_parent) :
                    $_product = wc_get_product( $product->post->post_parent );
                    $_product_desc =  $_product->get_short_description();
                    return $_product_desc;
                else:
                    return $product->get_short_description();
                endif;
                break;

            case 'product_cats':

                if($product->post->post_parent) {
                    $terms = get_the_terms( $product->get_parent_id(), 'product_cat' );
                }else {
                    $terms = get_the_terms( $product->get_id(), 'product_cat' );
                }
                if ( empty( $terms ) || is_wp_error( $terms ) ){
                    return '';
                }
                $term_names = array();
                foreach ( $terms as $term ) {
                    $term_names[] = $term->name;
                }
                ksort($term_names);
                return join( ',', $term_names );
                break;

            case 'product_tags':
                if($product->post->post_parent) {
                    $terms = get_the_terms( $product->get_parent_id(), 'product_tag' );
                }else {
                    $terms = get_the_terms( $product->get_id(), 'product_tag' );
                }
                if ( empty( $terms ) || is_wp_error( $terms ) ){
                    return '';
                }
                $term_names = array();
                foreach ( $terms as $term ) {
                    $term_names[] = $term->name;
                }
                ksort($term_names);
                return join( ',', $term_names );
                break;

            case 'link':
                return $product->get_permalink(); break;

            case 'condition':
                return 'New'; break;

            case 'availability':
                if ( $product->is_in_stock() == TRUE ) {
                    return 'in stock';
                } else {
                    return 'out of stock';
                }

            case 'quantity':
                return $product->get_stock_quantity(); break;

            case 'weight':
                return $product->get_weight(); break;

            case 'width':
                return $product->get_width(); break;

            case 'height':
                return $product->get_height(); break;

            case 'length':
                return $product->get_length(); break;

            case 'type':
                return $product->get_type(); break;

            case 'rating_average':
                return $product->get_average_rating(); break;

            case 'rating_total':
                return $product->get_rating_count(); break;

            case 'sale_price_dates_from':

                $sale_date_from = $product->get_date_on_sale_from();
                if ($sale_date_from) {
                    return date( get_option( 'date_format' ), $sale_date_from->getTimestamp() );
                }else {
                    return null;

                }
                break;

            case 'sale_price_dates_to':
                $sale_date_to = $product->get_date_on_sale_to();
                if ($sale_date_to) {
                    return date( get_option( 'date_format' ), $sale_date_to->getTimestamp() );
                }else {
                    return null;
                }
                break;

            case 'sale_price_effective_date':
                $sale_price_dates_to        = ( $date = get_post_meta( $product->get_id(), '_sale_price_dates_to', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';
                $sale_price_dates_from      = ( $date = get_post_meta( $product->get_id(), '_sale_price_dates_from', true ) ) ? date_i18n( 'Y-m-d', $date ) : '';

                if ( ! empty( $sale_price_dates_to ) && ! empty( $sale_price_dates_from ) ) {
                    $from   = date( "c", strtotime( $sale_price_dates_from ) );
                    $to     = date( "c", strtotime( $sale_price_dates_to ) );


                    return $from . '/' . $to;
                }else {
                    return '';
                }

            default:
                break;
        }
    }

}
