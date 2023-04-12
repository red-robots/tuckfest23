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
    $termID = get_queried_object();
		$n=1;
    $wp_query = new WP_Query();
    $wp_query->query(array(
      'post_type'=>'competition',
      'posts_per_page' => -1,
      'order_by' => 'menu_order',
      'order' => 'ASC',
      'tax_query' => array(
        array(
          'taxonomy' => 'competition_type', // your custom taxonomy
          'field' => 'slug',
          'terms' => array( 'deep-water-solo' ) // the terms (categories) you created
        )
      )
    ));
		if ( $wp_query->have_posts() ) { ?>
		<div class="repeatable-content-blocks dws">

		  

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
		      $i=1; while ( $wp_query->have_posts() ) : $wp_query->the_post(); 
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
		        



            <?php 

            // $title = get_field('extra_card_title', 'competition_type_'.$termID);
            // $text = get_field('extra_card_description', 'competition_type_'.$termID);
            // $featImage = get_field('extra_card_image', 'competition_type_'.$termID);

            
            // Commenting this out. Getting repeating tiles for some reason...
            //if( ($title || $text) ||  $featImage ) { 
            if( $someThingCrazy ) {
              ?>
            
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



		    
		  </div>

		  
		  
		</div>
		<?php } ?>


        <?php  
        $dws_blurb = get_field('dws_blurb','option');
        $bottom = get_field('dws_competition_bottom','option');
        $bottomText = (isset($bottom['title']) && $bottom['title']) ? $bottom['title'] : '';
        $bottomURL = (isset($bottom['url']) && $bottom['url']) ? $bottom['url'] : '';
        $bottomTarget = (isset($bottom['target']) && $bottom['target']) ? $bottom['target'] : '_self';

        $bottomExtraBtn = get_field('more_cta_buttons','option');
        // echo '<pre>';
        // print_r($bottomExtraBtn);
        // echo '</pre>';

        ?>

        <?php if ($dws_blurb || ($bottomText && $bottomURL) ) { ?>
        <div class="bottom-dws-blurb">
          <div class="wrapper ">

            <?php if ($dws_blurb) { ?>
            <div class="blurb"><?php echo $dws_blurb ?></div> 
            <?php } ?>
        
            <?php if ($bottomText && $bottomURL) { ?>
              <div class="btncenter">
              <div class="buttondiv">
                <a href="<?php echo $bottomURL ?>" target="<?php echo $bottomTarget ?>" class="ctaBtn btn-green"><?php echo $bottomText ?></a>
              </div>
              <?php if( $bottomExtraBtn ){ ?>
                <?php foreach(  $bottomExtraBtn as $btn ){ 
                  $bottomText = (isset($btn['link']['title']) && $btn['link']['title']) ? $btn['link']['title'] : '';
                  $bottomURL = (isset($btn['link']['url']) && $btn['link']['url']) ? $btn['link']['url'] : '';
                  $bottomTarget = (isset($btn['link']['target']) && $btn['link']['target']) ? $btn['link']['target'] : '_self';

                  // echo '<pre>';
                  // print_r($btn);
                  // echo '</pre>';
                  ?>
                  <div class="buttondiv">
                  <a href="<?php echo $bottomURL ?>" target="<?php echo $bottomTarget ?>" class="ctaBtn btn-green"><?php echo $bottomText ?></a>
                </div>
                <?php } ?>
              <?php } ?>
            </div><!-- btn center -->
            <?php } ?>
            
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
