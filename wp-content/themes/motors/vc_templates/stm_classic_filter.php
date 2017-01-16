<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$recaptcha_enabled = get_theme_mod('enable_recaptcha',0);
$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
if(!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) {
	wp_enqueue_script( 'stm_grecaptcha' );
}
?>

<?php if(stm_is_motorcycle()) {
	get_template_part('partials/single-car-motorcycle/tabs');
} ?>

<div class="archive-listing-page <?php echo esc_attr($css_class); ?>">
	<?php
		$boats_template = get_theme_mod('listing_boat_filter', true);

		if(stm_is_listing()) {
			get_template_part( 'partials/listing-cars/listing-directory', 'archive' );
		} elseif(stm_is_boats() and $boats_template) {
			get_template_part( 'partials/listing-cars/listing-boats', 'archive' );
		} elseif(stm_is_motorcycle()) {
			require_once(locate_template( 'partials/listing-cars/motos/listing-motos-archive.php'));
		} else {
			get_template_part( 'partials/listing-cars/listing', 'archive' );
		}
	?>
</div>