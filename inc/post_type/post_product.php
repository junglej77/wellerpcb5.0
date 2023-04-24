<?php if (!defined('ABSPATH')) {
  exit;
}

function create_product_post_types()
{

  register_post_type(
    'product',
    array(
      'labels' => array(
        'name' => __('Products'),
        'singular_name' => __('Product')
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true, // 指定使用 REST API
    )
  );
}
add_action('init', 'create_product_post_types');
