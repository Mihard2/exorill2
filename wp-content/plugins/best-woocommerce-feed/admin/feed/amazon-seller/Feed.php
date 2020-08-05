<?php

namespace RexTheme\RexShoppingFeedCustom\AmazonSellerFeed;

class AmazonSellerFeed extends \RexTheme\RexShoppingFeed\Feed
{
    protected $attributes;

    protected function init_atts() {
        $this->attributes = array(
            'feed_product_type' => 'Product Type',
            'item_sku' => 'Seller SKU',
            'brand_name' => 'Brand Name',
            'item_name' => 'Title',
            'external_product_id' => 'Product ID',
            'manufacturer' => 'Manufacturer',
            'external_product_id_type' => 'Product ID Type',
            'part_number' => 'Manufacturer Part Number',
            'item_type' => 'Item Type Keyword',
            'outer_material_type1' => 'Outer Material Type',
            'outer_material_type2' => 'Outer Material Type',
            'outer_material_type3' => 'Outer Material Type',
            'outer_material_type4' => 'Outer Material Type',
            'outer_material_type5' => 'Outer Material Type',
            'compatible_phone_models1' => 'Compatible Phone Models',
            'compatible_phone_models2' => 'Compatible Phone Models',
            'compatible_phone_models3' => 'Compatible Phone Models',
            'compatible_phone_models4' => 'Compatible Phone Models',
            'compatible_phone_models5' => 'Compatible Phone Models',
            'material_composition1' => 'Material Composition',
            'material_composition2' => 'Material Composition',
            'material_composition3' => 'Material Composition',
            'material_composition4' => 'Material Composition',
            'material_composition5' => 'Material Composition',
            'material_composition6' => 'Material Composition',
            'material_composition7' => 'Material Composition',
            'material_composition8' => 'Material Composition',
            'material_composition9' => 'Material Composition',
            'material_composition10' => 'Material Composition',
            'bullet_point1' => 'Key Product Features',
            'bullet_point2' => 'Key Product Features',
            'bullet_point3' => 'Key Product Features',
            'bullet_point4' => 'Key Product Features',
            'bullet_point5' => 'Key Product Features',
            'color_name' => 'Color',
            'color_map' => 'Color Map',
            'department_name1' => 'Department',
            'department_name2' => 'Department',
            'department_name3' => 'Department',
            'department_name4' => 'Department',
            'department_name5' => 'Department',
            'material_type1' => 'Material Type',
            'material_type2' => 'Material Type',
            'material_type3' => 'Material Type',
            'material_type4' => 'Material Type',
            'material_type5' => 'Material Type',
            'size_name' => 'Size',
            'metal_type' => 'Metal Type',
            'setting_type' => 'Setting Type',
            'special_features1' => 'Additional Features',
            'special_features2' => 'Additional Features',
            'special_features3' => 'Additional Features',
            'special_features4' => 'Additional Features',
            'special_features5' => 'Additional Features',
            'gem_type' => 'Gem Type',
            'band_size_num' => 'Band Size Numeric',
            'band_size_num_unit_of_measure' => 'Band Size Num Unit Of Measure',
            'size_map' => 'Size Map',
            'is_adult_product' => 'Is Adult Product',
            'standard_price' => 'Standard Price',
            'quantity' => 'Quantity',
            'main_image_url' => 'Main Image URL',
            'parent_child' => 'Parentage',
            'parent_sku' => 'Parent SKU',
            'relationship_type' => 'Relationship Type',
            'variation_theme' => 'Variation Theme',
            'other_image_url1' => 'Other Image URL1',
            'swatch_image_url' => 'Swatch Image URL',
            'update_delete' => 'Update Delete',
            'product_description' => 'Product Description',
            'closure_type' => 'Closure Type',
            'model' => 'Style Number',
            'certificate_type1' => 'Certificate Type',
            'certificate_type2' => 'Certificate Type',
            'certificate_type3' => 'Certificate Type',
            'certificate_type4' => 'Certificate Type',
            'certificate_type5' => 'Certificate Type',
            'certificate_type6' => 'Certificate Type',
            'certificate_type7' => 'Certificate Type',
            'certificate_type8' => 'Certificate Type',
            'certificate_type9' => 'Certificate Type',
            'model_name' => 'Model Name',
            'fuel_type' => 'Fuel Type',
            'inner_material_type1' => 'Inner Material Type',
            'inner_material_type2' => 'Inner Material Type',
            'inner_material_type3' => 'Inner Material Type',
            'inner_material_type4' => 'Inner Material Type',
            'inner_material_type5' => 'Inner Material Type',
            'language_value1' => 'Audio Encoding Language',
            'language_value2' => 'Audio Encoding Language',
            'language_value3' => 'Audio Encoding Language',
            'language_value4' => 'Audio Encoding Language',
            'language_value5' => 'Audio Encoding Language',
        );
    }

