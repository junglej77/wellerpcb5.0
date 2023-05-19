<?php if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
    <div class="papri-single-wraper">
        <div class="single-ctg-img">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/bg/breadcrumbsDefault.jpg ?>" alt="img">
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
            <h4><a href="#" class="post-title"><?php the_title(); ?></a></h4>
            <p><?php the_excerpt(); ?></p>
            <a href="<?php echo the_Permalink(); ?>" class="btn btn-typ5">
                Read More
                <i class="fa fa-long-arrow-right"></i>
            </a>
        </div>
    </div>
</div>