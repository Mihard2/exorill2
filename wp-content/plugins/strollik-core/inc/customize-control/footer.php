<?php
if (!defined( 'ABSPATH' )){
    exit;
}

class OSF_Customize_Control_Footers extends WP_Customize_Control {
    public $type = 'otf-footers';

    /**
     * @return array
     */
    public function get_footers() {
        $args = array(
            'post_type'      => 'footer',
            'posts_per_page' => -1,
            'post_status'    => 'publish',
        );

        return get_posts( $args );
    }

    /**
     * Render the control's content.
     *
     * @return  void
     */
    public function render_content() {
        /**
         * @var $footer WP_Post
         */
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
        $footers        = $this->get_footers();
        ?>
        <div class="opal-control-image-select opal-control-footer" data-id="<?php echo esc_attr( $this->id ) ?>">
            <select <?php $this->link(); ?> title="">
                <option value="" disabled>---<?php esc_html_e('Select Footer', 'strollik-core') ?>---</option>
                <?php
                foreach ($footers as $footer):
                    echo '<option data-id="'.$footer->ID.'" value="' . esc_attr( $footer->post_name ) . '"' . selected( $this->value(), $footer->post_name, false ) . '>' . esc_html( $footer->post_title ) . '</option>';
                    ?>
                <?php endforeach; ?>
            </select>
            <a href="#" target="_blank" data-link="<?php echo esc_url(admin_url('post.php?action=edit')) ?>" class="button button-primary" style="display: none;"><?php esc_html_e('Go to Footer builder', 'strollik-core') ?></a>
        </div>
        <?php
    }
}
