<?php

namespace Apollo\Assets;

/**
 * Scripts and stylesheets
 *
 * Enqueue stylesheets in the following order:
 * 1. /theme/dist/styles/main.css
 *
 * Enqueue scripts in the following order:
 * 1. Latest jQuery via Google CDN (if enabled in config.php)
 * 2. /theme/dist/scripts/modernizr.js
 * 3. /theme/dist/scripts/main.js
 *
 * Google Analytics is loaded after enqueued scripts if:
 * - An ID has been defined in config.php
 * - You're not logged in as an administrator
 */

class JsonManifest {
  private $manifest;

  public function __construct($manifest_path) {
    if (file_exists($manifest_path)) {
      $this->manifest = json_decode(file_get_contents($manifest_path), true);
    } else {
      $this->manifest = [];
    }
  }

  public function get() {
    return $this->manifest;
  }

  public function getPath($key = '', $default = null) {
    $collection = $this->manifest;
    if (is_null($key)) {
      return $collection;
    }
    if (isset($collection[$key])) {
      return $collection[$key];
    }
    foreach (explode('.', $key) as $segment) {
      if (!isset($collection[$segment])) {
        return $default;
      } else {
        $collection = $collection[$segment];
      }
    }
    return $collection;
  }
}

function asset_path($filename, $dist) {
  $dist_path = get_template_directory_uri() . $dist;
  $directory = dirname($filename) . '/';
  $file = basename($filename);
  static $manifest;

  if (empty($manifest)) {
    $manifest_path = get_template_directory() . $dist . 'assets.json';
    $manifest = new JsonManifest($manifest_path);
  }

  if (WP_ENV !== 'development' && array_key_exists($file, $manifest->get())) {
    return $dist_path . $directory . $manifest->get()[$file];
  } else {
    return $dist_path . $directory . $file;
  }
}

function bower_map_to_cdn($dependency, $fallback) {
  static $bower;

  if (empty($bower)) {
    $bower_path = get_template_directory() . '/bower.json';
    $bower = new JsonManifest($bower_path);
  }

  $templates = [
    'google' => '//ajax.googleapis.com/ajax/libs/%name%/%version%/%file%?ver=%version%'
  ];

  $version = $bower->getPath('dependencies.' . $dependency['name']);

  if (isset($version) && preg_match('/^(\d+\.){2}\d+$/', $version)) {
    $search = ['%name%', '%version%', '%file%'];
    $replace = [$dependency['name'], $version, $dependency['file']];
    return str_replace($search, $replace, $templates[$dependency['cdn']]);
  } else {
    return $fallback;
  }

}

function assets() {

  wp_enqueue_style('apollo-css', asset_path('css/app.css', DIST_DIR), false, null);

  // GOOGLE FONTS
  if ( GOOGLE_FONTS !== false ) {
    $google_url = 'https://fonts.googleapis.com/css?family=' . GOOGLE_FONTS;
    wp_enqueue_style( 'google-fonts', $google_url );
  }

  // FONT AWESOME ICONS
  if ( FONTAWESOME ) {
    wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
  }

  // GOOGLE MAPS
  if( is_page(108) ) {
    wp_enqueue_script('google_maps', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCZG-xwOhjcTz_BmxIUikjvHmPupZBNSQQ', [], null, true);
  }

  // BASIC SITE SCRIPTS
  wp_enqueue_script('apollo-js', asset_path('js/app.js', DIST_DIR), ['jquery'], null, true);
}

add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);


// GOOGLE ANALYTICS
// ============================================================

// Add Google Analytics ID to general settings page in admin
add_action('admin_init', __NAMESPACE__ . '\\j2_fb_api_settings_section');

// Add a new section to the General Settings Page
function j2_fb_api_settings_section() {
  add_settings_section('ga_id_section', 'Google Analytics', __NAMESPACE__ . '\\ga_id_callback', 'general');

  // Add an analytics Form Field
  add_settings_field( 'ga_id', 'Google Analytics ID', __NAMESPACE__ . '\\ga_id_textbox_callback', 'general', 'ga_id_section', array('ga_id'));

  // Register the field
  register_setting('general','ga_id', 'esc_attr');
}

// GA ID Callback - add descriptive message
function ga_id_callback() {
  echo '<p>Enter your '.
        '<a href="https://support.google.com/analytics/answer/1032385?hl=en" target="blank">' .
        'Google Analytics UA ID'.
        '</a> number to allow tracking.</p>';
}

// Save Analytics Field
function ga_id_textbox_callback($args) {
  $option = get_option($args[0]);
  echo '<input type="text" id="'. $args[0] .'" name="'. $args[0] .'" value="' . $option . '" />';
}

// Add Google Analytics to the head
// Cookie domain is 'auto' configured: http://goo.gl/VUCHKM
function google_analytics() {
  ?>
  <script>
    <?php if (WP_ENV === 'production' && !current_user_can('manage_options')) : ?>
      (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
      function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
      e=o.createElement(i);r=o.getElementsByTagName(i)[0];
      e.src='//www.google-analytics.com/analytics.js';
      r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
    <?php else : ?>
      function ga() {
        if (window.console) {
          console.log('Google Analytics: ' + [].slice.call(arguments));
        }
      }
    <?php endif; ?>
    ga('create','<?= get_option('ga_id') ?>','auto');ga('send','pageview');
  </script>
  <?php
}

if (get_option('ga_id') && WP_ENV === 'production') {
  add_action('wp_footer', __NAMESPACE__ . '\\google_analytics', 20);
}