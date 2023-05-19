<?php if (!defined('ABSPATH')) {
  exit;
}

require_once get_template_directory() . '/inc/post_type/post_PCB_layout_design.php'; // 添加自定PCB_layout_design
require_once get_template_directory() . '/inc/post_type/post_PCB_fabrication.php'; // 添加自定PCB_fabrication
require_once get_template_directory() . '/inc/post_type/post_PCB_assembly.php'; // 添加自定PCB_assembly
require_once get_template_directory() . '/inc/post_type/post_our_services.php'; // 添加自定我们的服务
// require_once get_template_directory() . '/inc/post_type/post_product.php'; // 添加自定产品文章

// 移除默认的标签列
function remove_tags_column($defaults)
{
  unset($defaults['tags']);
  return $defaults;
}
add_filter('manage_posts_columns', 'remove_tags_column');
// 移除默认的日期列
function remove_date_column($defaults)
{
  unset($defaults['date']);
  return $defaults;
}
add_filter('manage_posts_columns', 'remove_date_column');
add_filter('manage_pages_columns', 'remove_date_column');

// 添加新的日期列
function add_new_date_column($columns)
{
  $columns['new_date'] = 'Date';
  return $columns;
}
add_filter('manage_posts_columns', 'add_new_date_column');
add_filter('manage_pages_columns', 'add_new_date_column');

// 设置新的日期列的内容
function set_new_date_column_content($column_name, $post_id)
{
  if ($column_name == 'new_date') {
    $post = get_post($post_id);
    $date_format = get_option('date_format') . ' ' . get_option('time_format');
    $date = $post->post_date;
    $modified = $post->post_modified;

    // 比较发布日期和修改日期
    if ($date == $modified) {
      // 如果相同，显示发布日期
      echo '发布日期<br>' . mysql2date($date_format, $date);
    } else {
      // 如果不同，显示修改日期
      echo '最近修改<br>' . mysql2date($date_format, $modified);
    }
  }
}
add_action('manage_posts_custom_column', 'set_new_date_column_content', 10, 2);
add_action('manage_pages_custom_column', 'set_new_date_column_content', 10, 2);

// 为新的日期列添加排序功能
function register_new_date_column_sortable($columns)
{
  $columns['new_date'] = 'new_date';
  return $columns;
}
$post_types = array('pcb_layout_design', 'pcb_fabrication', 'pcb_assembly', 'our_services', 'page', 'post'); // 请用你的实际文章类型替换 'post_type_1', 'post_type_2', 'post_type_3'

foreach ($post_types as $post_type) {
  add_filter("manage_edit-{$post_type}_sortable_columns", 'register_new_date_column_sortable');
}
function sort_new_date_column($query)
{
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  if ('new_date' == $query->get('orderby')) {
    $query->set('orderby', 'modified');
  }
}
add_action('pre_get_posts', 'sort_new_date_column');


// 添加新的文章列表浏览次数列
function add_views_column($columns)
{
  $columns['_check_count'] = 'Views';
  return $columns;
}
add_filter('manage_posts_columns', 'add_views_column');
add_filter('manage_pages_columns', 'add_views_column');

// 在新列中显示文章的浏览次数
function show_views_count($column, $post_id)
{
  if ($column == '_check_count') {
    echo get_post_meta($post_id, '_check_count', true);
  }
}
add_action('manage_posts_custom_column', 'show_views_count', 10, 2);
add_action('manage_pages_custom_column', 'show_views_count', 10, 2);

// 为浏览次数添加排序功能
function register_check_count_column_sortable($columns)
{
  $columns['_check_count'] = '_check_count';
  return $columns;
}

foreach ($post_types as $post_type) {
  add_filter("manage_edit-{$post_type}_sortable_columns", 'register_check_count_column_sortable');
}
function sort_views_column($query)
{
  if (!is_admin() || !$query->is_main_query()) {
    return;
  }

  if ($query->get('orderby') == '_check_count') {
    $query->set('meta_key', '_check_count');
    $query->set('orderby', 'meta_value_num');
  }
}
add_action('pre_get_posts', 'sort_views_column');
// 为之前的文章页添加浏览次数字段
function add_views_fields_to_all_posts()
{
  $args = array(
    'post_type'      => array('pcb_layout_design', 'pcb_fabrication', 'pcb_assembly', 'our_services', 'page', 'post'),
    'posts_per_page' => -1,
    'post_status'    => 'publish',
  );
  $all_posts = get_posts($args);
  foreach ($all_posts as $post) {
    if (!metadata_exists('post', $post->ID, '_check_count')) {
      add_post_meta($post->ID, '_check_count', 0, true);
    }
  }
}
add_views_fields_to_all_posts();
