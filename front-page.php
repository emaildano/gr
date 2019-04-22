<?php

  /****************************************************************************
   * About Section
   */

  // $image = get_field('about_image'); $alt = $image['alt'];
  // $imageSize = $image['sizes'][ '4x3_md' ];

  $images = get_field('about_images');
  $count = count($images);


  $content = get_field('about_content');
  $link = get_field('about_link');

?>

<div class="row-table about">
  <div class="column-half">

    <?php if($count > 1) : // If there needs to be a slider ?>

        <div id="js-slider" class="slide-wrapper">
          <?php while( have_rows('about_images') ) : the_row();
            $image = get_sub_field('about_image'); ?>

            <div class="">
              <img src="<?= $image['sizes'][ '4x3_md' ] ?>" alt="<?= $image['alt'] ?>" />
            </div>

          <?php endwhile; ?>
        </div>

    <?php else : ?>
        <?php
          $image = $images[0]['about_image']['sizes'][ '4x3_md' ];
          $alt = $images[0]['about_image']['alt'];
        ?>
        <img src="<?= $image ?>" alt="<?= $alt ?>" />

    <?php endif; ?>
  </div>

  <div class="column-half about--content">
    <?= $content ?>
    <a href="<?= $link ?>" class="read-more">Learn More</a>
  </div>
</div>


<?php

  /****************************************************************************
   * Featured Projects Section
   */
  $content = get_field('featured_projects_content');
  $featured = get_field('featured_projects');

?>

<div class="gray-panel featured-projects">

  <div class="featured-projects--content row">
    <p><?= $content ?></p>
  </div>

  <div class="row">

    <?php
      foreach( $featured as $post) {
        setup_postdata( $post );
        get_template_part('templates/projects/project-mod');
      }
      wp_reset_postdata();
    ?>

  </div>

</div>



