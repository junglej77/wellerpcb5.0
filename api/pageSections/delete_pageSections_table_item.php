<?php
function delete_pageSections_table_item($request)
{
    global $wpdb;
    $table_name = 'page_sections';
    $id = $request['id'];

    try {
        // 删除子节点及子子节点
        delete_record_and_children($id,$table_name,$wpdb);

        $response = [
            'message' => '删除成功',
        ];
        return new WP_REST_Response($response, 200);
    } catch (Exception $e) {
        $response = [
            'message' => '删除失败: ' . $e->getMessage(),
        ];
        return new WP_REST_Response($response, 400);
    }

}

/**
* 删除子节点及子子节点
**/
function delete_record_and_children($record_id,$table_name,$wpdb) {
    // 查询要删除的记录的 parentId
    $parent_id = $wpdb->get_var($wpdb->prepare("SELECT parentId FROM $table_name WHERE id = %d", $record_id));

    // 删除该记录
    $wpdb->delete($table_name, ['id' => $record_id]);

    // 删除所有子节点
    $children = $wpdb->get_results($wpdb->prepare("SELECT id FROM $table_name WHERE parentId = %d", $record_id));
    foreach ($children as $child) {
        delete_record_and_children($child->id, $table_name, $wpdb);
    }
}