<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!--[if IE]><link rel="shortcut icon" href="<?= get_bloginfo('template_url') ?>/favicon.ico"><![endif]-->
  <link rel="apple-touch-icon-precomposed" href="<?= get_bloginfo('template_url') ?>/favicon.icns">
  <link rel="icon" href="<?= get_bloginfo('template_url') ?>/favicon.png">

  <link rel="alternate" type="application/rss+xml" title="<?= get_bloginfo('name'); ?> Feed" href="<?= esc_url(get_feed_link()); ?>">

  <?php wp_head(); ?>
</head>
