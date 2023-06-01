<?php if (!defined('ABSPATH')) {
  exit;
} ?>
<!--底部-->

<!-- End Subscribe_Section -->
<!-- Main Footer -->
<footer class="main-footer">
  <div class="auto-container">
    <!--Widgets Section-->
    <?php
    $args = array(
      'sectionType' => 'footer_menu'
    );
    $results = get_page_sections_tree_data($args);
    if (!empty($results['data'])) {
    ?>
      <div class="widgets-section">
        <h2 class="title_wrap">
          <div class="logo">
            <a href="/">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo.png" alt="" />
            </a>
          </div>
        </h2>
        <div class="desc">
          <p>
            <?php echo $results['data'][0]->description ?>
          </p>
        </div>
        <div class="footer_anchor_list_wrap">

          <div class="footer_anchor_list">
            <!--Footer Column-->
            <?php
            if (!empty($results['data'][0]->children)) {
              foreach ($results['data'][0]->children as $key => $list) {
            ?>
                <div class="footer-column">
                  <div class="widget-content">
                    <h2 class="widget-title"><?php echo $list->title ?></h2>
                    <?php
                    if (!empty($list->children)) {
                    ?>
                      <ul class="user-links">
                        <?php
                        foreach ($list->children as $key1 => $list1) {
                        ?>
                          <li>
                            <?php echo $list1->linkTo ? '<a href=' . $list1->linkTo . '>' : '' ?>
                            <?php echo $list1->title ?>
                            <?php echo  $list1->linkTo ? '</a>' : '' ?>
                          </li>
                        <?php  } ?>
                      </ul>
                    <?php  } ?>
                  </div>
                </div>
              <?php  } ?>
            <?php  } ?>
          </div>

          <ul class="icon_wrap_list">
            <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
            <li><a href="#"><i class="fab fa-youtube"></i></a></li>
            <li><a href="#"><i class="fab fa-twitter"></i></a></li>
            <li><a href="#"><i class="fab fa-instagram"></i></a></li>
          </ul>
        </div>
      </div>
    <?php } ?>

    <!--Footer Bottom-->
    <div class="footer-bottom">
      <p class="copyright-text">&copy;
        Copyrights © 2005 - 2023 All Rights Reserved by Weller Technology Co. Ltd.
      </p>
    </div>
  </div>
</footer>
<!--End Main Footer -->
</div><!-- End Page Wrapper -->

<!-- Scroll_To_Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>
<?php wp_footer(); ?>
</body>

</html>