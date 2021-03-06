<?php
$listing_grid_choices = get_theme_mod('listing_grid_choices', '9,12,18,27');
$listing_grid_choice = get_theme_mod('listing_grid_choice', '9');
$listing_grid_choices = explode(',',$listing_grid_choices);

if(!empty($_GET['posts_per_page'])) {
	$listing_grid_choice = intval($_GET['posts_per_page']);
}

if(!empty($listing_grid_choices) and in_array($listing_grid_choice, $listing_grid_choices)): ?>
	<?php if(stm_is_motorcycle()): ?>
		<span class="stm_label heading-font"><?php esc_html_e('Vehicles per page:', 'motors'); ?></span>
	<?php endif; ?>
	<span class="first"><?php esc_html_e('Show', 'motors'); ?></span>
	<?php if(stm_is_motorcycle()): ?>
		<div class="stm_motorcycle_pp">
	<?php endif; ?>
		<ul>
			<?php foreach($listing_grid_choices as $listing_grid_choice_single): ?>
				<?php
					if($listing_grid_choice_single == $listing_grid_choice) {
						$active = 'active';
					} else {
						$active = '';
					}
				?>

				<li class="<?php echo esc_attr($active); ?>">
					<span>
						<a href="<?php echo esc_url(add_query_arg(array('posts_per_page' => intval($listing_grid_choice_single)),$_SERVER['REQUEST_URI'])); ?>">
							<?php echo intval($listing_grid_choice_single); ?>
						</a>
					</span>
				</li>

			<?php endforeach; ?>
		</ul>
	<?php if(stm_is_motorcycle()): ?>
		</div>
	<?php endif; ?>
	<span class="last"><?php esc_html_e('items per page', 'motors'); ?></span>
<?php endif; ?>