<?php
/**
 * Template Name: Gallery
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
      <?php //if ( get_the_content() ) { ?>
      <section class="entry-content page-content">
        <div class="wrapper"><?php the_content(); ?></div>
      </section>
      <section class="photo-gallery">
        <div class="inner">
  			<?php 

  			$gallery = get_field('gallery');

  			foreach ( $gallery as $image ) { 

  				// echo '<pre>';
  				// print_r($image);
  				// echo $i;
  				// echo '</pre>';

  				if( $image['caption'] ) {
  					$output = $image['caption'];
  					$class='youtube';
  					$i++;
  				} else {
  					$output = $image['url'];
  					$class='gallery';
  				}
  				

  				?>
  				<div class="gal-thumb">
  					<?php if( $image['caption'] ) { ?>
            <a class="<?php echo $class; ?>" href="#video-<?php echo $i; ?>">
              <figure style="background-image:url('<?php echo $image['sizes']['tile']; ?>');">
                <img src="<?php echo $image['sizes']['tile']; ?>" class="actual">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/resizer-square.png" alt="" class="resizer">
              </figure>
            </a>
  					<?php } else { ?>
            <a class="<?php echo $class; ?>" href="<?php echo $output; ?>">
              <figure style="background-image:url('<?php echo $image['sizes']['tile']; ?>');">
                <img src="<?php echo $image['sizes']['tile']; ?>" class="actual">
                <img src="<?php echo get_stylesheet_directory_uri() ?>/images/resizer-square.png" alt="" class="resizer">
              </figure>
            </a>
  					<?php } ?>
  						
  					</div>

  					<?php if( $image['caption'] ) { ?>
  						<div style="display: none;">
  							<div id="video-<?php echo $i; ?>" class="video">
  								<?php echo wp_oembed_get($output); ?>
  							</div>
  						</div>
  					<?php } ?>

  			<?php }
  			 ?>
      </div>
		</section>
      <?php //} ?>
		<?php endwhile; ?>	
	</main>
</div>
<?php
endif;
get_footer();
