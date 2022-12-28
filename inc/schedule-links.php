<?php 
// NEW
	$classes = '';
	$post_id = get_the_ID();
	$postType = get_post_type($post_id);

			$activity = get_the_terms($post_id, 'competition_type');
			if($activity) {
				foreach( $activity as $act ) {
					$act = $act->slug;
					$classes .= ' ' . $act;
				}
			}

			if( $postType == 'music' ) {
				$classes .= ' music';
			}
			// if( $postType == 'demo_clinic' ) {
			// 	$classes .= ' film';
			// }



			if( $postType == 'demo_clinic' ) {
				if( $termz = get_the_terms($post_id, 'demo_clinic_type') ) {
  				foreach ( $termz as $t ) {
  					$classes .= ' '.$t->slug;
  				}
        }
				// $classes .= $post_id;
			}
			// $demC = get_the_terms($post_id, 'demo_clinic');
			// if($demC) {
			// 	foreach( $demC as $dem ) {
			// 		$dem = $dem->slug;
			// 		$classes .= ' ' . $dem;
			// 	}
			// }

			if( $postType == 'yoga' ) {
				$classes .= ' yoga';
			}

			// echo '<pre>';
			// print_r($classes);
			// echo '</pre>';

			//NEW

$queried_object = get_queried_object();
$i++; 
if( $i == 1 ) {
	
	// echo '<h2>'.$queried_object->name.'</h2>';
}

$wwAct = 'https://center.whitewater.org/visit/activity-passes/';

$thurTime = get_field('thursday_time_p');
$thurEndTime = get_field('thursday_time_p_end');
$friTime = get_field('friday_time_p');
$friEndTime = get_field('friday_time_p_end');
$satTime = get_field('saturday_time_p');
$satEndTime = get_field('saturday_time_p_end');
$sunTime = get_field('sunday_time_p');
$sunEndTime = get_field('sunday_time_p_end');


// echo '<pre>';
// print_r($thurTime);
// echo '</pre>';
if( $queried_object->slug == 'thursday' ) {
	$pp = get_field('thursday_schedule', 'option');
	$startTime = $thurTime;
	$EndTime = $thurEndTime;
	$regStart = get_field('thursday_start', 'option');
	$regEnd = get_field('thursday_end', 'option');
	$regLink = get_field('thursday_time_link', 'option');
	$regStartTwo = get_field('thursday_start_2', 'option');
	$regEndTwo = get_field('thursday_end_2', 'option');
	$actTime = '10:00 am - 6:00 pm';
}elseif( $queried_object->slug == 'friday' ) {
	$pp = get_field('friday_schedule', 'option');
	$startTime = $friTime;
	$EndTime = $friEndTime;
	$regStart = get_field('friday_start', 'option');
	$regEnd = get_field('friday_end', 'option');
	$regLink = get_field('friday_time_link', 'option');
	$regStartTwo = get_field('friday_start_2', 'option');
	$regEndTwo = get_field('friday_end_2', 'option');
	$actTime = '10:00 am - 7:00 pm';
}elseif( $queried_object->slug == 'saturday' ) {
	$pp = get_field('saturday_schedule', 'option');
	$startTime = $satTime;
	$EndTime = $satEndTime;
	$regStart = get_field('saturday_start', 'option');
	$regEnd = get_field('saturday_end', 'option');
	$regStartTwo = get_field('saturday_start_2', 'option');
	$regEndTwo = get_field('saturday_end_2', 'option');
	$regLink = get_field('saturday_time_link', 'option');
	$actTime = '10:00 am - 7:00 pm';
}elseif( $queried_object->slug == 'sunday' ) {
	$pp = get_field('sunday_schedule', 'option');
	$startTime = $sunTime;
	$EndTime = $sunEndTime;
	$regStart = get_field('sunday_start', 'option');
	$regEnd = get_field('sunday_end', 'option');
	$regStartTwo = get_field('sunday_start_2', 'option');
	$regEndTwo = get_field('sunday_end_2', 'option');
	$regLink = get_field('sunday_time_link', 'option');
	$actTime = '10:00 am - 7:00 pm';
}

$theID = get_the_ID();
$postType = get_post_type();

if( $postType == 'music') {
	$taxSlug = 'event-day';
	$tax = 'event_day';
} elseif( $postType == 'competition') {
	$taxSlug = 'competition-type';
	$tax = 'competition_type';
} elseif( $postType == 'demo_clinic') {
	$taxSlug = 'demo-clinic-type';
	$tax = 'demo_clinic_type';
} elseif( $postType == 'yoga') {
	$taxSlug = 'yoga-day';
	$tax = 'yoga_day';
}


if( $tax != '' ) {
	$terms = get_the_terms($theID, $tax );

	if($terms){$term = $terms[0]->slug;}

	$hash = sanitize_title_with_dashes(get_the_title());
	
	// echo '<pre>';
	// print_r($terms);
	// echo '</pre>';
}



if( $postType == 'music' ) {
	// if( $term == 'thursday') {
	// 	$page = 'thursday-line-up';
	// } elseif( $term == 'friday') {
	// 	$page = 'friday-line-up';
	// } elseif( $term == 'saturday') {
	// 	$page = 'saturday-line-up';
	// } elseif( $term == 'sunday') {
	// 	$page = 'sunday-line-up';
	//}
	// Chnage for
	$page = '2020-artists';
	// echo 'mussiiic';

	//$url = get_bloginfo('url').'/tuckfest-music/2020-artists/#'.$hash;
  $url = get_permalink($theID);
// } elseif ( $postType == 'demo_clinic' ) {
// 	$url = get_bloginfo('url').'/clinics/#'.$hash;
} else {
	$url = get_the_permalink();
	// $url = get_bloginfo('url').'/'.$taxSlug.'/'.$term.'/#'.$hash;
} 


if( $i == 1 ) {

?>
	<li class="item ">
		<a href="<?php echo $regLink; ?>">
			<?php if( $pp ){ ?>
				<div class="title first ">
					<?php echo $pp; ?>
				</div>
			<?php } ?>
			<div class="time">
				<?php 
				if( $regStart && $regEnd ) {
					echo $regStart.' - '.$regEnd;  
				}
				if( $regStartTwo && $regEndTwo ) {
					echo '<br>' . $regStartTwo.' - '.$regEndTwo;  
				}

				?>
			</div>
		</a>
	</li>
	<li>
		<a href="<?php echo $wwAct; ?>" target="_blank">
			<div class="title first">
				Whitewater Center Activities
			</div>
			<div class="time">
				<?php echo $actTime; ?>
			</div>
		</a>
	</li>
<?php } ?>

<li class="item <?php echo $classes; ?> sched-act">
	<a href="<?php echo $url; ?>">
	<?php if( get_post_type() == 'music' ) { ?>
		<div class="musicnote">
			<img src="<?php bloginfo('template_url'); ?>/images/MusicNote.png">
		</div>
		<div class="mis">
			<div class="title"><?php the_title(); ?></div>
			<div class="time">
			<?php 
				echo $startTime; 
				if( $EndTime != '') {
					echo ' - '.$EndTime;
					}?>
			</div>
		</div>
	<?php } else { ?>
		<div class="title">
			<?php 
			// Temporary link for music
			//if(get_post_type() == 'music') { ?>
			 <?php //} else { ?>
				
			<?php //} ?>
				<?php the_title(); ?>
				<!-- <br>|| <?php echo $classes; ?> -->
			
		</div>
		<div class="time">
			<?php 
			echo $startTime; 
			if( $EndTime != '') {
				echo ' - '.$EndTime;
				}?>
		</div>
	<?php } ?>
	</a>
</li>
