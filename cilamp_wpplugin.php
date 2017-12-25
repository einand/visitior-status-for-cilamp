<?php
/**
 * Created by PhpStorm.
 * User: einandersson
 * Date: 2017-12-25
 * Time: 20:03
 */

class cilamp_wpplugin {

	static function init() {
		wp_enqueue_script( 'visitor-cilamp', plugin_dir_url( __FILE__ ) . 'js/script.js', array( 'jquery' ), false, true );
		wp_localize_script( 'visitor-cilamp', 'cilamp_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	}

	static function admin_menu() {
		$main_page_title = 'cilamp';
		$main_menu_title = 'cilamp';
		$main_capability = 'manage_options';
		$main_menu_slug  = 'cilamp_admin';
		$main_function   = ['cilamp_wpplugin', 'adminPage'];
		$main_icon_url   = plugin_dir_url( __FILE__ ) . 'img/menu_icon16.png';
		$main_position   = null;

		add_menu_page( $main_page_title, $main_menu_title, $main_capability, $main_menu_slug, $main_function, $main_icon_url, $main_position );

	}

	static function cilamp_ajax_action() {
		$systemID = get_option( 'cilamp_systemid' );
		$lamp     = new \cilamp\cilamp( $systemID );
		echo $lamp->randomColor();
		wp_die();
	}


	static function adminPage() {
		$cilamp_systemid = get_option( 'cilamp_systemid' );

		if( isset($_POST[ 'cilamp_systemid' ])  ) {
			$cilamp_systemid = $_POST['cilamp_systemid'];
			update_option( 'cilamp_systemid', $cilamp_systemid );
		}

		echo '<div class="wrap">';

		echo '

<h1>Visitor Status CILAMP</h1>
<form name="cilamp_settingss_form" method="post" action="">
<table class="form-table">
<tbody>
<tr>
<th class="row"> <label for="systemid">Systemid:</label> </th>
<td>
   <input type="text" name="cilamp_systemid" value="'. $cilamp_systemid .'">
</td>
</tr>

</tbody>
</table>

<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>';

		echo '</div>';


	}

}