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
  <h1><?php echo get_term( get_queried_object_id() )->name;  ?></h1>
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
          $mergedEntries = array();
          $mergedIds = array();
          if( $merge_items = get_field('merge_competitions','option') ) {
            foreach($merge_items as $m) {
              if($postids = $m['posts']) {
                if( count($postids)>1 ) {
                  foreach($postids as $id) {
                    $mergedIds[] = $id;
                  }

                  $parent_id = $postids[0];
                  $mergedEntries[$parent_id] = array(
                    'custom_title'=>$m['custom_title'],
                    'parent_id'=>$parent_id,
                    'posts'=>$postids
                  );
                }
              }
            }
          }


		      $current_count = count( get_posts($args) );
		      $i=1; while ( have_posts() ) : the_post(); 
		      $post_id = get_the_ID();
		      $thumbnail_id = get_post_thumbnail_id($post_id);
		      $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
		      $imageStyle = ($featImage) ? ' style="background-image:url('.$featImage[0].')"':'';
		      $postType = get_post_type($post_id);
		      $div3rdcol = 'post-type-'.$postType;
		      $pagelink = ($postType=='music') ? 'Event.preventDefault()' : get_permalink();
		      $title = get_the_title();
          $text = get_the_content();
          $buttons = get_sub_field('buttons');
          $image = get_sub_field('image');
          $column_class = ( ($title || $text) &&  $featImage ) ? 'half':'full';

          if( $mergedIds ) {
            if( array_key_exists($post_id, $mergedEntries) ) {
                $data = $mergedEntries[$post_id]; 
                $custom_title = ($data['custom_title']) ? $data['custom_title'] : $title;
                $children = $data['posts'];
              ?>

              <?php if( ($custom_title || $text) ||  $featImage ) { ?>
                <div data-pid="<?php echo $post_id ?>" class="content-block merged <?php echo $column_class ?>">
                  <?php if ( $title || $text ) { ?>
                  <div class="textcol block">
                    <div class="inside">
                      <?php if ($custom_title) { ?>
                       <h2 class="rb_title"><span><b><?php echo $custom_title ?></b></span></h2> 
                      <?php } ?>

                      <?php if ($text) { ?>
                       <div class="rb_content"><?php echo anti_email_spam($text); ?></div> 
                      <?php } ?>

                      <?php if ($children) { ?>
                       <div class="rb_buttons">
                        <?php foreach ($children as $id) { 
                          $buttonText = get_the_title($id);
                          ?>
                          <div class="btngroup">
                            <a href="<?php echo get_permalink($id)?>"  class="btn2 btn-green">See <?php echo get_the_title($id) ?></a>
                          </div>
                        <?php } ?>
                         
                       </div> 
                      <?php } ?>
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

            <?php } else {
              
              if( !in_array($post_id,$mergedIds) ) { ?>

                <?php if( ($title || $text) ||  $featImage ) { ?>
                <div data-pid="<?php echo $post_id ?>" class="content-block <?php echo $column_class ?>">
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
                         <a href="<?php bloginfo('url'); ?>/competitions"  class="btn2 btn-green">SEE ALL COMPETITIONS</a>
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


              <?php }

            }
          } else { ?>

            <?php if( ($title || $text) ||  $featImage ) { ?>
            <div data-pid="<?php echo $post_id ?>" class="content-block <?php echo $column_class ?>">
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
                     <a href="<?php bloginfo('url'); ?>/competitions"  class="btn2 btn-green">SEE ALL COMPETITIONS</a>
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

          <?php }

		
		   $i++; endwhile; wp_reset_postdata(); ?>
		      
		    
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
