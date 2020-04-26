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

			require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/class-sidebar-builder-cpt.php';
			require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/class-sidebar-builder-helper.php';
			require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/class-template-library-widget.php';
			add_action( 'widgets_init', array( $this, 'register_template_library_widget' ) );
		}

		/**
		 * Loads textdomain for the plugin.
		 *
		 * @since 1.0.0
		 */
		public function load_textdomain() {
			/**
			 * Filters the languages directory path to use for Social Elementor.
			 *
			 * @param string $lang_dir The languages directory path.
			 */
			$lang_dir = apply_filters( 'reusable_blocks_textdomain', WE_REUSABLE_BLOCKS_ROOT . '/languages/' );
			load_plugin_textdomain( 'sidebar-using-page-builder', false, $lang_dir );
		}

		/**
		 * Regiter Template Library widget
		 *
		 * @return void
		 */
		function register_template_library_widget() {
			register_widget( 'Sidebar_Template_Library' );
		}
	}

	$instance = new WE_SB_Fileloader();
}
