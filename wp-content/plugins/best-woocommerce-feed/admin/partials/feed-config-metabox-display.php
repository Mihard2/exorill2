<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is display the custom feed configuration part of the metabox on feed edit screen.
 *
 * @link       https://rextheme.com
 * @since      1.0.0
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/partials
 */

// Exit if $feed_template obj isn't available.
if ( ! isset($feed_template) ) {
    return;
}


?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<thead>
<tr>
    <th class="large-col"><?php echo __('Attributes', 'rex-product-feed') ?></th>
    <th class="large-col"><?php echo __('Type', 'rex-product-feed') ?></th>
    <th class="large-col"><?php echo __('Value', 'rex-product-feed') ?></th>
    <th class="small-col"><?php echo __('Prefix', 'rex-product-feed') ?></th>
    <th class="small-col"><?php echo __('Suffix', 'rex-product-feed') ?></th>
    <th class="large-col"><?php echo __('Output Sanitization', 'rex-product-feed') ?></th>
    <th colspan="2" class="small-col"><?php echo __('Output Limit', 'rex-product-feed') ?></th>
</tr>
</thead>

<tbody>

<?php
$keyy = rand(999, 3000); ?>
<tr data-row-id="<?php echo $keyy; ?>" style="display: none; ">
    <td data-title="Attributes : "><?php $feed_template->printSelectDropdown( $keyy, 'attr', '' );?>
    </td>
    <td data-title="Type : "><?php $feed_template->printAttType( $keyy, '' ); ?></td>
    <td data-title="Value : ">
        <div class="meta-dropdown">
            <?php
                echo '<select  name="fc['.$keyy.'][' . esc_attr( 'meta_key' ) . ']" >';
                echo "<option value=''>Please Select</option>";
                echo $feed_template->printProductAttributes();
                echo "</select>";
            ?>
        </div>
        <div class="static-input">
            <?php $feed_template->printInput( $keyy, 'st_value', '' ); ?>
        </div>
    </td>
    <td data-title="Prefix : "><?php $feed_template->printInput( $keyy, 'prefix', '' ); ?></td>
    <td data-title="Suffix : "><?php $feed_template->printInput( $keyy, 'suffix', '' ); ?></td>
    <td data-title="Output Sanitization : "><?php $feed_template->printSelectDropdown( $keyy, 'escape', '' ); ?></td>
    <td data-title="Output Limit : "><?php $feed_template->printInput( $keyy, 'limit', '' ); ?></td>
    <td>
        <a class="delete-row" title="Delete">
            <i class="fa fa-trash"></i>
        </a>
    </td>
</tr>

<?php foreach ( $feed_template->getTemplateMappings() as $key => $item): ?>
    <?php
    $hideStaticInput = $item['type'] != 'static' ? 'style="display:none;"' : '';
    $hideMetaInput   = $item['type'] == 'static' ? 'style="display:none;"' : '';

    ?>
    <tr data-row-id="<?php echo $key; ?>">
        <td data-title="Attributes : ">
            <?php
            if(array_key_exists('attr', $item)) {
                $feed_template->printSelectDropdown( $key, 'attr', $item['attr'] );
            }else {
                $feed_template->printInput( $key, 'cust_attr', $item['cust_attr'] );
            }

            ?>
        </td>
        <td data-title="Type : "><?php $feed_template->printAttType( $key, $item['type'] ); ?></td>
        <td data-title="Value : ">
            <div class="meta-dropdown" <?php echo $hideMetaInput; ?>>
                <?php
                    echo '<select  name="fc['.$key.'][' . esc_attr( 'meta_key' ) . ']" >';
                    echo "<option value=''>Please Select</option>";
                    echo $feed_template->printProductAttributes($item['meta_key']);
                    echo "</select>";
                ?>
            </div>
            <div class="static-input" <?php echo $hideStaticInput; ?>>
                <?php $feed_template->printInput( $key, 'st_value', $item['st_value'] ); ?>
            </div>
        </td>
        <td data-title="Prefix : "><?php $feed_template->printInput( $key, 'prefix', $item['prefix'] ); ?></td>
        <td data-title="Suffix : "><?php $feed_template->printInput( $key, 'suffix', $item['suffix'] ); ?></td>
        <td data-title="Output Sanitization : "><?php $feed_template->printSelectDropdown( $key, 'escape', $item['escape'] ); ?></td>
        <td data-title="Output Limit : "><?php $feed_template->printInput( $key, 'limit', $item['limit'] ); ?></td>
        <td>
            <a class="delete-row" title="Delete">
                <i class="fa fa-trash"></i>
            </a>
        </td>
    </tr>
<?php endforeach ?>

</tbody>