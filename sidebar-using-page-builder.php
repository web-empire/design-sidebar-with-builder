<?php
/*
 *	Plugin Name: Reusable Blocks - Elementor, BB, WYSIWYG, Gutenberg
	Description: The plugin is useful for reuse the designed templates built using Beaver Builder, Elementor page builders. Also you can reuse the WordPress editor's template along with Gutenberg support. You can easily built your sidebar or pages using <strong> Reusable Template Library </strong> widget.
	Version: 1.1.0
	Author: WebEmpire
	Author URI: https://profiles.wordpress.org/webempire/
	Text Domain: we-sidebar-builder
	License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 *  @package WE_Sidebar_Builder.
*/

if ( ! defined( 'WE_SIDEBAR_PLUGIN' ) ) {
	define( 'WE_SIDEBAR_PLUGIN', __FILE__ );
}

if ( ! defined( 'WE_SIDEBAR_PLUGIN_VERSION' ) ) {
	define( 'WE_SIDEBAR_PLUGIN_VERSION', '1.1.0' );
}

if ( ! defined( 'WE_SIDEBAR_PLUG_NAME' ) ) {
	define( 'WE_SIDEBAR_PLUG_NAME', 'Reusable Templates' );
}

if ( ! defined( 'WE_SIDEBAR_PLUG_SLUG' ) ) {
	define( 'WE_SIDEBAR_PLUG_SLUG', 'we-sidebar-builder' );
}

if ( ! defined( 'WE_SIDEBAR_PLUGIN_DIR' ) ) {
	define( 'WE_SIDEBAR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WE_SIDEBAR_PLUGIN_URL' ) ) {
	define( 'WE_SIDEBAR_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
}

if ( ! defined( 'WE_REUSABLE_BLOCKS_BASE' ) ) {
	define( 'WE_REUSABLE_BLOCKS_BASE', plugin_basename( WE_SIDEBAR_PLUGIN ) );
}

if ( ! defined( 'WE_REUSABLE_BLOCKS_ROOT' ) ) {
	define( 'WE_REUSABLE_BLOCKS_ROOT', dirname( WE_REUSABLE_BLOCKS_BASE ) );
}

require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/we-sb-fileloader.php';
