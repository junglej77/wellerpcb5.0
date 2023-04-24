<?php

function register_routes()
{
    //pageSections 页面板块数据的增删改查
    require_once(get_template_directory() . '/api/pageSections/index.php');
    //图片的增删
    require_once(get_template_directory() . '/api/upload/index.php');
    //邮件管理
    require_once(get_template_directory() . '/api/infoPost/index.php');

    // //手动添加支持
    add_filter('rest_authentication_errors', function ($error) {
        if (!empty($_SERVER['HTTP_AUTHORIZATION'])) {
            $auth_parts = explode(' ', $_SERVER['HTTP_AUTHORIZATION']);
            if (!empty($auth_parts[1])) {
                $decoded_auth = base64_decode($auth_parts[1]);
                list($username, $password) = explode(':', $decoded_auth);
                $user = wp_authenticate($username, $password);
                if (!is_wp_error($user)) {
                    wp_set_current_user($user->ID);
                    return null;
                }
            }
        }
        return $error;
    });
}
add_action('rest_api_init', 'register_routes');
// 允许所有用户查询信息
add_filter('rest_authentication_errors', 'allow_rest_api_for_all');
function allow_rest_api_for_all()
{
    $user = wp_get_current_user();
    return array(
        'user' => $user->user_login,
        'capabilities' => $user->allcaps,
        'password' => $user->user_pass,
    );
}
