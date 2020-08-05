<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OSF_Customize_Control_Font_Style
 */
class OSF_Customize_Control_Font_Style extends WP_Customize_Control {
    public $type = 'otf-font-style';

    public $fonts;

    /**
     * @return  void
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

        $default = wp_parse_args( $this->settings['default']->default, array(
            'italic'     => '',
            'underline'  => '',
            'uppercase'  => '',
            'fontWeight' => '',
        ) );

        // Prepare current value.
        $value = wp_parse_args( $this->value(), array(
            'italic'     => '',
            'underline'  => '',
            'uppercase'  => '',
            'fontWeight' => '',
        ) );
        ?>
        <div otf-font-style-control data-id="<?php echo esc_attr( $this->id ) ?>">
            <div class="otf-font-style-group">
                <label class="item">
                    <input class="otf-font-weight" type="checkbox" <?php echo checked( $value['fontWeight'], true ) ?>>
                    <div class="otf-box">
                        <span class="dashicons dashicons-editor-bold"></span>
                    </div>
                </label>
            </div>
            <div class="otf-font-style-group">
                <label class="item">
                    <input class="otf-italic" type="checkbox" <?php echo checked( $value['italic'], true ) ?>>
                    <div class="otf-box">
                        <span class="dashicons dashicons-editor-italic"></span>
                    </div>
                </label>
            </div>
            <div class="otf-font-style-group">
                <label class="item">
                    <input class="otf-underline" type="checkbox" <?php echo checked( $value['underline'], true ) ?>>
                    <div class="otf-box">
                        <span class="dashicons dashicons-editor-underline"></span>
                    </div>
                </label>
            </div>
            <div class="otf-font-style-group">
                <label class="item">
                    <input class="otf-uppercase" type="checkbox" <?php echo checked( $value['uppercase'], true ) ?>>
                    <div class="otf-box">
                        <span class="dashicons dashicons-editor-textcolor"></span>
                    </div>
                </label>
            </div>
        </div>
        <?php
    }
}