<?php

  /**
   * Clients Page
   * Archive of clients CPT in list form
   *
   * ***************************************************************************
   * Lead Content Section
   */
  $lead = get_field('client_page_lead', 'options');
  $content = get_field('client_page_content', 'options');
  $aside = get_field('client_page_aside', 'options');

?>
  <div class="page-lead clients-page">
    <div class="page-lead--lead">
      <h1 class="head-1"><?= $lead ?></h1>
      <?= $content ?>
    </div>
    <div class="plus-aside page-lead--aside">
      <p><?= $aside ?></p>
    </div>
  </div>



<?php

  /*****************************************************************************
   * Client List Filter
   */

  $args = [
    // 'orderby' => 'id',
    // 'order'   => 'ASC',
  ];

  $terms = get_terms('client_type', $args);
  $html = '<h3 class="head-5">View</h3>';
  $html .= '<p id="j2--client-toggle" class="resp-client-toggle"><span>Category</span> <i class="fa fa-angle-down"></i></p>';
  $html .= '<ul class="client-filter--list">';

  foreach($terms as $term) {
    $html .= '<li>';
    $html .= '<a class="client-fliter--link " href="#' . $term->slug . '" data-target="'  . $term->slug . '">';
    $html .= $term->name . '</a>';
    $html .= '</li>';
  }

  $html .= '</ul>';

?>

<nav class="client-filter">
  <?= $html ?>
</nav>



<?php

  /*****************************************************************************
   * Client List
   */

  if( have_posts() ):
    echo '<section class="client-list">';

      while ( have_posts() ) : the_post();

        global $post;
        $style = 'head-3';
        $terms = get_the_terms( $post, 'client_type' );
        $filter = $terms ? $terms[0]->slug : '';

        echo '<div class="client-list--entry ' . $filter .'">';
          echo '<p class="head-3">' . get_the_title() . '</p>';
        echo '</div>';
      endwhile;

      echo '<div id="masonry-measure"></div>';
    echo '</section>';
  endif;

?>





