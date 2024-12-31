<?php
/**
 * Plugin Name: Simple Text Block VC Addon
 * Plugin URI: https://example.com
 * Description: A custom Visual Composer element to display a styled text block.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL2
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (function_exists('vc_map')) {
    function simple_text_block_vc_element() {
        vc_map(array(
            "name" => __("Simple Text Block", "text-domain"),
            "base" => "simple_text_block",
            "category" => __("Custom Elements", "text-domain"),
            "icon" => "icon-wpb-plain-text",
            "params" => array(
                array(
                    'type' => 'textarea_html',
                    'holder' => 'div',
                    'class' => 'wpc-text-class',
                    'heading' => __( 'Description', 'text-domain' ),
                    'param_name' => 'content',
                    'value' => __( '', 'text-domain' ),
                    'description' => __( 'To add link highlight text or url and click the chain to apply hyperlink', 'text-domain' ),
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Extra CSS Class", "text-domain"),
                    "param_name" => "el_class",
                    "value" => "",
                    "description" => __("Add a custom CSS class for additional styling.", "text-domain"),
                ),
                // Include the Design Options tab
                array(
                    "type" => "css_editor",
                    "heading" => __("Design Options", "text-domain"),
                    "param_name" => "css",
                    "group" => __("Design Options", "text-domain"),
                ),
            ),
            "js_view" => "VcCustomTextBlockView",
        ));
    }
    add_action('vc_before_init', 'simple_text_block_vc_element');
}

function simple_text_block_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'css' => '',
        'el_class' => '',
    ), $atts);

    // Generate CSS class for Design Options
    $css_classes = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'simple-text-block ' . $atts['el_class'], 'simple_text_block', $atts);

    // Generate inline styles
    $inline_styles = vc_shortcode_custom_css_class($atts['css'], ' ');

    $style = "";

//     $style = sprintf(
//         'color: %s; font-size: %s; text-align: %s;',
// esc_attr($atts['text_color']),
// esc_attr($atts['font_size']),
//         esc_attr($atts['text_align'])
//     );

    return '<div class="' . esc_attr($css_classes . $inline_styles) . '" style="' . $style . '">' .
        wp_kses_post($content) .
        '</div>';
}
add_shortcode('simple_text_block', 'simple_text_block_shortcode');

