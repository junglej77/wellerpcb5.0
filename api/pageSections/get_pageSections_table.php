<?php
function get_pageSections_table($request)
{
    global $wpdb;
    $table_name = 'page_sections';

    // Get request parameters
    $paged = absint($request->get_param('paged') ?: 1);
    $pages = absint($request->get_param('pages') ?: 10);
    $data = $request->get_param('data') ?: [];
    $orderby = $request->get_param('orderby') ?: 'id';
    $order = $request->get_param('order') ?: 'ASC';

    // Build SQL query
    $sql = "SELECT * FROM $table_name";
    $params = array();
    if (!empty($data)) {
        $sql .= " WHERE ";
        foreach ($data as $key => $value) {
            switch ($key) {
                case 'id':
                    $sql .= "id =%d AND ";
                    $params[] = $value;
                    break;
                case 'parentId':
                    $sql .= "parentId =%d AND ";
                    $params[] = $value;
                    break;
                case 'sectionType':
                    $sql .= "sectionType = %s AND ";
                    $params[] = $value;
                    break;
                default:
                    $sql .= $key . ' LIKE %s AND ';
                    $params[] = '%' . $value . '%';
                    break;
            }
        }
        // 去掉查询语句末尾的 AND
        $sql = rtrim($sql, " AND ");
    }
    // 添加排序语句
    $sql .= " ORDER BY $orderby $order";

    // 计算分页信息
    $offset = ($paged - 1) * $pages;
    $sql_count = str_replace('*', 'count(*)', $sql);
    $total = absint($wpdb->get_var($wpdb->prepare($sql_count, $params)));
    $total_pages = ceil($total / $pages);
    $sql .= " LIMIT $offset, $pages";

    // 使用 $wpdb->prepare() 方法将参数绑定到查询语句中
    $query = $wpdb->prepare($sql, $params);
    // 执行查询并返回结果
    $results = $wpdb->get_results($query);
    // 封装分页数据和列表数据
    $response = [
        'data' => $results,
        'page' => [
            'total' => $total,
            'total_pages' => $total_pages,
            'paged' => $paged,
            'pages' => $pages
        ]
    ];

    return new WP_REST_Response($response, 200);
}
