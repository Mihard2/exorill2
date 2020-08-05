<?php
if (!defined( 'ABSPATH' )){
    exit;
}

/**
 * Class OSF_Customize_Control_Image_Select
 */
class OSF_Customize_Control_Image_Select extends WP_Customize_Control {

    public $type = 'otf-image-select';

    public $layout = 'default';

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

        if ($this->layout === 'default'){
            $this->render_layout_default();
        } else{
            $this->render_layout_sidebar();
        }
    }

    public function render_layout_default() {
        ?>
        <div otf-select-image-control data-id="<?php echo esc_attr( $this->id ) ?>">
            <div class="select-control">
                <select <?php $this->link(); ?>>
                    <?php
                    foreach ($this->choices as $value => $image)
                        echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $image . '</option>';
                    ?>
                </select>
            </div>
            <ul class="select-list-image">
                <?php
                foreach ($this->choices as $value => $image) {
                    ?>
                    <li class="<?php echo ( $this->value() == $value ) ? esc_attr( ' active' ) : ''; ?>">
                        <div class="box">
                            <img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $value ); ?>">
                        </div>
                    </li>
                    <?php
                }
                ?>
            </ul>
        </div>
        <?php
    }

    public function render_layout_sidebar() {
        ?>
        <div class="opal-control-image-select" data-id="<?php echo esc_attr( $this->id ) ?>">
            <div class="select-control">
                <select <?php $this->link(); ?>>
                    <?php
                    foreach ($this->choices as $value => $image)
                        echo '<option value="' . esc_attr( $value ) . '"' . selected( $this->value(), $value, false ) . '>' . $value . $image . '</option>';
                    ?>
                </select>
            </div>
            <div class="image-select">
                <?php
                foreach ($this->choices as $value => $image) {
                    echo '<div data-value="'.esc_attr($value).'" class="image-select-tpl' . ( $value == $this->value() ? ' active' : '' ) . '"><img src="' . esc_url( $image ) . '" alt="' . esc_attr( $value ) . '"></div>';
                }
                ?>
            </div>
            <div class="change-image">
                <button type="button" class="button button-change-image">
                    <?php _e( 'Change', 'strollik-core' ); ?>
                </button>
            </div>
        </div>
        <?php
    }
}
