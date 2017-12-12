<?php
/**
 * Created by PhpStorm.
 * User: einandersson
 * Date: 2017-12-12
 * Time: 16:35

Plugin Name: Visitor Status for CIlamp
Plugin URI:  http://www.cilamp.se
Description: Change color if anyone visits your site
Version:     0.0.3
Author:      Ein Andersson on demand of Olof Bjarnarson
Author URI:  http://www.cilamp.se
License:     FreeBSD
License URI: https://www.freebsd.org/copyright/freebsd-license.html
Domain Path:
Text Domain: cilamp
*/
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


add_action('init', 'cilamp_init');

function cilamp_init() {
    wp_enqueue_script('visitor-cilamp', plugin_dir_url( __FILE__ ). 'js/script.js', array( 'jquery' ), false, true);
    add_action( 'wp_ajax_cilamp_ajax_action', 'cilamp_ajax_action' );
    wp_localize_script( 'visitor-cilamp', 'cilamp_ajax',
        array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}


function cilamp_ajax_action() {
    $colors = ['FF0000', '00FF00', '0000FF'];
    $systemID = "";
    global $wpdb; // this is how you get access to the database

    $color =  $colors[rand(0,2)];
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,'https://api.cilamp.se/v1/'. $systemID  .'/');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,'color='. $color );
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $server_output = curl_exec ($ch);

    curl_close ($ch);

    echo $color . PHP_EOL;
    if ($server_output != "OK") {
        echo $server_output . PHP_EOL;
    } else {
        echo 'error' . PHP_EOL;
    }


    wp_die(); // this is required to terminate immediately and return a proper response
}