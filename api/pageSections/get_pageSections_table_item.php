<?php
function get_pageSections_table_item($request)
{
    global $wpdb;
    $table_name = 'page_sections';
    // 获取前端参数
    $id = $request->get_param('id');

    // 构建 SQL 查询语句
    $sql = "SELECT * FROM $table_name WHERE ";
    $params = array();

    // 构建查询条件
    $sql .= "id = %d AND ";
    $params[] = $id;

    // 去掉查询语句末尾的 AND
    $sql = rtrim($sql, " AND ");

    // 使用 $wpdb->prepare() 方法将参数绑定到查询语句中
    $query = $wpdb->prepare($sql, $params);

    // 执行查询并返回结果
    $result = $wpdb->get_results($query);
    return $result[0];
}
