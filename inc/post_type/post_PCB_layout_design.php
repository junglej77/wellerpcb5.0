<?php if (!defined('ABSPATH')) {
  exit;
}

function create_PCB_layout_design_post_types()
{

  register_post_type(
    'PCB_layout_design',
    array(
      'labels' => array(
        'name' => 'PCB_layout_design',
        'singular_name' => 'PCB_layout_design'
      ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'author', 'thumbnail', 'excerpt',  'custom-fields', 'comments', 'page-attributes', 'post-formats'),
      'taxonomies' => array('category', 'post_tag'),
      'show_in_rest' => true, // 指定使用 REST API
    )
  );
}
add_action('init', 'create_PCB_layout_design_post_types');

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
