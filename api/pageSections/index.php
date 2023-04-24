<?php
$namespace = 'pageSections';
// 获取数据列表
register_rest_route($namespace, '/getList', array(
    'methods' => 'GET',
    'callback' => 'get_pageSections_table',
    'permission_callback' => '__return_true',
    'args' => array(
        'paged' => array(
            'type' => 'integer',
            'sanitize_callback' => 'absint',
        ),
        'pages' => array(
            'type' => 'integer',
            'sanitize_callback' => 'absint',
        ),
        'orderby' => array(
            'type' => 'string',
        ),
        'order' => array(
            'type' => 'string',
        ),
        'data' => array(
            'type' => 'array',
            'sanitize_callback' => function ($value) {
                return array_map('sanitize_text_field', $value);
            },
            'additionalProperties' => true,
        ),
    )
));
require_once(get_template_directory() . '/api/pageSections/get_pageSections_table.php');

// 获取树形数据列表
register_rest_route($namespace, '/getTreeList', array(
    'methods' => 'GET',
    'callback' => 'get_pageSections_tree_table',
    'permission_callback' => '__return_true',
    'args' => array(
        'paged' => array(
            'type' => 'integer',
            'sanitize_callback' => 'absint',
        ),
        'pages' => array(
            'type' => 'integer',
            'sanitize_callback' => 'absint',
        ),
        'orderby' => array(
            'type' => 'string',
        ),
        'order' => array(
            'type' => 'string',
        ),
        'data' => array(
            'type' => 'array',
            'sanitize_callback' => function ($value) {
                return array_map('sanitize_text_field', $value);
            },
            'additionalProperties' => true,
        ),
    )
));
require_once(get_template_directory() . '/api/pageSections/get_pageSections_tree_table.php');

// 获取单个数据
register_rest_route($namespace, '/get', array(
    'methods' => 'GET',
    'callback' => 'get_pageSections_table_item',
    'permission_callback' => '__return_true',
    'args' => array(
        'id' => array(
            'type' => 'integer',
            'required' => true,
        )
    )
));
require_once(get_template_directory() . '/api/pageSections/get_pageSections_table_item.php');

//创建数据
register_rest_route($namespace, '/create', array(
    'methods' => 'POST',
    'callback' => 'create_pageSections_table_item',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/pageSections/create_pageSections_table_item.php');

//更新单个数据
register_rest_route($namespace, '/update/(?P<id>\d+)', array(
    'methods' => 'PUT',
    'callback' => 'update_pageSections_table_item',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/pageSections/update_pageSections_table_item.php');

//更新批量数据数据
register_rest_route($namespace, '/bulkUpdate', array(
    'methods' => 'PUT',
    'callback' => 'update_pageSections_table',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/pageSections/update_pageSections_table.php');

//删除单个数据
register_rest_route($namespace, '/delete/(?P<id>\d+)', array(
    'methods' => 'DELETE',
    'callback' => 'delete_pageSections_table_item',
    'permission_callback' => '__return_true',
));
require_once(get_template_directory() . '/api/pageSections/delete_pageSections_table_item.php');
