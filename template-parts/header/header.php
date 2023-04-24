<?php if (!defined('ABSPATH')) {
  exit;
} ?>
<!--这是头部-->
<!doctype HTML>

<head>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta Http-equiv="Content-Type" content="text/html; charset=<?php echo get_bloginfo('charset'); ?>" />
  <title>
    <?php bloginfo('name'); ?>
  </title>

  <meta name="description" content="<?php bloginfo('description'); ?>" />
  <?php wp_head(); ?>
</head>

<body>
  <div class="wellerpcb-wrapper">
    <!-- Main Header-->
    <header class="main-header <?php echo is_home() ? '' : 'not-home' ?>">
      <!--Main Box-->
      <div class="auto-container d-flex align-items-center justify-content-between">
        <div class="nav_btn_wrap">
          <div class="nav_btn top"></div>
          <div class="nav_btn center"></div>
          <div class="nav_btn bottom"></div>
        </div>
        <div class="logo">
          <a href="/">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo/logo.png ?>" alt="">
          </a>
        </div>
        <!-- Main Menu -->
        <nav class="main-menu">
          <?php
          function current_url()
          {
            $hosturl = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
            $url =  $_SERVER['REQUEST_URI'];
            return array(
              'hosturl' => $hosturl,
              'url' => $url
            );
          }
          $args = array(
            'sectionType' => 'main_menu'
          );
          $results = get_page_sections_tree_data($args, $orderby = 'menu_order');
          if (!empty($results['data']) && !empty($results['data'][0]->children)) {
          ?>
            <?php
            function renderSections($results, $parentId)
            {
            ?>
              <ul <?php
                  echo
                  $results[0]->parentId === $parentId ? 'class="navigation clearfix"' : '' ?>>
                <?php
                foreach ($results as $section) {
                ?>
                  <li <?php
                      $classname = 'class="';
                      $droplist = !empty($section->children) ? 'droplist' : '';
                      $current = (current_url()['hosturl'] === $section->linkTo || current_url()['url'] === $section->linkTo) ? 'current' : '';
                      $classname .= $droplist . $current . '"';
                      echo (!strpos($classname, 'droplist') && !strpos($classname, 'current')) ? '' : $classname
                      ?>>
                    <a href="<?php echo $section->linkTo ?>">
                      <?php echo $section->title ?>
                    </a>
                    <?php
                    if (!empty($section->children)) {
                      // 如果该对象中有列表，则递归遍历列表中的每个对象
                      renderSections($section->children, $parentId);
                    }
                    ?>
                  </li>
                <?php } ?>
              </ul>
            <?php } ?>
          <?php
            renderSections($results['data'][0]->children, $results['data'][0]->id);
          }
          ?>
        </nav>
        <!-- Main Menu End-->

        <div class="get-quote">
          Get Free Quote
        </div>
      </div>
      <!--End Header Lower-->

    </header>
    <!--End Main Header -->