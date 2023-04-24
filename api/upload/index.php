<?php

/**
 * 上传图片接口
 */
$namespace = 'myself';
register_rest_route($namespace, '/upload', array(
    'methods' => 'POST',
    'callback' => 'myself_image_upload',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/upload/myself_image_upload.php');

/**
 * 删除图片接口
 */
$namespace = 'myself/upload';
register_rest_route($namespace, '/delete/(?P<id>\d+)', array(
    'methods' => 'DELETE',
    'callback' => 'myself_image_delete',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/upload/myself_image_delete.php');
