<?php
function myself_image_upload($request)
{
    // do something with the uploaded file here...

    $file = $_FILES['file'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $maxSize = $_POST['maxSize'] ?: 5; // 默认最大文件是5M
    $typebySelf = $_POST['typebySelf'] ?: array('image/png', 'image/jpeg', 'image/svg+xml'); // 默认是图片文件

    // 检查文件是否上传成功等
    if (!is_uploaded_file($file['tmp_name'])) {
        return new WP_Error(400, 'Failed to upload file');
    }
    // 检查文件类型是否满足条件
    if (!in_array($file['type'], $typebySelf)) {
        return new WP_Error(400, 'file type does not belong to' . implode(",", $typebySelf));
    }
    // 检查文件大小是否满足条件
    if ($file['size'] > $maxSize * 1024 * 1024) {
        return new WP_Error(400, 'The file exceeds' . $maxSize . 'M');
    }

    // 处理上传文件
    $upload_dir = wp_upload_dir();
    //上传目录按月分类
    $current_time = current_time('mysql');
    $upload_dir_path = $upload_dir['basedir'] . '/' . date('Y/m', strtotime($current_time));
    $upload_dir_url = $upload_dir['baseurl'] . '/' . date('Y/m', strtotime($current_time));
    wp_mkdir_p($upload_dir_path);
    // 在重名文件后面添加数字
    $file_name = wp_unique_filename($upload_dir_path, $file['name']);
    $file_path = $upload_dir_path . '/' . $file_name;
    move_uploaded_file($file['tmp_name'], $file_path);

    // 添加到媒体库方便管理
    $attachment = array(
        'attachment_filename' => $file_name, // 文件名
        'post_mime_type' => $file['type'], // 文件类型
        'post_content' => '', // 附件描述
        'post_title' => preg_replace('/\.[^.]+$/', '', $file_name), // 附件标题
        'post_author' => '', // 附件作者
        'post_status' => 'inherit', // 附件状态
        'width' => $width, // 文件宽度
        'height' => $height // 文件长度
    );
    $attachment_id  = wp_insert_attachment($attachment, $file_path);

    $attachment_metadata  = wp_get_attachment_metadata($attachment_id);
    if (isset($attachment_metadata['width']) && isset($attachment_metadata['height'])) {
        $attachment_metadata['width'] = $width;
        $attachment_metadata['height'] = $height;
    }
    // 更新图片元数据
    wp_update_attachment_metadata($attachment_id, $attachment_metadata);

    // 最终图片地址
    $file_url = wp_get_attachment_url($attachment_id);
    //返回 URL
    return array(
        'code' => 200,
        'url' => $file_url,
        'id' => $attachment_id,
        'message' => 'File uploaded successfully',
    );
}
