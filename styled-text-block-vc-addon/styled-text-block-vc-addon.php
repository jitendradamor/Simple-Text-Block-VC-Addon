<?php
/**
 * Plugin Name: Styled Text Block VC Addon
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
    function styled_text_block_VC_addon() {
        vc_map(array(
            "name" => __("Styled Text Block", "text-domain"),
            "base" => "styled_text_block",
            "category" => __("Custom Elements", "text-domain"),
            "icon" => "icon-wpb-plain-text",
            "params" => array(
                // Title field
                array(
                    "type" => "textfield",
                    "heading" => __("Title", "text-domain"),
                    "param_name" => "title_text",
                    "value" => __("Default title here.", "text-domain"),
                    "description" => __("Enter the title to display.", "text-domain"),
                ),
                // Title element tag field
                array(
                    "type" => "dropdown",
                    "heading" => __("Title Element Tag", "text-domain"),
                    "param_name" => "title_tag",
                    "value" => array(
                        __("h1", "text-domain") => "h1",
                        __("h2", "text-domain") => "h2",
                        __("h3", "text-domain") => "h3",
                        __("h4", "text-domain") => "h4",
                        __("h5", "text-domain") => "h5",
                        __("h6", "text-domain") => "h6",
                        __("p", "text-domain") => "p",
                        __("div", "text-domain") => "div",
                    ),
                    "description" => __("Choose title element tag.", "text-domain"),
                ),
                // Title alignment field
                array(
                    "type" => "dropdown",
                    "heading" => __("Title Alignment", "text-domain"),
                    "param_name" => "title_alignment",
                    "value" => array(
                        __("Left", "text-domain") => "left",
                        __("Center", "text-domain") => "center",
                        __("Right", "text-domain") => "right",
                    ),
                    "description" => __("Choose text alignment.", "text-domain"),
                ),
                // Title color
                array(
                    "type" => "colorpicker",
                    "heading" => __("Title Color", "text-domain"),
                    "param_name" => "title_color",
                    "value" => "#000000",
                    "description" => __("Choose a text color.", "text-domain"),
                ),
                // Description editor field
                array(
                'type' => 'textarea_html',
                    'holder' => 'div',
                    'class' => 'wpc-text-class',
                    'heading' => __( 'Description', 'text-domain' ),
                    'param_name' => 'content',
                    'value' => __( '', 'text-domain' ),
                    'description' => __( 'To add link highlight text or url and click the chain to apply hyperlink', 'text-domain' ),
                ),
                // Extra css class
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
    add_action('vc_before_init', 'styled_text_block_VC_addon');
}

function styled_text_block_shortcode($atts, $content = null) {
    $atts = shortcode_atts(array(
        'title_text' => 'Default title here.',
        'title_tag' => 'h2',
        'title_alignment' => 'left',
        'title_color' => '#000000',
        'css' => '',
        'el_class' => '',
    ), $atts);

    // Generate CSS class for Design Options
    $css_classes = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'styled-text-block ' . $atts['el_class'], 'styled_text_block', $atts);

    // Generate inline styles
    $inline_styles = vc_shortcode_custom_css_class($atts['css'], ' ');

    $style = sprintf(
'color: %s; text-align: %s;',
esc_attr($atts['title_color']),
        esc_attr($atts['title_alignment'])
    );

    return '<div class="' . esc_attr($css_classes . $inline_styles) . '">' .
            '<'.$atts['title_tag'].'  style="' . $style . '">'. wp_kses_post($atts['title_text']) . '</'.$atts['title_tag'].'>'.
            '<div>' . wp_kses_post($content) . '</div>'.
        '</div>';
}
add_shortcode('styled_text_block', 'styled_text_block_shortcode');