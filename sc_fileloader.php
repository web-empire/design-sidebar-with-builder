<?php

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'SC_Fileloader' ) ) {
	
	class SC_Fileloader {

		public function __construct() {
			$this->sc_load();
		}
		
		public function sc_load() {
			require_once WPSC_PLUGIN_DIR . '/modules/class-sidebar-customize-cpt.php';
		}
	}
	
	$sc = new sc_fileloader();
}
