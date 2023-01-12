<?php
/**
 * Template Name: Schedule (new layout)
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
        get_template_part('parts/hero-subpage');
			endwhile; // End of the loop.?>

			<?php  //include( locate_template( 'inc/schedule-links-filter.php', false, false ) );  ?>
			<?php include( locate_template( 'inc/schedule-links-filter-column.php', false, false ) ); ?>

      <?php 
      /* SET DAYS HERE */
      $days = array('friday','saturday','sunday'); 
      $columnCount = count($days);
      ?>
      <div class="wrapper">
        <div id="grido" class="schedule numcols<?php echo $columnCount ?>">
          <?php foreach ($days as $day) { ?>
            <div class="col js-day alldays <?php echo $day ?>" id="<?php echo $day ?>">
              <h2><?php echo ucwords($day) ?></h2>
              <?php  
              $i=0; 
              $wp_query = new WP_Query();
                $wp_query->query(array(
                'post_type'=> array('yoga','demo_clinic', 'competition','music'),
                'posts_per_page' => -1,
                'meta_key'      => $day.'_time_p',
                'orderby'     => 'meta_value',
                'order'       => 'ASC',
                'meta_type'         => 'TIME',
                'post_status' => array( 'publish', 'private' ),
                'tax_query' => array(
                  array(
                    'taxonomy' => 'event_day', // your custom taxonomy
                    'field' => 'slug',
                    'terms' => array( $day ) // the terms (categories) you created
                  )
                )
              )); 
              if ($wp_query->have_posts()) { ?>
              <div class="col-wrap">
                <div class="contents">
                  <ul class="list">
                    <?php while ($wp_query->have_posts()) : $wp_query->the_post();  
                      include( locate_template( 'inc/schedule-links.php', false, false ) );  
                    endwhile;  ?>
                  </ul>
                </div>
              </div>
              <?php } ?>
            </div>
          <?php } ?>


        </div>
      </div>

		</main><!-- #main -->
	</div><!-- #primary -->
  <?php
}
// get_sidebar();
get_footer();
