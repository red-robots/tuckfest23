<?php
/**
 * Template Name: Contact
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
if($soon !== 'soon') : ?>
<header class="entry-title">
  <h1><?php the_title(); ?></h1>
</header>
<?php get_template_part('parts/hero-subpage'); ?>
<div id="primary" class="content-area default-template">
	<main id="main" class="site-main">
		<?php while ( have_posts() ) : the_post(); 
			$leftcol = get_field("leftcol_content");
          	$rightcol = get_field("rightcol_content");
          	$column_class = ($leftcol && $rightcol) ? 'half':'full';
          	?>
      <?php //if ( get_the_content() ) { ?>
      <section class="entry-content page-content">
        <div class="wrapper"><?php the_content(); ?></div>
        	
      </section>

		<?php if ( $leftcol || $rightcol ) { ?>
			<div class="flexcol-content <?php echo $column_class ?>">

		<?php if ( $leftcol ) { ?>
			<div class="flexcol fl">
				<div class="inside"><div class="wrap"><?php echo $leftcol ?></div></div>
			</div>
		<?php } ?>

		<?php if ( $rightcol ) { ?>
			<div class="flexcol fr">
				<div class="inside"><div class="wrap"><?php echo $rightcol ?></div></div>
			</div>
		<?php } ?>

		</div> 
		<?php } ?>

      <?php //} ?>
		<?php endwhile; ?>	
	</main>
</div>
<?php
endif;
get_footer();
