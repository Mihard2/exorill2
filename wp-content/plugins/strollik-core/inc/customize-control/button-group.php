<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OSF_Customize_Control_Button_Group
 */
class OSF_Customize_Control_Button_Group extends WP_Customize_Control {
    public $type    = 'otf-button-group';
    public $buttons = array();

    /**
     * Render the control.
     */
    public function render_content() {
        if ($this->label){
            ?>
            <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
            <?php
        }

        if ($this->description){
            ?>
            <span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
            <?php
        }

        ?>
        <div class="otf-button-group button-group">
            <?php
            foreach ($this->choices as $value => $label) { ?>
                <label>
                    <input class="screen-reader-text"
                           name="<?php echo esc_attr( $this->id ) ?>" <?php checked( $this->value(), $value ) ?>
                           type="radio" value="<?php echo esc_attr($value) ?>" <?php $this->link() ?>>
                    <span class="button"><?php echo esc_html( $label ) ?></span>
                </label>

            <?php } ?>
        </div>
        <?php
    }
}