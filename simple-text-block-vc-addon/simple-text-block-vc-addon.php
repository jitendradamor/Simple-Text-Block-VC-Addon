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
                    "type" => "textarea",
                    "heading" => __("Text Content", "text-domain"),
                    "param_name" => "text_content",
                    "value" => __("Default text here.", "text-domain"),
                    "description" => __("Enter the content to display.", "text-domain"),
                ),
                array(
                    "type" => "colorpicker",
                    "heading" => __("Text Color", "text-domain"),
                    "param_name" => "text_color",
                    "value" => "#000000",
                    "description" => __("Choose a text color.", "text-domain"),
                ),
                array(
                    "type" => "textfield",
                    "heading" => __("Font Size", "text-domain"),
                    "param_name" => "font_size",
                    "value" => "16px",
                    "description" => __("Set the font size (e.g., 16px, 1em).", "text-domain"),
                ),
                array(
                    "type" => "dropdown",
                    "heading" => __("Text Alignment", "text-domain"),
                    "param_name" => "text_align",
                    "value" => array(
                        __("Left", "text-domain") => "left",
                        __("Center", "text-domain") => "center",
                        __("Right", "text-domain") => "right",
                    ),
                    "description" => __("Choose text alignment.", "text-domain"),
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
        'text_content' => 'Default text here.',
        'text_color' => '#000000',
        'font_size' => '16px',
        'text_align' => 'left',
        'css' => '',
        'el_class' => '',
    ), $atts);

    // Generate CSS class for Design Options
    $css_classes = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'simple-text-block ' . $atts['el_class'], 'simple_text_block', $atts);

    // Generate inline styles
    $inline_styles = vc_shortcode_custom_css_class($atts['css'], ' ');

    $style = sprintf(
        'color: %s; font-size: %s; text-align: %s;',
esc_attr($atts['text_color']),
esc_attr($atts['font_size']),
        esc_attr($atts['text_align'])
    );

    return '<div class="' . esc_attr($css_classes . $inline_styles) . '" style="' . $style . '">' .
        wp_kses_post($atts['text_content']) .
        '</div>';
}
add_shortcode('simple_text_block', 'simple_text_block_shortcode');

