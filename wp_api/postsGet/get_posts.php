<?php
// ajax 获取搜索文章并创建对应的表
// 在主题被激活的时候创建表
function create_search_table()
{
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'search_keywords';

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        keyword text NOT NULL,
        ip_address varchar(45) NOT NULL,
        search_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'create_search_table');

// ajax 获取文章内容/分页/排序/搜索
function post_sort()
{
    $keyword = $_POST['keyword'];
    $isRecordKeyword = $_POST['isRecordKeyword'];
    $post_type = $_POST['post_type'];
    $cat = $_POST['cat'];
    $posts_per_page = $_POST['posts_per_page'];
    $paged = $_POST['paged'];
    $orderby = $_POST['orderby'];
    $order = $_POST['order'];
    $meta_key = $_POST['meta_key'];

    $args = array(
        'posts_per_page' => $posts_per_page,
        'paged' => $paged,
        'orderby' => $orderby,
        'order' => $order,
    );
    if (!empty($keyword)) {
        $args['s'] =  $keyword;
        $args['post__not_in'] = array(1180); // 博客页面的id, 这个页面不展示
    }
    if (!empty($post_type)) {
        $args['post_type'] =  $post_type;
    }
    if (!empty($cat)) {
        $args['cat'] =  $cat;
    }
    if (!empty($meta_key)) {
        $args['meta_key'] =  $meta_key;
    }
    $query = new WP_Query($args);
    $posts = $query->posts;
    // $isRecordKeyword 为 true 记录该搜索词相关信息
    if ($isRecordKeyword) {
        insert_keyword($keyword);
    }
    // 关键词不为空高亮处理
    if (!empty($keyword)) {
        // 返回搜索结果
        $results = array();
        foreach ($posts as $post) {
            // 标题中的关键词替换为带有HTML标签的关键词
            $highlighted_post_title = str_ireplace($keyword, '<span class="highlighted">' . $keyword . '</span>', strip_tags($post->post_title));
            // 摘要中的关键词替换为带有HTML标签的关键词
            $highlighted_post_excerpt = str_ireplace($keyword, '<span class="highlighted">' . $keyword . '</span>', strip_tags($post->post_excerpt));
            // 内容中的关键词替换为带有HTML标签的关键词
            $content = $post->post_content;
            $content = preg_replace('/<!--(.*?)-->/', "", $content);
            $content = preg_replace('/<style\b[^>]*>(.*?)<\/style>/s', "", $content);
            $content = strip_tags($content);
            $highlighted_post_content = str_ireplace($keyword, '<span class="highlighted">' . $keyword . '</span>', $content);
            // 获取关键词在文章内容中的位置
            $keyword_pos = strpos($highlighted_post_content, $keyword);
            // 定义需要提取的字符长度
            $char_length = 300;
            // 如果关键词在文章内容中的位置不是 false
            if ($keyword_pos !== false) {
                // 如果关键词的位置小于 $char_length，则从头开始提取
                if ($keyword_pos < $char_length) {
                    $start_pos = 0;
                } else {
                    // 否则从关键词的位置减去 $char_length 开始提取
                    $start_pos = $keyword_pos - $char_length;
                }
                // 提取一段包含关键词的文字
                $post_content_excerpt = substr($highlighted_post_content, $start_pos, strlen($keyword) + $char_length);
            } else {
                // 如果关键词不在文章内容中，则使用文章的摘要作为提取的文字
                // 如果关键词在文章的摘要中
                if (strpos($highlighted_post_excerpt, $keyword) !== false) {
                    $post_content_excerpt =  $highlighted_post_excerpt;
                } else {
                    // 如果关键词不在文章的摘要中
                    $post_content_excerpt = substr($highlighted_post_content, 0, $char_length);
                }
            }
            // 修改文章内容
            $post->post_title = $highlighted_post_title;
            $post->post_content = $post_content_excerpt;
            array_push($results, $post);
        }
        $query->posts = $results;
    }
    // wp_send_json_success($results);

    // wp_die();

    if ($query->have_posts()) {
        // 如果有文章，那么我们进入循环
        while ($query->have_posts()) {
            $query->the_post();
            // 在这里输出文章的 HTML
            if (!empty($keyword)) {
                get_template_part('template-parts/list/posts-search', get_post_format());
            } else {
                get_template_part('template-parts/list/posts-1', get_post_format());
            }
        }
    } else {
        // 如果没有文章，那么我们输出一个提示
        echo '<p class="text-center">Sorry, but nothing matched your search terms. Please try again with some different keywords.</p>';
    }



    // 生成分页链接
    $pagination = paginate_links(array(
        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'total' => $query->max_num_pages,
        'current' => max(1, $paged),
    ));
    $pagination = str_replace('<a', '<span', $pagination);
    $pagination = str_replace('</a>', '</span>', $pagination);
    // 使用 preg_replace() 函数删除 href 属性
    $pagination = preg_replace('/href="[^"]*"/', '', $pagination);
    echo '<div class="col-xl-12"><div class="papri-pagination"><nav class="pagination"><div class="nav-links">' . $pagination . '</div></nav></div></div>';

    wp_die();
}
add_action('wp_ajax_post_sort', 'post_sort');
add_action('wp_ajax_nopriv_post_sort', 'post_sort');

