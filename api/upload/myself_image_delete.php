<?php
function myself_image_delete($request)
{
    $id = $request->get_param('id');
    $force = $request->get_param('force'); // 如果被帖子或者页面引用，则不会强制被删除
    $deleted = wp_delete_attachment($id, $force);

    if ($deleted === false) {
        return new WP_Error('custom_delete_failed', 'Failed to delete media file.', array('status' => 500));
    }

    return array(
        'status' => 'success',
        'message' => sprintf('Media file %d has been deleted.', $id),
    );
}
