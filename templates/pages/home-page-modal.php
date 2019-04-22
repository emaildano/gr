<?php
  $title = get_field('modal_title');
  $content = get_field('modal_content');
?>

<div id="js-modal-wrapper" class="bkg-fade modal--wrapper">
  <div class="modal">
    <?php if($title) { ?><p class="modal--title"><?= $title ?></p><? } ?>
    <?php if($content) { ?><p class="modal--content"><?= $content ?></p><? } ?>
    <a href="#" id="js-modal-close" class="modal--button read-more">Continue to site</a>
  </div>
</div>