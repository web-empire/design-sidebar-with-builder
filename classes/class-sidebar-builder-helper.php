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
			}
		}

		/**
		 * Callback to template for Elementor template.
		 *
		 * @param array $id attributes for template.
		 */
		public function render_elementor_shortcode_template( $id ) {

			if ( ! defined( 'ELEMENTOR_VERSION' ) && ! is_callable( 'Elementor\Plugin::instance' ) ) {

				return;
			}

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
		 * Callback to template for Beaver Builder template.
		 *
		 * @param array $id attributes for template.
		 */
		public function render_beaver_shortcode_template( $id ) {

			if ( ! class_exists( 'FLBuilder' ) && ! is_callable( 'FLBuilderShortcodes::insert_layout' ) ) {
				return;
			}

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
		 * Callback to template for content template.
		 *
		 * @param int $id attributes for template.
		 */
		public function render_content_shortcode_template( $id ) {

			if ( empty( $id ) ) {
				return '';
			}

			$post_content   = get_post( $id );
			$content        = $post_content->post_content;
			$content_markup = do_shortcode( $content );

			return $content_markup;
		}

		/**
		 * Callback to render template.
		 *
		 * @param array $id attributes for shortcode.
		 */
		public function render_template( $id ) {

			if ( empty( $id ) ) {
				return '';
			}

			$post_meta = array();
			$post_meta = get_post_meta( $id );

			$markup = '';

			if ( is_array( $post_meta ) && array_key_exists( '_elementor_version', $post_meta ) && array_key_exists( '_elementor_edit_mode', $post_meta ) ) {
				$markup = $this->render_elementor_shortcode_template( $id );
			} elseif ( is_array( $post_meta ) && array_key_exists( '_fl_builder_data', $post_meta ) && array_key_exists( '_fl_builder_enabled', $post_meta ) ) {
				$markup = $this->render_beaver_shortcode_template( $id );
			} else {
				$markup = $this->render_content_shortcode_template( $id );
			}

			return $markup;
		}
	}

	$instance = new Sidebar_Builder_Helper();
}
