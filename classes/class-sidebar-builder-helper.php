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

				add_shortcode( 'sidebar_builder_elementor_design', array( $this, 'render_elementor_shortcode_template' ) );
			}

			if ( class_exists( 'FLBuilder' ) && is_callable( 'FLBuilderShortcodes::insert_layout' ) ) {

				add_shortcode( 'sidebar_builder_beaver_design', array( $this, 'render_beaver_shortcode_template' ) );
			}

			add_shortcode( 'sidebar_builder_content_design', array( $this, 'render_content_shortcode_template' ) );
		}

		/**
		 * Callback to shortcode for Elementor template.
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

		/**
		 * Callback to shortcode for Beaver Builder template.
		 *
		 * @param array $atts attributes for shortcode.
		 */
		public function render_beaver_shortcode_template( $atts ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts,
				'sidebar_builder_beaver_design'
			);

			$id = ! empty( $atts['id'] ) ? intval( $atts['id'] ) : '';

			if ( empty( $id ) ) {
				return '';
			}

			return FLBuilderShortcodes::insert_layout(
				array(
					'id' => $id,
				)
			);
		}

		/**
		 * Callback to shortcode for content template.
		 *
		 * @param array $atts attributes for shortcode.
		 */
		public function render_content_shortcode_template( $atts ) {

			$atts = shortcode_atts(
				array(
					'id' => '',
				),
				$atts,
				'sidebar_builder_content_design'
			);

			$id = ! empty( $atts['id'] ) ? intval( $atts['id'] ) : '';

			if ( empty( $id ) ) {
				return '';
			}

			$post_content = get_post( $id );
			$content = $post_content->post_content;
			$content_markup = do_shortcode( $content );

			return $content_markup;
		}
	}

	$instance = new Sidebar_Builder_Helper();
}