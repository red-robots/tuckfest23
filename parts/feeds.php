<?php 
$posts = new WP_Query($args);
if ( $posts->have_posts() ) { ?>
<div class="feeds-wrapper">
  <div class="filter-options">
    <span class="ftitle">FILTER BY:</span>
    <span class="filter-field">
      <select name="">
        <option value="">Select...</option>
      </select>
    </span>
    <span class="filter-field">
      <select name="">
        <option value="">Select...</option>
      </select>
    </span>
  </div>
  <div class="columns">
    <?php while ( $posts->have_posts() ) : $posts->the_post(); 
        $post_id = get_the_ID();
        $thumbnail_id = get_post_thumbnail_id($post_id);
        $featImage = wp_get_attachment_image_src($thumbnail_id,'large');
        $imageStyle = ($featImage) ? ' style="background-image:url('.$featImage[0].')"':'';
      ?>
      <div class="column">
        <div class="inner">
          <div class="image">
            <figure<?php echo $imageStyle ?>><a href="<?php echo get_permalink() ?>"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/square.png" class="helper" alt=""></a></figure>
          </div>
          <h4 class="title"><a href="<?php echo get_permalink() ?>"><?php the_title(); ?></a></h4>
        </div>
      </div>
    <?php endwhile; wp_reset_postdata(); ?>
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