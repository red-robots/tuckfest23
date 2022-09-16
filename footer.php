	</div><!-- #content -->
	
  <?php 
  $footer_logo = get_field("footer_logo","option");
  $social_media = get_social_media();
  ?>
  <footer id="colophon" class="site-footer" role="contentinfo">
    <div class="wrapper wide">
      <div class="flexwrap">
        <?php if ($footer_logo) { ?>
        <div class="footcol left">
         <img src="<?php echo $footer_logo['url'] ?>" alt="<?php echo $footer_logo['title'] ?>" class="footlogo"> 
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

        <?php if ($social_media) { ?>
        <div class="social-media">
          <?php foreach ($social_media as $m) { ?>
            <a href="<?php echo $m['url'] ?>" target="_blank" aria-label="<?php echo $m['type'] ?>"><i class="<?php echo $m['icon'] ?>"></i></a>
          <?php } ?>
        </div>
        <?php } else { ?>
          <div class="social-media nolinks">&nbsp;</div>
        <?php } ?>
      </div>
    </div>
	</footer><!-- #colophon -->
	
</div><!-- #page -->
<?php wp_footer(); ?>
</body>
</html>
