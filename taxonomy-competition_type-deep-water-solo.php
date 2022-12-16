<?php
/**
 * Template Name: Activities
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */
get_header(); 
get_template_part('inc/coming-soon');
$comingSoon = get_field('coming_soon');
$soon = ( isset($comingSoon[0]) ) ? $comingSoon[0] : '';
if($soon !== 'soon') :?>
<header class="entry-title">
  <h1><?php the_title(); ?></h1>
</header>
<?php get_template_part('parts/hero-subpage'); ?>
<div id="primary" class="content-area default-template">
	<main id="main" class="site-main">
      <section class="entry-content ">
        <div class="">




		<?php 
		$n=1;
		if ( have_posts() ) { ?>
		<div class="repeatable-content-blocks">

		  

		  <div class="wrapper">
		    <?php 
		      $current_count = count( get_posts($args) );
		      $i=1; while ( have_posts() ) : the_post(); 
		      $post_id = get_the_ID();
		      $thumbnail_id = get_post_thumbnail_id($post_id);
		      $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
		      $imageStyle = ($featImage) ? ' style="background-image:url('.$featImage[0].')"':'';
		      $postType = get_post_type($post_id);
		      $div3rdcol = 'post-type-'.$postType;
		      //$div3rdcol .= ( ($i % 3==0) || ($i==$current_count) ) ? ' third':'';
		      //$div3rdcol .= ($i==$current_count) ? ' last':'';
		      $pagelink = ($postType=='music') ? 'Event.preventDefault()' : get_permalink();
		      // echo '<pre>';
		      // print_r($imageStyle);
		      // echo '</pre>';
		      $title = get_the_title();
	          $text = get_the_content();
	          $buttons = get_sub_field('buttons');
	          $image = get_sub_field('image');
	          $column_class = ( ($title || $text) &&  $featImage ) ? 'half':'full';
	          if( ($title || $text) ||  $featImage ) { ?>
	          <div class="content-block <?php echo $column_class ?>">
	            <?php if ( $title || $text ) { ?>
	            <div class="textcol block">
	              <div class="inside">
	                <?php if ($title) { ?>
	                 <h2 class="rb_title"><span><b><?php echo $title ?></b></span></h2> 
	                <?php } ?>

	                <?php if ($text) { ?>
	                 <div class="rb_content"><?php echo anti_email_spam($text); ?></div> 
	                <?php } ?>

	                <?php //if ($buttons) { ?>
	                 <div class="rb_buttons">
	                   <?php //foreach ($buttons as $btn) { 
	                    // $b = $btn['button'];
	                    // $btn_target = ( isset($b['target']) && $b['target'] ) ? $b['target'] : '_self';
	                    // $btn_text = ( isset($b['title']) && $b['title'] ) ? $b['title'] : '';
	                    // $btn_link = ( isset($b['url']) && $b['url'] ) ? $b['url'] : '';
	                    //if( $btn_text && $btn_link ) { ?>
	                      <a href="<?php bloginfo('url'); ?>/competitions"  class="btn2 btn-green">SEE ALL COMPETITIONS</a>
	                    <?php //} ?>
	                   <?php //} ?>
	                 </div> 
	                <?php //} ?>
	              </div>
	            </div> 
	            <?php } ?>

	            <?php if ( $featImage ) { ?>
	            <div class="imagecol block">
              <div class="imagediv" style="background-image:url('<?php echo $featImage[0] ?>')">
                <img src="<?php echo $featImage[0] ?>" >
              </div>
            </div> 
	            <?php } ?>
	          </div>
	          <?php } ?>
		      
		      
		      <!-- <div data-postid="<?php echo $post_id ?>" class="column <?php echo $div3rdcol ?>">
		        <div class="inner">
		          <div class="image">
		            <figure<?php echo $imageStyle ?>>
		              <a href="<?php echo $pagelink ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/square.png" class="helper" alt=""></a></figure>
		          </div>
		          <h4 class="title"><a href="<?php echo $pagelink ?>"><?php the_title(); ?></a></h4>
		        </div>
		      </div> -->

		      

		    <?php $i++; endwhile; wp_reset_postdata(); ?>
		      
		    
		  </div>

		  
		  
		</div>
		<?php } ?>




        </div>
      </section>
	</main>
</div>
<?php
endif;
get_footer();
