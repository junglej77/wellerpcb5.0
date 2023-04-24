<?php
// 查询数据
function get_page_sections_tree_data($data, $orderby = 'id', $order = 'ASC', $paged = 1, $pages = 10)
{
    global $wpdb;
    $table_name = 'page_sections';

    // 构建 SQL 查询语句
    $sql = "SELECT * FROM $table_name ";
    $params = array();

    // 构建查询条件
    if (!empty($data)) {
        $sql .= ' WHERE ';
        foreach ($data as $key => $value) {
            if (!empty($value)) {
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
        $result->children = find_child_tree_nodes($result->id, $wpdb, $orderby, $order);
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

    return $response;
}
function find_child_tree_nodes($parent_id, $wpdb, $orderby, $order)
{
    $sql = 'SELECT * FROM page_sections WHERE parentId = ' . $parent_id;
    $sql .= " ORDER BY $orderby $order";

    $children = $wpdb->get_results($sql);

    if (!empty($children)) {
        $temp_children = array();
        foreach ($children as $child) {
            $child->children = find_child_tree_nodes($child->id, $wpdb, $orderby, $order);
            $temp_children[] = $child;
        }
        $children = $temp_children;
    }
    return $children;
}
