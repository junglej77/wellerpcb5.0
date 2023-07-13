<?php
if (!defined('ABSPATH')) {
  exit;
}
// 注册css,js
function add_theme_styleScripts()
{
  //注册css
  wp_enqueue_style('bootstrap', get_stylesheet_directory_uri() . '/assets/css/bootstrap.css', array(), wp_get_theme()->get('Version'), 'all');
  // wp_enqueue_style('dc4d6977983946188534c054add0997c', get_stylesheet_directory_uri() . '/assets/css/dc4d6977983946188534c054add0997c.css', array(), wp_get_theme()->get('Version'), 'all');
  wp_enqueue_style('flaticon', get_stylesheet_directory_uri() . '/assets/css/flaticon.css', array(), wp_get_theme()->get('Version'), 'all');
  wp_enqueue_style('fontawesome-all', get_stylesheet_directory_uri() . '/assets/css/fontawesome-all.css', array(), wp_get_theme()->get('Version'), 'all');
  wp_enqueue_style('animate', get_stylesheet_directory_uri() . '/assets/css/animate.css', array(), wp_get_theme()->get('Version'), 'all');
  // wp_enqueue_style('jquery-ui', get_stylesheet_directory_uri() . '/assets/css/jquery-ui.css', array(), wp_get_theme()->get('Version'), 'all');
  wp_enqueue_style('swiper.min', get_stylesheet_directory_uri() . '/assets/css/swiper.min.css', array(), wp_get_theme()->get('Version'), 'all');
  // wp_enqueue_style('owl', get_stylesheet_directory_uri() . '/assets/css/owl.css', array(), wp_get_theme()->get('Version'), 'all');
  wp_enqueue_style('jquery.fancybox.min', get_stylesheet_directory_uri() . '/assets/css/jquery.fancybox.min.css', array(), wp_get_theme()->get('Version'), 'all');
  wp_enqueue_style('style', get_stylesheet_uri()); // 引入css
  wp_enqueue_style('custom', get_stylesheet_directory_uri() . '/assets/css/custom.css', array(), wp_get_theme()->get('Version'), 'all');



  //注册js
  wp_enqueue_script('myjquery', get_template_directory_uri() . '/assets/js/jquery.js', array(), wp_get_theme()->get('Version'), true);
  // wp_enqueue_script('popper.min', get_template_directory_uri() . '/assets/js/popper.min.js', array(), wp_get_theme()->get('Version'), true);
  wp_enqueue_script('bootstrap.min', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), wp_get_theme()->get('Version'), true);
  wp_enqueue_script('jquery.fancybox', get_template_directory_uri() . '/assets/js/jquery.fancybox.js', array(), wp_get_theme()->get('Version'), true);
  // wp_enqueue_script('jquery-ui', get_template_directory_uri() . '/assets/js/jquery-ui.js', array(), wp_get_theme()->get('Version'), true);
  wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/wow.js', array(), wp_get_theme()->get('Version'), true);
  // wp_enqueue_script('appear', get_template_directory_uri() . '/assets/js/appear.js', array(), wp_get_theme()->get('Version'), true);
  wp_enqueue_script('swiper', get_template_directory_uri() . '/assets/js/swiper.min.js', array(), wp_get_theme()->get('Version'), true);
  wp_enqueue_script('swiper.animate', get_template_directory_uri() . '/assets/js/swiper.animate.min.js', array(), wp_get_theme()->get('Version'), true);
  // wp_enqueue_script('owl', get_template_directory_uri() . '/assets/js/owl.js', array(), wp_get_theme()->get('Version'), true);
  // wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/js/isotope.js', array(), wp_get_theme()->get('Version'), true);
  wp_enqueue_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), wp_get_theme()->get('Version'), true);
}
add_action('wp_enqueue_scripts', 'add_theme_styleScripts');

function my_custom_admin_styles($hook)
{

  global $pagenow;
  if (
    $pagenow == 'admin.php'
  ) {
    if (isset($_GET['page'])) {
      $current_menu =  $_GET['page'];
      if ($current_menu == 'page_edit') {
        // 加载 Vue.js 库
        wp_enqueue_script('vue', 'https://unpkg.com/vue@next');
        // 加载 ElementUI 的 CSS 样式文件
        wp_enqueue_style('elementPlus', 'https://unpkg.com/element-plus@latest/theme-chalk/index.css');
        // 引入图标库
        wp_enqueue_script('elementPlusIcons', 'https://unpkg.com/@element-plus/icons-vue', array('vue'),);
        // 加载 ElementUI 的 JavaScript 文件
        wp_enqueue_script('elementPlus', 'https://unpkg.com/element-plus@latest', array('vue'),);
        wp_enqueue_script('Sortable', 'https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.8.3/Sortable.min.js', array(), '',);
        //引入axios 请求
        wp_enqueue_script('axios', 'https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js', array(), '',);
        //引入自定义后台样式表
        wp_enqueue_style('admin-ui', get_stylesheet_directory_uri() . '/assets/css/admin-ui.css', array(), wp_get_theme()->get('Version'), 'all');
      }
    }
  }
}
// 在后台指定页面引入样式
add_action('admin_enqueue_scripts', 'my_custom_admin_styles');
