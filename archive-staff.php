<?php

  /**
   * People Page
   * Archive of staff CPT in list form
   *
   * ***************************************************************************
   * Lead Content Section
   */
  $lead = get_field('people_page_lead', 'options');
  $content = get_field('people_page_content', 'options');
  $aside = get_field('people_page_aside', 'options');

?>
  <div class="page-lead staff-page">
    <div class="page-lead--lead">
      <h1 class="head-1"><?= $lead ?></h1>
      <?= $content ?>
    </div>
    <div class="plus-aside page-lead--aside">
      <p><?= $aside ?></p>
    </div>
  </div>





<?php

  if(have_posts()) :
    echo '<div class="row staff-module-wrapper">';
      while(have_posts()) : the_post();
          // ACF Image Object
          $image = get_field('headshot');

          $name = get_the_title();
          $position = get_field('position');
        ?>

        <div class="staff-module bump-nth fade-in">
          <a href="<?= get_permalink() ?>">
            <picture>
              <source srcset="<?= $image['sizes'][ '2x3_md' ] ?>" media="(min-width: 400px)" />
              <img srcset="<?= $image['sizes'][ '2x3_sm' ] ?>" alt="<?= $image['alt'] ?>" />
            </picture>
          </a>

          <div class="staff-module--content">
            <h3 class="head-4"><?= get_the_title() ?></h3>
            <p class="head-3"><?= get_field('position') ?></p>
            <a href="<?= get_permalink() ?>" class="read-more light small">Profile</a>
          </div>

        </div>

      <?php endwhile;
    echo '</div>';
  endif;
