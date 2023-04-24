<?php
$namespace = 'info/email';

/**
 * 发送邮件
 */
$namespace = 'info/email';
register_rest_route($namespace, '/send', array(
    'methods' => 'POST',
    'callback' => 'send_email',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/infoPost/email_post.php');
