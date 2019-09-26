<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class OpalEtFieldCreator_Font_Awesome {

	private $prefix;

	private $data = [];

	public function __construct( $path, $fa_css_prefix = 'fa' ) {
		$this->prefix = $fa_css_prefix;

		$css = file_get_contents( $path );

		$pattern = '/\.(' . $fa_css_prefix . '-(?:\w+(?:-)?)+):before\s+{\s*content:\s*"(.+)";\s+}/';

		preg_match_all( $pattern, $css, $matches, PREG_SET_ORDER );

		foreach ( $matches as $match ) {

			// Set Basic Data
			$item            = [];
			$item['class']   = $match[1];
			$item['unicode'] = $match[2];
			$this->data[]    = $item;
		}

	}

	public function getIcons() {
		return $this->data;
	}

	public function getPrefix() {
		return (string) $this->prefix;
	}
}
