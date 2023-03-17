<?php 

//get_template_part('parts/hero-subpage.php'); 
$posttype = get_post_type();


?>
  <header class="entry-title">
    <h1><?php the_title(); ?></h1>
  </header>
  <?php get_template_part('parts/hero-subpage'); ?>
	<div id="primary" class="content-area-full single-competition">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
      <?php  
      $course_iframe = get_field('course_iframe');
      $registrationLink = get_field("register_button","option");
      $eventStartDate = get_field("eventStartDate");
      $start_date = ($eventStartDate) ? date('l, M d, Y',strtotime($eventStartDate)) . ' <span>&ndash;</span> ' . date('h:i a',strtotime($eventStartDate)) : '';
      if( $posttype === 'competition' ) {
	      $terms = get_the_terms( get_the_ID(), 'competition_type');
	      foreach ($terms as $t) {
	      	$termName = $t->name;
	      	$termID = $t->term_id;
	      }
	      $termLink = get_term_link( $termID );
	  }
   //    echo '<pre>';
	  // print_r($registrationLink);
	  // echo '</pre>';
      ?>
      <div class="wrapper pagecontent">
        <?php if ($start_date || $registrationLink) { ?>
        <ul class="tabs-info">
          <?php if ($start_date) { ?>
            <li><span class="orange active"><a href="#" data-tab="#eventinfo" class="tablink"><?php echo $start_date ?></a></span></li>
          <?php } ?>
          <?php if($posttype === 'competition'){ ?>
	            <li><span class="yellow"><a href="<?php echo $registrationLink['url'] ?>" target="_blank">Register</a></span></li>
	        <?php } ?>
          <?php if( have_rows('past_results') ) { ?>  
            <li><span class="gray"><a href="#" data-tab="#pastresults" class="tablink">Past Results</a></span></li>
          <?php } ?>
        </ul> 
        <?php } ?>

        <?php 
        $tab_active = ( get_the_content() ) ? ' active':'';
        ?>

        <?php if ( get_the_content() ) { ?>
        <div id="eventinfo" class="event-info tab-panel active">
          <div class="pad">
          	<?php the_content(); ?>
          	<div class="comp-footer">
	          	<?php if( $posttype === 'competition' ) { 
	          		echo '<div class="other-links-btn"><a href="'.get_bloginfo('url').'/competitions">See All Competitions</a></div>';
	          		echo '<div class="other-links-btn"><a href="'.$termLink.'">See All '.$termName.' Competitions</a></div>';
	          	} elseif( $posttype === 'yoga' ) { 
	          		echo '<div class="other-links-btn"><a href="'.get_bloginfo('url').'/tuckfest-yoga">See All Yoga</a></div>';
	          	} elseif( $posttype === 'demo_clinic' ) { 
	          		echo '<div class="other-links-btn"><a href="'.get_bloginfo('url').'/clinics">See All Clinics</a></div>';
	          	}
	          	?>
          	</div>
          </div>
        </div> 
        <?php } ?>

        <?php if($course_iframe) { ?>
          <section class="coursemap">
            <?php echo $course_iframe; ?>
          </section>
        <?php } ?>

        <?php if( have_rows('past_results') && $posttype === 'competition' ) { ?>
        <div id="pastresults" class="event-info pastresults tab-panel<?php echo (!get_the_content()) ? ' active':''?>">
          <div class="pad">
            <h2 class="tab-title">Past Results</h2>
            <?php while ( have_rows('past_results') ) : the_row(); ?>
              <?php if( get_row_layout() == 'info' ) { 
                $year = get_sub_field('year');
                $result = get_sub_field('result');
                if( $year && $result ) { ?>
                <div class="past-year">
                  <p class="year"><?php echo $year ?></p>
                  <?php if( have_rows('result') ) { ?>
                  <div class="divisions">
                    <div class="flexwrap">
                      <?php while ( have_rows('result') ) : the_row(); ?>
                        <?php 
                          $category = get_sub_field('category'); 
                          $items = get_sub_field('items'); 
                          if($category && $items) { ?>
                          <div class="cat-info">
                            <h4 class="cat"><?php echo $category ?></h4>
                            <div class="result-list">
                              <?php foreach ($items as $r) { 
                                $title = $r['title'];
                                $link = $r['link'];
                                if($title) { ?>
                                <div class="item">
                                  <?php if ($link) { ?>
                                  <a href="<?php echo $link['url'] ?>" target="_blank"><?php echo $title ?></a>
                                  <?php } else { ?>
                                  <?php echo $title ?>
                                  <?php } ?>
                                </div> 
                                <?php } ?>
                              <?php } ?>
                            </div>
                          </div>
                          <?php } ?>
                      <?php endwhile; ?>
                    </div>
                  </div>
                  <?php } ?>
                </div> 
                <?php } ?>
              <?php } ?>
            <?php endwhile; ?>
          </div>
        </div>
        <?php } ?>

        <?php  
        $map_image = get_field("map_image");
        if($map_image) { ?>
          <div class="map-image">
            <img src="<?php echo $map_image['url'] ?>" alt="<?php echo $map_image['title'] ?>">
          </div>
        <?php } ?>

        <?php  
        $visibility = get_field("result_visibility");
        $coming_soon_note = get_field("coming_soon_note");
        $present_results = get_field("present_results");
        if( $posttype === 'competition' ):
        ?>
        <div class="result-section">
          <div class="flexwrap">
            <?php if(has_post_thumbnail()) { ?>
            <div class="imagecol">
              <?php the_post_thumbnail('large'); ?>
            </div>
            <?php } ?>

            <div class="textcol resultsCol">
              <h3 class="title-orange">Results</h3>

              <?php if ($visibility=="coming_soon") { ?>
              
              <div class="coming-soon">
                <?php echo ($coming_soon_note) ? $coming_soon_note : 'Coming Soon!'; ?>
              </div>

              <?php } else if( $visibility=="show_result" ) { ?>

                <?php if( have_rows('present_results') ) { ?>
                  <?php while ( have_rows('present_results') ) : the_row(); 
                    if( get_row_layout() == 'info' ) { 
                      $category = get_sub_field('category'); 
                      $results = get_sub_field('result'); 
                      if($category || $results) { ?>
                        <div class="result-item">
                          <?php if ($category) { ?>
                            <h4 class="catname"><?php echo $category ?></h4>
                          <?php } ?>

                          <?php if ($results) { ?>
                            <div class="result-list">
                              <?php foreach ($results as $r) { 
                                $title = $r['title'];
                                $link = $r['link'];
                                if($title) { ?>
                                <div class="item">
                                  <?php if ($link) { ?>
                                  <a href="<?php echo $link['url'] ?>" target="_blank"><?php echo $title ?></a>
                                  <?php } else { ?>
                                  <?php echo $title ?>
                                  <?php } ?>
                                </div> 
                                <?php } ?>
                              <?php } ?>
                            </div>
                          <?php } ?>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  <?php endwhile; ?>
                <?php } ?>

              <?php } ?>

              

            </div>
            	
          </div>
        </div>

    	<?php endif; ?>
    	<?php if(has_post_thumbnail() && $posttype !== 'competition') { ?>
	        <div class="imagecol xtra">
	          <?php the_post_thumbnail('full'); ?>
	        </div>
       <?php } ?>
      </div>

		<?php endwhile; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<script type="text/javascript">
jQuery(document).ready(function($){
  $(".tablink").on("click",function(e){
    e.preventDefault();
    var tabID = $(this).attr("data-tab");
    var parent = $(this).parent();
    $(".tab-panel").not(tabID).removeClass('active');
    $('ul.tabs-info li span').removeClass('active');
    parent.addClass('active');
    $(tabID).addClass("active");
  });
});
</script>
