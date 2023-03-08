<?php if( is_front_page() || is_home() ) { 
  $home_banner = get_field('home_banner');
  
  $buttons = get_field('home_buttons');
  ?>
  <?php if( $home_banner || $buttons ) { ?>


    <?php if ($home_banner) { ?>
    <div class="home-banner">
      <div class="wrapper">
        <figure>
          <img class="desktop" src="<?php echo $home_banner['url'] ?>" alt="<?php echo $home_banner['title'] ?>">
          <!-- <img class="mobile" src="<?php echo $home_banner_mobile['url'] ?>" alt="<?php echo $home_banner_mobile['title'] ?>"> -->
        </figure>
      </div>
    </div>
    <?php } ?>

    <?php if ($buttons) { ?>
    <div class="home-buttons">
      <div class="wrapper">
        <div class="flexwrap">
          <?php $i=1; foreach ($buttons as $btn) { 
            $color = ($btn['color']) ? $btn['color'] : '#CCC';
            // $image_hover = $btn['image_hover'];
            $image = $btn['image'];
            $div_id = $btn['id'];
            $link = ($btn['link']) ? $btn['link'] : '';
            $pagelink = ( isset($link['url']) && $link['url'] ) ? $link['url'] : 'javascript:void(0)';
            $link_title = ( isset($link['title']) && $link['title'] ) ? $link['title'] : '';
            $target = ( isset($link['target']) && $link['target'] ) ? $link['target'] : '_self';
            $bgcolor = ($color) ? ' style="background-color:'.$color.'"':'';
            if ( file_exists( locate_template('parts/graphic/'.$div_id.'.php') ) ) {
              if( $link_title &&  $pagelink ) {  ?>
              <div id="<?php echo $div_id ?>" class="button graphic <?php echo $div_id?>_svg">
                <a href="<?php echo $pagelink ?>" target="<?php echo $target ?>" class="<?php echo $div_id?>-icon">
                  <span class="button-text"><?php echo $link_title ?></span>
                  <span class="graphic">
                    <?php include( locate_template('parts/graphic/'.$div_id.'.php') ); ?>
                  </span>
                </a>
              </div>
              <?php if ($color) { ?>
              <style type="text/css">
                @media screen and (max-width:820px) {#<?php echo $div_id ?>.button.graphic{background-color:<?php echo $color ?>}}
              </style>  
              <?php } ?>
            <?php } ?>
            <?php } ?>
          <?php $i++; } ?>
        </div>
      </div>
    </div>
    <?php } ?>
    
  <?php } ?>
<?php } ?>
<?php  if( have_rows( 'boxes' ) ) : ?>
        <section class="extra-boxes">
          <div class="home-buttons">
              <div class="wrapper">
                <div class="flexwrap">
                  <?php while( have_rows( 'boxes' ) ): the_row();
                    $box_color = get_sub_field('box_color');
                    $title = get_sub_field('title');
                    $link = get_sub_field('link');
                    $image = get_sub_field('image'); 
                    if( $box_color == 'orange') {
                      $cClass = 'orange';
                    } elseif( $box_color == 'blue') {
                      $cClass = 'blue';
                    } elseif( $box_color == 'red') {
                      $cClass = 'red';
                    } else {
                      $cClass = 'green';
                    }
                    ?>
                    <div class="button extra">
                      <a href="<?php echo $link ?>">
                        <img src="<?php echo $image['url'] ?>">
                        <div class="bottom <?php echo $cClass; ?>">
                          <div class="title"><?php echo $title; ?></div>
                        </div>
                      </a>
                    </div>
                  <?php endwhile; ?>
                </div>
              </div>
            </div>
        </section>
    
<?php endif; ?>