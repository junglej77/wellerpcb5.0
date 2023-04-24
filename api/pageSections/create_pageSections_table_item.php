<?php
function create_pageSections_table_item($request)
{
    global $wpdb;
    $table_name = 'page_sections';
    // 定义默认值数组
    $data = array(
        'parentId' => isset($request['parentId']) ? $request['parentId'] : null,
        'sectionType' => isset($request['sectionType']) ? $request['sectionType'] : '',
        'alias' => isset($request['alias']) ? $request['alias'] : '',
        'title' => isset($request['title']) ? $request['title'] : '',
        'description' => isset($request['description']) ? $request['description'] : '',
        'imgId' => isset($request['imgId']) ? $request['imgId'] : null,
        'imgUrl' => isset($request['imgUrl']) ? $request['imgUrl'] : '',
        'imgAlt' => isset($request['imgAlt']) ? $request['imgAlt'] : '',
        'sourceUrl' => isset($request['sourceUrl']) ? $request['sourceUrl'] : '',
        'number' => isset($request['number']) ? $request['number'] : '',
        'linkTo' => isset($request['linkTo']) ? $request['linkTo'] : ''
    );

    $wpdb->insert($table_name, $data);
    return 'success';
}