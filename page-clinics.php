<?php
/**
 * Template Name: Clinics
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package ACStarter
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
    <?php while ( have_posts() ) : the_post(); ?>
      <?php if ( get_the_content() ) { ?>
      <section class="entry-content ">
        <div class="wrapper"><?php the_content(); ?></div>
      </section>
      <?php } ?>
    <?php endwhile; ?>  


    <?php
    $i=0;
    $posttype = 'demo_clinic';
    $wp_query = new WP_Query();
    $wp_query->query(array(
      'post_type'=>$posttype,
      'posts_per_page' => -1,
      'paged' => $paged,
      'facetwp' => true
    ));

    $terms['demo_clinic_type'] = getPostTerms($posttype,'demo_clinic_type',array('name','ASC'));
    $terms['event_day'] = getPostTerms($posttype,'event_day',null);

    // echo "<pre>";
    // print_r($terms);
    // echo "</pre>";

    if ($wp_query->have_posts()) { ?>

      <?php if ( $terms && array_filter($terms) ) { ?>
      <div class="filters filter-custom center" id="filters">
        <div class="filter-title">Filter By:</div>
        <?php if ($terms) { ?>
          <?php foreach ($terms as $tax => $items) { ?>
          <div class="select" data-taxonomy="<?php echo $tax ?>">
            <div data-selected="all" class="select-styled">All</div>
            <ul class="select-options">
              <li rel="all">All</li>
              <?php foreach ($items as $item) { ?>
                <li rel="<?php echo $item->slug ?>"><?php echo $item->name ?></li>
              <?php } ?>
            </ul>
          </div>
          <?php } ?>
        <?php } ?>
        <?php //echo do_shortcode('[facetwp facet="clinic_type"]'); ?>
        <?php //echo do_shortcode('[facetwp facet="event_day"]'); ?>
      </div>
      <?php } ?>
      
      
      <div class="repeatable-content-blocks">
        <div class="wrapper">
          <?php while ($wp_query->have_posts()) : $wp_query->the_post(); $i++; ?>
            <?php include( locate_template('inc/loop-post.php', false, false)); ?>
          <?php endwhile; ?>
        </div>
      </div>
    <?php } ?>

  </main>
</div>
<?php
endif;
get_footer();

