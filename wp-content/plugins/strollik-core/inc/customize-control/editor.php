<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OSF_Customize_Control_Editor
 */
class OSF_Customize_Control_Editor extends WP_Customize_Control {
    public $type = 'otf-editor';


    /**
     * Render the control's content.
     *
     * @return  void
     */
    public function render_content() {
        ?>
        <label>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
        </label>
        <input type="hidden" <?php $this->link(); ?> value="<?php echo esc_attr( $this->value() ); ?>">
        <?php
        wp_editor( $this->value(), $this->id, array(
            'textarea_name' => $this->id,
            'textarea_rows' => 5
        ) );
        do_action( 'admin_footer' );
        do_action( 'admin_print_footer_scripts' );
    }
}
