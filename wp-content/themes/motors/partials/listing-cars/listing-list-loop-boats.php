<?php
$regular_price_label = get_post_meta(get_the_ID(), 'regular_price_label', true);
$special_price_label = get_post_meta(get_the_ID(),'special_price_label',true);

$badge_text = get_post_meta(get_the_ID(),'badge_text',true);
$badge_bg_color = get_post_meta(get_the_ID(),'badge_bg_color',true);

$price = get_post_meta(get_the_id(),'price',true);
$sale_price = get_post_meta(get_the_id(),'sale_price',true);

$car_price_form_label = get_post_meta(get_the_ID(), 'car_price_form_label', true);

$data_price = '0';

if(!empty($price)) {
	$data_price = $price;
}

if(!empty($sale_price)) {
	$data_price = $sale_price;
}

if(empty($price) and !empty($sale_price)) {
	$price = $sale_price;
}

$mileage = get_post_meta(get_the_id(),'mileage',true);

$data_mileage = '0';

if(!empty($mileage)) {
	$data_mileage = $mileage;
}

$middle_infos = stm_get_car_archive_listings();

$taxonomies = stm_get_taxonomies();

$categories = wp_get_post_terms(get_the_ID(), $taxonomies);

$classes = array();
$datas = array();

if(!empty($categories)) {
	foreach($categories as $category) {
		$classes[] = $category->slug.'-'.$category->term_id;
		$datas[] = 'data-' . $category->taxonomy.'="'.$category->name.'"';
	}

	$loc = get_post_meta(get_the_id(), 'stm_car_location', true);
	if(empty($loc)) {
		$loc = 'zzzzz';
	}
	$datas[] = 'data-stm_car_location="'.$loc.'"';
}

$datas_num_arr = array();
$datas_num = stm_get_car_archive_listings();

if(!empty($datas_num)) {
	foreach($datas_num as $data_num) {
		if(!empty($data_num['numeric']) and $data_num['numeric']) {
			$val = get_post_meta( get_the_id(), $data_num['slug'], true );
			if ( empty( $val ) ) {
				$val = '';
			}

			$datas_num_arr[] = 'data-' . $data_num['slug'] . '="' . intval( $val ) . '"';
		}
	}
}

$show_compare = get_theme_mod( 'show_listing_compare', true );

$cars_in_compare = array();
if ( ! empty( $_COOKIE['compare_ids'] ) ) {
	$cars_in_compare = $_COOKIE['compare_ids'];
}

$car_already_added_to_compare = '';
$car_compare_status           = esc_html__( 'Add to compare', 'motors' );

if ( ! empty( $cars_in_compare ) and in_array( get_the_ID(), $cars_in_compare ) ) {
	$car_already_added_to_compare = 'active';
	$car_compare_status           = esc_html__( 'Remove from compare', 'motors' );
}

//Lat lang location
$stm_car_location = get_post_meta(get_the_ID(),'stm_car_location', true);
$stm_to_lng = get_post_meta(get_the_ID(),'stm_lng_car_admin', true);
$stm_to_lat = get_post_meta(get_the_ID(),'stm_lat_car_admin', true);


$distance = '';
if(stm_location_validates()) {

	$stm_from_lng = esc_attr(floatval($_GET['stm_lng']));
	$stm_from_lat = esc_attr(floatval($_GET['stm_lat']));

	if(!empty($stm_to_lng) and !empty($stm_to_lat)) {
		$distance = stm_calculate_distance_between_two_points( $stm_from_lat, $stm_from_lng, $stm_to_lat, $stm_to_lng );
	}
}

?>

