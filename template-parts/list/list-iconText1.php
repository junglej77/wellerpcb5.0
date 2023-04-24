<?php if (!defined('ABSPATH')) {
    exit;
}
?>
<?php
$count = 0;
foreach ($args as $key => $list) {
    $count += $key;
?>

    <div class="service-block wow <?php
                                    echo $key % 3 === 0 ? 'bounceInLeft' : ($key % 3 === 2 ? 'bounceInRight' : 'zoomIn');
                                    echo $key > 2 ? ' upToTop' : ''; ?>" data-wow-duration="1.5s">
        <div class="inner-box-wrap chooseDtail">
            <div class="inner-box">
                <div class="content-center">
                    <div class="content">
                        <div class="icon <?php echo $list->imgAlt ?>"></div>
                        <h4>
                            <?php echo $list->title ?>
                        </h4>
                        <p class="text">
                            <?php echo $list->description ?>
                        </p>
                        <span class="detail"> Detail </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="service-block none <?php echo $count > 2 ? 'upToTop' : ''; ?>">
        <div class="inner-box-wrap">
        </div>
    </div>
<?php } ?>