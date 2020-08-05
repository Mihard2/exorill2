<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OSF_User_Action {
	public function __construct() {
		require_once( ABSPATH . 'wp-includes/pluggable.php' );
		if ( ! is_user_logged_in() ) {
//            add_action( 'wp_footer', array( $this, 'render_login_register_modal' ) );
			// Ajax Login, Register and Forgot Password
			add_action( 'wp_ajax_osf_login', array( $this, 'ajax_login' ) );
			add_action( 'wp_ajax_nopriv_osf_login', array( $this, 'ajax_login' ) );

			add_action( 'wp_ajax_osf_register', array( $this, 'ajax_register' ) );
			add_action( 'wp_ajax_osf_register', array( $this, 'ajax_register' ) );
		}
	}

	public function ajax_login() {
		do_action( 'osf_ajax_verify_captcha' );
		check_ajax_referer( 'ajax-osf-login-nonce', 'security-login' );
		$info = array();

		$info['user_login']    = $_REQUEST['username'];
		$info['user_password'] = $_REQUEST['password'];
		$info['remember']      = $_REQUEST['remember'];

		$user_signon = wp_signon( $info, false );
		if ( is_wp_error( $user_signon ) ) {
			wp_send_json( array(
				'status' => false,
				'msg'    => esc_html__( 'Wrong username or password. Please try again!!!', 'strollik-core' )
			) );
		} else {
			wp_set_current_user( $user_signon->ID );
			wp_send_json( array(
				'status' => true,
				'msg'    => esc_html__( 'Signin successful, redirecting...', 'strollik-core' )
			) );
		}
	}

	public function ajax_register() {
		do_action( 'osf_ajax_verify_captcha' );
		check_ajax_referer( 'ajax-osf-register-nonce', 'security-submit' );
		/**
		 * @var WP_Error $reg_errors
		 */
		global $reg_errors;
		$this->registration_validation(
			$_POST['username'],
			$_POST['email'],
			$_POST['password'],
			$_POST['password2']
		);
		if ( 1 > count( $reg_errors->get_error_messages() ) ) {

			$username = sanitize_user( $_POST['username'] );
			$email    = sanitize_email( $_POST['email'] );
			$password = esc_attr( $_POST['password'] );

			$userdata = array(
				'user_login' => $username,
				'user_email' => $email,
				'user_pass'  => $password,
				'role'       => 'opalrealestate_agent',
			);
			$res      = wp_insert_user( $userdata );

			if ( ! is_wp_error( $res ) ) {
				$jsondata              = array(
					'status' => true,
					'msg'    => esc_html__( 'You have registered, redirecting ...', 'strollik-core' )
				);
				$info['user_login']    = $username;
				$info['user_password'] = $password;
				$info['remember']      = 1;
				wp_signon( $info, false );

			} else {
				$jsondata = array( 'status' => false, 'msg' => esc_html__( 'Register user error!', 'strollik-core' ) );
			}
		} else {
			$jsondata = array( 'status' => false, 'msg' => implode( '<br>', $reg_errors->get_error_messages() ) );
		}
		wp_send_json( $jsondata );
	}

	private function registration_validation( $username, $email, $password, $confirmpassword ) {
		global $reg_errors;
		$reg_errors = new WP_Error;
		if ( empty( $username ) || empty( $password ) || empty( $email ) || empty( $confirmpassword ) ) {
			$reg_errors->add( 'field', esc_html__( 'Required form field is missing', 'strollik-core' ) );
		}

		if ( 4 > strlen( $username ) ) {
			$reg_errors->add( 'username_length', esc_html__( 'Username too short. At least 4 characters is required', 'strollik-core' ) );
		}

		if ( username_exists( $username ) ) {
			$reg_errors->add( 'user_name', esc_html__( 'Sorry, that username already exists!', 'strollik-core' ) );
		}

		if ( ! validate_username( $username ) ) {
			$reg_errors->add( 'username_invalid', esc_html__( 'Sorry, the username you entered is not valid', 'strollik-core' ) );
		}

		if ( 5 > strlen( $password ) ) {
			$reg_errors->add( 'password', esc_html__( 'Password length must be greater than 5', 'strollik-core' ) );
		}

		if ( $password != $confirmpassword ) {
			$reg_errors->add( 'password', esc_html__( 'Password must be equal Confirm Password', 'strollik-core' ) );
		}

		if ( ! is_email( $email ) ) {
			$reg_errors->add( 'email_invalid', esc_html__( 'Email is not valid', 'strollik-core' ) );
		}

		if ( email_exists( $email ) ) {
			$reg_errors->add( 'email', esc_html__( 'Email Already in use', 'strollik-core' ) );
		}
	}
}

new OSF_User_Action();