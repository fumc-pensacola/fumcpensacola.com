<?php
/**
 * Theme Footer
 */

// No direct access
if ( ! defined( 'ABSPATH' ) ) exit;

?>

		</div>

	</div>

	<!-- Middle End -->

	<!-- Footer Start -->

	<footer id="resurrect-footer">

		<div id="resurrect-footer-inner">

			<div id="resurrect-footer-content" class="resurrect-clearfix">

				<div id="resurrect-footer-responsive-toggle">

					<a id="resurrect-footer-full-site" href="#">
						<?php _e( 'View Full Site', 'resurrect' ); ?>
					</a>

					<a id="resurrect-footer-mobile-site" href="#">
						<?php _e( 'View Mobile Site', 'resurrect' ); ?>
					</a>

				</div>

				<div id="resurrect-footer-left" class="resurrect-clearfix">

					<?php
					wp_nav_menu( array(
						'theme_location'	=> 'footer',
						'menu_id'			=> 'resurrect-footer-menu-links',
						'container'			=> false, // don't wrap in div
						'depth'				=> 1, // no sub menus
						'fallback_cb'		=> false // don't show pages if no menu found - show nothing
					) );
					?>

					<?php if ( $footer_icons = resurrect_social_icons( ctfw_customization( 'footer_icon_urls' ), 'return' ) ) : ?>
						<div id="resurrect-footer-social-icons">
							<?php echo $footer_icons; ?>
						</div>
					<?php endif; ?>

				</div>

				<div id="resurrect-footer-right">

					<?php if ( ctfw_customization( 'footer_address' ) || ctfw_customization( 'footer_phone' ) ) : ?>

						<ul id="resurrect-footer-contact">

							<?php if ( ctfw_customization( 'footer_address' ) ) : ?>
							<li><span id="resurrect-footer-icon-address" class="<?php resurrect_icon_class( 'footer-address' ); ?>"></span> <span id="resurrect-footer-address"><?php echo ctfw_customization( 'footer_address' ); ?></span></li>
							<?php endif; ?>

							<?php if ( ctfw_customization( 'footer_phone' ) ) : ?>
							<li><span id="resurrect-footer-icon-phone" class="<?php resurrect_icon_class( 'footer-phone' ); ?>"></span> <span id="resurrect-footer-phone"><?php echo ctfw_customization( 'footer_phone' ); ?></span></li>
							<?php endif; ?>

						</ul>

					<?php endif; ?>

					<?php if ( ctfw_customization( 'footer_notice' ) ) : ?>
						<div id="resurrect-notice">
							<?php echo nl2br( wptexturize( do_shortcode( ctfw_customization( 'footer_notice' ) ) ) ); ?>
						</div>
					<?php endif; ?>

				</div>

			</div>

		</div>

	</footer>

	<!-- Footer End -->

</div>

<!-- Container End -->

<?php
wp_footer(); // a hook for extra code in the footer, if needed
?>

<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.8.4/moment.min.js"></script>

<script>
  function instaCallback(response) {
    for (var i = 0; i < Math.min(10, response.data.length); i++) {
      var data = response.data[i];
      var img = new Image(data.images.low_resolution.width / 2, data.images.low_resolution.height / 2);
      img.src = data.images.low_resolution.url;
      images.push(img);
      jQuery('#chrismon-tree-images').append(jQuery('<a>').attr('href', data.link).append(img));
    }
  }

  if (jQuery && jQuery('#chrismon-tree-images').length) {
    window.images = [];
    jQuery.ajax({
      url: 'https://api.instagram.com/v1/tags/christmasfumc/media/recent?client_id=87a18d1bfa66478791f2a41d202e6397&callback=instaCallback',
      dataType: 'jsonp',
      data: {},
      jsonpCallback: 'instaCallback'
    });
  }


  // BULLETINS
  (function ($) {
    var $traditionalBulletin = $('#traditional-bulletin'),
        $ICONBulletin = $('#icon-bulletin');
    if ($traditionalBulletin.length) {
      $.get('https://fumc.herokuapp.com/api/bulletins?orderBy=date:Z').then(function (bulletins) {
        if (bulletins.length) {
          var result = { },
              newestBulletins = bulletins.filter(function (b) { return b.date === bulletins[0].date; });
          
          for (var i = 0; i < newestBulletins.length; i++) {
            result[newestBulletins[i].service] = newestBulletins[i];
          }
          
          var traditional = result['Traditional Services'],
              icon = result['ICON'];
              
          if (traditional) {
            $traditionalBulletin
              .show()
              .find('a')
              .attr('href', 'https://fumc.herokuapp.com/api/file/' + traditional.file)
              .find('#traditional-bulletin-date')
              .text(moment(traditional.date).format('MMMM D, YYYY'));
          }
          
          if (icon) {
            $ICONBulletin
              .show()
              .find('a')
              .attr('href', 'https://fumc.herokuapp.com/api/file/' + icon.file)
              .find('#icon-bulletin-date')
              .text(moment(icon.date).format('MMMM D, YYYY'));
          }
        }
      });
    }
  })(jQuery);

</script>

</body>
</html>