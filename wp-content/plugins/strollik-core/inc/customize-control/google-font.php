<?php
if (!defined( 'ABSPATH' )) {
    exit;
}

/**
 * Class OSF_Customize_Control_Google_Fonts
 */
class OSF_Customize_Control_Google_Font extends WP_Customize_Control {

    public $type = 'otf-google-fonts';

    public $fonts;

    /**
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

        $default = wp_parse_args( $this->settings['default']->default, array(
            'family'     => '',
            'subsets'    => 'latin',
            'fontWeight' => '400',
        ) );

        // Prepare current value.
        $value = wp_parse_args( $this->value(), array(
            'family'     => '',
            'subsets'    => 'latin',
            'fontWeight' => '400',
        ) );

        ?>
        <div otf-fonts-control data-id="<?php echo esc_attr( $this->id ) ?>">
            <select class="otf-customize-google-fonts" title="Google Fonts">
                <option></option>
                <?php
                foreach ($this->fonts as $font) {
                    echo '<option data-info="' . esc_attr( json_encode( array( 'variants' => $font->variants, 'subsets' => $font->subsets ) ) ) . '" value="' . esc_attr( $font->family ) . '" ' . selected( $value['family'], $font->family, false ) . '>' . $font->family . '</option>';
                }
                ?>
            </select>
            <div class="google-font-extend">
                <div class="select-control otf-font-weight">
                    <select data-value="<?php echo esc_attr($value['fontWeight']) ?>" title="Font Weight"></select>
                </div>
                <div class="select-control otf-font-subsets">
                    <select data-value="<?php echo esc_attr($value['subsets']) ?>" title="Subsets"></select>
                </div>
            </div>
        </div>
        <?php
    }
}
