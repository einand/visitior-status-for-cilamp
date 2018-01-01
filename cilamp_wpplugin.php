<?php
/**
 * Created by PhpStorm.
 * User: einandersson
 * Date: 2017-12-25
 * Time: 20:03
 */

class cilamp_wpplugin {

	static function init() {

		$loadAjax = cilamp_wpplugin::pageAllowsCilampAjax();

		if ( $loadAjax ) {
			wp_enqueue_script( 'visitor-cilamp', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery' ), false, true );
			wp_localize_script( 'visitor-cilamp', 'cilamp_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
	}

	static function admin_menu() {
		$main_page_title = 'cilamp';
		$main_menu_title = 'cilamp';
		$main_capability = 'manage_options';
		$main_menu_slug  = 'cilamp_admin';
		$main_function   = [ 'cilamp_wpplugin', 'adminPage' ];
		$main_icon_url   = plugin_dir_url( __FILE__ ) . 'img/menu_icon16.png';
		$main_position   = null;

		add_menu_page( $main_page_title, $main_menu_title, $main_capability, $main_menu_slug, $main_function, $main_icon_url, $main_position );

	}

	static function pageAllowsCilampAjax() {
		$admin = true;

		if ( get_option( 'cilamp_disable_for_admin' ) == 'checked' ) {
			$admin = false;
		}


		if ( current_user_can( 'administrator' ) && ! $admin ) {
			return false;
		}


		return true;
	}


	static function cilamp_ajax_action() {
		$systemID = get_option( 'cilamp_systemid' );
		$lamp     = new \cilamp\cilamp( $systemID );
		echo $lamp->randomColor();
		wp_die();
	}


	static function adminPage() {
		$cilamp_systemid          = get_option( 'cilamp_systemid' );
		$cilamp_trigger_urls      = get_option( 'cilamp_trigger_urls' );
		$cilamp_disable_for_admin = get_option( 'cilamp_disable_for_admin' );
		$nonce = false;


		if ( isset( $_POST['cilamp_systemid'] )  ) {
			$nonce = wp_verify_nonce( $_POST['cilamp_settings_form'], 'cilamp_settings_form' );
		}

		if ( isset( $_POST['cilamp_systemid'] ) && $nonce ) {
			$cilamp_systemid = $_POST['cilamp_systemid'];
			update_option( 'cilamp_systemid', $cilamp_systemid );
		}

		if ( isset( $_POST['cilamp_trigger_urls'] ) && $nonce ) {
			$cilamp_trigger_urls = $_POST['cilamp_trigger_urls'];
			update_option( 'cilamp_trigger_urls', $cilamp_trigger_urls );
		}

		if ( isset( $_POST['cilamp_disable_for_admin'] ) && $nonce ) {
			$cilamp_disable_for_admin = 'checked';
			update_option( 'cilamp_disable_for_admin', $cilamp_disable_for_admin );
		} elseif ( $nonce ) {
			$cilamp_disable_for_admin = '';
			update_option( 'cilamp_disable_for_admin', $cilamp_disable_for_admin );
		}


		ein_admin_gui::page_start( 'Visitor Status CILAMP' );
		if ($nonce) {
			ein_admin_gui::noticeBox('Settings saved.');
		}

		ein_admin_gui::start_form( "cilamp_settings_form" );
		ein_admin_gui::table_start();
		ein_admin_gui::table_textbox( 'Systemid:', 'cilamp_systemid', $cilamp_systemid );
//		ein_admin_gui::table_textbox( 'Path to enable lamp on (/path1, /path2, /path3):', 'cilamp_trigger_urls', $cilamp_trigger_urls );
		ein_admin_gui::table_checktbox( 'Disable for admin:', 'cilamp_disable_for_admin', $cilamp_disable_for_admin );
		ein_admin_gui::table_end();
		ein_admin_gui::form_saveButton();
		ein_admin_gui::end_form();
		ein_admin_gui::page_end();

	}

}