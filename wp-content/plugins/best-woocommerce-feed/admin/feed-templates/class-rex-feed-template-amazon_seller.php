<?php


/**
 *
 * Defines the attributes and template for amazon seller feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Amazon_seller
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Amazon_seller extends Rex_Feed_Abstract_Template
{

    protected function init_atts()
    {
        $this->attributes = array(
            'Required Information' => array(
                'feed_product_type' => 'Product Type',
                'item_sku' => 'Seller SKU',
                'brand_name' => 'Brand Name',
                'item_name' => 'Title',
                'external_product_id' => 'Product ID',
                'manufacturer' => 'Manufacturer',
                'external_product_id_type' => 'Product ID Type',
                'part_number' => 'Manufacturer Part Number',
                'item_type' => 'Item Type Keyword',
                'bullet_point1' => 'Key Product Features',
                'bullet_point2' => 'Key Product Features',
                'bullet_point3' => 'Key Product Features',
                'bullet_point4' => 'Key Product Features',
                'bullet_point5' => 'Key Product Features',
                'department_name1' => 'Department',
                'department_name2' => 'Department',
                'department_name3' => 'Department',
                'department_name4' => 'Department',
                'department_name5' => 'Department',
                'is_adult_product' => 'Is Adult Product',
                'standard_price' => 'Standard Price',
                'quantity' => 'Quantity',
                'main_image_url' => 'Main Image URL',
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
                'color_name' => 'Color',
                'color_map' => 'Color Map',
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
            ),
            'Basic Information' => array(
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
                'target_audience_keywords1' => 'Target Audience',
                'target_audience_keywords2' => 'Target Audience',
                'target_audience_keywords3' => 'Target Audience',
                'target_audience_keywords4' => 'Target Audience',
                'target_audience_keywords5' => 'Target Audience',
                'generic_keywords1' => 'Search Terms',
                'generic_keywords2' => 'Search Terms',
                'generic_keywords3' => 'Search Terms',
                'generic_keywords4' => 'Search Terms',
                'generic_keywords5' => 'Search Terms',
            ),
            'Variation Attributes' => array(
                'parent_sku' => 'Parent SKU',
                'relationship_type' => 'Relationship Type',
                'variation_theme' => 'Variation Theme',
            ),
            'Image Attributes' => array(
                'other_image_url1' => 'Other Image URL1',
                'swatch_image_url' => 'Swatch Image URL',
            )

        );
    }

    protected function init_default_template_mappings()
    {
        $this->template_mappings = array(
            array(
                'attr' => 'feed_product_type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'item_sku',
                'type' => 'meta',
                'meta_key' => 'sku',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'brand_name',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'item_name',
                'type' => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'external_product_id',
                'type' => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'manufacturer',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'external_product_id_type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'part_number',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'item_type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'outer_material_type1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'compatible_phone_models1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'material_composition1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'bullet_point1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'color_name',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'color_map',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'department_name1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'material_type1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'size_name',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'metal_type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'setting_type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'special_features1',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'gem_type',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'band_size_num',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'band_size_num_unit_of_measure',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'size_map',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'is_adult_product',
                'type' => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'standard_price',
                'type' => 'meta',
                'meta_key' => 'price',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'quantity',
                'type' => 'meta',
                'meta_key' => 'quantity',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            ),
            array(
                'attr' => 'main_image_url',
                'type' => 'meta',
                'meta_key' => 'featured_image',
                'st_value' => '',
                'prefix' => '',
                'suffix' => '',
                'escape' => 'default',
                'limit' => 0
            )
        );
    }

}
