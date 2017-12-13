<?php
/**
 * Created by PhpStorm.
 * User: einandersson
 * Date: 2017-12-12
 * Time: 16:35
 *
 * Plugin Name: Visitor Status for CIlamp
 * Plugin URI:  http://www.cilamp.se
 * Description: Change color if anyone visits your site
 * Version:     0.0.3
 * Author:      Ein Andersson on demand of Olof Bjarnarson
 * Author URI:  http://www.cilamp.se
 * License:     FreeBSD
 * License URI: https://www.freebsd.org/copyright/freebsd-license.html
 * Domain Path:
 * Text Domain: cilamp
 */
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action( 'init', 'cilamp_init' );

function cilamp_init() {
	wp_enqueue_script( 'visitor-cilamp', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery' ), false, true );
	wp_localize_script( 'visitor-cilamp', 'cilamp_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}

add_action('admin_menu', 'my_menu');
function my_menu() {
	$main_page_title = 'cilamp';
	$main_menu_title = 'cilamp';
	$main_capability = 'manage_options';
	$main_menu_slug = 'cilamp_admin';
	$main_function = 'cilamp_helloWorld';
	$main_icon_url = plugin_dir_url( __FILE__ ) . 'img/menu_icon16.png';
	$main_position = null;

	add_menu_page( $main_page_title, $main_menu_title, $main_capability, $main_menu_slug, $main_function, $main_icon_url, $main_position );
}

function cilamp_helloWorld() {
	echo 'hello';
}


add_action( 'wp_ajax_nopriv_cilamp_ajax_action', 'cilamp_ajax_action' );

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

function cilamp_ajax_action() {
	$systemID = "XXXX"; // TODO: use db value
	global $wpdb; // this is how you get access to the database

	$color = random_color();
	$ch    = curl_init();

	curl_setopt( $ch, CURLOPT_URL, 'https://api.cilamp.se/v1/' . $systemID . '/' );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, 'color=' . $color );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	$server_output = curl_exec( $ch );

	curl_close( $ch );

	echo $color . PHP_EOL;
	if ( $server_output != "OK" ) {
		echo $server_output . PHP_EOL;
	} else {
		echo 'error' . PHP_EOL;
	}


	wp_die(); // this is required to terminate immediately and return a proper response
}
