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
  <h1>
  	<?php 
  	//get_queried_object()->term_id;
  	echo get_term( get_queried_object_id() )->name; 
  	?>
  </h1>
</header>
<?php get_template_part('parts/hero-subpage'); ?>
<div id="primary" class="content-area default-template">
	<main id="main" class="site-main">
      <section class="entry-content ">
        <div class="wrapper">




		<?php 
		//$posts = new WP_Query($args);
		if ( have_posts() ) { ?>
		<div class="feeds-wrapper">

		  <?php  
		  $filter_options = ($filter) ? explode(',',$filter) : '';
		  if($filter_options) { ?>
		    <?php if ( do_shortcode('[facetwp facet="competition_type"]') || do_shortcode('[facetwp facet="competition_day"]') ) { ?>
		    <div class="filter-options">
		      <span class="ftitle">FILTER BY:</span>
		      <?php foreach ($filter_options as $opt) { ?>
		        <?php if ( do_shortcode('[facetwp facet="'.$opt.'"]') ) { ?>
		          <?php echo do_shortcode('[facetwp facet="'.$opt.'"]'); ?>
		        <?php } ?>
		      <?php } ?>
		    </div>
		    <?php } ?>
		  <?php } ?>

		  <div class="columns">
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
		      ?>
		      <?php if ($i==1 && $postType=='music') { ?>
		       <div class="parent-wrap <?php echo $div3rdcol ?>"> 
		      <?php } ?>
		      <div data-postid="<?php echo $post_id ?>" class="column <?php echo $div3rdcol ?>">
		        <div class="inner">
		          <div class="image">
		            <figure<?php echo $imageStyle ?>>
		              <a href="<?php echo $pagelink ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/square.png" class="helper" alt=""></a></figure>
		          </div>
		          <h4 class="title"><a href="<?php echo $pagelink ?>"><?php the_title(); ?></a></h4>
		        </div>
		      </div>

		      <?php if ($i % 3==0 && $postType=='music') { ?>
		        </div><div class="parent-wrap <?php echo $div3rdcol ?>"><!-- end of .parent-wrap -->
		      <?php } ?>

		    <?php $i++; endwhile; wp_reset_postdata(); ?>
		      
		    <?php if($postType=='music') { ?>
		      </div>
		    <?php } ?>
		  </div>

		  <?php
		  $total_pages = $posts->max_num_pages;
		  if ($total_pages > 1) { ?>
		  <div id="pagination" class="pagination">
		    <?php
		    $pagination = array(
		        'base' => @add_query_arg('pg','%#%'),
		        'format' => '?paged=%#%',
		        'current' => $paged,
		        'total' => $total_pages,
		        'prev_text' => __( '&laquo;', 'red_partners' ),
		        'next_text' => __( '&raquo;', 'red_partners' ),
		        'type' => 'plain'
		    );
		    echo paginate_links($pagination); ?>
		  </div>
		  <?php } ?>
		</div>
		<?php } ?>




        </div>
      </section>
	</main>
</div>
<?php
endif;
get_footer();
