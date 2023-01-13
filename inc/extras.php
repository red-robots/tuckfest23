<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri());

/*-------------------------------------
 new image size
---------------------------------------*/

add_image_size('tile', 350, 350, array('center', 'center'));

// function pageSlug()

function bellaworks_body_classes( $classes ) {

    if( !is_page('schedule') ) {
      $pTitle = sanitize_title_with_dashes( get_the_title() );
      $classes[] = $pTitle;
    }

    if( is_page('2023-artists') ) {
      $classes[] = 'artists';
     }

    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );

function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

function shortenText2($text, $max = 50, $append = '…') {
  if (strlen($text) <= $max) return $text;
  $return = substr($text, 0, $max);
  if (strpos($text, ' ') === false) return $return . $append;
  return preg_replace('/\w+$/', '', $return) . $append;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function get_social_media() {
    $options = get_field("social_media","option");
    $icons = social_icons();
    $list = array();
    if($options) {
        foreach($options as $i=>$opt) {
            if( isset($opt['link']) && $opt['link'] ) {
                $url = $opt['link'];
                $parts = parse_url($url);
                $host = ( isset($parts['host']) && $parts['host'] ) ? $parts['host'] : '';
                if($host) {
                    foreach($icons as $type=>$icon) {
                        if (strpos($host, $type) !== false) {
                            $list[$i] = array('url'=>$url,'icon'=>$icon,'type'=>$type);
                        }
                    }
                }
            }
        }
    }

    return ($list) ? $list : '';
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fa fa-facebook-square',
        'twitter'   => 'fab fa-twitter-square',
        'linkedin'  => 'fa fa-linkedin-square',
        'instagram' => 'fab fa-instagram-square',
        'youtube'   => 'fab fa-youtube-square',
        'vimeo'     => 'fab fa-vimeo-square',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}


/* ACF CUSTOM OPTIONS TABS */
// if( function_exists('acf_add_options_page') ) {
//     acf_add_options_page();
// }
/* Options page under custom post type */
if( function_exists('acf_add_options_page') ) {
    acf_add_options_sub_page(array(
        'page_title'    => 'Competitions Options',
        'menu_title'    => 'Competitions Options',
        'position'      => 4,
        'parent_slug'   => 'edit.php?post_type=competition'
    ));
}
// function be_acf_options_page() {
//     if ( ! function_exists( 'acf_add_options_page' ) ) return;
    
//     $acf_option_tabs = array(
//         array( 
//             'title'      => 'Today Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Menu Options',
//             'capability' => 'manage_options',
//         ),
//         array( 
//             'title'      => 'Global Options',
//             'capability' => 'manage_options',
//         )
//     );

//     foreach($acf_option_tabs as $options) {
//         acf_add_options_page($options);
//     }
// }
//add_action( 'acf/init', 'be_acf_options_page' );


function get_images_dir($fileName=null) {
    return get_bloginfo('template_url') . '/images/' . $fileName;
}


/* ACF CUSTOM VALUES */
$gravityFormsSelections = array('gravityForm','global_the_form');
function acf_load_gravity_form_choices( $field ) {
    // reset choices
    $field['choices'] = array();
    $choices = getGravityFormList();
    if( $choices && is_array($choices) ) {       
        foreach( $choices as $choice ) {
            $post_id = $choice->id;
            $post_title = $choice->title;
            $field['choices'][ $post_id ] = $post_title;
        }
    }
    return $field;
}
foreach($gravityFormsSelections as $fieldname) {
  add_filter('acf/load_field/name='.$fieldname, 'acf_load_gravity_form_choices');
}

function getGravityFormList() {
    global $wpdb;
    $query = "SELECT id, title FROM ".$wpdb->prefix."gf_form WHERE is_active=1 AND is_trash=0 ORDER BY title ASC";
    $result = $wpdb->get_results($query);
    return ($result) ? $result : '';
}


function custom_excerpt_more( $excerpt ) {
    return '...';
}
add_filter( 'excerpt_more', 'custom_excerpt_more' );

//change the number for the length you want
function custom_excerpt_length( $length ) {
    return 150;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function get_excerpt($text,$limit=100) {
    $text = get_the_content('');
    $text = apply_filters('the_content', $text);
    $text = str_replace('\]\]\>', ']]>', $text);
    $text = preg_replace('@<script[^>]*?>.*?</script>@si', '', $text);

    /* This gets rid of all empty p tags, even if they contain spaces or &nbps; inside. */
    $text = preg_replace("/<p[^>]*>(?:\s|&nbsp;)*<\/p>/", '', $text); 

    /* Get rid of <img> tag */
    $text = preg_replace("/<img[^>]+\>/i", "", $text); 
    $text = strip_tags($text,"<p><a>");
    $excerpt_length = $limit;
    $words = explode(' ', $text, $excerpt_length + 1);
    if (count($words)> $excerpt_length) {
            array_pop($words);
            array_push($words, '...');
            $text = implode(' ', $words);
            $text = force_balance_tags( $text );
    }
 
    return $text;
}   


add_shortcode( 'team_list', 'team_list_shortcode_func' );
function team_list_shortcode_func( $atts ) {
  $a = shortcode_atts( array(
    'numcol'=>3
  ), $atts );
  $numcol = ($a['numcol']) ? $a['numcol'] : 3;
  $output = '';
  ob_start();
  //include( locate_template('parts/team_feeds.php') );
  get_template_part('parts/team_feeds',null,$a);
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}


add_shortcode( 'feeds', 'feeds_shortcode_func' );
function feeds_shortcode_func( $atts ) {
  $output = '';
  $a = shortcode_atts( array(
    'post'=>'',
    'filter'=>'',
    'perpage'=>'-1'
  ), $atts );
  
  $filter = (isset($a['filter']) && $a['filter']) ? $a['filter'] : '';
  $post_type = (isset($a['post']) && $a['post']) ? $a['post'] : '';
  $perpage = (isset($a['perpage']) && $a['perpage']) ? $a['perpage'] : '-1';
  $paged = ( get_query_var( 'pg' ) ) ? absint( get_query_var( 'pg' ) ) : 1;
  if($post_type) {
    ob_start();
    $args = array(
      'posts_per_page'  => $perpage,
      'post_type'       => $post_type,
      'post_status'     => 'publish',
      'paged'           => $paged,
      'facetwp'         => true,
      'orderby'         => 'menu_order',
      'order'           => 'ASC'
    );
    include( locate_template('parts/feeds.php') );
    $output = ob_get_contents();
    ob_end_clean();
    if($output) {
      $pattern = "/<p[^>]*><\\/p[^>]*>/"; 
      $output = str_replace('<p></p>','',$output);
      $output = preg_replace( $pattern, '', $output );
      $output = preg_replace('/<br>|\n|<br( ?)\/>/', '', $output);
    }
  }
  return $output;
}


/* Disabling Gutenberg on certain templates */

function ea_disable_editor( $id = false ) {

  $excluded_templates = array(
    'template-flexible-content.php',
    'page-clientlogin.php',
    'page-contact.php'
  );

  $excluded_ids = array(
    // get_option( 'page_on_front' )
  );

  if( empty( $id ) )
    return false;

  $id = intval( $id );
  $template = get_page_template_slug( $id );

  return in_array( $id, $excluded_ids ) || in_array( $template, $excluded_templates );
}

/**
 * Disable Gutenberg by template
 *
 */
function ea_disable_gutenberg( $can_edit, $post_type ) {

  if( ! ( is_admin() && !empty( $_GET['post'] ) ) )
    return $can_edit;

  if( ea_disable_editor( $_GET['post'] ) )
    $can_edit = false;

  if( get_post_type($_GET['post'])=='team' )
    $can_edit = false;

  return $can_edit;

}
add_filter( 'gutenberg_can_edit_post_type', 'ea_disable_gutenberg', 10, 2 );
add_filter( 'use_block_editor_for_post_type', 'ea_disable_gutenberg', 10, 2 );

/**
 * Disable Classic Editor by template
 *
 */
// function ea_disable_classic_editor() {

//   $screen = get_current_screen();
//   if( 'page' !== $screen->id || ! isset( $_GET['post']) )
//     return;

//   if( ea_disable_editor( $_GET['post'] ) ) {
//     remove_post_type_support( 'page', 'editor' );
//   }

// }
// add_action( 'admin_head', 'ea_disable_classic_editor' );


/**
 * Remove default description column from category
 *
 */
function jw_remove_taxonomy_description($columns) {
 // only edit the columns on the current taxonomy, replace category with your custom taxonomy (don't forget to change in the filter as well)
 // if ( !isset($_GET['taxonomy']) || $_GET['taxonomy'] != 'category' )
 // return $columns;

 // unset the description columns
 if ( isset($_GET['taxonomy']) ){ unset($columns['description']); }
 
 return $columns;
}
if( is_admin() ) {
  if( isset($_GET['taxonomy']) && $_GET['taxonomy'] ) {
    $taxonomy = $_GET['taxonomy'];
    add_filter('manage_edit-'.$taxonomy.'_columns','jw_remove_taxonomy_description');
  }
}




function my_ajax_files() {
 wp_localize_script( 'function', 'my_ajax_script', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
add_action('template_redirect', 'my_ajax_files');


add_action( 'wp_ajax_nopriv_getPostData', 'getPostData' );
add_action( 'wp_ajax_getPostData', 'getPostData' );
function getPostData() {
  if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $post_id = ($_POST['post_id']) ? $_POST['post_id'] : 0;
    $post = get_post($post_id);
    $html = ($post) ? getPostContentHTML($post) : '';
    
    $response['content'] = $html;
    echo json_encode($response);
  }
  else {
    header("Location: ".$_SERVER["HTTP_REFERER"]);
  }
  die();
}
function getPostContentHTML($obj) {
  $post_id = $obj->ID;
  $post_title = $obj->post_title;
  $content = $obj->post_content;
  $content = apply_filters('the_content',$content); 
  ob_start(); ?>
  <div id="event-details" class="fullwidth-block event-details animated fadeIn">
    <div class="inner">
      <a href="javascript:void(0)" class="close-event-info"></a>
      <h2 class="eventtitle"><?php echo $post_title ?></h2>
      <div class="eventinfo"><?php echo $content ?></div>
    </div>
  </div>
  <?php
  $content = ob_get_contents();
  ob_end_clean();
  return $content;
}


function getPostTerms($posttype,$taxonomy,$orderby=null) {
  $args = array(
    'taxonomy' => $taxonomy,
    'post_types'=> array($posttype),
    'hide_empty' => 1,
  );

  if($orderby && count($orderby)==2 ) {
    $args['orderby'] = $orderby[0];
    $args['order'] = $orderby[1];
  }
  $terms = get_terms($args);
  return $terms;
}


