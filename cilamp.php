<?php
/**
 * Created by PhpStorm.
 * User: einandersson
 * Date: 2017-12-25
 * Time: 19:17
 */

namespace cilamp;


class cilamp {

	private $systemID = null;

	public function __construct($_systemID) {
		$this->systemID = $_systemID;
	}

	public function setColor($_color, $_period = 0) {
		return $this->sendColor($_color);
	}

	private function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}


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