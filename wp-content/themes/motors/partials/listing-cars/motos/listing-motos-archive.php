<?php
	//Get filter content from custom function from inc/custom.php
	$stm_listing_filter = stm_get_filter(true);

	$listing = $stm_listing_filter['listing_query'];

	$filter_badges = $stm_listing_filter['badges'];

	$filter_links = stm_get_car_filter_links();

	$listing_filter_position = get_theme_mod('listing_filter_position', 'left');
	if(!empty($_GET['filter_position']) and $_GET['filter_position'] == 'right') {
		$listing_filter_position = 'right';
	}

	$sidebar_pos_classes = '';
	$content_pos_classes = '';

	if($listing_filter_position == 'right') {
		$sidebar_pos_classes = 'col-md-push-9 col-sm-push-0';
		$content_pos_classes = 'col-md-pull-3 col-sm-pull-0';
	}

	//	Sort selected
	$date_selected = 'selected';
	$location_selected = '';
	if(stm_location_validates()) {
		$date_selected = '';
		$location_selected = 'selected';
	}

	$title_generated = '';
	$title_generated = $stm_listing_filter['title'];

	$total_matches = $stm_listing_filter['total'];


	//Grid/list settings
	$view_list = '';
	$view_grid = '';
	$current_link_args = array();
	if(!empty($_GET)){
		$current_link_args = $_GET;
	}

	$view_list_link = $view_grid_link = $current_link_args;
	$view_list_link['view_type'] = 'list';
	$view_grid_link['view_type'] = 'grid';


	if(!empty($_GET['view_type'])) {
		if ( $_GET['view_type'] == 'list' ) {
			$view_list = 'active';
		} elseif ( $_GET['view_type'] == 'grid' ) {
			$view_grid = 'active';
			$current_link_args['view_type'] = 'grid';
		}
	} else {
		$view_list = 'active';
	}

	$tab_tax = '';
	$tab_tax_exist = false;
	$filter = stm_get_car_filter();
	foreach($filter as $filter_taxex) {
		if(!empty($filter_taxex['use_on_tabs']) and $filter_taxex['use_on_tabs'] and !$tab_tax_exist) {
			$tab_tax = $filter_taxex;
			$tab_tax_exist = true;
		}
	}

	if($tab_tax_exist) {
		echo '<style type="text/css">';
		echo '.filter .stm-filter_' . $tab_tax['slug'] . '{display:none}';
		echo '</style>';
	}
