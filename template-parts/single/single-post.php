<?php if (!defined('ABSPATH')) {
    exit;
}
$COOKNAME = 'wellerpcb_view'; //cookie名称
$TIME = 60 * 60 * 12;
$PATH = '/';

$id = $posts[0]->ID;
$expire = time() + $TIME; //cookie有效期
if (isset($_COOKIE[$COOKNAME]))
    $cookie = $_COOKIE[$COOKNAME]; //获取cookie
else
    $cookie = '';

if (empty($cookie)) {
    //如果没有cookie
    setcookie($COOKNAME, $id, $expire, $PATH);
} else {
    //用a分割成数组
    $list = explode('a', $cookie);
    //如果已经存在本文的id
    if (!in_array($id, $list)) {
        setcookie($COOKNAME, $cookie . 'a' . $id, $expire, $PATH);
    }
}
process_postviews();
?>
<!--文章模板-->

<?php my_header();
?>

<style>
    .wellerpcb-wrapper {
        overflow: visible;
    }

    @media (max-width: 575px) {
        .auto-container {
            padding: 0px 15px;
        }
    }

    .papri-breadcrumb-area {
        margin-bottom: 30px;
    }
</style>
<!-- breadcrumb area start -->
<div class="papri-breadcrumb-area text-center" <?php
                                                if (has_post_thumbnail(get_the_ID())) {
                                                    $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'full');

                                                    echo 'style="background-image: url(' . $thumbnail_url . ')"';
                                                }
                                                ?>>
    <div class="auto-container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-content-box">
                    <h2>blog detail</h2>
                    <ul class="breadcrumb justify-content-center">
                        <li class="breadcrumb-item">
                            <a href="/" title="Home"><i class="fa fa-home"></i> Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="/wellerpcb_news" title="wellerpcb_news">posts</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->
<!-- papri blog area start -->
<div class="papri-blog-area">
    <div class="auto-container">
        <div class="row">
            <div id="post-container" class="col-xl-8 col-lg-8">
                <?php my_content() ?>
            </div>
            <div class="col-xl-4 col-lg-4">
                <!-- latest post wedget -->
                <div class="single-sid-wdg sticky">
                    <h3>popular posts</h3>
                    <?php
                    $args = array(
                        'post_type' => 'post',
                        'posts_per_page' => 4,
                        'paged' => 1,
                        'orderby' => 'meta_value_num',
                        'order' => 'DESC',
                        'meta_key' => '_check_count',
                        'post__not_in' => array(get_the_ID()),
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
                            <a class="single-wdg-post" href="<?php echo the_Permalink(); ?>">
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
<!-- papri blog area end -->


<?php my_footer() ?>