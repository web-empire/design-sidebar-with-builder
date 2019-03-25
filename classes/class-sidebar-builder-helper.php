<?php
/**
 * Entry point for the plugin. Checks if Elementor is installed and activated and loads it's own files and actions.
 *
 * @package  sidebar-builder
 */

defined( 'ABSPATH' ) || exit;

/*
 * This class is used for sidebar builder helper functionalities
 */

if ( ! class_exists( 'Sidebar_Builder_Helper' ) ) {

	/**
	 * Class Sidebar_Builder_Helper
	 */
	class Sidebar_Builder_Helper {

		/**
		 * Instance of Elemenntor Frontend class.
		 *
		 * @var \Elementor\Frontend()
		 */
		private static $elementor_instance;

		/**
		 * Constructor
		 */
		function __construct() {

			if ( defined( 'ELEMENTOR_VERSION' ) && is_callable( 'Elementor\Plugin::instance' ) ) {

				self::$elementor_instance = Elementor\Plugin::instance();

				// Scripts and styles.
				add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

				// Scripts and styles.
				add_shortcode( 'sidebar_builder_elementor_design', array( $this, 'render_elementor_shortcode_template' ) );

			} else {

				add_action( 'admin_notices', array( $this, 'elementor_not_available' ) );
				add_action( 'network_admin_notices', array( $this, 'elementor_not_available' ) );
			}
		}

		/**
		 * Enqueue styles and scripts.
		 */
		public function enqueue_scripts() {

			if ( class_exists( '\Elementor\Plugin' ) ) {
				$elementor = \Elementor\Plugin::instance();
				$elementor->frontend->enqueue_styles();
			}

			if ( class_exists( '\ElementorPro\Plugin' ) ) {
				$elementor_pro = \ElementorPro\Plugin::instance();
				$elementor_pro->enqueue_styles();
			}
		}

		/**
		 * Callback to shortcode.
		 *
		 * @param array $atts attributes for shortcode.
		 */
		public function render_elementor_shortcode_template( $atts ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts,
				'sidebar_builder_elementor_design'
			);

			$id = ! empty( $atts['id'] ) ? intval( $atts['id'] ) : '';

			if ( empty( $id ) ) {
				return '';
			}

			if ( class_exists( '\Elementor\Core\Files\CSS\Post' ) ) {

				// Load elementor styles.
				$css_file = new \Elementor\Core\Files\CSS\Post( $id );
				$css_file->enqueue();
			}

			return self::$elementor_instance->frontend->get_builder_content_for_display( $id );
		}
	}

	$instance = new Sidebar_Builder_Helper();
}