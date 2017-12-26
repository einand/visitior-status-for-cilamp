<?php
/**
 * Created by PhpStorm.
 * User: einandersson
 * Date: 2017-12-26
 * Time: 02:17
 */

class ein_admin_gui {

	static function page_start( $_topic ) {
		echo '<div class="wrap">';
		echo '<h1>' . $_topic . '</h1>';


	}

	static function page_end() {
		echo '</div>';
	}

	static function start_form( $_formName ) {
		echo '<form name="' . $_formName . '" method="post" action="">';
		wp_nonce_field( $_formName, $_formName );
	}

	static function end_form() {
		echo '</form>';
	}

	static function table_start() {
		echo '<table class="form-table">';
		echo '<tbody>';
	}

	static function table_end() {
		echo '</tbody>';
		echo '</table>';
	}

	static function table_textbox( $_label, $_name, $_value ) {

		echo '<tr>';
		echo '<th class="row"> <label for="' . $_name . '">' . $_label . '</label> </th>';
		echo '<td>';
		echo '<input type="text" name="' . $_name . '" value="' . $_value . '">';
		echo '</td>';
		echo '</tr>';
	}

	static function form_saveButton() {
		echo '<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
	}

}