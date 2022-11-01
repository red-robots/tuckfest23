<?php
/**
 * Template Name: Schedule (old layout)
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
 */

get_header(); 
get_template_part('inc/coming-soon');
$comingSoon = get_field('coming_soon');
$soon = ( isset($comingSoon[0]) ) ? $comingSoon[0] : '';
  if($soon !== 'soon') { ?>
<header class="entry-title">
  <h1><?php the_title(); ?></h1>
</header>
	<div id="primary" class="content-area-full">
		<main id="main" class="site-main" role="main">

			<?php
			while ( have_posts() ) : the_post(); 
        //get_template_part('inc/special-title');
        //get_template_part('inc/banner');
			endwhile; // End of the loop.?>

			<?php  //include( locate_template( 'inc/schedule-links-filter.php', false, false ) );  ?>
			<?php include( locate_template( 'inc/schedule-links-filter-column.php', false, false ) ); ?>


      <div class="wrapper">
        <div id="grido" class="schedule">
        	
        	<div class="col js-day friday alldays" id="friday">
        		<h2>Friday</h2>
        		<div class="col-wrap">
        			<!-- <div class="offset"></div> -->
        			<div class="contents">
                <ul class="list">
                  <?php
                  $i=0; 
                  $wp_query = new WP_Query();
                  $wp_query->query(array(
                  'post_type'=> array('yoga','demo_clinic', 'competition','music'),
                  'posts_per_page' => -1,
                  'meta_key'			=> 'friday_time_p',
                  'orderby'			=> 'meta_value',
                  'order'				=> 'ASC',
                  'meta_type'         => 'TIME',
                  'post_status' => array( 'publish', 'private' ),
                  'tax_query' => array(
                  	array(
                  		'taxonomy' => 'event_day', // your custom taxonomy
                  		'field' => 'slug',
                  		'terms' => array( 'friday' ) // the terms (categories) you created
                  	)
                  )
                  ));
                  if ($wp_query->have_posts()) :  while ($wp_query->have_posts()) :  $wp_query->the_post(); 
                    include( locate_template( 'inc/schedule-links.php', false, false ) );  
                  endwhile; ?>
                  <?php endif; ?>
                </ul>
        		</div>
        		</div>
        	</div>
        	<div class="col js-day saturday alldays" id="saturday">
        		<h2>Saturday</h2>
        		<div class="col-wrap">
        			<!-- <div class="offset"></div> -->
        			<div class="contents">
                <ul class="list">
            		  <?php
            		  $i=0; 
                	$wp_query = new WP_Query();
                	$wp_query->query(array(
                		'post_type'=> array('yoga','demo_clinic', 'competition','music'),
                		'posts_per_page' => -1,
                		'meta_key'			=> 'saturday_time_p',
                		'orderby'			=> 'meta_value',
                		'order'				=> 'ASC',
                		'meta_type'         => 'TIME',
                		'post_status' => array( 'publish', 'private' ),
                		'tax_query' => array(
                			array(
                				'taxonomy' => 'event_day', // your custom taxonomy
                				'field' => 'slug',
                				'terms' => array( 'saturday' ) // the terms (categories) you created
                			)
                		)
                	));
            	     if ($wp_query->have_posts()) :  while ($wp_query->have_posts()) :  $wp_query->the_post(); 
            		    include( locate_template( 'inc/schedule-links.php', false, false ) ); 
            			 endwhile; ?>
            		  <?php endif; ?>
                </ul>
        		</div>
        		</div>
        	</div>
        	<div class="col js-day sunday alldays" id="sunday">
        		<h2>Sunday</h2>
        		<div class="col-wrap">
        			<!-- <div class="offset"></div> -->
        			<div class="contents">
                <ul class="list">
              		<?php
                  $i=0; 
                  $wp_query = new WP_Query();
                  $wp_query->query(array(
                  'post_type'=> array('yoga','demo_clinic', 'competition','music'),
                  'posts_per_page' => -1,
                  'meta_key'			=> 'sunday_time_p',
                  'orderby'			=> 'meta_value',
                  'order'				=> 'ASC',
                  'meta_type'         => 'TIME',
                  'post_status' => array( 'publish', 'private' ),
                  'tax_query' => array(
                  	array(
                  		'taxonomy' => 'event_day', // your custom taxonomy
                  		'field' => 'slug',
                  		'terms' => array( 'sunday' ) // the terms (categories) you created
                  	)
                  )
                  ));
                  if ($wp_query->have_posts()) :  while ($wp_query->have_posts()) :  $wp_query->the_post(); 

                  include( locate_template( 'inc/schedule-links.php', false, false ) ); 

                  	 endwhile; ?>
                  <?php endif; ?>
                  <?php $wp_query->wp_reset_postdata(); ?>
                </ul>
        		</div>
        		</div>
        	</div>
        </div>
      </div>

		</main><!-- #main -->
	</div><!-- #primary -->
  <?php
}
// get_sidebar();
get_footer();
