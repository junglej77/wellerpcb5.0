<?php
function get_pageSections_tree_table($request)
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
    $sql = "SELECT * FROM $table_name WHERE ";
    $params = array();
    $WHERE_add = false; // 相当于没有传参
    if (!empty($data)) {
        foreach ($data as $key => $value) {
            if (!empty($value)) {
                $WHERE_add = true;
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
        }
        // 去掉查询语句末尾的 AND
        $sql = rtrim($sql, " AND ");
    }
    // 如果查询语句中没有parentId 相关查询，则某人查询parentId为null
    if (strpos($sql, 'parentId') === false) {
        $sql .= $WHERE_add ? " AND parentId IS NULL" : " parentId IS NULL";
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

    // 用查询出来的数据找到这个数据的所有子节点
    foreach ($results as $result) {
        $result->level = 1;
        $result->children = find_child_nodes($result->level, $result->id, $wpdb, $orderby, $order);
    }


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


function find_child_nodes($level, $parent_id, $wpdb, $orderby, $order)
{
    $sql = 'SELECT * FROM page_sections WHERE parentId = ' . $parent_id;
    $sql .= " ORDER BY $orderby $order";

    $children = $wpdb->get_results($sql);

    if (!empty($children)) {
        $temp_children = array();
        foreach ($children as $child) {
            $child->level = $level + 1;
            $child->children = find_child_nodes($child->level, $child->id, $wpdb, $orderby, $order);
            $temp_children[] = $child;
        }
        $children = $temp_children;
    }
    return $children;
}
