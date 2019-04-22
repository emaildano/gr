<?php

  $link_option = get_field('link_to_single');
  if( is_single() ) {
    $link_option = false;
  }


  /****************************************************************************
   * Featured Image
   */

  $image_type = get_field('featured_image_option');

  // Static Image
  if($image_type === 'static') :
    // ACF Image Object
    $image = get_field('featured_image');
    $alt = $image['alt'];
    $image_md = $image['sizes'][ '5x3_md' ];
    $image_sm = $image['sizes'][ '5x3_sm' ];


    echo '<div class="blog-module--image">';
      if($link_option) echo '<a href="' . get_the_permalink() . '">';

        echo '<picture>';
          echo '<source srcset="' . $image_md . '" media="(min-width: 600px)" />';
          echo '<img srcset="' . $image_sm . '" alt="' . $alt . '" />';
        echo '</picture>';

      if($link_option) echo '</a>';
    echo '</div>';


  // Slider Image
  elseif($image_type === 'slider') :
    echo '<div class="blog-module--image blog-module--slider">';
      if( have_rows('featured_slider') ) : while( have_rows('featured_slider') ) : the_row();

        $image = get_sub_field('featured_slider_image');
        $alt = $image['alt'];
        $image_md = $image['sizes'][ '5x3_md' ];
        $image_sm = $image['sizes'][ '5x3_sm' ];

        echo '<div class="blog-module--slider--image">';
          echo '<picture>';
            echo '<source srcset="' . $image_md . '" media="(min-width: 600px)" />';
            echo '<img srcset="' . $image_sm . '" alt="' . $alt . '" />';
          echo '</picture>';
        echo '</div>';

      endwhile; endif;

    echo '</div>';


  endif;




  /****************************************************************************
   * Meta and Excerpt
   */

  $title = '<h2 class="head-2">';
  if($link_option)  $title .= '<a href="' . get_the_permalink() . '">';
  $title .= get_the_title();
  if($link_option)  $title .= '</a>';
  $title .= '</h2>';

?>

<header class="blog-module--meta">
  <h3 class="head-3"><?= get_the_date('F j, Y') ?></h3>
  <?= $title ?>
</header>