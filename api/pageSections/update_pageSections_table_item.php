<?php
function update_pageSections_table_item($request)
{
    global $wpdb;
    $table_name = 'page_sections';
    $item = $request->get_params(); // 获取请求参数
    $id = $item['id'];

    $data = array();

    foreach ($item as $key => $value) {
        if (isset($value)) {
            if ($key !== 'id' && $key !== 'children' && $key !== 'level') {
                $data[$key] = $value;
            }
        }
    }

    $wpdb->update($table_name, $data, array('id' => $id));
    return 'success';
}
