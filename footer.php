	</div><!-- #content -->
	
  <?php 
  $footer_logo = get_field("footer_logo","option");
  $footer_logo_website = get_field("footer_logo_website","option");
  ?>
  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="wrapper">
      <div class="flexwrap">
        <?php if ($footer_logo) { ?>
        <div id="footlogo" class="footcol left">
          <?php if ($footer_logo_website) { ?>
            <a href="<?php echo $footer_logo_website ?>" target="_blank"><img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>" class="footlogo"></a>
          <?php } else { ?>
            <img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>" class="footlogo"> 
          <?php } ?>
        </div>
        <?php } ?>

        <?php if ( has_nav_menu( 'footer' ) ) { ?>
          <nav id="footer-navigation" class="footer-navigation" role="navigation">
            <?php wp_nav_menu( array( 'theme_location' => 'footer', 'container'=>false, 'menu_id' => 'footer-menu') ); ?>
            <?php if ( $topNavs = get_field("topNavs","option") ) { ?>
            <ul class="menu other">
            <?php foreach ($topNavs as $n) { 
              if( $n['link'] ) { 
                $a = $n['link'];
                $target = ( isset($a['target']) && $a['target'] ) ? $a['target'] : '_self';
                $icon = ($n['icon']) ? $n['icon'] : '';
                $hasIcon = ($icon) ? 'has-icon':'no-icon';
                ?>
                <li class="foot-link <?php echo $hasIcon ?>"><a href="<?php echo $a['url'] ?>" target="<?php echo $target ?>"><?php echo $icon ?><?php echo $a['title'] ?></a></li>
              <?php } ?>
            <?php } ?>
            </ul>
            <?php } ?>
          </nav>
        <?php } ?>
      </div>
    </div>

    <?php 
      $sponsors_text = get_field("footer_sponsors_text","option"); 
      if( have_rows('footer_sponsors', 'option') ) : ?>
      <div class="footer-sponsors sponsors container rotator">
        <?php if ($sponsors_text) { ?>
          <div class="sponsor-text"><?php echo $sponsors_text ?></div> 
        <?php } ?>
        
        <?php while( have_rows('footer_sponsors', 'option') ) : the_row();

          $icon = get_sub_field('icon', 'option');
          $link = get_sub_field('link', 'option');

        ?>
            <li>
              <a href="<?php echo $link; ?>" target="_blank">
                <img src="<?php echo $icon['url']; ?>">
              </a>
            </li>
          <?php endwhile; ?>
        
      </div>
      <?php endif; ?>

	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
