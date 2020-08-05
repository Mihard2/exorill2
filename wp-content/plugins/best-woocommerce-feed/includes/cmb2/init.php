<?php
/**
 * The initation loader for WPMF_CMB2, and the main plugin file.
 *
 * @category     WordPress_Plugin
 * @package      WPMF_CMB2
 * @author       WPMF_CMB2 team
 * @license      GPL-2.0+
 * @link         https://cmb2.io
 *
 * Plugin Name:  WPMF_CMB2
 * Plugin URI:   https://github.com/WPMF_CMB2/WPMF_CMB2
 * Description:  WPMF_CMB2 will create metaboxes and forms with custom fields that will blow your mind.
 * Author:       WPMF_CMB2 team
 * Author URI:   https://cmb2.io
 * Contributors: Justin Sternberg (@jtsternberg / dsgnwrks.pro)
 *               WebDevStudios (@webdevstudios / webdevstudios.com)
 *               Zao (zao.is)
 *               Human Made (@humanmadeltd / hmn.md)
 *               Jared Atchison (@jaredatch / jaredatchison.com)
 *               Bill Erickson (@billerickson / billerickson.net)
 *               Andrew Norcross (@norcross / andrewnorcross.com)
 *
 * Version:      2.4.2
 *
 * Text Domain:  cmb2
 * Domain Path:  languages
 *
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * https://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * **********************************************************************
 */

/**
 * *********************************************************************
 *               You should not edit the code below
 *               (or any code in the included files)
 *               or things might explode!
 * ***********************************************************************
 */

if ( ! class_exists( 'WPMF_CMB2_Bootstrap_242', false ) ) {

	/**
	 * Handles checking for and loading the newest version of WPMF_CMB2
	 *
	 * @since  2.0.0
	 *
	 * @category  WordPress_Plugin
	 * @package   WPMF_CMB2
	 * @author    WPMF_CMB2 team
	 * @license   GPL-2.0+
	 * @link      https://cmb2.io
	 */
	class WPMF_CMB2_Bootstrap_242 {

		/**
		 * Current version number
		 *
		 * @var   string
		 * @since 1.0.0
		 */
		const VERSION = '2.4.2';

		/**
		 * Current version hook priority.
		 * Will decrement with each release
		 *
		 * @var   int
		 * @since 2.0.0
		 */
		const PRIORITY = 9999;

		/**
		 * Single instance of the WPMF_CMB2_Bootstrap_242 object
		 *
		 * @var WPMF_CMB2_Bootstrap_242
		 */
		public static $single_instance = null;

		/**
		 * Creates/returns the single instance WPMF_CMB2_Bootstrap_242 object
		 *
		 * @since  2.0.0
		 * @return WPMF_CMB2_Bootstrap_242 Single instance object
		 */
		public static function initiate() {
			if ( null === self::$single_instance ) {
				self::$single_instance = new self();
			}
			return self::$single_instance;
		}

		/**
		 * Starts the version checking process.
		 * Creates WPMF_CMB2_LOADED definition for early detection by other scripts
		 *
		 * Hooks WPMF_CMB2 inclusion to the init hook on a high priority which decrements
		 * (increasing the priority) with each version release.
		 *
		 * @since 2.0.0
		 */
		private function __construct() {
			/**
			 * A constant you can use to check if WPMF_CMB2 is loaded
			 * for your plugins/themes with WPMF_CMB2 dependency
			 */
			if ( ! defined( 'WPMF_CMB2_LOADED' ) ) {
				define( 'WPMF_CMB2_LOADED', self::PRIORITY );
			}




			add_action( 'init', array( $this, 'wpfm_include_cmb' ));
		}

		/**
		 * A final check if WPMF_CMB2 exists before kicking off our WPMF_CMB2 loading.
		 * WPMF_CMB2_VERSION and WPFM_WPMF_CMB2_DIR constants are set at this point.
		 *
		 * @since  2.0.0
		 */
		public function wpfm_include_cmb() {


			if ( class_exists( 'WPFM_CMB2', false ) ) {
				return;
			}

			if ( ! defined( 'WPFM_CMB2_VERSION' ) ) {
				define( 'WPFM_CMB2_VERSION', self::VERSION );
			}

			if ( ! defined( 'WPFM_CMB2_DIR' ) ) {
				define( 'WPFM_CMB2_DIR', trailingslashit( dirname( __FILE__ ) ) );
			}

			$this->l10ni18n();

			// Include helper functions.
			require_once WPFM_CMB2_DIR . 'includes/WPFM_CMB2_Base.php';
			require_once WPFM_CMB2_DIR . 'includes/WPFM_CMB2.php';
			require_once WPFM_CMB2_DIR . 'includes/helper-functions.php';

//			// Now kick off the class autoloader.
			spl_autoload_register( 'wpfm_cmb2_autoload_classes' );

			// Kick the whole thing off.
			require_once( wpfm_cmb2_dir( 'bootstrap.php' ) );
			wpfm_cmb2_bootstrap();
		}

		/**
		 * Registers WPMF_CMB2 text domain path
		 *
		 * @since  2.0.0
		 */
		public function l10ni18n() {

			$loaded = load_plugin_textdomain( 'cmb2', false, '/languages/' );

			if ( ! $loaded ) {
				$loaded = load_muplugin_textdomain( 'cmb2', '/languages/' );
			}

			if ( ! $loaded ) {
				$loaded = load_theme_textdomain( 'cmb2', get_stylesheet_directory() . '/languages/' );
			}

			if ( ! $loaded ) {
				$locale = apply_filters( 'plugin_locale', get_locale(), 'cmb2' );
				$mofile = dirname( __FILE__ ) . '/languages/cmb2-' . $locale . '.mo';
				load_textdomain( 'cmb2', $mofile );
			}

		}

	}

	// Make it so...
    WPMF_CMB2_Bootstrap_242::initiate();

}// End if().
