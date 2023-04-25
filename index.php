<?php if (!defined('ABSPATH')) {
    exit;
} ?>
<!--首页模板-->
<?php my_header() ?>

<!-- Banner -->
<section class="banner page-screen banner-screen">
    <?php
    $args = array(
        'sectionType' => 'indexBanner',
    );
    $results = get_page_sections_tree_data($args);
    if (!empty($results['data'])) {
    ?>
        <div class="swiper" id="indexBanner">
            <div class="swiper-wrapper">
                <?php
                if (!empty($results['data'][0]->children)) {
                    foreach ($results['data'][0]->children as $key => $list) {
                ?>
                        <div class="swiper-slide">
                            <div class="title ani" data-wow-duration="2s">
                                <img src="<?php echo $results['data'][0]->imgUrl ?>" alt="<?php echo $results['data'][0]->title ?>">
                                <h2><?php echo $list->title ?></h2>
                                <h3><?php echo $list->description ?></h3>
                            </div>
                            <div class="img-box">
                                <img class="bg_img" src="<?php echo $list->imgUrl ?>">
                            </div>
                        </div>
                    <?php  } ?>
                <?php  } ?>
            </div>
        </div>
    <?php  } ?>
</section>


<section class="manufacturing-service padgap">
    <div class="auto-container">
        <?php
        $search_array = array(
            'sectionType' => 'section1',
        );
        $results = get_page_sections_tree_data($search_array);
        if (!empty($results['data'])) {
        ?>
            <div class="sec-title wow slideInUp" data-wow-duration="1.5s">
                <h2>
                    <?php echo $results['data'][0]->title ?>
                </h2>
                <div class="icon-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/wellerpcb-line.png" alt="">
                </div>
                <p>
                    <?php echo $results['data'][0]->description ?>
                </p>
            </div>

            <div class="row mask-move">
                <?php
                if (!empty($results['data'][0]->children)) {
                    foreach ($results['data'][0]->children as $key => $row) {
                ?>
                        <div class="col-sm-6 col-xl-3 wow <?php echo  $key < 2 ? 'bounceInLeft' : 'bounceInRight' ?>" data-wow-duration="1s" data-wow-delay="<?php echo  $key === 1 || $key === 2 ? '0' : '0.5s' ?>">
                            <div class="inner-box">
                                <div class="img-bg-wrap">
                                    <div class="img-bg">
                                        <img src="<?php echo $row->imgUrl ?>" alt="<?php echo $row->imgAlt ?>">
                                    </div>
                                    <div class="anchor-list-wrap">
                                        <ul class="anchor-list">
                                            <?php
                                            if (!empty($row->children)) {
                                                foreach ($row->children as $item) {
                                            ?>
                                                    <li>
                                                        <a href="<?php echo $item->linkTo ?>">
                                                            <?php echo  $item->title ?>
                                                        </a>
                                                    </li>
                                            <?php  }
                                            } ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="title">
                                    <h3>
                                        <?php echo $row->title ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                <?php  }
                } ?>
            <?php  } ?>
            </div>
    </div>
</section>

