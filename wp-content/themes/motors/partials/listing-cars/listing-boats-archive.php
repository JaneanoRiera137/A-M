<?php
//Get filter content from custom function from inc/custom.php
$stm_listing_filter = stm_get_filter();

$listing = $stm_listing_filter['listing_query'];

$filter_badges = $stm_listing_filter['badges'];

$filter_links = stm_get_car_filter_links();

$listing_filter_position = get_theme_mod( 'listing_filter_position', 'left' );
if ( ! empty( $_GET['filter_position'] ) and $_GET['filter_position'] == 'right' ) {
	$listing_filter_position = 'right';
}

$sidebar_pos_classes = '';
$content_pos_classes = '';

if ( $listing_filter_position == 'right' ) {
	$sidebar_pos_classes = 'col-md-push-9 col-sm-push-0';
	$content_pos_classes = 'col-md-pull-3 col-sm-pull-0';
}

$view_list         = '';
$view_grid         = '';
$current_link_args = array();
if ( ! empty( $_GET ) ) {
	$current_link_args = $_GET;
}

$view_list_link              = $view_grid_link = $current_link_args;
$view_list_link['view_type'] = 'list';
$view_grid_link['view_type'] = 'grid';


if ( ! empty( $_GET['view_type'] ) ) {
	if ( $_GET['view_type'] == 'list' ) {
		$view_list = 'active';
	} elseif ( $_GET['view_type'] == 'grid' ) {
		$view_grid                      = 'active';
		$current_link_args['view_type'] = 'grid';
	}
} else {
	$view_list = 'active';
}

$current_view_type = 'list';
if($view_grid == 'active') {
	$current_view_type = 'grid';
}

?>

	<div class="row">
		<div class="col-md-12 col-sm-12 classic-filter-row sidebar-sm-mg-bt <?php echo esc_attr($sidebar_pos_classes); ?>">
			<?php echo ($stm_listing_filter['filter_html']); ?>
		</div>
		<div class="col-md-12 col-sm-12 <?php echo esc_attr($content_pos_classes); ?>">
			<div class="stm-ajax-row">
				<div class="stm-car-listing-sort-units clearfix sort-type-<?php echo esc_attr($current_view_type); ?>">
					<?php if($current_view_type == 'grid'): ?>
						<div class="stm-sort-by-options clearfix">
							<span><?php esc_html_e('Sort by:', 'motors'); ?></span>
							<div class="stm-select-sorting">
								<select>
									<option value="date_high" selected><?php esc_html_e( 'Date: newest first', 'motors' ); ?></option>
									<option value="date_low"><?php esc_html_e( 'Date: oldest first', 'motors' ); ?></option>
									<option value="price_low"><?php esc_html_e( 'Price: lower first', 'motors' ); ?></option>
									<option value="price_high"><?php esc_html_e( 'Price: highest first', 'motors' ); ?></option>
								</select>
							</div>
						</div>
						<div class="stm_boats_view_by">
							<?php get_template_part('partials/listing-layout-parts/items-per','page'); ?>
						</div>
					<?php else: ?>
						<?php get_template_part('partials/listing-layout-parts/boats-list','sort'); ?>
					<?php endif; ?>
				</div>

				<?php if(!empty($filter_badges)): ?>
					<div class="stm-filter-chosen-units">
						<?php echo $filter_badges; ?>
					</div>
				<?php endif; ?>

				<?php if($listing->have_posts()): ?>

					<?php if($view_grid == 'active'): ?>
						<div class="row row-3 car-listing-row <?php if($view_grid == 'active'){echo esc_attr('car-listing-modern-grid');} ?>">
					<?php endif; ?>


					<div class="stm-isotope-sorting">
						<?php while($listing->have_posts()): $listing->the_post();
							if($view_grid == 'active'){
								if(stm_is_listing()){
									get_template_part( 'partials/listing-cars/listing-grid', 'loop' );
								} else {
									get_template_part( 'partials/listing-cars/listing-grid', 'loop' );
								}
							} else {
								if(stm_is_listing()) {
									get_template_part( 'partials/listing-cars/listing-list-directory', 'loop' );
								} else {
									get_template_part( 'partials/listing-cars/listing-list-loop', 'boats' );
								}
							}
						endwhile; ?>
					</div>

					<?php if($view_grid == 'active'): ?>
						</div>
					<?php endif; ?>
				<?php else: ?>
					<div class="row">
						<div class="col-md-12">
							<div class="stm-isotope-sorting">
								<h3><?php esc_html_e('Sorry, No results', 'motors') ?></h3>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</div>
			<!--Pagination-->
			<div class="row stm-ajax-pagination classic-filter-pagination">
				<!--Pagination-->
				<?php
				$show_pagination = true;

				if($listing->found_posts == 0) {
					$show_pagination = false;
				}

				if(!empty($listing->found_posts) and !empty($listing->query_vars['posts_per_page'])) {
					if($listing->found_posts < $listing->query_vars['posts_per_page']) {
						$show_pagination = false;
					}
				}
				if($show_pagination): ?>
					<div class="col-md-12">
						<div class="stm-blog-pagination">
							<?php
							echo paginate_links( array(
								'base'           => stm_get_listing_archive_link() . '%_%',
								'type'           => 'list',
								'total'          => $listing->max_num_pages,
								'posts_per_page' => $listing->query_vars['posts_per_page'],
								'prev_text'      => '<i class="fa fa-angle-left"></i>',
								'next_text'      => '<i class="fa fa-angle-right"></i>',
							) );
							?>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</div> <!--col-md-9-->
	</div>

	<?php
	$bind_tax = stm_data_binding();
	?>


	<script type="text/javascript">
		(function($) {
			"use strict";

			var buttonText = '';
			$('document').ready(function(){
				$('.stm-boats-expand-filter span').click(function(){
					$('.stm-filter-sidebar-boats').toggleClass('expanded');
					$('.stm-boats-longer-filter').slideToggle();

					if(buttonText == '') {
						buttonText = $(this).text();
						$(this).text(stm_filter_expand_close);
					} else {
						$(this).text(buttonText);
						buttonText = '';
					}
				});

				var stmTaxRelations = <?php echo $bind_tax; ?>;

				$('.stm-filter-sidebar-boats select:not(.hide)').select2().on('change', function(){

					/*Remove disabled*/

					var stmCurVal = $(this).val();
					var stmCurSelect = $(this).attr('name');

					if (stmTaxRelations[stmCurSelect]) {
						var key = stmTaxRelations[stmCurSelect]['dependency'];
						$('select[name="' + key + '"]').val('');
						console.log(stmCurVal);
						if(stmCurVal == '') {
							$('select[name="' + key + '"] > option').each(function () {
								$(this).removeAttr('disabled');
							});
						} else {
							var allowedTerms = stmTaxRelations[stmCurSelect][stmCurVal];

							if(typeof(allowedTerms) == 'object') {
								$('select[name="' + key + '"] > option').removeAttr('disabled');

								$('select[name="' + key + '"] > option').each(function () {
									var optVal = $(this).val();
									if (optVal != '' && $.inArray(optVal, allowedTerms) == -1) {
										$(this).attr('disabled', '1');
									}
								});
							} else {
								$('select[name="' + key + '"]').val(allowedTerms);
							}
						}

						$('.stm-filter-sidebar-boats select[name="' + key + '"]').select2("destroy");

						$('.stm-filter-sidebar-boats select[name="' + key + '"]').select2();
					}
				});
			});

		})(jQuery);
	</script>

	<?php wp_reset_postdata(); ?>