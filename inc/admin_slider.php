<?php if (!defined('ABSPATH')) {
    exit;
}
// 调整wordpress 菜单顺序
function custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;
    return array(
        'index.php', // 仪表盘
        'upload.php', // 媒体
        'page_edit', // 页面
        'edit.php?post_type=page', // 页面
        'edit.php?post_type=pcb_layout_design', // pcb_layout_design
        'edit.php?post_type=pcb_fabrication', // pcb_fabrication
        'edit.php?post_type=pcb_assembly', // pcb_assembly
        'edit.php?post_type=our_services', // our_services
        'edit.php?post_type=product', // product
        'edit.php', // 文章
        'edit-comments.php', // 评论
        'themes.php', // 外观
        'plugins.php', // 插件
        'users.php', // 用户
        'tools.php', // 工具
        'options-general.php' // 设置
    );
}
add_filter('custom_menu_order', '__return_true');
add_filter('menu_order', 'custom_menu_order');
// 添加页面数据模块
add_action('admin_menu', 'register_page_data_edit', 9);
function register_page_data_edit()
{
    // 页面编辑
    add_menu_page(
        '特殊页面',  // 页面标题
        '特殊页面',  // 菜单标题
        'manage_options',  // 用户权限
        'page_edit',  // 菜单slug
        'home_page',  // 回调函数
        'dashicons-admin-page',  // 菜单图标
        2.1 // 菜单在侧边栏中的位置
    );
}
// 引用回调函数文件
require_once get_template_directory() . '/inc/admin_slider/page_sections/home_page.php'; //首页

// 添加邮箱管理
// add_action('admin_menu', 'register_email_manage_edit', 9);
function register_email_manage_edit()
{
    //邮件管理
    add_menu_page(
        '邮箱管理',  // 页面标题
        '邮箱管理',  // 菜单标题
        'manage_options',  // 用户权限
        'email-edit',  // 菜单slug
        'email_SMTP',  // 回调函数
        'dashicons-format-gallery',  // 菜单图标
        22 // 菜单在侧边栏中的位置
    );
    /*****子菜单 */
    // 接收邮件配置
    add_submenu_page(
        'email-edit',  // 父菜单slug
        '邮箱配置',  // 页面标题
        '邮箱配置',  // 菜单标题
        'manage_options',  // 用户权限
        'email-edit',  // 菜单slug
        'email_SMTP'  // 回调函数
    );
}
// 引用回调函数文件
// require_once get_template_directory() . '/inc/admin_slider/email_manage/email_SMTP.php'; //邮箱配置
