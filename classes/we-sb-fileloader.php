<?php
/**
 * WE_Sidebar_Builder setup
 *
 * @since 1.0.0
 * @package WE_Sidebar_Builder
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WE_SB_Fileloader' ) ) {

	/**
	 * This class initializes WE_SB_Fileloader
	 *
	 * @class WE_SB_Fileloader
	 */	
	class WE_SB_Fileloader {

		/**
		 * Calls constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			$this->load_textdomain();
			$this->we_sb_run_loader();
		}

		/**
		 * Loads textdomain for the plugin.
		 *
		 * @since 1.0.0
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'we-sidebar-builder' );
		}

		/**
		 * Run file loader
		 *
		 * @since 1.0.0
		 */
		public function we_sb_run_loader() {
			require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/class-sidebar-builder-cpt.php';
			require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/class-sidebar-builder-helper.php';
		}
	}
	
	$instance = new WE_SB_Fileloader();
}
