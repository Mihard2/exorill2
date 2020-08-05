<?php
if (!defined( 'ABSPATH' )) {
    exit;
}
/**
 * Class OSF_Customize_Control_Heading
 */
class OSF_Customize_Control_Heading extends WP_Customize_Control {

    public $type = 'heading';

    /**
     * @return  void
     */
    public function render_content() {
        if ( ! empty( $this->label ) ) :
            ?>
            <h4><?php echo esc_html( $this->label ); ?></h4>
            <?php
        endif;

        if ( ! empty( $this->description ) ) :
            ?>
            <span class="description customize-control-description"><?php echo '' . $this->description ; ?></span>
        <?php endif;
    }
}
