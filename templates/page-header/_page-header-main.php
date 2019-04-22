<?php // Main Page Header File

if(is_front_page()) :
  // Lead Content
  $lead = get_field('page_lead');

  // Lead Project
  $project = get_field('page_lead_project');
  $id = $project->ID;
  $title = $project->post_title;
  $link = get_permalink( $id );
  $image      = get_field('featured_image', $id); $alt = $image['alt'];
  $imageSrc   = $image['sizes'][ '11x6_lg' ];
  $imageHTML  = '<img src="' . $imageSrc . '" alt="' . $alt . '" />';

  ?>

  <div class="page-header">
    <div class="container swipe">

      <div id="drag-container" class="swiper">

        <!-- Responsive Content -->
        <div class="swipe--resp-img-wrapper">
          <picture>
            <source srcset="<?= $image['sizes'][ '4x3_md' ] ?>" media="(min-width: 400px)" />
            <img srcset="<?= $image['sizes'][ '1x1' ] ?>" alt="<?= $alt ?>" />
          </picture>
          <!-- <img src="<?= $image['sizes'][ '1x1' ] ?>" alt="<?= $alt ?>" /> -->
          <div class="bkg-fade-dark"></div>
        </div>


        <div class="swiper--image" style="background-image: url(<?= $imageSrc ?>)"></div>
        <div class="bkg-fade-dark desktop"></div>

        <div id="swipe-wrapper" class="swiper--content-wrapper">
          <div id="dragged-content" class="swiper--content">
            <h2 class="head-2 large"><?= $lead ?></h2>
            <a class="read-more small blue swiper--resp-link" href="<?= get_post_type_archive_link('projects') ?>">Learn More</a>
          </div>
        </div>

      </div>

      <div id="dragged-title" class="swiper--project-title">
        <p class="head-3 white">Featured Project</p>
        <h2 class="head-2 white"><?= $title ?></h2>
        <a href="<?= $link ?>" class="read-more small blue">View Project</a>
      </div>

      <div id="drag-control" class="swiper--drag"></div>

      <div class="swipe--background">
        <?= $imageHTML ?>
      </div>

    </div>

  </div>

<?php endif;