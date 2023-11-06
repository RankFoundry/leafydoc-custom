<?php

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

/**
 * LeafyDOC Custom Main Class
 */

 if (!defined('WPINC')) {
    die;
}

class LeafyDOC_Custom {
    /**
     * The unique identifier of this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     */
    protected $version;

    public $admin;
    public $states;

    /**
     * Define the core functionality of the plugin.
     */
    public function __construct() {
        if (defined('LEAFYDOC_CUSTOM_VERSION')) {
            $this->version = LEAFYDOC_CUSTOM_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->plugin_name = 'leafydoc-custom';

        $this->load_dependencies();
        $this->set_locale();
        $this->initialize_update_checker();
        $this->define_public_hooks();

        if (is_admin()) {
            $this->define_admin_hooks();
        }
    }

    /**
     * Load the required dependencies for this plugin.
     */
    private function load_dependencies() {
        require_once LEAFYDOC_CUSTOM_PLUGIN_DIR . 'includes/class-leafydoc-custom-states.php';
        require_once LEAFYDOC_CUSTOM_PLUGIN_DIR . 'public/class-leafydoc-custom-shortcode.php';
    }

    /**
     * Define the locale for this plugin for internationalization.
     */
    private function set_locale() {
        // This is where you'd set up any translation/internationalization functionality.
    }

    /**
     * Load the update checker
     */
    private function initialize_update_checker() {
        $myUpdateChecker = PucFactory::buildUpdateChecker(
            'https://github.com/rankfoundry/leafydoc-custom/',
            LEAFYDOC_CUSTOM_FILE,
            'leafydoc-custom',
            48
        );

        //Set the branch that contains the stable release.
        $myUpdateChecker->setBranch('master');

        //Optional: If you're using a private repository, specify the access token like this:
        //$myUpdateChecker->setAuthentication('your-token-here');
    }

    /**
     * Register all of the hooks related to the admin area functionality.
     */
    private function define_admin_hooks() {

        require_once LEAFYDOC_CUSTOM_PLUGIN_DIR . 'admin/class-leafydoc-custom-admin.php';
        $this->admin = new LeafyDOC_Custom_Admin($this->plugin_name, $this->version);

        add_action('admin_menu', array($this->admin, 'add_menu'));
        add_action('admin_init', array($this->admin, 'register_settings'));

        $this->states = new LeafyDOC_Custom_States();
        register_setting($this->plugin_name, 'leafydoc_custom_states', array($this, 'sanitize_urls'));
    }

    /**
     * Register all of the hooks related to the public-facing functionality.
     */
    private function define_public_hooks() {
        // This will involve enqueueing scripts/styles for the frontend, and other related functions.
        add_shortcode('leafydoc-state-dropdown', array('LeafyDOC_Custom_Shortcode', 'state_dropdown'));
    }

    /**
     * Run the plugin.
     */
    public function run() {
        // Any code that needs to execute upon plugin initialization would go here.

    }

}
