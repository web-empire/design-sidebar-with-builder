<?php

defined( 'ABSPATH' ) || exit;

/**This class is used for register the custom post type*/
if ( ! class_exists( 'SC_Sidebar_CPT' ) ) {
	class SC_Sidebar_CPT {

		public function __construct() {
	
		add_action( 'init', array( $this , 'sidebar_custom' ) ); 
		add_filter( 'the_title', array( $this ,'sc_add_cpt_prefix' ) );
	    }

		function sidebar_custom() {	
			$post_type = get_option('post_type',true);
			// Set UI labels for Custom Post Type
			    $labels = array(
			        'name'                => _x( 'SideBar', 'Post Type General Name', '' ),
			        'singular_name'       => _x( 'SideBar', 'Post Type Singular Name', '' ),
			        'menu_name'           => __( 'SideBar', '' ),
			        'parent_item_colon'   => __( 'Parent Sidebar', '' ),
			        'all_items'           => __( 'All SideBar', '' ),
			        'view_item'           => __( 'View Sidebar', '' ),
			        'add_new_item'        => __( 'Add New Sidebar', '' ),
			        'add_new'             => __( 'Add New', '' ),
			        'edit_item'           => __( 'Edit Sidebar', '' ),
			        'update_item'         => __( 'Update Sidebar', '' ),
			        'search_items'        => __( 'Search Sidebar', '' ),
			        'not_found'           => __( 'Not Found', '' ),
			        'not_found_in_trash'  => __( 'Not found in Trash', '' ),
			    );
			     
			// Set other options for Custom Post Type
			     
			    $args = array(
			        'label'               => __( 'Sidebar', '' ),
			        'description'         => __( 'Sidebar news and reviews', '' ),
			        'labels'              => $labels,
			        // Features this CPT supports in Post Editor
			        'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			        // You can associate this CPT with a taxonomy or custom taxonomy. 
			        'taxonomies'          => array( 'genres' ),
			        /* A hierarchical CPT is like Pages and can have
			        * Parent and child items. A non-hierarchical CPT
			        * is like Posts.
			        */ 
			        'hierarchical'        => false,
			        'public'              => true,
			        'show_ui'             => true,
			        'show_in_menu'        => true,
			        'show_in_nav_menus'   => true,
			        'show_in_admin_bar'   => true,
			        'menu_position'       => 5,
			        'can_export'          => true,
			        'has_archive'         => true,
			        'exclude_from_search' => false,
			        'publicly_queryable'  => true,
			        'capability_type'     => 'page',
			    );
			     
			    // Registering your Custom Post Type
			    register_post_type( 'Sidebar', $args );
 		}

		function sc_add_cpt_prefix( $title ) {
		    global $id, $post;
		    if ( $id && $post && $post->post_type == 'Sidebar' ) {
		        $title = '<span>Sidebar:</span> ' . $title;
		        print_r($title);
		        die();
		    }
		    return $title;
		}
	}
	$sc_cpt = new SC_Sidebar_CPT();
}
