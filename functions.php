<?php if (!defined('ABSPATH')) {
	exit;
}
// assets
include_once('assets/assets-import.php'); // 引入css, js 静态资源

// inc
include_once('inc/remove_wp_unnecessary.php'); // 移除不必要的引用
include_once('inc/add_wp_necessary.php'); // 引入必要功能
include_once('inc/post_type.php'); // 添加自定义文章
include_once('inc/admin_slider.php'); // 后台左边菜单栏修正


//api  // 接口定义
require_once('api/registerRoutes.php');
//wp_api  // 接口定义
require_once('wp_api/wp_registerRoutes.php');



//template-parts // 前台自定义模板
include_once('template-parts/my_template.php'); // 前台自定义模板
