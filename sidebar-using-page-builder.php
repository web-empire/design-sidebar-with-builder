<?php
/* 
 *	Plugin Name: Design Sidebar Using Page Builder
	Plugin URI: #
	Description: The plugin is useful to edit and design the sidebar of your site without sacrificing your favorite page builder.
	Version: 1.0.0
	Author: WebEmpire
	Author URI: #
	Text Domain: we-sidebar-builder
	License: GPL version 2 or later - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 *
 *  @package WE_Sidebar_Builder.
*/

if ( ! defined( 'WE_SIDEBAR_PLUGIN' ) ) {
	define( 'WE_SIDEBAR_PLUGIN', __FILE__ );
}

if ( ! defined( 'WE_SIDEBAR_PLUGIN_VERSION' ) ) {
	define( 'WE_SIDEBAR_PLUGIN_VERSION', '1.0.0' );
}

if ( ! defined( 'WE_SIDEBAR_PLUG_NAME' ) ) {
	define( 'WE_SIDEBAR_PLUG_NAME', 'Sidebar Builder' );
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

require_once WE_SIDEBAR_PLUGIN_DIR . '/classes/we-sb-fileloader.php';
