<?php
if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * Class OSF_Customize_Control_Color
 */
class OSF_Customize_Control_Button_Move extends WP_Customize_Control {
    public $type    = 'otf-button-move';
    public $buttons = array();

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
        <?php
        foreach ($this->buttons as $id => $button) {
            $button = wp_parse_args( $button, array(
                'type'  => '',
                'label' => '',
            ) );
            echo '<button type="button" otf-button-move class="button" data-id="' . esc_attr( $id ) . '" data-type="' . esc_attr( $button['type'] ) . '">' . esc_html( $button['label'] ) . '</button>';
        }
    }
}