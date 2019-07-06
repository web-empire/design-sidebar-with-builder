<?php
/**
 * WE_Sidebar_Builder setup
 *
 * @since 1.0.0
 * @package WE_Sidebar_Builder
 */

defined( 'ABSPATH' ) || exit;

/*
 * This class is used for register the custom post type
 */

if ( ! class_exists( 'WE_SB_CustomPostType' ) ) {

	/**
	 * This class initializes WE_SB_CustomPostType
	 *
	 * @class WE_SB_CustomPostType
	 */
	class WE_SB_CustomPostType {

		/**
		 * Calls constructor
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			// Add required action.
			add_action( 'init', array( $this , 'sidebar_builder_register_cpt' ) );

			add_action( 'admin_menu', array( $this, 'register_admin_menu' ), 50 );

			// Add Elementor's support for Sidebar Builder CPT.
			add_action( 'admin_init', array( $this , 'we_sb_elementor_support' ) );

			// Add BB's support for Sidebar Builder CPT.
			add_filter( 'fl_builder_post_types', array( $this , 'we_sb_bb_support' ) );

			// Add custom column to edit CPT page.
			add_filter( 'manage_edit-we-sidebar-builder_columns', array ( $this , 'we_sb_custom_columns' ) );

			// Manage post actions.
			add_filter( 'list_table_primary_column', array ( $this , 'list_table_primary_column' ), 10, 2 );
	    }

	    /**
		 * Create custom post type
		 *
		 * @since 1.0.0
		 * @return $default actions
		 */
		public function sidebar_builder_register_cpt() {
			$labels = array(
				'name'          => esc_html_x( 'Reusable Templates', 'template general name', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'singular_name' => esc_html_x( 'Template', 'template singular name', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'search_items'  => esc_html__( 'Search Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'all_items'     => esc_html__( 'Template Page', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'edit_item'     => esc_html__( 'Edit Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'view_item'     => esc_html__( 'View Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'add_new'       => esc_html__( 'Add New', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'update_item'   => esc_html__( 'Update Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'add_new_item'  => esc_html__( 'Add New Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'new_item_name' => esc_html__( 'New Template', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
			);

			$args = array(
				'labels'              => $labels,
				'show_in_menu'        => false,
				'public'              => true,
				'show_ui'             => true,
				'query_var'           => true,
				'can_export'          => true,
				'show_in_admin_bar'   => true,
				'exclude_from_search' => true,
				'supports'            => array( 'title', 'editor', 'thumbnail', 'elementor' ),
				'menu_position'       => 30,
				'capability_type'     => 'page',
				'map_meta_cap'        => true,
				'hierarchical'        => false,
	            'show_in_nav_menus'   => true,
	            'has_archive'         => true,
	            'publicly_queryable'  => true,	           
			);

			register_post_type( 'we-sidebar-builder', $args );

			// Enqueue required importing styles.
			wp_enqueue_style( 'we-sb-admin-css', WE_SIDEBAR_PLUGIN_URL . 'assets/css/admin.css' );
 		}

 		/**
		 * Register the admin menu for sidebar builder.
		 *
		 * @since  1.0.0
		 * Moved the menu under Appearance -> Sidebar Builder
		 */
		public function register_admin_menu() {
			add_submenu_page(
				'themes.php',
				__( 'Reusable Templates', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				__( 'Reusable Templates', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'edit_pages',
				'edit.php?post_type=we-sidebar-builder'
			);
		}

 		/**
		 * Add Elementor support to custom post type by default
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function we_sb_elementor_support() {

			// if exists, assign to $cpt_support_var.
			$cpt_support = get_option( 'elementor_cpt_support' );

			// check if option doesn't exist in db.
			if ( ! $cpt_support ) {

				// create array of default supported post types.
				$cpt_support = [ 'page', 'post', 'we-sidebar-builder' ];

				// write it to the database.
				update_option( 'elementor_cpt_support', $cpt_support );
			} elseif ( ! in_array( 'we-sidebar-builder', $cpt_support ) ) {

				$cpt_support[] = 'we-sidebar-builder'; // append to array.
				update_option( 'elementor_cpt_support', $cpt_support ); // update database.
			}

			// otherwise do nothing, we-sidebar-builder is already exists in elementor_cpt_support option.
		}

		/**
		 * Add BB support to custom post type by default
		 *
		 * @since 1.0.0
		 * @return void
		 */
		public function we_sb_bb_support( $value ) {

			// create array of default supported post types.
			$value[] = 'we-sidebar-builder';
			return $value;
		}

		/**
		 * Create custom columns to post type
		 *
		 * @since 1.0.0
		 * @return $columns new column
		 */
		public function we_sb_custom_columns() {

			$columns = array(
				'cb'                   => '&lt;input type="checkbox" />',
				'title'                => __( 'Page Title', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'actions'              => __( 'Actions', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
				'date'				   => __( 'Date', 'we-sidebar-builder', 'sidebar-using-page-builder' ),
			);

			return $columns;
		}

		/**
		 * Manage row actions in new custom column
		 *
		 * @param $screen for active screen.
		 * @param $default for string actions.
		 * @since 1.0.0
		 * @return $default actions
		 */
		static public function list_table_primary_column( $default, $screen ) {

			if ( 'edit-we-sidebar-builder' === $screen ) {
				$default = 'actions';
			}

			return $default;
		}
	}

	$instance = new WE_SB_CustomPostType();
}
