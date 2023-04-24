<?php if (!defined('ABSPATH')) {
    exit;
}
?>
<?php foreach ($args as $key => $list) { ?>
    <div class="list-style-one col-md-3 wow zoomIn" data-wow-duration="1.5s">
        <a href="#">
            <div class="pic_wrap">
                <div class="pic">
                    <img src="<?php echo $list->imgUrl ?>" alt="<?php echo $list->imgAlt ?>">
                </div>
            </div>
            <div class="info">
                <h3>
                    <?php echo $list->title ?>
                </h3>
            </div>
        </a>
    </div>
<?php } ?>