<div
	class="listing-list-loop stm-isotope-listing-item all <?php print_r(implode(' ', $classes)); ?>"
	data-price="<?php echo esc_attr($data_price) ?>"
    data-date="<?php echo get_the_date('Ymdhi') ?>"
    data-mileage="<?php echo esc_attr($data_mileage); ?>"
	<?php print_r(implode(' ', $datas)); ?>
	<?php print_r(implode(' ', $datas_num_arr)); ?>
	>

		<div class="image">
			<?php if(!empty($gallery_video)): ?>
				<span class="video-preview fancy-iframe" data-url="<?php echo esc_url($gallery_video); ?>"><i class="fa fa-film"></i><?php esc_html_e('Video', 'motors'); ?></span>
			<?php endif; ?>
			<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
				<div class="image-inner">

					<?php if(has_post_thumbnail()): ?>
						<?php
							$img = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'stm-img-796-466');
						?>
						<img
							data-original="<?php echo esc_url($img[0]); ?>"
							src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/boats-placeholders/boats-170.png'); ?>"
							class="lazy img-responsive"
							alt="<?php echo stm_generate_title_from_slugs(get_the_id()); ?>"
						/>

					<?php else : ?>
						<img
							src="<?php echo esc_url(get_stylesheet_directory_uri().'/assets/images/boats-placeholders/boats-170.png'); ?>"
							class="img-responsive"
							alt="<?php esc_html_e('Placeholder', 'motors'); ?>"
							/>
					<?php endif; ?>

				</div>
				<?php stm_get_boats_image_hover(get_the_ID()); ?>
				<!--Compare-->
				<?php if(!empty($show_compare) and $show_compare): ?>
					<div
						class="stm-listing-compare stm-compare-directory-new <?php echo esc_attr($car_already_added_to_compare); ?>"
						data-id="<?php echo esc_attr(get_the_id()); ?>"
						data-title="<?php echo stm_generate_title_from_slugs(get_the_id(),false); ?>"
						data-toggle="tooltip" data-placement="bottom" title="<?php echo esc_attr($car_compare_status); ?>"
						>
						<i class="stm-boats-icon-add-to-compare"></i>
					</div>
				<?php endif; ?>
			</a>
		</div>


		<div class="content">
			<div class="meta-top">

				<?php if(!empty($price) and !empty($sale_price) and $price != $sale_price):?>
					<div class="price discounted-price">
						<div class="regular-price">
							<?php if(!empty($special_price_label)): ?>
								<span class="label-price"><?php echo esc_attr($special_price_label); ?></span>
							<?php endif; ?>
							<?php echo esc_attr(stm_listing_price_view($price)); ?>
						</div>

						<div class="sale-price">
							<?php if(!empty($regular_price_label)): ?>
								<span class="label-price"><?php echo esc_attr($regular_price_label); ?></span>
							<?php endif; ?>
							<span class="heading-font"><?php echo esc_attr(stm_listing_price_view($sale_price)); ?></span>
						</div>
					</div>
				<?php elseif(!empty($price)): ?>
					<div class="price">
						<div class="normal-price">
							<?php if(!empty($regular_price_label)): ?>
								<span class="label-price"><?php echo esc_attr($regular_price_label); ?></span>
							<?php endif; ?>
							<?php if(!empty($car_price_form_label)): ?>
								<span class="heading-font"><?php echo esc_attr($car_price_form_label); ?></span>
							<?php else: ?>
								<span class="heading-font"><?php echo esc_attr(stm_listing_price_view($price)); ?></span>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<div class="title heading-font">
					<a href="<?php the_permalink() ?>" class="rmv_txt_drctn">
						<?php echo stm_generate_title_from_slugs(get_the_id()); ?>
					</a>
				</div>
			</div>
			<?php if(!empty($middle_infos)): ?>

				<?php
					$middle_infos['location'] = array(
						'single_name' => esc_html__('Location', 'motors'),
						'slug' => 'stm_car_location',
						'font' => 'stm-boats-icon-pin',
						'numeric' => 'true',
					);
					if(!empty($distance)) {
						$middle_infos['location']['value'] = $distance;
					}
				?>

				<div class="meta-middle">
					<?php foreach($middle_infos as $middle_info): ?>
						<?php
							if(empty($middle_info['value'])) {
								$data_meta = get_post_meta( get_the_id(), $middle_info['slug'], true );
							} else {
								$data_meta = $middle_info['value'];
							}
							$data_value = '';
						?>
						<?php if(!empty($data_meta) and $data_meta != 'none' and $middle_info['slug'] != 'price'):
							if(!empty($middle_info['numeric']) and $middle_info['numeric']):
								$data_value = ucfirst($data_meta);
							else:
								$data_meta_array = explode(',',$data_meta);
								$data_value = array();

								if(!empty($data_meta_array)){
									foreach($data_meta_array as $data_meta_single) {
										$data_meta = get_term_by('slug', $data_meta_single, $middle_info['slug']);
										if(!empty($data_meta->name)) {
											$data_value[] = esc_attr($data_meta->name);
										}
									}
								}

							endif;

						endif; ?>

						<?php if(!empty($data_value) and $data_value != ''): ?>
							<?php if($middle_info['slug'] != 'price' and !empty($data_meta)): ?>
								<div class="meta-middle-unit <?php if(!empty($middle_info['font'])){ echo esc_attr('font-exists');} ?> <?php echo esc_attr($middle_info['slug']); ?>">
									<div class="meta-middle-unit-top">
										<?php if(!empty($middle_info['font'])): ?>
											<div class="icon"><i class="<?php echo esc_attr($middle_info['font']); ?>"></i></div>
										<?php endif; ?>
										<div class="name">
											<?php
											if(is_array($data_value)){
												if(count($data_value) > 1) { ?>

													<div
														class="stm-tooltip-link"
														data-toggle="tooltip"
														data-placement="bottom"
														title="<?php echo esc_attr(implode(', ', $data_value)); ?>">
														<?php echo $data_value[0].' <span class="stm-dots">...</span>'; ?>
													</div>

												<?php } else {
													echo esc_attr(implode(', ', $data_value));
												}
											} else {
												echo esc_attr($data_value);
											}
											?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

			<a href="<?php the_permalink(); ?>" class="stm-car-view-more button visible-xs"><?php esc_html_e('View more', 'motors'); ?></a>
		</div>

</div>
