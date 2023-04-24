<?php if (!defined('ABSPATH')) {
    exit;
}
// 404 页面
function my_404_page($template)
{
    if (is_404()) {
        $new_template = locate_template(array('template-parts/404/404.php'));
        if ('' != $new_template) {
            return $new_template;
        }
    }
    return $template;
}
add_filter('template_include', 'my_404_page', 99);

// 页面page
function my_page_page($template)
{
    if (is_page()) {
        $page = get_queried_object();
        $page_slug = $page->post_name;
        $custom_template = get_stylesheet_directory() . '/template-parts/page/page-' . $page_slug . '.php';
        if (file_exists($custom_template)) {
            $template = $custom_template;
        } else {
            $template = get_stylesheet_directory() . '/template-parts/page/page.php';
        }
    }
    return $template;
}
add_filter('template_include', 'my_page_page', 99);

// 分类页面category
function my_category_page($template)
{
    if (is_category()) {
        $template = get_stylesheet_directory() . '/template-parts/category/category.php';
    }
    return $template;
}
add_filter('template_include', 'my_category_page', 99);

// 文章页面single
function my_single_page($template)
{
    if (is_single()) {
        global $post;
        $custom_template = get_stylesheet_directory() . '/template-parts/single/single-' . $post->post_type . '.php';
        if (file_exists($custom_template)) {
            $template = $custom_template;
        } else {
            $template = get_stylesheet_directory() . '/template-parts/single/single.php';
        }
    }
    return $template;
}
add_filter('template_include', 'my_single_page', 99);

// 使用自定header
function my_header($option = '', $data = [])
{
    $template = 'template-parts/header/header' . (!empty($option) ? '-' . $option : '');
    get_template_part($template, null,  $data);
}

// 使用自定content
function my_content($data = [])

{
    $page = get_queried_object();
    $page_slug = $page->post_name;

    $template = 'template-parts/content/content';
    $custom_template_path = get_stylesheet_directory() . '/template-parts/content/content-' . $page_slug . '.php';
    if (file_exists($custom_template_path)) {
        $template = 'template-parts/content/content-' . $page_slug;
    }
    get_template_part($template, null,  $data);
}

// 使用自定footer
function my_footer($option = '', $data = [])
{
    $template = 'template-parts/footer/footer' . (!empty($option) ? '-' . $option : '');
    get_template_part($template, null,  $data);
}

// 使用自定slider
function my_slider($option = '', $data = [])
{
    $template = 'template-parts/slider/slider' . (!empty($option) ? '-' . $option : '');
    get_template_part($template, null,  $data);
}


// 使用自定list/ 单个list 默认为图文列表
function my_list($option = '', $data = [])
{
    $template = 'template-parts/list/list' . (!empty($option) ? '-' . $option : '');
    get_template_part($template, null,  $data);
}
