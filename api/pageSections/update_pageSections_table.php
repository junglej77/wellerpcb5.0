<?php
function update_pageSections_table($request)
{
    global $wpdb;
    $table_name = 'page_sections';
    $items = $request->get_params(); // 获取请求参数
    $updated_items = array(); // 存储更新后的项目
    foreach ($items as $item) {
        $id = $item['id'];
        $data = array();

        foreach ($item as $key => $value) {
            if (isset($value)) {
                if ($key !== 'id') {
                    $data[$key] = $value;
                }
            }
        }
        $wpdb->update($table_name, $data, array('id' => $id));
        // 将更新后的项目添加到 $updated_items 数组中
        $updated_items[] = $wpdb->get_row("SELECT * FROM $table_name WHERE id = $id");
    }
    return $updated_items;
}
