<?php
use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}
class OSF_Elementor_Parallax {
	public function __construct() {
		// Fix Parallax granular-controls-for-elementor
		if ( function_exists( 'granular_get_options' ) ) {
			$parallax_on = granular_get_options( 'granular_editor_parallax_on', 'granular_editor_settings', 'no' );
			if ( 'yes' === $parallax_on ) {
				add_action( 'elementor/frontend/section/after_render', [
					$this,
					'granular_editor_after_render'
				], 10, 1 );
			}
		}
	}
	public function granular_editor_after_render( $element ) {
		$settings = $element->get_settings();
		if ( $element->get_settings( 'section_parallax_on' ) == 'yes' ) {
			$type        = $settings['parallax_type'];
			$and_support = $settings['android_support'];
			$ios_support = $settings['ios_support'];
			$speed       = $settings['parallax_speed'];
			?>

			<script type="text/javascript">
                (function ($) {
                    "use strict";
                    var granularParallaxElementorFront = {
                        init      : function () {
                            elementorFrontend.hooks.addAction('frontend/element_ready/global', granularParallaxElementorFront.initWidget);
                        },
                        initWidget: function ($scope) {
                            $('.elementor-element-<?php echo $element->get_id(); ?>').jarallax({
                                type       : '<?php echo $type; ?>',
                                speed      : <?php echo $speed; ?>,
                                keepImg    : true,
                                imgSize    : 'cover',
                                imgPosition: '50% 0%',
                                noAndroid  : <?php echo $and_support; ?>,
                                noIos      : <?php echo $ios_support; ?>
                            });
                        }
                    };
                    $(window).on('elementor/frontend/init', granularParallaxElementorFront.init);
                }(jQuery));
			</script>

		<?php }
	}
}
new OSF_Elementor_Parallax();