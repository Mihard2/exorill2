<?php
if (!defined( 'ABSPATH' )){
    exit;
}

class OSF_Customize_Control_Headers extends WP_Customize_Control {
    public $type = 'otf-headers';

    /**
     * @return array
     */
    public function get_headers() {
        $args = array(
            'post_type'      => 'header',
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
        $headers = $this->get_headers();

        ?>
        <div class="otf-select-group-button">
            <select <?php $this->link(); ?> title="Header">
                <option value="" disabled>---<?php esc_html_e('Select Header', 'strollik-core') ?>---</option>
                <?php
                foreach ($headers as $header):
                    /**
                     * @var $header WP_Post
                     */
                    echo '<option data-id="'.$header->ID.'" value="' . esc_attr( $header->post_name ) . '"' . selected( $this->value(), $header->post_name, false ) . '>' . esc_html( $header->post_title ) . '</option>';
                    ?>
                <?php endforeach; ?>
            </select>
            <a href="#" target="_blank" data-link="<?php echo esc_url(admin_url('post.php?action=edit')) ?>" class="button button-primary" style="display: none;"><?php esc_html_e('Go to header builder', 'strollik-core') ?></a>
        </div>
        <?php
    }
}
