<?php
if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * Class OSF_Customize_Control_Slider
 */
class OSF_Customize_Control_Slider extends WP_Customize_Control {
    public $type = 'otf-slider';

    /**
     * @var array
     */
    public $choices;

    /**
     * Enqueue control related scripts/styles.
     *
     * @return  void
     */
    public function enqueue() {
        // Load jQuery UI
        wp_enqueue_style( 'jquery-ui-slider' );
        wp_enqueue_script( 'jquery-ui-slider' );
    }

    /**
     * Render the control's content.
     *
     * @return  void
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
        <div class="customize-control-content otf-customize-slider"
             id="<?php echo esc_attr( $this->type ); ?>-<?php echo esc_attr( $this->id ); ?>">
            <div class="otf-slider wp-slider"
                 data-min="<?php echo( isset( $this->choices['min'] ) ? esc_attr( $this->choices['min'] ) : '0' ); ?>"
                 data-max="<?php echo( isset( $this->choices['max'] ) ? esc_attr( $this->choices['max'] ) : '100' ); ?>"
                 data-step="<?php echo( isset( $this->choices['step'] ) ? esc_attr( $this->choices['step'] ) : '1' ); ?>"
                 data-unit="<?php echo( isset( $this->choices['unit'] ) ? esc_attr( $this->choices['unit'] ) : '' ); ?>"
                 data-default-value="<?php echo esc_attr( $this->settings['default']->default ); ?>"
                 data-value="<?php echo esc_attr( $this->value() ) ?>"
                 data-id="<?php echo esc_attr( $this->id ) ?>"
                 data-highlight="true">
            </div>
            <a href="#" class="otf-reset dashicons dashicons-image-rotate"></a>
        </div>
        <?php
    }
}
