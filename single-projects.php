<?php
  global $post;
  $meta = get_post_meta( $post->ID );

  /****************************************************************************
   * Featured Image and Content
   */

  $ftd_img       = get_field('featured_image');
  $ftd_alt       = $ftd_img['alt'];
  $ftd_lg        = $ftd_img['sizes'][ '11x6_lg' ];  // > 1200
  $ftd_md        = $ftd_img['sizes'][ '11x6_md' ];  // > 600
  $ftd_sm        = $ftd_img['sizes'][ '4x3_sm' ];   // > init
  $ftd_max_width = get_field('title_max_width');
  $style         = $ftd_max_width ? 'style="max-width: ' . $ftd_max_width . '"' : '';

  $ftd_aside     = get_field('featured_image_aside');
  $intro_content = get_field('intro_content');
  $client        = $meta['client'][0];
  $location      = $meta['location'][0];
  $ftd_detail    = get_field('featured_detail');
  $details       = get_field('details');

  // Conditional Vars
  $ftd_img_class = 'project--ftd--img';
  if(!$ftd_aside)
    $ftd_img_class .= ' no-aside';



?>

<div class="row project--ftd">

  <?php if($ftd_aside) : ?>
    <div class="plus-aside bump plus--ftd--aside">
      <p><?= $ftd_aside ?></p>
    </div>
  <?php endif; ?>

  <div class="<?= $ftd_img_class ?>" >

    <picture>
      <!--[if IE 9]><video style="display: none;"><![endif]-->
      <source srcset="<?= $ftd_lg ?>" media="(min-width: 1200px)" />
      <source srcset="<?= $ftd_md ?>" media="(min-width: 600px)" />
      <!--[if IE 9]></video><![endif]-->
      <img srcset="<?= $ftd_sm ?>" alt="<?= $ftd_alt ?>" class="scroll-item scroll-start-zero" data-speed="-0.3" />
    </picture>

  </div>

</div>


<div class="project--content">

  <div class="row">
    <h1 class="project--content--title head-1 large" <?= $style ?>>
      <?= get_the_title() ?>
    </h1>
  </div>

  <div class="row project--content--content-wrapper">
    <div class="project--content--content">
      <?= $intro_content ?>
    </div>

    <div class="project--content--details plus">
      <ul class="list-unstyled">
        <?php
          if($client) echo '<li class="head-3">' . $client . '</li>';
          if($location) echo '<li class="head-3">' . $location . '</li>';
          if($ftd_detail) echo '<li class="head-3">' . $ftd_detail . '</li>';

          if( have_rows('details') ) : while( have_rows('details') ) : the_row();
            echo '<li class="head-3">' . get_sub_field('detail') . '</li>';
          endwhile; endif; // End Repeater
        ?>
      </ul>
    </div>

  </div>
</div>