<!--  Market_Serviced_Section -->
<?php
$search_array = array(
    'sectionType' => 'section6',
);
$results = get_page_sections_tree_data($search_array);
if (!empty($results['data'])) {
?>
    <section class="market-serviced-section padgap">
        <div class="auto-container">
            <div class="sec-title wow slideInUp" data-wow-duration="1.5s">
                <h2>
                    <?php echo $results['data'][0]->title ?>
                </h2>
                <div class="icon-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/wellerpcb-line.png" alt="">
                </div>
                <p>
                    <?php echo $results['data'][0]->description ?>
                </p>
            </div>
            <div class="market-serviced bounce wow" data-wow-duration="3s">
                <div class="menu-center">
                    <div class="inner_box_wrap">
                        <svg style="visibility: hidden; position: absolute;" width="0" height="0" xmlns="http://www.w3.org/2000/svg" version="1.1">
                            <defs>
                                <filter id="goo">
                                    <feGaussianBlur in="SourceGraphic" stdDeviation="4" result="blur" />
                                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo" />
                                    <feComposite in="SourceGraphic" in2="goo" operator="atop" />
                                </filter>
                            </defs>
                        </svg>
                        <div class="inner_box">
                            <div class="num">8</div>
                            <div class="des">OUR MARKET DISTRIBUTION</div>
                        </div>
                    </div>
                </div>
                <?php
                if (!empty($results['data'][0]->children)) {
                    foreach ($results['data'][0]->children as $key => $item) {
                ?>
                        <a href="javascript:void(0)" title="<?php echo $item->title ?>" class=" menu-item menu-<?php echo $key ?> ">
                            <div class="inner_box_wrap">
                                <div class="inner_box">
                                    <?php echo $item->icon ?>
                                    <h3><?php echo $item->title ?></h3>
                                    <div class="line"></div>
                                </div>
                            </div>
                        </a>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </section>
<?php  } ?>

<!-- Banner -->
<?php
$search_array = array(
    'sectionType' => 'section7',
);
$results = get_page_sections_tree_data($search_array);
if (!empty($results['data'])) {
?>
    <section class="banner-partner padgap">
        <div class="sec-title wow slideInUp" data-wow-duration="1.5s">
            <h2>
                <?php echo $results['data'][0]->title ?>
            </h2>
            <div class="icon-img">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/wellerpcb-line.png" alt="">
            </div>
            <p>
                <?php echo $results['data'][0]->description ?>
            </p>
        </div>
        <div class="swiper" id="PartnerSwiper">
            <div class="swiper-wrapper">
                <?php
                if (!empty($results['data'][0]->children)) {
                    foreach ($results['data'][0]->children as $list) {
                ?>
                        <div class="swiper-slide">
                            <img src="<?php echo $list->imgUrl ?>" alt="">
                        </div>
                <?php  }
                } ?>
            </div>
        </div>
    </section>
<?php  } ?>

<!-- Services_Section -->
<section class="services-section padgap">
    <div class="auto-container">
        <?php
        $search_array = array(
            'sectionType' => 'section3',
        );
        $results = get_page_sections_tree_data($search_array);
        if (!empty($results['data'])) {
        ?>
            <div class="sec-title wow slideInUp" data-wow-duration="1.5s">
                <h2>
                    <?php echo $results['data'][0]->title ?>
                </h2>
                <div class="icon-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/wellerpcb-line.png" alt="">
                </div>
                <p>
                    <?php echo $results['data'][0]->description ?>
                </p>
            </div>
            <div class="list_wrap">
                <?php
                if (!empty($results['data'][0]->children)) {
                    my_list('iconText1', $results['data'][0]->children);
                } ?>
            </div>
            <div class="chooseDtail_text_wrap">
                <div class="chooseDtail_text wow" data-wow-duration="1.5s">
                    <div class="close_btn">X</div>
                    <p class="content"></p>
                </div>
            </div>
        <?php  } ?>
    </div>
</section>

<!-- See Banner -->
<?php
$search_array = array(
    'sectionType' => 'section8',
);
$results = get_page_sections_tree_data($search_array);
if (!empty($results['data'])) {
?>
    <section class="banner-customers-say padgap">
        <div class="auto-container">
            <div class="sec-title wow slideInUp" data-wow-duration="1.5s">
                <h2>
                    <?php echo $results['data'][0]->title ?>
                </h2>
                <div class="icon-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/wellerpcb-line.png" alt="">
                </div>
            </div>

            <div class="swiper" id="myCustomersSwiper">
                <div class="swiper-wrapper">
                    <?php
                    if (!empty($results['data'][0]->children)) {
                        foreach ($results['data'][0]->children as $list) {
                            $imgUrl = $list->imgUrl;
                            $title = $list->title;
                            $alias = $list->alias;
                            $description = $list->description;
                            $imgAlt = $list->imgAlt;
                    ?>
                            <div class="swiper-slide">
                                <div class="back">
                                    <div class="info_group">
                                        <div class="pic">
                                            <img src="<?php echo $imgUrl ?>" alt="">
                                        </div>
                                        <div class="icon" data-count="5">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                        <h2 class="tit" data-size="20px">
                                            <?php echo $title ?>
                                        </h2>
                                        <div class="user_name" data-size="18px">
                                            <?php echo $alias ?>
                                        </div>
                                        <div class="info ">
                                            <p>
                                                <?php echo $description ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="position">
                                        <?php echo $imgAlt ?>
                                    </div>
                                </div>
                            </div>
                    <?php  }
                    } ?>
                </div>
            </div>
        </div>
    </section>
<?php  } ?>


<!-- Subscribe_Section -->
<?php
$search_array = array(
    'sectionType' => 'section10',
);
$results = get_page_sections_tree_data($search_array);
if (!empty($results['data'])) {
?>
    <section class="subscribe-section padgap" style="background: url(<?php echo $results['data'][0]->imgUrl ?>) fixed center center no-repeat;background-size: 100%;">
        <div class="text_wrap">
            <h4>Let's Start A New PCB's Project Today</h4>
            <button type="button" id="subscribe-newslatters" class="theme-btn get-quote btn-style-one wow rubberBand" data-wow-duration="2.5s">Get instant quote</button>
        </div>
    </section>
<?php  } ?>



<!-- News_Section -->
<section class="banner-blog padgap">
    <div class="auto-container">
        <?php
        $search_array = array(
            'sectionType' => 'section9',
        );
        $results = get_page_sections_tree_data($search_array);
        if (!empty($results['data'])) {
        ?>
            <!-- Sec Title -->
            <div class="sec-title wow slideInUp" data-wow-duration="1.5s">
                <h2>
                    <?php echo $results['data'][0]->title ?>
                    <br>
                    <?php echo $results['data'][0]->description ?>
                </h2>
                <div class="icon-img">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/wellerpcb-line.png" alt="">
                </div>
            </div>
        <?php  } ?>

        <?php
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 5,
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
        ?>
            <div class="swiper" id="blogSwiper">
                <div class="swiper-wrapper">
                    <?php
                    while ($query->have_posts()) {
                        $query->the_post();
                    ?>
                        <div class="swiper-slide">
                            <a href=" <?php the_permalink();  ?>" class="block">
                                <div class="pic">
                                    <div class="scale-img">
                                        <?php the_post_thumbnail();  ?>
                                    </div>
                                </div>
                                <div class="bot-info">
                                    <h2 class="new-title">
                                        <?php the_title();  ?>
                                    </h2>
                                    <div class="new-info">
                                        <?php the_excerpt();  ?>
                                    </div>
                                    <div class="btn-wrap">
                                        <span class="btn"> Read More
                                        </span>
                                        <div class="date">
                                            <?php the_time('Y-m-d'); ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php  } ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        <?php  } else { ?>
            <div class="no_post">
                没有文章
            </div>
        <?php  } ?>

    </div>
</section>

<?php my_footer() ?>