<?php if (!defined('ABSPATH')) {
  exit;
}

function create_our_services_post_types()
{
  register_post_type(
    'our_services',
    array(
      'labels' => array(
        'name' => 'our_services',
        'singular_name' => 'our_services'
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt',  'custom-fields', 'comments', 'page-attributes', 'post-formats'),
      'show_in_rest' => true, // 指定使用 REST API
    )
  );
}
add_action('init', 'create_our_services_post_types');

function create_services_taxonomy()
{
  register_taxonomy(
    'our_services_category',  // 分类名
    'our_services',  // 文章类型
    array(
      'label' => __('分类'),
      'rewrite' => array('slug' => 'custom_category'),
      'hierarchical' => true,  // 这使得您可以创建子分类
    )
  );
}
add_action('init', 'create_services_taxonomy');
/**
 *'title'：标题
 *'editor'：内容编辑器
 *'author'：作者
 *'thumbnail'：特色图片
 *'excerpt'：摘要
 *'trackbacks'：引用通告
 *'custom-fields'：自定义字段
 *'comments'：评论
 *'revisions'：修订版本
 *'page-attributes'：页面属性
 *'post-formats'：文章格式
 */
