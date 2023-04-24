<?php
if (!defined('ABSPATH')) {
    exit;
}
// Disable Emojis in WordPress
function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
}
add_action('init', 'disable_emojis');

// Filter function used to remove the tinymce emoji plugin
function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}


// Remove admin bar for all users
add_filter('show_admin_bar', '__return_false');

// Gutenberg 移除默认块
// function my_allowed_block_types($allowed_block_types, $post)
// {
//     // 在此处添加您允许使用的块类型
//     $allowed_block_types = array();
//     return $allowed_block_types;
// }
// add_filter('allowed_block_types_all', 'my_allowed_block_types', 10, 2);

function remove_core_updates()
{
    global $wp_version;
    return (object) array(
        'last_checked' => time(),
        'version_checked' => $wp_version,
        'updates' => array()
    );
}
add_filter('pre_site_transient_update_core', 'remove_core_updates');


function remove_wp_default_styles_scripts()
{
    // Remove all default WordPress CSS files
    // wp_dequeue_style('wp-block-library'); // WordPress core
    wp_dequeue_style('wp-block-library-theme'); // WordPress core
    wp_dequeue_style('wc-block-style'); // WooCommerce
    wp_dequeue_style('storefront-gutenberg-blocks'); // Storefront theme
    wp_dequeue_style('storefront-gutenberg-blocks-rtl'); // Storefront theme
    wp_dequeue_style('classic-theme-styles');
    // wp_dequeue_style('global-styles'); // WordPress core
    // wp_dequeue_style('global-styles-inline'); // WordPress core

    // Remove all default WordPress JS files
    wp_dequeue_script('jquery'); // jQuery
    wp_deregister_script('jquery'); // jQuery
    wp_dequeue_script('wp-embed'); // WordPress core
}
//移除不必要的工具,css，js
add_action('wp_enqueue_scripts', 'remove_wp_default_styles_scripts', 999);

// 移除后台底部的版本号
add_filter('update_footer', '__return_empty_string', 11);
// 移除后台底部的版权声明文字
function remove_footer_admin()
{
    echo '';
}
add_filter('admin_footer_text', 'remove_footer_admin');
