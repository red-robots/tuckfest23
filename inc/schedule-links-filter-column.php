<!-- SELECT --><!-- SELECT --><!-- SELECT --><!-- SELECT --><!-- SELECT -->
<div class="wrapper">
<div class="filters" id="filters">
<h2>Filter By</h2>
<?php 
$i=0;
/*
################   Second we Query the Activity Type   ##############

*/
// we'll store terms in this array so we don't repeat buttons of the same name.
$second = array();
$altN = array();
$combo = array();

$wp_query = new WP_Query();
$wp_query->query(array(
	'post_type'=> array('yoga','demo_clinic', 'competition','music'),
	'posts_per_page' => -1,
	'post_status' => array( 'publish', 'private' ),
	// No specific tax terms because we're pulling everything.
));
if ($wp_query->have_posts()) :  while ($wp_query->have_posts()) :  $wp_query->the_post(); 
		// Get the ID and terms of each post
		$theID = get_the_ID();
		$terms = get_the_terms($theID, 'competition_type');
		// $termsDemo = get_the_terms($theID, 'demo_clinic_type');
		
		// Loop through competition type
		if($terms){
			foreach ($terms as $term) {
				$day = $term->name;
				$altName = get_field('alt_name', $term);
				//echo $altName.'</br>';
				if( $altName == '' ) {
					$altName = $day;
				}
				
				// echo '<pre>';
				// print_r($term);
				// echo '</pre>';

				// if we havn't added the day into the array, add it. Let's not repeat ourselves.
				if( !in_array($day, array_column($second, 'name') ) ) {
					// old method for a simple array
					// $second[] = $day;

					// new method with Alt name for menu dropdown
					$second[] = array( 'name' => $day, 'alt' => $altName );
					
				}
			}
		}

	endwhile; 
endif; 

// $combo[] = array_merge($second, $altN);

// let's get music and yoga in here manually just because
$second[] = array( 'name' => 'Music', 'alt' => 'Music' );
$second[] = array( 'name' => 'Demos', 'alt' => 'Demos' );
$second[] = array( 'name' => 'Yoga', 'alt' => 'Yoga' );
$second[] = array( 'name' => 'Clinics', 'alt' => 'Clinics' );
// $second[] = array( 'name' => 'Films', 'alt' => 'Films' );

// alphabetize the dropdown.

// old method
// sort($second);

// new method for multidimensional array
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key=> $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

array_sort_by_column($second, 'name');
?>
	<div class="types filter_field">
    <div class="select">
      <div class="select-styled">All</div>
      <ul class="select-options">
        <li rel=".sched-act">All</li>
        <?php foreach ($second as $button) { 
          $filterString = sanitize_title_with_dashes($button['name']);
          $bName = $button['alt'];
          ?>
          <li rel=".<?php echo $filterString ?>"><?php echo $bName ?></li>
        <?php } ?>
      </ul>
    </div>
	</div>


</div>
<!-- SELECT -->
</div>
</div>
