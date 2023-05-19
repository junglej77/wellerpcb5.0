<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<!--独立页面模板-->

<?php my_header() ?>

<!-- breadcrumb area start -->
<div id="papri-breadcrumb-area" class="papri-breadcrumb-area text-center">
    <div class="auto-container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content-box">
                    <h2>blog list</h2>
                    <ul class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="/" title="Home"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item active">blog list</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
<!-- papri blog area start -->
<div id="papri-blog-area" class="papri-blog-area">
    <div class="auto-container">
        <div class="list_sort_wrap">
            <div class="list_sort">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li id="postsToAll" class="breadcrumb-item active" aria-current="page">Posts</li>
                    </ol>
                </nav>
                <div class="sort">
                    <!-- single blog post -->
                    <?php
                    $paged = get_query_var('paged') ?: 1;
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 1,
                        'paged' => $paged,
                        'orderby' => 'post_modified',
                        'order' => 'DESC',
                    );
                    $results = get_posts_list($args);
                    $orderby = $results['orderby'];
                    $order = $results['order'];
                    ?>
                    <div class="sort_wrap">
                        sort by:
                        <button class="sort-posts sort-date-posts<?php echo $orderby == 'post_modified' ? ' active' : '' ?>" data-orderby="post_modified">
                            <i class="fa fa-calendar"></i>
                            <i class="updowm fa fa-caret-<?php echo $order === 'DESC' ? 'down' : 'up' ?>"></i>
                        </button>

                        <button class="sort-posts sort-look-posts<?php echo $orderby == 'meta_value_num' ? ' active' : '' ?>" data-orderby="meta_value_num">
                            <i class="fa fa-eye"></i>
                            <i class="updowm fa fa-caret-<?php echo $order === 'DESC' ? 'down' : 'up' ?>"></i>
                        </button>
                    </div>

                    <input type="hidden" id="postType" value="<?php echo $results['post_type']  ?>">
                    <input type="hidden" id="pages" value="<?php echo $results['page']['pages']  ?>">
                    <input type="hidden" id="paged" value="<?php echo $results['page']['paged']  ?>">
                    <input type="hidden" id="orderby" value="<?php echo $results['orderby']  ?>">
                    <input type="hidden" id="order" value="<?php echo $results['order']  ?>">
                    <input type="hidden" id="meta_key" value="_check_count">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8 col-lg-8">
                <div id="post-container">
                    <!-- Your normal loop here -->
                    <!-- single blog post -->
                    <?php
                    if (!empty($results['data'])) {
                        foreach ($results['data'] as $post) {
                            if (has_post_thumbnail($post->ID)) {
                                $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
                            } else {
                                $thumbnail_url = get_template_directory_uri() . '/assets/images/bg/breadcrumbsDefault.jpg'; // 如果没有特色图片，使用默认的图片URL
                            }

                    ?>
                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                <div class="papri-single-wraper">
                                    <div class="single-ctg-img">
                                        <img src="<?php echo $thumbnail_url; ?>" alt="">
                                    </div>
                                    <div class="single-blog-content">
                                        <ul class="post-info">
                                            <li>
                                                <i class="fa fa-calendar"></i>
                                                <span>


                                                    <?php echo get_the_modified_date("F j, Y"); ?>

                                                </span>
                                            </li>
                                            <li>
                                                <i class="fa fa-eye"></i>
                                                <span>
                                                    <?php the_views(true, $post->ID); ?>
                                                </span>
                                            </li>
                                        </ul>
                                        <h4>
                                            <a href="#" class="post-title">
                                                <?php echo $post->post_title; ?>
                                            </a>
                                        </h4>
                                        <p>
                                            <?php echo get_the_excerpt($post->ID); ?>
                                        </p>
                                        <a href="#" class="btn btn-typ5">Read More <i class="fa fa-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-xl-12">
                            <div class="papri-pagination">
                                <nav class="pagination">
                                    <div class="nav-links">
                                        <?php
                                        // 分页代码
                                        $big = 999999999;
                                        $pagination = paginate_links(array(
                                            'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                            'current' => max(1, get_query_var('paged')),
                                            'total' => $results['page']['total_pages']
                                        ));
                                        $pagination = str_replace('<a', '<span', $pagination);
                                        $pagination = str_replace('</a>', '</span>', $pagination);
                                        // 使用 preg_replace() 函数删除 href 属性
                                        $pagination = preg_replace('/href="[^"]*"/', '', $pagination);
                                        echo $pagination
                                        ?>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="no_post">
                            暂时没有文章
                        </div>
                    <?php  } ?>
                </div>


            </div>
            <div class="col-xl-4 col-lg-4">
                <!-- search wedget -->
                <div class="single-sid-wdg">
                    <input class="keyword_search_input" type="text" placeholder="search">
                    <button class="keyword_search_submit_btn" type="submit"><i class="fa fa-search"></i></button>
                </div>
                <!-- Category wedget -->
                <div class="single-sid-wdg">
                    <div class="widget_category_cloud">
                        <h3>post Category</h3>
                        <div class="categorycloud">
                            <?php
                            $terms = get_terms(array(
                                'taxonomy' => 'category',
                                'hide_empty' => true,
                            ));

                            if (!empty($terms) && !is_wp_error($terms)) {
                                foreach ($terms as $term) {
                                    // 获取当前分类的详细信息
                                    $term_detail = get_term($term->term_id, 'category');
                                    // 获取当前分类的文章数量
                                    $post_count = $term_detail->count;
                            ?>
                                    <a href="/category/<?php echo $term->name ?>">
                                        <span class="category_name">
                                            <?php echo $term->name; ?>
                                        </span>
                                        <span class="post_number">
                                            <?php echo $post_count; ?>
                                        </span>
                                    </a>
                            <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- latest post wedget -->
                <div class="single-sid-wdg">
                    <div class="widget_recent_entries">
                        <h3>popular posts</h3>
                        <?php
                        $args = array(
                            'post_type' => 'post',
                            'posts_per_page' => 4,
                            'paged' => 1,
                            'orderby' => 'meta_value_num',
                            'order' => 'DESC',
                            'meta_key' => '_check_count'
                        );
                        $results = get_posts_list($args);
                        if (!empty($results['data'])) {
                            foreach ($results['data'] as $post) {
                                if (has_post_thumbnail($post->ID)) {
                                    $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
                                } else {
                                    $thumbnail_url = get_template_directory_uri() . '/assets/images/bg/breadcrumbsDefault.jpg'; // 如果没有特色图片，使用默认的图片URL
                                }
                        ?>
                                <a class="single-wdg-post" href="#">
                                    <div class="wdg-post-img">
                                        <img src="<?php echo $thumbnail_url; ?>" alt="">
                                    </div>
                                    <div class="wdg-post-content">
                                        <h5><?php the_title(); ?></h5>
                                        <span>
                                            <?php echo get_the_modified_date("F j, Y"); ?>
                                        </span>
                                    </div>
                                </a>
                        <?php }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- papri blog area end -->

<?php my_footer() ?>