// 插入搜索关键操作
// 插入搜索关键操作
function insert_keyword($keyword)
{
    // 将搜索关键词存储到我们创建的数据库表中
    global $wpdb;
    $table_name = $wpdb->prefix . 'search_keywords';

    //获取用户IP
    $user_ip = $_SERVER['REMOTE_ADDR'];

    //查询是否存在在12小时内同一IP和关键词的记录
    $existing = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table_name WHERE ip_address = %s AND keyword = %s AND search_date > DATE_SUB(NOW(), INTERVAL 12 HOUR)",
        $user_ip,
        $keyword
    ));

    //如果不存在相同的记录，则插入新记录
    if ($existing == 0) {
        $wpdb->insert(
            $table_name,
            array(
                'keyword' => $keyword,
                'ip_address' => $user_ip,
                'search_date' => current_time('mysql')
            )
        );
    }
}

/***********文章统计*********/
function process_postviews()
{
    global $post;
    if (check_cookie($post))
        return;
    if (is_int($post)) {
        $post = get_post($post);
    }
    if (!wp_is_post_revision($post)) {
        if (is_single() || is_page()) {
            $id = intval($post->ID);
            //$post_views = get_post_custom($id);

            $post_views = intval(get_post_meta($id, '_check_count', true));
            $false_check_count = intval(get_post_meta($post->ID, 'false_check_count', true));
            //统计所有人
            $should_count = true;
            //排除机器人
            $bots = array('Google Bot' => 'googlebot', 'Google Bot' => 'google', 'MSN' => 'msnbot', 'Alex' => 'ia_archiver', 'Lycos' => 'lycos', 'Ask Jeeves' => 'jeeves', 'Altavista' => 'scooter', 'AllTheWeb' => 'fast-webcrawler', 'Inktomi' => 'slurp@inktomi', 'Turnitin.com' => 'turnitinbot', 'Technorati' => 'technorati', 'Yahoo' => 'yahoo', 'Findexa' => 'findexa', 'NextLinks' => 'findlinks', 'Gais' => 'gaisbo', 'WiseNut' => 'zyborg', 'WhoisSource' => 'surveybot', 'Bloglines' => 'bloglines', 'BlogSearch' => 'blogsearch', 'PubSub' => 'pubsub', 'Syndic8' => 'syndic8', 'RadioUserland' => 'userland', 'Gigabot' => 'gigabot', 'Become.com' => 'become.com', 'Baidu Bot' => 'Baiduspider');
            $useragent = $_SERVER['HTTP_USER_AGENT'];
            foreach ($bots as $name => $lookfor) {
                if (stristr($useragent, $lookfor) !== false) {
                    $should_count = false;
                    break;
                }
            }
            if ($should_count) {
                if (!update_post_meta($id, '_check_count', ($post_views + 1))) {
                    add_post_meta($id, '_check_count', 1, true);
                    update_post_meta($id, '_false_total_views', (1 + $false_check_count));
                } else {
                    update_post_meta($id, '_false_total_views', ($post_views + 1 + $false_check_count));
                }
            }
        }
    }
}

