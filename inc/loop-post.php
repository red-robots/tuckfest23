<?php
$pId = get_the_ID();
$title = get_the_title();
$text = get_the_content();
$buttons = get_field('buttons');
$slug = basename( get_permalink() );
$image = wp_get_attachment_url( get_post_thumbnail_id($pId), 'large' );
$column_class = ( ($title || $text) &&  $image ) ? 'half':'full';

//$term_list = get_the_terms($post->ID, 'your_taxonomy');
$post_terms = array();
if( isset($terms) && $terms ) {
  foreach($terms as $taxonomy=>$items) {
    $p_terms = get_the_terms($pId, $taxonomy);
    if($p_terms) {
      foreach($p_terms as $pt) {
        $post_terms[] = $pt->slug;
      }
    }
  }
}

$terms_class = ($post_terms) ? ' ' . implode(' ',$post_terms) : '';
if( ($title || $text) ||  $image ) { ?>
<div data-pid="<?php echo $pId ?>" class="content-block <?php echo $column_class.' '.$terms_class; ?>">
  <?php if ( $title || $text ) { ?>
  <div class="textcol block">
    <div class="inside">
      <?php if ($title) { ?>
       <h2 class="rb_title"><span><b><?php echo $title ?></b></span></h2>
      <?php } ?>

      <?php if ($text) { ?>
       <div class="rb_content"><?php echo anti_email_spam($text); ?></div> 
      <?php } ?>

      <?php if ($buttons) { ?>
       <div class="rb_buttons">
         <?php foreach ($buttons as $btn) { 
          $b = $btn['button'];
          $btn_target = ( isset($b['target']) && $b['target'] ) ? $b['target'] : '_self';
          $btn_text = ( isset($b['title']) && $b['title'] ) ? $b['title'] : '';
          $btn_link = ( isset($b['url']) && $b['url'] ) ? $b['url'] : '';
          if( $btn_text && $btn_link ) { ?>
            <a href="<?php echo $btn_link ?>" targe="<?php echo $btn_target ?>" class="btn2 btn-green"><?php echo $btn_text ?></a>
          <?php } ?>
         <?php } ?>
       </div> 
      <?php } ?>
    </div>
  </div> 
  <?php } ?>

  <?php if ( $image ) { ?>
  <div class="imagecol block">
    <div class="imagediv" style="background-image:url('<?php echo $image ?>')">
      <img src="<?php echo $image ?>" >
    </div>
  </div> 
  <?php } ?>
</div>
<?php } ?>


