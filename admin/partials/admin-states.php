<?php
// First, handle the POST submission
if (isset($_POST['reset_urls'])) {
    $state_manager = new LeafyDOC_Custom_States();
    delete_option('leafydoc_custom_states');
    $state_manager->register_default_urls();
    // Optionally, add a message to inform the user that URLs have been reset
    echo '<div class="notice notice-success is-dismissible"><p>URLs have been reset to default values.</p></div>';
}

// Now, fetch the state URLs
$state_manager = new LeafyDOC_Custom_States();
$state_urls = $state_manager->get_state_urls();


echo '<div class="wrap">';
echo '<h1>' . esc_html(get_admin_page_title()) . '</h1>';

// Add your explanatory paragraph here
echo '<p>';
echo 'Use this section to update the location for each state in the dropdown. To use this dropdown in your content, simply add the shortcode: <code>[leafydoc-state-dropdown]</code>.';
echo '</p>';


echo '<form action="options.php" method="post">';
settings_fields($this->plugin_name);
do_settings_sections($this->plugin_name);

foreach ($state_urls as $state => $url) {
    echo '<div class="state-input-group">';
    echo '<label for="' . esc_attr($state) . '">' . esc_html($state) . '</label>';
    echo '<input type="text" name="leafydoc_custom_states[' . esc_attr($state) . ']" value="' . esc_attr($url) . '">';
    echo '</div>';
}

submit_button('Save URLs');

echo '</form>';

echo '<form action="" method="post">';
echo '<input type="submit" name="reset_urls" value="Reset URLs to Default" class="button button-secondary" onclick="return confirm(\'Are you sure you want to reset URLs to default?\');">';
echo '</form>';

echo '</div>';

// Inline CSS
echo <<<CSS
<style>
    .state-input-group {
        margin-bottom: 15px;
    }

    .state-input-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    .state-input-group input[type="text"] {
        width: 100%;
        max-width: 600px;
        padding: 8px;
    }
</style>
CSS;
?>