?>

	<div class="row">
		<div class="col-md-3 col-sm-12 classic-filter-row sidebar-sm-mg-bt <?php echo esc_attr($sidebar_pos_classes); ?>">
			<?php echo ($stm_listing_filter['filter_html']); ?>
			<?php if(!empty($sidebar)):
				$post_sidebar = get_post( $sidebar );
				if(!empty($post_sidebar)) { ?>
					<style type="text/css">
						<?php echo get_post_meta( $sidebar, '_wpb_shortcodes_custom_css', true ); ?>
					</style>

					<div class="sidebar-area-vc stm-sidebar-mode-vc">
						<?php echo apply_filters( 'the_content' , $post_sidebar->post_content); ?>
					</div>
				<?php }
			endif; ?>
		</div>
		<div class="col-md-9 col-sm-12 <?php echo esc_attr($content_pos_classes); ?>">
			<div class="stm-ajax-row">
				<div class="stm-car-listing-sort-units stm-car-listing-directory-sort-units clearfix">
					<div class="stm-directory-listing-top__right">
						<div class="clearfix">
							<div class="stm-listing-directory-title">
								<h3 class="title"><?php echo esc_attr($title_generated); ?></h3>
								<div class="stm-listing-directory-total-matches total stm-secondary-color heading-font"><span><?php echo esc_attr($total_matches); ?></span> <?php esc_html_e('matches', 'motors');  ?></div>
							</div>
							<div class="stm-view-by">
								<a href="<?php echo esc_url(add_query_arg($view_grid_link, stm_get_listing_archive_link())); ?>" class="view-grid view-type <?php echo esc_attr($view_grid); ?>">
									<i class="stm-icon-grid"></i>
								</a>
								<a href="<?php echo esc_url(add_query_arg($view_list_link, stm_get_listing_archive_link())); ?>" class="view-list view-type <?php echo esc_attr($view_list); ?>">
									<i class="stm-icon-list"></i>
								</a>
							</div>
						</div>
					</div>
				</div>

				<?php if(!empty($filter_badges)): ?>
					<div class="stm-filter-chosen-units">
						<?php echo $filter_badges; ?>
					</div>
				<?php endif; ?>

				<?php if(!empty($listing)): ?>
					<?php if($listing->have_posts()): ?>
	
						<?php if($view_grid == 'active'): ?>
							<div class="row row-3 car-listing-row <?php if($view_grid == 'active'){echo esc_attr('car-listing-modern-grid');} ?>">
						<?php endif; ?>

						<?php
							if($view_grid == 'active'){
								$template =  'partials/listing-cars/motos/grid';
							} else {
								$template = 'partials/listing-cars/motos/list';
							}
						?>
	
						<div class="stm-isotope-sorting">
							<?php while($listing->have_posts()): $listing->the_post();
								get_template_part($template);
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
				<?php endif; ?>
			</div>
			<!--Pagination-->
			<?php if(!empty($listing)): ?>
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
							<div class="clearfix">
								<div class="stm-blog-pagination">
									<?php if ( !get_previous_posts_link('<i class="fa fa-angle-left"></i>', $listing->max_num_pages ) ) {
										echo '<div class="stm-prev-next stm-prev-btn disabled"><i class="fa fa-angle-left"></i></div>';
									}

									echo paginate_links( array(
										'base'           => stm_get_listing_archive_link() . '%_%',
										'type'           => 'list',
										'total'          => $listing->max_num_pages,
										'posts_per_page' => $listing->query_vars['posts_per_page'],
										'prev_text'      => '<i class="fa fa-angle-left"></i>',
										'next_text'      => '<i class="fa fa-angle-right"></i>',
									) );

									if ( ! get_next_posts_link('<i class="fa fa-angle-right"></i>', $listing->max_num_pages ) ) {

										echo '<div class="stm-prev-next stm-next-btn disabled"><i class="fa fa-angle-right"></i></div>';
									} ?>
								</div>
								<?php if(stm_is_motorcycle()): ?>
									<div class="stm-motorcycle-per-page stm_boats_view_by">
										<?php get_template_part('partials/listing-layout-parts/items-per','page'); ?>
									</div>
	                            <?php endif; ?>
							</div>
						</div>
					<?php elseif(stm_is_motorcycle()): ?>
						<div class="stm-motorcycle-per-page stm_boats_view_by left-mode">
							<?php get_template_part('partials/listing-layout-parts/items-per','page'); ?>
						</div>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div> <!--col-md-9-->
	</div>

	<?php wp_reset_postdata(); ?>

<?php
$stm_vehicle_listing_options = stm_get_car_filter(); ?>
<style type="text/css">
	<?php foreach($stm_vehicle_listing_options as $stm_vehicle_listing_option): ?>
		<?php if(!empty($stm_vehicle_listing_option['numeric']) and $stm_vehicle_listing_option['numeric']): ?>
			.select2-selection__rendered[title="<?php echo esc_html__('Max', 'motors').' '.esc_attr($stm_vehicle_listing_option['single_name']); ?>"] {
		<?php else: ?>
			.select2-selection__rendered[title="<?php echo esc_attr($stm_vehicle_listing_option['single_name']); ?>"] {
		<?php endif; ?>
			background-color: transparent !important;
			border: 1px solid rgba(170,170,170,0.4) !important;
			color: #fff !important;
		}

		<?php if(!empty($stm_vehicle_listing_option['numeric']) and $stm_vehicle_listing_option['numeric']): ?>
		.select2-selection__rendered[title="<?php echo esc_html__('Max', 'motors').' '.esc_attr($stm_vehicle_listing_option['single_name']); ?>"] + .select2-selection__arrow b {
		<?php else: ?>
		.select2-selection__rendered[title="<?php echo esc_attr($stm_vehicle_listing_option['single_name']); ?>"] + .select2-selection__arrow b {
		<?php endif; ?>
			color: rgba(255,255,255,0.5);
		}
	<?php endforeach; ?>
</style>


<!--JS translations-->
<script type="text/javascript">
	var stm_added_to_compare_text = "<?php esc_html_e('Added to compare', 'motors'); ?>";
	var stm_removed_from_compare_text = "<?php esc_html_e('was removed from compare', 'motors'); ?>";
	var stm_already_added_to_compare_text = "<?php esc_html_e('You have already added 3 cars', 'motors'); ?>";
</script>