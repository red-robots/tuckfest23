<?php
/**
 * Template Name: Artists
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package bellaworks
 */
get_header(); 
get_template_part('inc/coming-soon');
$comingSoon = get_field('coming_soon');
$soon = ( isset($comingSoon[0]) ) ? $comingSoon[0] : '';
if($soon !== 'soon') :
?>
<header class="entry-title ">
  <h1><?php the_title(); ?></h1>
</header>
<?php get_template_part('parts/hero-subpage'); ?>
<div id="primary" class="content-area default-template">
	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); ?>
      <?php if ( get_the_content() ) { ?>
      <section class="entry-content ">
        <div class="wrapper">
        	<div class="spotify-wrap">
        		<?php the_content(); ?>
        		<?php echo do_shortcode('[feeds post="music"  perpage="-1"  filter="music_day"]'); ?>
        	</div>
        </div>
      </section>
      <?php } ?>
		<?php endwhile; ?>	
	</main>
</div>
<?php
endif;
get_footer();