<?php






  /****************************************************************************
   * Image Layouts
   */

  // Start Flexible Content
  if( have_rows('image_layouts') ) :
    echo '<div class="row project--layouts">';

      while ( have_rows('image_layouts') ) : the_row();





        /******* Before and After Layout *************************************/

        if( get_row_layout() == 'before_and_after_layout' ):
          $before_side = get_sub_field('before_image_position');

          // Before Image
          $before_img  = get_sub_field('before_image');
          $before_alt  = $before_img['alt'];
          $before_src  = $before_img['sizes']['4x3_sm'];
          $before_quote = get_sub_field('before_caption');


          // After Image
          $after_img  = get_sub_field('after_image');
          $after_alt  = $after_img['alt'];
          $after_src  = $after_img['sizes']['4x3_md'];


          // Quote
          $quote      = get_sub_field('quote');
          $quote_el = '';


          // Build Quote Content
          if($quote) {
            $quote_attr  = get_sub_field('quote_attribution');
            $quote_class = 'project--images--quote';
            $quote_class .= $before_side === 'left' ? ' quote-' . $before_side : ' quote-full-width';
            $quote_el   .= '<div class="project--images--quote quote-' . $before_side . '"';
            $quote_el   .= '';
            $quote_el   .= '>';
            $quote_el   .=   '<p class="quote">' . $quote . '</p>';
            if($quote_attr) $quote_el .= '<p class="quote-attr">' . $quote_attr . '</p>';
            $quote_el   .= '</div>';
          }

          // Wrapper
          $images_wrapper_open = '<div class="row project--images--wrapper before-to-' . $before_side . '">';
          $images_wrapper_close = '</div>';

          // Build Before Image Element
          $classes    = 'project--images--before fade-in';
          $classes   .= $before_quote ? ' before-tag' : '';
          $before_el  = '<div class="' . $classes . '"';
          $before_el .= $before_side === 'right' ?  ' ' : '';
          $before_el .= '>';
          $before_el .= '<picture>';
          $before_el .=   '<!--[if IE 9]><video style="display: none;"><![endif]-->';
          $before_el .=   '<source srcset="' . $before_img['sizes']['4x3_sm'] . '" media="(min-width: 1000px)" />';
          $before_el .=   '<source srcset="' . $before_img['sizes']['4x3_md'] . '" media="(min-width: 600px)" />';
          $before_el .=   '<!--[if IE 9]></video><![endif]-->';
          $before_el .=   '<img srcset="' . $before_img['sizes']['4x3_sm'] . '" alt="' . $before_alt . '" />';
          $before_el .= '</picture>';
          $before_el .=   $before_quote ? '<p class="plus before">Before</p>' : '';
          $before_el .= '</div>';

          // Build After Image Element
          $after_el  = '<div class="project--images--after scroll-item fade-in" data-speed="0.1"';
          // $after_el .= ' data-bottom-top="transform: translate3d(0px, 3vw, 0px);" data-top-bottom="transform:translate3d(0px, 0vw, 0px)"';
          $after_el .= '>';
          $after_el .=   '<img class="fade-in" src="' . $after_src . '" alt="' . $after_alt . '"/>';
          $after_el .= '</div>';



          if($before_side === 'left') {
            echo $images_wrapper_open;
              echo '<div class="before-left-wrapper">';
                echo $before_el;
                echo $quote_el;
              echo '</div>';
              echo $after_el;
            echo $images_wrapper_close;

          } else {
            echo $images_wrapper_open;
              echo $after_el;
              echo $before_el;
              echo $quote_el;
            echo $images_wrapper_close;
          }





        /******* Full Width Image Layout *************************************/

        elseif( get_row_layout() == 'full_width_image' ) :

          $image = get_sub_field('full_image'); $alt = $image['alt'];
          $imageSrc = $image['sizes'][ '11x6_lg' ];

          $image_lg        = $image['sizes'][ '11x6_lg' ];  // > 1200
          $image_md        = $image['sizes'][ '11x6_md' ];  // > 600
          $image_sm        = $image['sizes'][ '4x3_sm' ];   // > init

          $quote = get_sub_field('full_image_quote');


          echo '<div class="row project--images--wrapper full-width">';
            echo '<div class="project--images--full-width fade-in">';
              echo '<picture>';
                echo '<!--[if IE 9]><video style="display: none;"><![endif]-->';
                echo '<source srcset="' . $image_lg . '" media="(min-width: 1200px)" />';
                echo '<source srcset="' . $image_md . '" media="(min-width: 600px)" />';
                echo '<!--[if IE 9]></video><![endif]-->';
                echo '<img srcset="' . $image_sm . '" alt="' . $ftd_alt . '" />';
              echo '</picture>';
            echo '</div>';

            // Build Quote Content
            if($quote) {
              $quote_el    = '';
              $quote_attr  = get_sub_field('full_image_quote_attribution');
              $quote_el   .= '<div class="project--images--quote quote-full-width" data-bottom-top="transform: translate3d(0px, 0vw, 0px);" data-top-bottom="transform:translate3d(0px, -12vw, 0px)">';
              $quote_el   .=   '<p class="blue bold">' . $quote . '</p>';
              if($quote_attr) $quote_el .= '<p class="blue quote-attr">' . $quote_attr . '</p>';
              $quote_el   .= '</div>';

              echo $quote_el;
            }

          echo '</div>';



        endif;

      endwhile;
    echo '</div>';
  endif;


?>






