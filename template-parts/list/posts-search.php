<?php if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="papri-single-wraper">
        <div class="single-ctg-img">
            <?php
            if (has_post_thumbnail($post->ID)) {
                $thumbnail_url = get_the_post_thumbnail_url($post->ID, 'full');
            } else {
                $thumbnail_url = get_template_directory_uri() . '/assets/images/bg/breadcrumbsDefault.jpg'; // 如果没有特色图片，使用默认的图片URL
            }
            ?>
            <img src="<?php echo $thumbnail_url; ?>" alt="img">
            <div class="blog-ctg"><?php echo get_post_type(); ?></div>
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
            <h4 class="post-title">
                <?php the_title(); ?>
            </h4>
            <p><?php the_content(); ?></p>
            <a href="<?php echo the_Permalink(); ?>" class="readMore">
                Read More
                <i class="fa fa-long-arrow-alt-right"></i>
            </a>
        </div>
    </div>
</div>