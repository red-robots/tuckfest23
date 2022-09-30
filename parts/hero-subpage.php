<?php
$banner_image = get_field('banner_image');
$banner_visibility = get_field('banner_visibility');
$button = get_field('banner_cta');
$register_button = get_field('register_button','option');
$btnLink = ( isset($register_button['url']) && $register_button['url'] ) ? $register_button['url'] : '';
$btnText = ( isset($register_button['title']) && $register_button['title'] ) ? $register_button['title'] : '';
$btnTarget = ( isset($register_button['target']) && $register_button['target'] ) ? $register_button['target'] : '_self';
if($banner_visibility=='on' && $banner_image) { ?>
<div class="banner-subpage">
  <div class="banner-image" style="background-image:url('<?php echo $banner_image['url'] ?>')"></div>
  <?php if($button=='on' && ($btnText && $btnLink) ) { ?>
  <div class="banner-button"><a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="heroBtn"><span><?php echo $btnText ?></span></a></div>
  <?php } ?>
</div>
<?php } else { ?>
  <?php if($button=='on' && ($btnText && $btnLink) ) { ?>
  <div class="banner-subpage noimage">
    <?php if($button=='on' && ($btnText && $btnLink) ) { ?>
    <div class="banner-button"><a href="<?php echo $btnLink ?>" target="<?php echo $btnTarget ?>" class="heroBtn"><span><?php echo $btnText ?></span></a></div>
    <?php } ?>
  </div>
  <?php } ?>
<?php } ?>