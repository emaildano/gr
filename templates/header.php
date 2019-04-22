<?php
  use Apollo\Extend\Util;
?>

<header class="navigation" role="banner">
  <div class="container">

    <a href="<?= esc_url(home_url('/')); ?>" class="site-logo">
      <?php get_template_part('/public/images/logo-image.svg' ); ?>
    </a>

    <nav id="nav-menu" class="navigation--menu" role="navigation">
      <?= Util\Ground_Nav() ?>
    </nav>

    <?php if( is_post_type_archive('projects') || is_singular('projects') ) { ?>
      <div class="navigation--filter">
        <a id="js--nav-filter-toggle" class="nav-filter-toggle" href="<?= get_post_type_archive_link('projects') ?>">Filter Projects</a>
      </div>
    <?php } ?>


    <a id="filter-toggle" class="nav-toggle" href="#">
      <span class="hamburger-bun">
        <span class="hamburger"></span>
        <span class="hamburger"></span>
        <span class="hamburger"></span>
      </span>
    </a>


  </div>
</header>

<?php

  /****************************************************************************
   * Filter Section
   */
  if( is_post_type_archive('projects') || is_singular('projects') ) :

    // Get the terms
    $args = [
      'orderby' => 'id',
      'order' => 'ASC'
    ];
    $terms = get_terms('project_type', $args);
    $link = get_post_type_archive_link('projects');

    // Setup base class values
    $class = 'filter-projects--link';
    if( is_post_type_archive('projects') )                                // TODO TK Remove if projects only filter stays
      $class .= ' js--filter-projects--link';

    $html = '';

    // Create a link for each term
    foreach ($terms as $term) {
      $term_class = $class;
      $attr_value = null;
      $attr = null;

      // Add JS attrs on projects archive
      if( is_post_type_archive('projects') ) {                            // TODO TK Remove if projects only filter stays
        $attr_value = 'filter-' . $term->slug;
        $attr = 'data-type="filter-' . $term->slug . '" ';
      }

      // Determine if link should be active or not
      if( isset($_GET['type']) ) {
        if ($attr_value === $_GET['type']) {
          $term_class .= ' active';
        }
      }

      // If link is archive link
      if( $term->slug === 'archive' )
        $term_class .= ' filter-archive';

      // Output link as html
      $html .= '<a class="' . $term_class . '" href="' . $link . '?type=filter-' . $term->slug . '" ' . $attr . '>';
      $html .= $term->name . '</a>';
    }

    // Add View All link
    $html .= '<a class="' . $class . '" href="' . $link . '?type=filter-all" data-type="filter-all">View All</a>';

  ?>
  <nav id="nav-filter" class="filter-projects">

    <p id="js--resp-filter-title" class="resp-filter-title">
      <span class="js--title">Projects</span>
      <i class="fa fa-angle-down"></i>
    </p>

    <div id="js--filter--link-wrapper" class="filter-projects--link-wrapper">
      <a href="#" id="close-features" class="nav-filter-toggle filter-projects--close">
        <?php get_template_part( 'assets/images/plus.svg' ); ?>
      </a>
      <?= $html ?>
    </div>

  </nav>

<?php endif;





