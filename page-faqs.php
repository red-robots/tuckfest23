<?php
/**
 * Template Name: FAQ's
 *
 * 
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

		<section class="faqs">
		<?php /*
		------------------------------------
		FAQ's
		------------------------------------*/ ?>
		<?php if( have_rows('faqs') ): ?>
			<?php while ( have_rows('faqs') ) : the_row(); ?>

				<div class="faqrow">
					<div class="question">
						<div class="plus-minus-toggle collapsed"></div>
						<?php the_sub_field('question'); ?>
					</div>
						<div class="answer"><?php the_sub_field('answer'); ?></div>
				</div><!-- faqrow -->
			<?php endwhile; ?>
		<?php endif; // end faq's ?>
		</section>

		<?php endwhile; ?>	
	</main>
</div>
<?php
endif;
get_footer();
