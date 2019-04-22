<?php
  global $post;
  get_template_part('templates/blog/blog-sidebar' );
?>


<section class="blog-entries blog-module single-module">
  <?php get_template_part('templates/blog/blog-entry-header' ); ?>

  <article>
    <?php

      $archive_text = get_field('display_archive_content');

      if(get_field('display_archive_content')) {
        the_field('archive_content');
      }

      // Start Flexible Content
      if( have_rows('single_page_content') ) :  while ( have_rows('single_page_content') ) : the_row();

          if( get_row_layout() == 'body_copy_layout' ):
            the_sub_field('body_copy');

          elseif( get_row_layout() == 'image_layout'):
            // ACF Image Object
            $image = get_sub_field('inline_image'); $alt = $image['alt'];
            $imageSize = $image['sizes'][ '11x6_md' ];
            echo '<div class="post--inline-image">';
              echo '<picture>';
                echo '<!--[if IE 9]><video style="display: none;"><![endif]-->';
                echo '<source srcset="' . $image['sizes'][ '11x6_md' ] . '" media="(min-width: 600px)" />';
                echo '<!--[if IE 9]></video><![endif]-->';
                echo '<img srcset="' . $image['sizes'][ '11x6_sm' ] . '" alt="' .$image['alt'] . '" />';
              echo '</picture>';
            echo '</div>';

          endif;

      endwhile; endif; // End Flexible Fields

    ?>

  </article>



  <?php

    // Setup Vars for share links
    $twitter_handle = get_field('twitter_handle', 'options');
    $twitter_handle = $twitter_handle ? '@' . $twitter_handle : get_bloginfo('name');
    $title = get_the_title() . ' by ' . $twitter_handle . ' // ';
    $titleURI = urlencode($title);
    $url = get_permalink();
    $urlURI = urlencode($url);
    $excerpt = get_the_excerpt();
    $excerptURI = urlencode($excerpt);
    $ftdImage = get_the_post_thumbnail();
    $ftdImageURI = urldecode($ftdImage);

  ?>

  <div class="share">
    <h4 class="head-4">Share</h4>
    <a href="http://www.facebook.com/share.php?u=<?php echo $urlURI; ?>&title=<?php echo $titleURI; ?>" class="share-link" target="blank">
      <i class="fa fa-facebook"></i>
    </a>
    <a href="http://twitter.com/home?status=<?= $titleURI ?>+<?php echo $urlURI; ?>" class="share-link" target="blank">
      <i class="fa fa-twitter"></i>
    </a>
    <a href="https://plus.google.com/share?url=<?php echo $urlURI; ?>" class="share-link" target="blank">
      <i class="fa fa-google-plus"></i>
    </a>
    <a href="mailto:?subject=News from Ground Reconsidered&body=<?php echo get_the_title() . ' - ' . $url; ?>">
      <i class="fa fa-envelope"></i>
    </a>
  </div>

</section>