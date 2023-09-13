<?php

class LeafyDOC_Custom_Admin {

    private $plugin_name;
    private $version;

    public function __construct($plugin_name, $version) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    // Register settings page under WP Settings
    public function add_menu() {
        $menu_icon = file_get_contents(LEAFYDOC_CUSTOM_PLUGIN_DIR . 'assets/images/leafydoc-custom-icon.svg');

        add_menu_page(
            'LeafyDOC Custom Settings',    // Page title
            'LeafyDOC',                    // Menu title
            'read',                        // Capability
            $this->plugin_name . '-menu',  // Menu slug (this is a dummy slug for a non-clickable title)
            array($this, 'display_settings_page'), // Default callback function
            'data:image/svg+xml;base64,' . base64_encode( $menu_icon ), // Icon URL 
            100                            // Position (optional)
        );
    
        // Override the default submenu with your settings
        add_submenu_page(
            $this->plugin_name . '-menu',       // parent slug
            'LeafyDOC Settings',               // page title
            'Settings',                        // menu title
            'manage_options',                  // capability
            $this->plugin_name . '-menu',      // menu slug (same as parent to override default submenu)
            array($this, 'display_settings_page')  // callback function
        );
    
        // Adding the states page as a submenu
        add_submenu_page(
            $this->plugin_name . '-menu',       // parent slug
            'State Page Links',                // page title
            'States',                          // menu title
            'manage_options',                  // capability
            $this->plugin_name . '-states',    // menu slug
            array($this, 'display_states_page')  // function
        );
    }

    // Display the settings page
    public function display_settings_page() {
        include_once 'partials/admin-settings.php';
    }

    // Display the states page
    public function display_states_page() {
        $state_manager = new LeafyDOC_Custom_States();
        $state_urls = $state_manager->get_state_urls();
        include_once 'partials/admin-states.php';
    }

    // Register settings
    public function register_settings() {
        register_setting($this->plugin_name, 'leafydoc_custom_states');
    }
}