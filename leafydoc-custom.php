<?php
/**
 * LeafyDOC Custom Plugin
 *
 * @package   LeafyDOC_Custom
 * @link      https://rankfoundry.com
 * @copyright Copyright (C) 2021-2023, Rank Foundry LLC - support@rankfoundry.com
 * @since     1.1.0
 * @license   GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name: LeafyDOC Custom
 * Plugin URI:  https://rankfoundry.com/plugins/leafydoc
 * Description: A plugin of custom features for use by LeafyDOC.
 * Version:     1.1.2
 * Author:      Rank Foundry
 * Author URI:  https://rankfoundry.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: leafydoc-custom
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

// Define plugin version
if (!defined('LEAFYDOC_CUSTOM_VERSION')) {
    define('LEAFYDOC_CUSTOM_VERSION', '1.1.2');
}

// Define plugin directory path
if (!defined('LEAFYDOC_CUSTOM_PLUGIN_DIR')) {
    define('LEAFYDOC_CUSTOM_PLUGIN_DIR', plugin_dir_path(__FILE__));
}

// Define plugin file
if ( ! defined( 'LEAFYDOC_CUSTOM_FILE' ) ) {
    define( 'LEAFYDOC_CUSTOM_FILE', __FILE__ );
}

// Load the Composer autoloader.
require_once LEAFYDOC_CUSTOM_PLUGIN_DIR . 'vendor/autoload.php';

// Include the main class file
require_once LEAFYDOC_CUSTOM_PLUGIN_DIR . 'includes/class-leafydoc-custom.php';

//Hook for activation
register_activation_hook(__FILE__, 'leafydoc_custom_activation');

function leafydoc_custom_activation() {
    require_once LEAFYDOC_CUSTOM_PLUGIN_DIR . 'includes/class-leafydoc-custom-states.php';
    $leafydoc_states = new LeafyDOC_Custom_States();
    $leafydoc_states->register_default_urls();
}

// Hook for deactivation
register_deactivation_hook(__FILE__, 'leafydoc_custom_deactivate');

function leafydoc_custom_deactivate() {
    delete_option('leafydoc_custom_states');
}


// Begin execution of the plugin.
function run_leafydoc_custom() {
    $plugin = new LeafyDOC_Custom();
    $plugin->run();
}

run_leafydoc_custom();
        
