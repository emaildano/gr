

<div class="gray-panel profile-offset-wrapper">

  <?php
    /****************************************************************************
     * Lead Section
     */

    $image = get_field('lead_image'); $alt = $image['alt'];
    $lead_image_md = $image['sizes'][ '11x6_md' ];
    $lead_image_sm = $image['sizes'][ '11x6_sm' ];
    $title = get_field('lead_intro');
    $content = get_field('lead_content');
    $aside_content = get_field('lead_aside');
    $aside_images = get_field('lead_aside_images');

  ?>

  <div class="row profile-lead-image scroll-item scroll-start-zero" data-speed="-0.3" >
    <picture>
      <!--[if IE 9]><video style="display: none;"><![endif]-->
      <source srcset="<?= $image['sizes'][ '11x6_md' ] ?>" media="(min-width: 600px)" />
      <!--[if IE 9]></video><![endif]-->
      <img srcset="<?= $image['sizes'][ '11x6_sm' ] ?>" alt="<?= $image['alt'] ?>" />
    </picture>
  </div>

  <div class="row profile--lead-wrapper">
    <div class="profile--lead content-column scroll-item scroll-start-zero" data-speed="0.15">

      <div class="profile-lead--content">
        <h1 class="head-1"><?= $title ?></h1>
        <?= $content ?>
      </div>

      <?php if($aside_content) : ?>
        <div class="plus-aside profile-lead--aside">
          <?= $aside_content ?>
        </div>
      <?php endif; ?>

    </div>

    <?php if( have_rows('lead_aside_images') ) : ?>
      <div class="profile-lead--aside-images">
        <?php while( have_rows('lead_aside_images') ) : the_row();
          $image = get_sub_field('lead_aside_image');
          if($image) : ?>
            <picture>
              <img src="<?= $image['sizes'][ '5x3_sm' ] ?>" alt="<?= $image['alt'] ?>" />
            </picture>
          <?php endif;
        endwhile; ?>
      </div>
    <?php endif; ?>

  </div>


  <?php
    /****************************************************************************
     * Story Section
     */

    $image = get_field('story_image'); $alt = $image['alt'];
    $story_image_md = $image['sizes'][ '2x3_md' ];
    $story_image_sm = $image['sizes'][ '4x3_sm' ];

    $title = get_field('story_title');
    $content = get_field('story_content');

  ?>

  <div class="row profile-story">

    <div class="profile-story--image scroll-item" data-speed="-0.15">
      <picture>
        <!--[if IE 9]><video style="display: none;"><![endif]-->
        <source srcset="<?= $story_image_md ?>" media="(min-width: 400px)" />
        <!--[if IE 9]></video><![endif]-->
        <img srcset="<?= $story_image_sm ?>" alt="<?= $image['alt'] ?>" />
      </picture>
    </div>

    <div class="profile-story--content" >
      <div class="profile-story--content--wrapper">
        <h1 class="head-1"><?= $title ?></h1>
        <?= $content ?>
      </div>
    </div>

  </div>

</div>

