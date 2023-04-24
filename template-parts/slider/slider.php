<?php if (!defined('ABSPATH')) {
    exit;
} ?>

<div class="slider_wrap">
    <?php if (get_post_type() === 'post') { ?>
        <h1>这是blog 的侧边栏</h1>
    <?php } else { ?>
        <section class="slider_menu">
            <h3><?php
                echo
                get_post_type() === 'pcb_fabrication' ? 'PCB Fabrication' : (get_post_type() === 'pcb_layout_design' ? 'PCB Layout & Design' : (get_post_type() === 'pcb_assembly' ? 'PCB Assembly' : 'Our Services'))
                ?></h3>
            <?php
            $args = array(
                'post_type' => get_post_type(),
                'posts_per_page' => -1, // 显示所有文章
            );
            $query = new WP_Query($args);
            if ($query->have_posts()) {
            ?>
                <ul class="menu">
                    <?php while ($query->have_posts()) {
                        $query->the_post(); ?>
                        <li class="<?php
                                    echo (current_url()['hosturl'] === get_the_permalink() ? 'active' : '');
                                    ?>">
                            <a href="<?php the_permalink() ?>">
                                <?php the_title(); ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } ?>
        </section>

    <?php } ?>

</div>