    /**
     * Add Items to csv
     * @return array|\RexTheme\RexShoppingFeed\Item[]
     */
    private function addItemsToFeedCSV($batch){

        if(count($this->items)){
            if($batch === 1) {
                $this->init_atts();
                $first_row = array('TemplateType=fptcustom', 'Version=2020.0414', 'TemplateSignature=S0lUQ0hFTixPVVRET09SX1JFQ1JFQVRJT05fUFJPRFVDVCxXSVJFTEVTU19BQ0NFU1NPUlksT1VURVJXRUFSLEhPTUVfQkVEX0FORF9CQVRILFNXRUFURVIsU0hJUlQsU0hPUlRTLEZBU0hJT05ORUNLTEFDRUJSQUNFTEVUQU5LTEVULEZJTkVORUNLTEFDRUJSQUNFTEVUQU5LTEVULFNQT1JUSU5HX0dPT0RTLEhBTkRCQUcsU1dJTVdFQVIsQlJBLEFSVF9TVVBQTElFUyxTT0NLU0hPU0lFUlksQUNDRVNTT1JZLFNFUlZFV0FSRSxQQU5UUyxPVVRET09SX0xJVklORyxIT01F', 'The top 3 rows are for Amazon.com use only. Do not modify or delete the top 3 rows.');
                $second_row = array();
                $_third_row = array_keys(end($this->items)->nodes());
                $third_row = [];

                foreach ($_third_row as $key) {
                    if(array_key_exists($key, $this->attributes)) {
                        $second_row[] = $this->attributes[$key];
                    }else {
                        $second_row[] = ucfirst($key);
                    }
                    $third_row[] = strtolower(str_replace(' ', '_', $key));
                }
                $this->items_row[] = $first_row;
                $this->items_row[] = $second_row;
                $this->items_row[] = $third_row;
            }

            foreach ($this->items as $item) {
                $row = array();
                foreach ($item->nodes() as $itemNode) {
                    if (is_array($itemNode)) {
                        foreach ($itemNode as $node) {
                            $row[] = str_replace(array("\r\n", "\n", "\r"), ' ', $node->get('value'));
                        }
                    } else {
                        $row[] = str_replace(array("\r\n", "\n", "\r"), ' ', $itemNode->get('value'));
                    }
                }
                $this->items_row[] = $row;
            }

            $str = '';
            foreach ($this->items_row as $fields) {
                $str .= implode("\t", $fields) . "\n";
            }
        }

        return $this->items_row;
    }


    /**
     * Generate CSV feed
     *
     * @param bool $batch
     * @param bool $output
     * @return array|\RexTheme\RexShoppingFeed\Item[]|string
     */
    public function asCSVFeed($batch, $output = false)
    {

        ob_end_clean();
        $data = $this->addItemsToFeedCSV($batch);
        if ($output) {
            die($data);
        }
        return $data;
    }



}
