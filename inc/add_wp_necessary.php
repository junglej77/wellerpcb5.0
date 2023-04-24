<?php
if (!defined('ABSPATH')) {
    exit;
}
// 添加缩略图
add_theme_support('post-thumbnails');
// 添加分类缩略图
add_action('init', 'add_category_thumbnail_support');
function add_category_thumbnail_support()
{
    add_theme_support('category-thumbnails', array('category'));
}
