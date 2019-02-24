<?php
/* 
* Plugin Name: Sidebar Customizer
* Description: The plugin is useful to edit and design the sidebar of your site without sacrificing your favorite page builder.
* Author: Web Empire
* Author URI: #
* Version: 0.0.1
*/

define( 'WPSC_PLUGIN', __FILE__ );

define( 'WPSC_PLUGIN_BASENAME', plugin_basename( WPSC_PLUGIN ) );

define( 'WPSC_PLUGIN_DIR', untrailingslashit( dirname( WPSC_PLUGIN ) ) );

define( 'WPSC_PLUGIN_URL', untrailingslashit( plugins_url( '', WPSC_PLUGIN ) ) );

require_once WPSC_PLUGIN_DIR . '/sc_fileloader.php';