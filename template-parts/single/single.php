<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<!--文章模板-->
<?php my_header();
?>

<div class="single_page <?php echo 'single_page' . get_post_type(); ?>">
    <div class="wellerpcb-breadcrumbs">
        <div class="breadcrumbs-img">
            <img src="<?php echo get_template_directory_uri() ?>'/assets/images/bg/breadcrumbsDefault.jpg' " alt="Breadcrumbs Image">
        </div>
        <div class="breadcrumbs-text white-color">
            <h1 class="page-title"><?php the_title() ?></h1>
            <ul>
                <li>
                    <a class="active" href="/">Home &gt;</a>
                </li>
                <li class="active">
                    <?php
                    echo
                    get_post_type() === 'pcb_fabrication' ? 'PCB Fabrication' : (get_post_type() === 'pcb_layout_design' ? 'PCB Layout & Design' : (get_post_type() === 'pcb_assembly' ? 'PCB Assembly' : 'Our Services'))
                    ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="auto-container">
        <div class="content_wrapper">
            <?php wp_reset_postdata() ?>
            <?php the_content() ?>
        </div>
    </div>
</div>


<?php my_footer() ?>