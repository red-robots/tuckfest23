<?php if( is_front_page() || is_home() ) { 
  $home_banner = get_field('home_banner');
  $buttons = get_field('home_buttons');
  ?>
  <?php if( $home_banner || $buttons ) { ?>


    <?php if ($home_banner) { ?>
    <div class="home-banner">
      <div class="wrapper">
        <figure>
          <img src="<?php echo $home_banner['url'] ?>" alt="<?php echo $home_banner['title'] ?>">
        </figure>
      </div>
    </div>
    <?php } ?>

    <?php if ($buttons) { ?>

    <style>
      .home-buttons path,
      .home-buttons g {
        transition: all ease .3s;
      }
      #registration #Path_825,
      #registration #Path_826 {
        opacity: 0;
      }
      #registration a:hover #Path_825, 
      #registration a:hover #Path_826 {
        opacity: 1;
        transform: translateY(-4px);
      }
      #registration a:hover #Path_755,
      #registration a:hover #Path_754,
      #registration a:hover #Path_756,
      #registration a:hover #Path_755-2,
      #registration a:hover #Path_757-2,
      #registration a:hover .st0 {
        transform: translateY(-4px);
      }
      #registration a:hover #Rectangle_58 {
        transform: translateY(0);
      }
      #competitions.button a {
        width: 112.5%;
        left: -12.5%;
      }
      #competitions #Group_365,
      #competitions #Group_364 {
        opacity: 0;
        transform: translateX(20px);
      }
      #competitions #Group_361 {
        opacity: 0;
        transform: translateY(10px);
      }
      #competitions a:hover #Path_777,
      #competitions a:hover #Path_776,
      #competitions a:hover #Path_77577,
      #competitions a:hover #Path_774,
      #competitions a:hover #Path_773 {
        transform: translateX(12px);
      }
      #competitions a:hover #Group_365,
      #competitions a:hover #Group_364 {
        opacity: 1;
        transform: translateX(-8px);
      }
      #competitions a:hover #Group_361 {
        opacity: 1;
        transform: translateY(0);
      }
      #music #Subtraction_2 {
        transform: translateY(5px);
      }
      #music #Layer_3 {
        opacity: 0;
        transform: translateY(0) scale(0,0);
        transform-origin: 50% 50%;;
      }
      #music a:hover #Layer_3 {
        opacity: 1;
        transform: translateY(-10px) scale(1, 1);
      }
      #music a:hover #Subtraction_2,
      #music a:hover #Intersection_2 {
        transform: translateY(-5px);
      }
    </style>

    <div class="home-buttons">
      <div class="wrapper">
        <div class="flexwrap">
          <?php $i=1; foreach ($buttons as $btn) { 
            $color = ($btn['color']) ? $btn['color'] : '#CCC';
            $image = $btn['image'];
            $div_id = $btn['id'];
            $image_hover = $btn['image_hover'];
            $link = ($btn['link']) ? $btn['link'] : '';
            $pagelink = ( isset($link['url']) && $link['url'] ) ? $link['url'] : 'javascript:void(0)';
            $link_title = ( isset($link['title']) && $link['title'] ) ? $link['title'] : '';
            $target = ( isset($link['target']) && $link['target'] ) ? $link['target'] : '_self';
            if ( file_exists( locate_template('parts/graphic/'.$div_id.'.php') ) ) {
              if( $link_title &&  $pagelink ) {  ?>
              <div id="<?php echo $div_id ?>" class="button graphic">
                <a href="<?php echo $pagelink ?>" target="<?php echo $target ?>">
                  <span class="button-text"><?php echo $link_title ?></span>
                  <span class="graphic">
                    <?php include( locate_template('parts/graphic/'.$div_id.'.php') ); ?>
                  </span>
                </a>
              </div>
            <?php } ?>
            <?php } ?>
          <?php $i++; } ?>
        </div>
      </div>
    </div>
    <?php } ?>
    
  <?php } ?>
<?php } ?>