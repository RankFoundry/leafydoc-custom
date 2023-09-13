<?php

class LeafyDOC_Custom_Shortcode {
    public static function state_dropdown($atts){
        $leafyDocStates = new LeafyDOC_Custom_States(); // Create an instance of the class
        $states = $leafyDocStates->get_state_urls();  // Fetch the states URLs using the instance method
    
        $content = '<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">';
        $content .= '<option value="">Select Your State</option>';
    
        foreach ($states as $state_name => $state_url) {
            $content .= "<option value=\"{$state_url}\">{$state_name}</option>";
        }
    
        $content .= '</select>';
    
        return $content;
    }
    
}
