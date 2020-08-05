<?php
if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * Class OSF_Customize_Control_Button_Switch
 */
class OSF_Customize_Control_Button_Switch extends WP_Customize_Control {
    public $type    = 'otf-button-switch';

    /**
     * Render the control.
     */
    public function render_content() {
        if ($this->label) {
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php
        }

        if ($this->description) {
            ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php
        }
        ?>
            <input class="otf-switch otf-switch-ios" id="<?php echo esc_attr($this->id); ?>" type="checkbox" <?php $this->link(); ?>>
            <label class="otf-switch-btn" for="<?php echo esc_attr($this->id); ?>"></label>
        <?php
    }
}