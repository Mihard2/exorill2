<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class VI_WOO_PRODUCT_VARIATIONS_SWATCHES_DATA {
	private $params;
	private $default;
	private $default_color;

	/**
	 * VI_WOO_PRODUCT_VARIATIONS_SWATCHES_DATA constructor.
	 * Init setting
	 */
	public function __construct() {
		$this->prefix = 'vi-wpvs-';
		global $vi_wpvs_settings;
		if ( ! $vi_wpvs_settings ) {
			$vi_wpvs_settings = get_option( 'vi_woo_product_variation_swatches_params', array() );
		}
		$this->default_color = array(
			'white'               => '#FFFFFF',
			'white smoke'         => '#F5F5F5',
			'gainsboro'           => '#DCDCDC',
			'light gray'          => '#D3D3D3',
			'light grey'          => '#D3D3D3',
			'silver'              => '#C0C0C0',
			'dark gray'           => '#A9A9A9',
			'dark grey'           => '#A9A9A9',
			'gray'                => '#808080',
			'grey'                => '#808080',
			'dim gray'            => '#696969',
			'dim grey'            => '#696969',
			'black'               => '#000000',
			'snow'                => '#FFFAFA',
			'azure'               => '#F0FFFF',
			'ivory'               => '#FFFFF0',
			'honeydew'            => '#F0FFF0',
			'ghost white'         => '#F8F8FF',
			'alice blue'          => '#F0F8FF',
			'floral white'        => '#FFFAF0',
			'lavender'            => '#E6E6FA',
			'light steel blue'    => '#B0C4DE',
			'light slate gray'    => '#778899',
			'slate gray'          => '#708090',
			'mint cream'          => '#F5FFFA',
			'sea shell'           => '#FFF5EE',
			'papaya whip'         => '#FFEFD5',
			'old lace'            => '#FDF5E6',
			'linen'               => '#FAF0E6',
			'lavender blush'      => '#FFF0F5',
			'misty rose'          => '#FFE4E1',
			'peach puff'          => '#FFDAB9',
			'navajo white'        => '#FFDEAD',
			'moccasin'            => '#FFE4B5',
			'rosy brown'          => '#BC8F8F',
			'tan'                 => '#D2B48C',
			'burly wood'          => '#DEB887',
			'sandy brown'         => '#F4A460',
			'peru'                => '#CD853F',
			'chocolate'           => '#D2691E',
			'sienna'              => '#A0522D',
			'saddle brown'        => '#8B4513',
			'light yellow'        => '#FFFFE0',
			'light golden'        => '#FAFAD2',
			'rod yellow'          => '#FAFAD2',
			'lemon chiffon'       => '#FFFACD',
			'corn silk'           => '#FFF8DC',
			'wheat'               => '#F5DEB3',
			'blanched almond'     => '#FFEBCD',
			'bisque'              => '#FFE4C4',
			'beige'               => '#F5F5DC',
			'antique white'       => '#FAEBD7',
			'pink'                => '#FFC0CB',
			'light pink'          => '#FFB6C1',
			'hot pink'            => '#FF69B4',
			'deep pink'           => '#FF1493',
			'pale violet red'     => '#DB7093',
			'medium violet red'   => '#C71585',
			'orchid'              => '#DA70D6',
			'magenta'             => '#FF00FF',
			'fuchsia'             => '#FF00FF',
			'violet'              => '#EE82EE',
			'plum'                => '#DDA0DD',
			'thistle'             => '#D8BFD8',
			'purple'              => '#800080',
			'medium orchid'       => '#BA55D3',
			'dark orchid'         => '#9932CC',
			'dark violet'         => '#9400D3',
			'dark magenta'        => '#8B008B',
			'medium purple'       => '#9370DB',
			'medium slate blue'   => '#7B68EE',
			'dark slate blue'     => '#483D8B',
			'slate blue'          => '#6A5ACD',
			'indigo'              => '#4B0082',
			'blue violet'         => '#8A2BE2',
			'royal blue'          => '#4169E1',
			'dark blue'           => '#00008B',
			'medium blue'         => '#0000CD',
			'midnight blue'       => '#191970',
			'light sky blue'      => '#87CEFA',
			'sky blue'            => '#87CEEB',
			'light blue'          => '#ADD8E6',
			'dodger blue'         => '#1E90FF',
			'deep sky blue'       => '#00BFFF',
			'corn flower blue'    => '#6495ED',
			'steel blue'          => '#4682B4',
			'cadet blue'          => '#5F9EA0',
			'powder blue'         => '#B0E0E6',
			'navy'                => '#000080',
			'blue'                => '#0000FF',
			'aqua marine'         => '#7FFFD4',
			'pale turquoise'      => '#AFEEEE',
			'medium turquoise'    => '#48D1CC',
			'turquoise'           => '#40E0D0',
			'dark turquoise'      => '#00CED1',
			'light cyan'          => '#E0FFFF',
			'cyan'                => '#00FFFF',
			'aqua'                => '#00FFFF',
			'dark cyan'           => '#008B8B',
			'teal'                => '#008080',
			'dark slate gray'     => '#2F4F4F',
			'light sea green'     => '#20B2AA',
			'medium sea green'    => '#3CB371',
			'medium aqua marine'  => '#66CDAA',
			'sea green'           => '#2E8B57',
			'spring green'        => '#00FF7F',
			'medium spring green' => '#00FA9A',
			'dark sea green'      => '#8FBC8F',
			'pale green'          => '#98FB98',
			'light green'         => '#90EE90',
			'lime green'          => '#32CD32',
			'lime'                => '#00FF00',
			'forest green'        => '#228B22',
			'green'               => '#008000',
			'dark green'          => '#006400',
			'green yellow'        => '#ADFF2F',
			'chart reuse'         => '#7FFF00',
			'lawn green'          => '#7CFC00',
			'olive drab'          => '#6B8E23',
			'dark olive green'    => '#556B2F',
			'yellow green'        => '#9ACD32',
			'yellow'              => '#FFFF00',
			'olive'               => '#808000',
			'khaki'               => '#F0E68C',
			'dark khaki'          => '#BDB76B',
			'pale golden rod'     => '#EEE8AA',
			'golden rod	'      => '#DAA520',
			'dark golden rod'     => '#B8860B',
			'gold'                => '#FFD700',
			'orange'              => '#FFA500',
			'dark orange'         => '#FF8C00',
			'orange red	'      => '#FF4500',
			'light salmon'        => '#FFA07A',
			'salmon'              => '#FA8072',
			'dark salmon'         => '#E9967A',
			'light coral'         => '#F08080',
			'indian red'          => '#CD5C5C',
			'coral'               => '#FF7F50',
			'tomato'              => '#FF6347',
			'red'                 => '#FF0000',
			'crimson'             => '#DC143C',
			'firebrick'           => '#B22222',
			'brown'               => '#A52A2A',
			'dark red'            => '#8B0000',
			'maroon'              => '#800000',
		);
		$this->default       = array(
			'ids'                          => array( 'variationswatchesdesign' ),
			'names'                        => array( 'Variation Swatches Design' ),
			'attribute_reduce_size_mobile' => array( '85' ),
			'attribute_width'              => array( '48' ),
			'attribute_height'             => array( '48' ),
			'attribute_fontsize'           => array( '16' ),
			'attribute_padding'            => array( '1px' ),
			'attribute_transition'         => array( '30' ),

			'attribute_default_box_shadow_color' => array( '#adada3' ),
			'attribute_default_color'            => array( '#666' ),
			'attribute_default_bg_color'         => array( '#fff' ),
			'attribute_default_border_color'     => array( '#ccc' ),
			'attribute_default_border_radius'    => array( '3' ),
			'attribute_default_border_width'     => array( '1' ),

			'attribute_hover_scale'            => array( '1' ),
			'attribute_hover_box_shadow_color' => array( '#adada3' ),
			'attribute_hover_color'            => array( '#222' ),
			'attribute_hover_bg_color'         => array( '#fff' ),
			'attribute_hover_border_color'     => array( '#ccc' ),
			'attribute_hover_border_radius'    => array( '3' ),
			'attribute_hover_border_width'     => array( '1' ),

			'attribute_selected_scale'            => array( '1' ),
			'attribute_selected_icon_enable'      => array( '' ),
			'attribute_selected_icon_type'        => array( '1' ),
			'attribute_selected_icon_color'       => array( '#56d465' ),
			'attribute_selected_box_shadow_color' => array( '#adada3' ),
			'attribute_selected_color'            => array( '#222' ),
			'attribute_selected_bg_color'         => array( '#fff' ),
			'attribute_selected_border_color'     => array( '#ddd' ),
			'attribute_selected_border_radius'    => array( '3' ),
			'attribute_selected_border_width'     => array( '1' ),

			'attribute_out_of_stock' => array( 'blur' ),

			'attribute_tooltip_enable'        => array( '1' ),
			'attribute_tooltip_type'          => array( 'label' ),
			'attribute_tooltip_position'      => array( 'top' ),
			'attribute_tooltip_width'         => array( '' ),
			'attribute_tooltip_height'        => array( '' ),
			'attribute_tooltip_fontsize'      => array( '14' ),
			'attribute_tooltip_border_radius' => array( '3' ),
			'attribute_tooltip_bg_color'      => array( '#fff' ),
			'attribute_tooltip_color'         => array( '#222' ),
			'attribute_tooltip_border_color'  => array( '#ccc' ),


			'attribute_display_default' => 'button',
			'attribute_profile_default' => '',
			'attribute_double_click'    => '',

			'taxonomy_profiles'     => array(),
			'taxonomy_display_type' => array(),

			'check_swatches_settings'         => '',
			'variation_threshold_single_page' => '30',
		);

		$this->params = apply_filters( 'vi_woo_product_variation_swatches_params', wp_parse_args( $vi_wpvs_settings, $this->default ) );
	}

	public function get_params( $name = "" ) {
		if ( ! $name ) {
			return $this->params;
		} elseif ( isset( $this->params[ $name ] ) ) {
			return apply_filters( 'vi_woo_product_variation_swatches_params-' . $name, $this->params[ $name ] );
		} else {
			return false;
		}
	}

	public function get_default( $name = "" ) {
		if ( ! $name ) {
			return $this->default;
		} elseif ( isset( $this->default[ $name ] ) ) {
			return apply_filters( 'vi_woo_product_variation_swatches_params_default-' . $name, $this->default[ $name ] );
		} else {
			return false;
		}
	}

	public function set( $name ) {
		if ( is_array( $name ) ) {
			return implode( ' ', array_map( array( $this, 'set' ), $name ) );

		} else {
			return esc_attr__( $this->prefix . $name );

		}
	}

	public function get_current_setting( $name = "", $i = 0 ) {
		if ( ! $name ) {
			$result = false;
		} elseif ( isset( $this->get_params( $name )[ $i ] ) ) {
			$result = $this->get_params( $name )[ $i ];
		} elseif ( isset( $this->get_default( $name )[0] ) ) {
			$result = $this->get_default( $name )[0];
		} else {
			$result = false;
		}

		return $result;
	}

	public function get_default_color( $color = '' ) {
		if ( ! $color ) {
			return $this->default_color;
		} elseif ( isset( $this->default_color[ $color ] ) ) {
			return apply_filters( 'vi_woo_product_variation_swatches_filter_color-' . $color, $this->default_color[ $color ] );
		} else {
			return false;
		}
	}

	public static function extend_post_allowed_html() {
		return array_merge( wp_kses_allowed_html( 'post' ), array(
				'input' => array(
					'type'         => 1,
					'id'           => 1,
					'name'         => 1,
					'class'        => 1,
					'placeholder'  => 1,
					'autocomplete' => 1,
					'style'        => 1,
					'value'        => 1,
					'data-*'       => 1,
					'size'         => 1,
				),
				'form'  => array(
					'type'   => 1,
					'id'     => 1,
					'name'   => 1,
					'class'  => 1,
					'style'  => 1,
					'method' => 1,
					'action' => 1,
					'data-*' => 1,
				),
			)
		);
	}
}

new VI_WOO_PRODUCT_VARIATIONS_SWATCHES_DATA();
