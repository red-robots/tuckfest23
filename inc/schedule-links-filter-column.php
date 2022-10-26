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

// echo '<pre>';
// print_r($second);
// echo '</pre>';

// we Queried Everything for the Day's now let's create the buttons.


?>

	<!-- <h2 class="filter-title">Filter By Activity Type:</h2> -->

	<!-- <div class="button-group group2 filters-button-group" data-filter-group="type"> -->
	<div class="types">
	<select id="filter_by_activity" class="option-set clearfix"  data-filter-group="type" onchange="getComboA(this)">
			<!-- <button class="filbutton button showall is-checked" data-filter="*">show all</button> -->
			<option value=".sched-act" data-filter-value="" class="selected">All</option>
		<?php 
		
			foreach ($second as $button) { 
				// sanitize it.
				$filterString = sanitize_title_with_dashes($button['name']);
				$bName = $button['alt'];
				// grab the first 4 characters so multi names can still link
				// $str = substr($filterString, 0, 4);
				?>
				<!-- <button class="filbutton button" data-filter=".<?php echo $filterString; ?>"><?php echo $button; ?></button> -->

<!-- <option value="#filter-type-<?php echo $filterString; ?>" data-filter-value=".<?php echo $filterString; ?>"><?php echo $bName; ?></option>	 -->	
<option value=".<?php echo $filterString; ?>" data-filter-value=".<?php echo $filterString; ?>"><?php echo $bName; ?></option>		<?php }
		?>
		</select>
		</div>

		<div class="days">
		<!-- <select id="filter_by_day" class="option-set clearfix"  data-filter-group="type" onchange="getComboA(this)">
			<option value="*" data-filter-value="" class="selected">All Days</option>
			<option value=".friday" data-filter-value="friday" class="selected">Friday</option>
			<option value=".saturday" data-filter-value="saturday" class="selected">Saturday</option>
			<option value=".sunday" data-filter-value="sunday" class="selected">Sunday</option>
		</select> -->
			<div class="select">
				<div class="select-styled dayz">Days</div>
				<ul class="select-options ">
					<li rel=".alldays">All</li>
					<li rel=".friday">Friday</li>
					<li rel=".saturday">Saturday</li>
					<li rel=".sunday">Sunday</li>
				</ul>
			</div>
	
		</div>
	<!-- </div> -->
</div>
<!-- SELECT -->
</div>
</div>
