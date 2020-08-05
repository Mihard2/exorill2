<?php

class OSF_Import {
	private $config, $path_rev, $homepage, $blogpage, $header, $footer, $contactForm, $mailchimp, $templates;

	public function __construct() {
		if ( is_admin() ) {
			$this->path_rev = trailingslashit( wp_upload_dir()['basedir'] ) . 'opal_rev_sliders_import/';
			add_action( 'after_setup_theme', array( $this, 'init' ) );
		}
	}

	public function init() {
		$this->init_hooks();
		add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );
	}

	public function init_hooks() {
		add_action( 'osf_before_import_customizer', array( $this, 'reset_theme_mods' ) );
		if ( get_option( 'otf-oneclick-first-import', 'yes' ) === 'yes' ) {
			add_filter( 'pt-ocdi/import_files', array( $this, 'import_file_base' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup_base' ), 20 );
		} else {
			add_filter( 'pt-ocdi/import_files', array( $this, 'import_files' ) );
			add_action( 'pt-ocdi/after_import', array( $this, 'after_import_setup' ) );
			add_filter( 'pt-ocdi/enable_grid_layout_import_popup_confirmation', '__return_false' );
			add_filter( 'otf-ocdi/reload_page', '__return_false' );
		}
	}

	public function import_file_base() {
		$this->init_data();
		$imports   = array();
		$import    = array(
			'import_file_name'  => 'Basic',
			'local_import_file' => trailingslashit( STROLLIK_CORE_PLUGIN_DIR ) . 'dummy-data/content.xml',
			'import_notice'     => 'Basic import includes default version from our demo and a few products, blog posts and portfolio projects. It is a required minimum to see how our theme built and to be able to import additional versions or pages.',
			'slug'              => '00'
		);
		$imports[] = $import;

		return $imports;
	}

	public function import_files() {
		$this->init_data();
		$imports = array();
		foreach ( $this->config as $key => $niche ) {
			$import = array(
				'import_file_name'         => $niche['name'],
				'import_preview_image_url' => $niche['screenshot'],
				'slug'                     => $key,
			);
			if ( isset( $niche['xml'] ) ) {
				$import['import_file_url'] = $niche['xml'];
			}

			$imports[] = $import;
		}

		return $imports;
	}

	private function init_data() {
		$this->config          = $this->get_remote_json( trailingslashit( STROLLIK_CORE_PLUGIN_URL ) . 'dummy-data/config.json', true );
		$this->homepage        = get_page_by_title( 'Home page' );
		$this->blogpage        = get_page_by_title( 'Blog List' );
		$this->header['main']  = get_page_by_title( 'Header Main', OBJECT, 'header' );
		$this->header['other'] = get_page_by_title( 'Header Other Page', OBJECT, 'header' );
		$this->footer['main']  = get_page_by_title( 'Footer Main', OBJECT, 'footer' );
		$this->footer['other'] = get_page_by_title( 'Footer Other Page', OBJECT, 'footer' );
		$this->contactForm     = get_page_by_title( 'Contact Form Strollik', OBJECT, 'wpcf7_contact_form' );
		$this->mailchimp       = get_page_by_title( 'MailChimp Strollik', OBJECT, 'mc4wp-form' );
	}

	public function after_import_setup_base( $selected_import ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', ( ( $this->homepage instanceof WP_Post ) ? $this->homepage->ID : 0 ) );
		update_option( 'page_for_posts', ( ( $this->blogpage instanceof WP_Post ) ? $this->blogpage->ID : 0 ) );
		update_option( 'otf-oneclick-first-import', 'no' );

		// Parallax
		$options = get_option('granular_editor_settings', array());
		$options['granular_editor_parallax_on'] = 'yes';
		update_option('granular_editor_settings', $options);
	}


	public function after_import_setup( $selected_import ) {
		if ( isset( $this->config[ $selected_import['slug'] ] ) ) {

			$setup = $this->config[ $selected_import['slug'] ];

			// REVSLIDER
			if ( $sliders = $setup['rev_sliders'] ) {
				if ( class_exists( 'RevSliderAdmin' ) ) {
					if ( ! file_exists( $this->path_rev ) ) {
						mkdir( $this->path_rev, 0777, true );
					}
					foreach ( $sliders as $slider ) {
						$this->add_revslider( $slider );
					}
				}
			}

			$settings        = $this->get_remote_json( $setup['settings'], true );
			$this->templates = $settings['templates'];

			// Setup Customizer
			$this->reset_theme_mods();
			$thememods = $settings['thememods'];
			foreach ( $thememods as $mod => $value ) {
				set_theme_mod( $mod, $value );
			}

			// Setup Elementor
			if ( osf_is_elementor_activated() ) {
				foreach ( $settings['elementor'] as $key => $value ) {
					update_option( $key, $value );
				}
				$global = new Elementor\Core\Files\CSS\Global_CSS( 'global.css' );
				$global->update_file();
				// Homepage
				$this->setup_homepage( $settings['homepage'], $settings['homepage-custom'] );

				// Header
				$this->setup_header( $settings['header']['main'], $settings['header']['other'], $settings['header-custom'] );

				// Footer
				$this->setup_footer( $settings['footer']['main'], $settings['footer']['main'] );

				// Logo
				$this->setup_logo( $settings['logo'] );

			}

			// Custom Css
			if ( $settings['custom_css'] ) {
				wp_update_custom_css_post( $settings['custom_css'] );
			}

			// Mailchimp
			$mailchimp = get_page_by_title( 'Opal MailChimp', OBJECT, 'mc4wp-form' );
			if ( $mailchimp ) {
				update_option( 'mc4wp_default_form_id', $mailchimp->ID );
			}
		}
		set_theme_mod( 'osf_dev_mode', false );
	}

	private function setup_logo( $logo ) {
		$logo_id = $this->get_image_id( $logo );
		if ( $logo_id ) {
			set_theme_mod( 'custom_logo', $logo_id );
		}
	}

	private function setup_homepage( $data, $custom ) {
		$data = $this->update_image_elementor( $data );
		update_post_meta( $this->homepage->ID, '_elementor_data', wp_slash( wp_json_encode( $data ) ) );
		$bc = new Elementor\Core\Files\CSS\Post( $this->homepage->ID );
		$bc->update();

		foreach ( $custom as $key => $value ) {
			update_post_meta( $this->homepage->ID, $key, $value );
		}
	}

	private function setup_footer( $main, $other ) {
		$main = $this->update_image_elementor( $main );
		update_post_meta( $this->footer['main']->ID, '_elementor_data', wp_slash( wp_json_encode( $main ) ) );
		$bc = new Elementor\Core\Files\CSS\Post( $this->footer['main']->ID );
		$bc->update();

		$other = $this->update_image_elementor( $other );
		update_post_meta( $this->footer['other']->ID, '_elementor_data', wp_slash( wp_json_encode( $other ) ) );
		$bc = new Elementor\Core\Files\CSS\Post( $this->footer['other']->ID );
		$bc->update();
	}

	private function setup_header( $main, $other, $custom ) {
		$main = $this->update_image_elementor( $main );
		update_post_meta( $this->header['main']->ID, '_elementor_data', wp_slash( wp_json_encode( $main ) ) );
		$bc = new Elementor\Core\Files\CSS\Post( $this->header['main']->ID );
		$bc->update();

		$other = $this->update_image_elementor( $other );
		update_post_meta( $this->header['other']->ID, '_elementor_data', wp_slash( wp_json_encode( $other ) ) );
		$bc = new Elementor\Core\Files\CSS\Post( $this->header['other']->ID );
		$bc->update();

		foreach ( $custom as $key => $value ) {
			if ( is_array( $value ) ) {
				$postid = $this->header[ $key ]->ID;
				foreach ( $value as $k => $v ) {
					update_post_meta( $postid, $k, $v );
				}
			}
		}
	}

	private function add_revslider( $slider ) {
		$dest_rev = $this->path_rev . basename( $slider );
		if ( ! file_exists( $dest_rev ) ) {
			file_put_contents( $dest_rev, wp_remote_fopen( $slider ) );
			$_FILES['import_file']['error']    = UPLOAD_ERR_OK;
			$_FILES['import_file']['tmp_name'] = $dest_rev;

			$revslider = new RevSlider();
			$revslider->importSliderFromPost( true, 'none' );
		}
	}

	/**
	 * @param $link
	 *
	 * @return object|boolean
	 */
	private function get_remote_json( $link, $assoc = false ) {
		$content = wp_remote_get( $link );
		if ( $content instanceof WP_Error ) {
			return false;
		}

		return json_decode( $content['body'], $assoc );
	}

	public function reset_theme_mods() {
		$mods = json_decode( file_get_contents( trailingslashit( STROLLIK_CORE_PLUGIN_DIR ) . 'reset-theme-mods.json' ) );
		foreach ( $mods as $mod ) {
			remove_theme_mod( $mod );
		}
	}

	private function update_image_elementor( $datas ) {
		if ( count( $datas ) <= 0 ) {
			return $datas;
		}
		foreach ( $datas as $key => $data ) {
			if ( ! empty( $data['settings']['background_image'] ) ) {
				$data['settings']['backgbackground_image']['id'] = $this->get_image_id( $data['settings']['backgbackground_image']['url'] );
			}

			if ( ! empty( $data['settings']['background_hover_image'] ) ) {
				$data['settings']['background_hover_image']['id'] = $this->get_image_id( $data['settings']['background_hover_image']['url'] );
			}

			// Call To action
			if ( ! empty( $data['settings']['bg_image'] ) ) {
				$data['settings']['bg_image']['id'] = $this->get_image_id( $data['settings']['bg_image']['url'] );
			}

			// Image
			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'image' ) {
				$data['settings']['image']['id'] = $this->get_image_id( $data['settings']['image']['url'] );
			}

			// Image Layers
			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'opal-images-layers' ) {
				if ( count( $data['settings']['img_layers_images_repeater'] ) > 0 ) {
					foreach ( $data['settings']['img_layers_images_repeater'] as $k => $repeater ) {
						if ( isset( $repeater['img_layers_image'] ) ) {
							$data['settings']['img_layers_images_repeater'][ $k ]['img_layers_image']['id'] = $this->get_image_id( $repeater['img_layers_image']['url'] );
						}
					}
				}
			}

			// 360
			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'rotate-image' ) {
				if ( count( $data['settings']['carousel'] ) > 0 ) {
					foreach ( $data['settings']['carousel'] as $k => $carousel ) {
						$data['settings']['carousel'][ $k ]['id'] = $this->get_image_id( $carousel['url'] );
					}
				}

			}

			// Tab Template ID
			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'opal-tabs' ) {
				if ( count( $data['settings']['tabs'] ) > 0 ) {
					foreach ( $data['settings']['tabs'] as $k => $tab ) {
						if ( isset( $tab['tab_template'] ) && $tab['tab_template'] ) {
							$title                                          = $this->templates[ $tab['tab_template'] ];
							$template                                       = get_page_by_title( $title, OBJECT, 'elementor_library' );
							$data['settings']['tabs'][ $k ]['tab_template'] = $template->ID;
						}
					}
				}
			}

			$args       = array(
				'post_type'      => 'product',
				'post_status'    => 'publish',
				'posts_per_page' => 1,
				'orderby'        => 'ID',
				'order'          => 'ASC',
			);
			$products   = get_posts( $args );
			$product_id = 0;
			foreach ( $products AS $product ) {
				$product_id = $product->ID;
			}
			if ( $product_id ) {
				if ( isset( $data['settings']['id_product'] ) && $data['settings']['id_product'] ) {
					$data['settings']['id_product'] = $product_id;
				}
				if ( isset( $data['settings']['product_id'] ) && $data['settings']['product_id'] ) {
					$data['settings']['product_id'] = $product_id;
				}
			}

			// Contact Form
			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'opal-contactform7' ) {
				$data['settings']['cf_id'] = $this->contactForm->ID;
			}

			if ( ! empty( $data['widgetType'] ) && $data['widgetType'] === 'image-box' ) {
				$data['settings']['image']['id'] = $this->get_image_id( $data['settings']['image']['url'] );
			}

			if ( ! empty( $data['elements'] ) ) {
				$data['elements'] = $this->update_image_elementor( $data['elements'] );
			}


			$datas[ $key ] = $data;
		}

		return $datas;
	}

	private function get_image_id( $image_url ) {
		global $wpdb;
		$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ) );
		return $attachment[0];
	}
}

return new OSF_Import();
