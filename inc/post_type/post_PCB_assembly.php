<?php if (!defined('ABSPATH')) {
  exit;
}

function create_PCB_assembly_post_types()
{

  register_post_type(
    'PCB_assembly',
    array(
      'labels' => array(
        'name' => __('PCB_assembly'),
        'singular_name' => __('PCB_assembly')
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_rest' => true, // 指定使用 REST API
    )
  );
}
add_action('init', 'create_PCB_assembly_post_types');
