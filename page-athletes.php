<?php
/**
 * Template Name: Athletes
 */

get_header(); 
get_template_part('inc/coming-soon');
$comingSoon = get_field('coming_soon');
$soon = ( isset($comingSoon[0]) ) ? $comingSoon[0] : '';
if($soon !== 'soon') :
?>
<header class="entry-title">
  <h1><?php the_title(); ?></h1>
</header>
<?php get_template_part('parts/hero-subpage'); ?>
<div id="primary" class="content-area default-template">

  <main id="main" class="site-main">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php if ( get_the_content() ) { ?>
      <section class="entry-content page-content">
        <div class="wrapper"><?php the_content(); ?></div>
      </section>
      <?php } ?>
      <?php endwhile; ?> 

      <?php 
      $wp_query = new WP_Query();
		$wp_query->query(array(
			'post_type'=>'athletes',
			'posts_per_page' => -1
		));
      if( $wp_query->have_posts() ) { ?>
      <div class="repeatable-content-blocks">
        <div class="wrapper">
        <?php $n=1; while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
          $title = get_the_title();
          $text = get_the_content();
          // $buttons = get_sub_field('buttons');
          $image = get_field('image');
          if( $image !== '' ) {
          	$imgCheck = 'yes';
          }
          $column_class = ( ($title || $text) &&  $image ) ? 'half':'full';
          if( ($title || $text) ||  $image ) { ?>
          <div class="content-block half <?php //echo $column_class ?>">
            <?php if ( $title || $text ) { ?>
            <div class="textcol block athlete">
              <div class="inside">
                <?php if ($title) { ?>
                 <h2 class="rb_title"><span><b><?php echo $title ?></b></span></h2> 
                <?php } ?>

                <?php //if ($text) { ?>
                 <div class="rb_content"><?php the_content(); ?></div> 
                <?php //} ?>

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

            <?php if ( $imgCheck == 'yes' ) { ?>
	            <div class="imagecol block">
	              <div class="imagediv" style="background-image:url('<?php echo $image['url'] ?>')">
	                <img src="<?php echo $image['url'] ?>" alt=" <?php echo $image['title'] ?>">
	              </div>
	            </div> 
            <?php } else { 
            	$aImage = get_bloginfo('template_url');
            ?>
            	<div class="imagecol block">
	              <div class="imagediv" style="background-image:url('<?php echo $aImage . '/images/athlete.png' ?>')">
	                <img src="<?php echo $aImage . '/images/athlete.png' ?>" alt=" <?php echo $image['title'] ?>">
	              </div>
	            </div> 
            <?php } ?>
          </div>
          <?php } ?>
        <?php endwhile; ?>
        </div>
      </div>
      <?php } ?>

     
  </main>
</div><!-- #primary -->

<?php
endif;
get_footer();
