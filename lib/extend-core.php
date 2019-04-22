<?php

namespace Apollo\Extend\Core;

// IMAGE SIZES
// ============================================================

add_image_size('11x6_lg', 1800, 938, true);
add_image_size('11x6_md', 1200, 625, true);
add_image_size('11x6_sm', 600, 312, true);

add_image_size('4x3_md', 900, 651, true);
add_image_size('4x3_sm', 600, 434, true);

add_image_size('2x3_md', 700, 860, true);
add_image_size('2x3_sm', 400, 491, true);

add_image_size('5x3_lg', 1800, 1292, true);
add_image_size('5x3_md', 900, 646, true);
add_image_size('5x3_sm', 500, 358, true);

add_image_size('1x1', 600, 600, true);


// WP CORE
// ============================================================

// Allow SVG uploads (1)
function mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes',  __NAMESPACE__ . '\\mime_types');

// Fix SVG Thumb Display (1)
function fix_svg_thumb_display() {
  echo '
    <style type="text/css">
      td.media-icon img[src$=".svg"], img[src$=".svg"].attachment-post-thumbnail {
        width: 100% !important;
        height: auto !important;
      }
    </style>
  ';
}

add_action('admin_head',  __NAMESPACE__ . '\\fix_svg_thumb_display');



// WP HEAD FUNCTIONS
// ============================================================
// *FUTURE*: WE SHOULD ADD THESE AS ENQUEUE SCRIPT AND STYLES /////////////////////////////////////

// Typekit
function typekit() {
  echo '<script type="text/javascript" src="//use.typekit.net/' . TYPEKIT_ID . '.js"></script>';
  echo '<script type="text/javascript">try{Typekit.load();}catch(e){}</script>';
}

if (TYPEKIT_ID) {
  add_action('wp_head', __NAMESPACE__ . '\\typekit', 1);
}


// CREDITS:
// (1) https://css-tricks.com/snippets/wordpress/allow-svg-through-wordpress-media-uploader/
