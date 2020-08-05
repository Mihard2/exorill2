<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is display the custom filter for product
 *
 * @link       https://rextheme.com
 * @since      1.1.10
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/partials
 */


// Exit if $feed_template obj isn't available.
if ( ! isset($feed_filter) ) {
    return;
}

unset($feed_filter->getFilterMappings()['Primary Attributes']['product_cats']);
unset($feed_filter->getFilterMappings()['Primary Attributes']['product_tags']);
$is_premium = apply_filters('wpfm_is_premium_activate', false);
?>




<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<?php do_action('wpfm_pro_filter_rules') ?>

<table id="config-table" class="filter-config-table responsive-table">
    <thead>
        <tr>
            <th class="large-col"><?php echo __('If', 'rex-product-feed') ?></th>
            <th class="large-col"><?php echo __('Condition', 'rex-product-feed') ?></th>
            <th class="large-col"><?php echo __('Value', 'rex-product-feed') ?></th>
            <th class="2"><?php echo __('Then', 'rex-product-feed') ?></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ( $feed_filter->getFilterMappings() as $key => $item): ?>
            <tr data-row-id="<?php echo $key; ?>">
                <td data-title="If : "><?php $feed_filter->printSelectDropdown( $key, 'if', $item['if'] ); ?></td>
                <td data-title="condition : "><?php $feed_filter->printSelectDropdown( $key, 'condition', $item['condition'] ); ?></td>
                <td data-title="value : "><?php $feed_filter->printInput( $key, 'value', $item['value'] ); ?></td>
                <td data-title="then : "><?php $feed_filter->printSelectDropdown( $key, 'then', $item['then'] ); ?></td>
                <td>
                    <a class="delete-row" title="Delete">
                        <i class="fa fa-trash"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>

</table>