function check_cookie($post)
{
    $COOKNAME = 'wellerpcb_view';
    if (isset($_COOKIE[$COOKNAME]))
        $cookie = $_COOKIE[$COOKNAME];
    else
        return false;
    $id = $post->ID;
    if (empty($id)) {
        return false;
    }
    if (!empty($cookie)) {
        $list = explode('a', $cookie);
        if (!empty($list) && in_array($id, $list)) {
            return true;
        }
    }
    return false;
}
### Function: Display The Post Views
function the_views($display = true, $id)
{
    $post_views = intval(get_post_meta($id, '_false_total_views', true));
    $output = number_format_i18n($post_views);
    if ($display) {
        echo $output;
    } else {
        return $output;
    }
}

### Function: Display Total Views
if (!function_exists('get_totalviews')) {
    function get_totalviews($display = true)
    {
        global $wpdb;
        $total_views = intval($wpdb->get_var("SELECT SUM(meta_value+0) FROM $wpdb->postmeta WHERE meta_key = '_check_count'"));
        if ($display) {
            echo number_format_i18n($total_views);
        } else {
            return $total_views;
        }
    }
}
//当 _check_count 或 false_check_count 字段的值被更新时，该函数会更新 _false_total_views 字段的值
function update_total_views($post_id)
{
    $check_count = intval(get_post_meta($post_id, '_check_count', true));
    $false_check_count = intval(get_post_meta($post_id, 'false_check_count', true));
    $total_views = $check_count + $false_check_count;
    update_post_meta($post_id, '_false_total_views', $total_views);
}
add_action('updated_post_meta', 'update_total_views', 10, 4);

### Function: Add Views Custom Fields
add_action('publish_post', 'add_views_fields');
add_action('publish_page', 'add_views_fields');
function add_views_fields($post_ID)
{
    global $wpdb;
    if (!wp_is_post_revision($post_ID)) {
        add_post_meta($post_ID, '_check_count', 0, true);
    }
}
### Function: Delete Views Custom Fields
add_action('delete_post', 'delete_views_fields');
add_action('publish_page', 'delete_views_fields');
function delete_views_fields($post_ID)
{
    global $wpdb;
    if (!wp_is_post_revision($post_ID)) {
        delete_post_meta($post_ID, '_check_count');
        delete_post_meta($post_ID, 'false_check_count');
        delete_post_meta($post_ID, '_false_total_views');
    }
}
// wp 获取对应文章类型前台渲染
function get_posts_list($array)
{
    // 创建查询参数

    $args = array(
        'post_type'      => $array['post_type'],
        'posts_per_page'      => $array['posts_per_page'],
        'paged'      => $array['paged'],
        'orderby'      => $array['orderby'],
        'order'      => $array['order'],
    );
    if (isset($array['cat'])) {
        $args['cat'] = $array['cat'];
    }
    if (isset($array['meta_key'])) {
        $args['meta_key'] = $array['meta_key'];
    }
    if (isset($array['post__not_in'])) {
        $args['post__not_in'] = $array['post__not_in'];
    }
    // 创建新的 WP_Query 对象
    $query = new WP_Query($args);

    // 获取查询结果
    $posts = $query->posts;

    // 封装分页数据和列表数据
    $response = [
        'data' => $posts,
        'post_type'      => $array['post_type'],
        'orderby'      => $array['orderby'],
        'order'      => $array['order'],
        'page' => [
            'total'       => $query->found_posts,
            'total_pages' => $query->max_num_pages,
            'paged'       => $array['paged'],
            'pages'       => $array['posts_per_page']
        ]
    ];
    if (isset($array['cat'])) {
        $response['cat'] = $array['cat'];
    }
    /* Restore original Post Data */
    return $response;
}
