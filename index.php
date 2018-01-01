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
 * Version:     0.3.2
 * Author:      Ein Andersson  with Olof Bjarnarson
 * Author URI:  http://www.cilamp.se
 * License:     FreeBSD
 * License URI: https://www.freebsd.org/copyright/freebsd-license.html
 * Domain Path:
 * Text Domain: cilamp
 */

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
include_once "ein_wordpress_admin_gui.php";
include_once "cilamp.php";
include_once "cilamp_wpplugin.php";



add_action( 'init', ['cilamp_wpplugin', 'init'] );
add_action( 'admin_menu', ['cilamp_wpplugin', 'admin_menu'] );
add_action( 'wp_ajax_nopriv_cilamp_ajax_action', ['cilamp_wpplugin', 'cilamp_ajax_action'] );
add_action( 'wp_ajax_cilamp_ajax_action', ['cilamp_wpplugin', 'cilamp_ajax_action'] );