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

			// Add Elementor's support for Sidebar Builder CPT.
			add_action( 'admin_init', array( $this , 'we_sb_elementor_support' ) );

			// Add BB's support for Sidebar Builder CPT.
			add_filter( 'fl_builder_post_types', array( $this , 'we_sb_bb_support' ) );

			// Add custom column to edit CPT page.
			add_filter( 'manage_edit-we-sidebar-builder_columns', array ( $this , 'we_sb_custom_columns' ) );

			// Manage columns from edit CPT page.
			add_action( 'manage_we-sidebar-builder_posts_custom_column', array ( $this , 'we_sb_manage_columns_data' ), 10, 2 );

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
				'name'          => esc_html_x( 'Sidebar Builder', 'flow general name', 'we-sidebar-builder' ),
				'singular_name' => esc_html_x( 'Sidebar', 'flow singular name', 'we-sidebar-builder' ),
				'search_items'  => esc_html__( 'Search Sidebar', 'we-sidebar-builder' ),
				'all_items'     => esc_html__( 'Sidebar Page', 'we-sidebar-builder' ),
				'edit_item'     => esc_html__( 'Edit Sidebar', 'we-sidebar-builder' ),
				'view_item'     => esc_html__( 'View Sidebar', 'we-sidebar-builder' ),
				'add_new'       => esc_html__( 'Add New', 'we-sidebar-builder' ),
				'update_item'   => esc_html__( 'Update Sidebar', 'we-sidebar-builder' ),
				'add_new_item'  => esc_html__( 'Add New Sidebar', 'we-sidebar-builder' ),
				'new_item_name' => esc_html__( 'New Sidebar', 'we-sidebar-builder' ),
			);

			$args = array(
				'labels'              => $labels,
				'show_in_menu'        => true,
				'public'              => true,
				'show_ui'             => true,
				'query_var'           => true,
				'can_export'          => true,
				'show_in_admin_bar'   => true,
				'exclude_from_search' => true,
				'supports'            => array( 'title', 'editor' ),
				'menu_position'       => 30,
            	'menu_icon'			  => 'dashicons-welcome-widgets-menus',
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
		 * Manage custom column's data to post type page
		 *
		 * @param $column for new column.
		 * @param $post_id for each post.
		 * @since 1.0.0
		 * @return void
		 */
		public function we_sb_manage_columns_data( $column, $post_id ) {

			global $post;

			switch ( $column ) {
				case 'we_sb_meta_shortcode':

					// Prepare unique shortcode for each sidebar post.
						echo __( '<input class="we-sb-shortcode-text" type="text" value="[we-sb-shortcode-'. $post->ID .']" readonly onfocus="this.select()" />', 'we-sidebar-builder' );
					break;

				default:
					break;
			}
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
				'title'                => __( 'Page Title', 'we-sidebar-builder' ),
				'we_sb_meta_shortcode' => __( 'Shortcode', 'we-sidebar-builder' ),
				'actions'              => __( 'Actions', 'we-sidebar-builder' ),
				'date'				   => __( 'Date', 'we-sidebar-builder' ),
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
