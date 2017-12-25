<?php
/**
 * API for CILamp how to easy set color with php
 *
 * First include the file
 * include_once "cilamp.php";
 *
 * just call the class
 * $lamp = new \cilamp\cilamp("systemID");
 *
 * and set a color
 * $lamp->setColor("#00FF00");
 */

namespace cilamp;

/**
 * cilamp class for api v1
 */
class cilamp {

	private $systemID = null;

	/**
	 * @param string $_systemID set the system id of the lamp
	 *
	 * @return object of cilamp
	 */
	public function __construct($_systemID) {
		$this->systemID = $_systemID;
	}

	/**
	 * Changes the color of the lamp
	 * @param string $_color hexadecimal RGB value of the color of the lamp including #
	 *
	 * @return answer from the server
	 */
	public function setColor($_color) {
		return $this->sendColor($_color);
	}

	private function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	/**
	 * Sets a random color of the lamp
	 *
	 * @return answer from the server
	 */
	public function randomColor() {
		$color =  $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
		return $this->setColor($color);
	}

	private function sendColor($_color) {
		$systemID = $this->systemID;
		$color = $_color;

		$ch    = curl_init();
		curl_setopt( $ch, CURLOPT_URL, 'https://api.cilamp.se/v1/' . $systemID . '/' );
		curl_setopt( $ch, CURLOPT_POST, 1 );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, 'color=' . $color );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		$server_output = curl_exec( $ch );
		curl_close( $ch );

		return $server_output;

	}

}