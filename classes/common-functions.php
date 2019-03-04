<?php
/**
 * WE_Sidebar_Builder setup
 *
 * @since 1.0.0
 * @package WE_Sidebar_Builder
 */

defined( 'ABSPATH' ) || exit;

add_shortcode( 'we-sb-shortcode-1044', 'fetch_template_content' );

if ( ! function_exists( 'fetch_template_content' ) ) {
	function fetch_template_content() {
		fetch_elementor_template_content(1044);
	}
}

if ( ! function_exists( 'fetch_elementor_template_content' ) ) {
	/**
	 * Retrieve builder content for display.
	 *
	 * Used to render and return the post content with all the Elementor elements.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int $post_id The post ID.
	 *
	 * @param bool $with_css Optional. Whether to retrieve the content with CSS
	 *                       or not. Default is false.
	 *
	 * @return string The post content.
	 */
	function fetch_elementor_template_content( $post_id, $with_css = false ) {
		if ( ! get_post( $post_id ) ) {
			return '';
		}

		$with_css = $with_css ? true : $is_edit_mode;

		$content = get_builder_content( $post_id, $with_css );

		return $content;
	}
}

if ( ! function_exists( 'get_builder_content' ) ) {
	/**
	 * Retrieve builder content.
	 *
	 * Used to render and return the post content with all the Elementor elements.
	 *
	 * Note that this method is an internal method, please use `get_builder_content_for_display()`.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param int  $post_id  The post ID.
	 * @param bool $with_css Optional. Whether to retrieve the content with CSS
	 *                       or not. Default is false.
	 *
	 * @return string The post content.
	 */
	function get_builder_content( $post_id, $with_css = false ) {

		ob_start();

		$content = ob_get_clean();

		$content = $this->process_more_tag( $content );

		/**
		 * Frontend content.
		 *
		 * Filters the content in the frontend.
		 *
		 * @since 1.0.0
		 *
		 * @param string $content The content.
		 */
		$content = apply_filters( 'elementor/frontend/the_content', $content );

		if ( ! empty( $content ) ) {
			$this->_has_elementor_in_page = true;
		}

		Plugin::$instance->documents->restore_document();

		return $content;
	}
}