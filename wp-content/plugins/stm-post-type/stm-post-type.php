<?php
/*
Plugin Name: STM Post Type
Plugin URI: http://stylemixthemes.com/
Description: STM Post Type
Author: Stylemix Themes
Author URI: http://stylemixthemes.com/
Text Domain: stm-post-type
Version: 2.5.1
*/

define( 'STM_POST_TYPE', 'stm-post-type' );

$plugin_path = dirname(__FILE__);

if(!is_textdomain_loaded('stm-post-type')) {
	load_plugin_textdomain('stm-post-type', false, 'stm-post-type/languages');
}

require_once $plugin_path . '/post_type.class.php';

$options = get_option('stm_post_types_options');


$defaultPostTypesOptions = array(
	'listings' => array(
		'title' => __( 'Listado', STM_POST_TYPE ),
		'plural_title' => __( 'Listados', STM_POST_TYPE ),
		'rewrite' => 'listings'
	),
);


$stm_post_types_options = wp_parse_args( $options, $defaultPostTypesOptions );

STM_PostType::registerPostType( 'sidebar', __('Sidebar', STM_POST_TYPE),
	array(
		'menu_icon' => 'dashicons-schedule',
		'supports' => array( 'title', 'editor' ),
		'exclude_from_search' => true,
		'publicly_queryable' => false
	)
);

STM_PostType::registerPostType( 'listings', $stm_post_types_options['listings']['title'],
	array(
		'pluralTitle' => $stm_post_types_options['listings']['plural_title'],
		'menu_icon' => 'dashicons-location-alt',
		'show_in_nav_menus' => true,
		'supports' => array( 'title', 'editor', 'thumbnail', 'comments', 'excerpt' ) ,
		'rewrite' => array( 'slug' => $stm_post_types_options['listings']['rewrite'] ),
		'has_archive' => true
	)
);

STM_PostType::registerPostType(
	'test_drive_request',
	__( 'Test Drive Requests', STM_POST_TYPE ),
	array(
		'pluralTitle' => __('Pruebas', STM_POST_TYPE),
		'supports' => array( 'title' ),
		'exclude_from_search' => true,
		'publicly_queryable' => false,
		'show_in_menu' => 'edit.php?post_type=listings'
	) );

$title_box_opt = array(
	'page_bg_color' => array(
		'label' => __( 'Color de Fondo de la Página', STM_POST_TYPE ),
		'type'  => 'color_picker'
	),
	'transparent_header' => array(
		'label'   => __( 'Cabecera Transparente', STM_POST_TYPE ),
		'type'    => 'checkbox'
	),
	'separator_title_box' => array(
		'label'   => __( 'Caja de Título', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'alignment' => array(
		'label'   => __( 'Alineación', STM_POST_TYPE ),
		'type'    => 'select',
		'options' => array(
			'left' => __( 'Izquierda', STM_POST_TYPE ),
			'center' => __( 'Centro', STM_POST_TYPE ),
			'right' => __( 'Derecha', STM_POST_TYPE )
		)
	),
	'title' => array(
		'label'   => __( 'Título', STM_POST_TYPE ),
		'type'    => 'select',
		'options' => array(
			'show' => __( 'Mostrar', STM_POST_TYPE ),
			'hide' => __( 'Ocultar', STM_POST_TYPE )
		)
	),
	'sub_title' => array(
		'label'   => __( 'Sub Título', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'title_box_bg_color' => array(
		'label' => __( 'Color de Fondo', STM_POST_TYPE ),
		'type'  => 'color_picker'
	),
	'title_box_font_color' => array(
		'label' => __( 'Color de Fuente', STM_POST_TYPE ),
		'type'  => 'color_picker'
	),
	'title_box_line_color' => array(
		'label' => __( 'Color de Línea', STM_POST_TYPE ),
		'type'  => 'color_picker'
	),
	'title_box_subtitle_font_color' => array(
		'label' => __( 'Color de Fuente de Sub título', STM_POST_TYPE ),
		'type'  => 'color_picker'
	),
	'title_box_custom_bg_image' => array(
		'label' => __( 'Imagen de Fondo Personalizada', STM_POST_TYPE ),
		'type'  => 'image'
	),
	'separator_breadcrumbs' => array(
		'label'   => __( 'Migas de Pan', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'breadcrumbs' => array(
		'label'   => __( 'Migas de Pan', STM_POST_TYPE ),
		'type'    => 'select',
		'options' => array(
			'show' => __( 'Mostrar', STM_POST_TYPE ),
			'hide' => __( 'Ocultar', STM_POST_TYPE )
		)
	),
	'breadcrumbs_font_color' => array(
		'label' => __( 'Color de Migas de Pan', STM_POST_TYPE ),
		'type'  => 'color_picker'
	),
);

if(get_option('stm_motors_chosen_template') == 'motorcycle') {
	$title_box_opt['motorcycle_sep'] = array(
		'label'   => __( 'Opción de cuadro de título adicional (disposición de la motocicleta)', STM_POST_TYPE ),
		'type'    => 'separator'
	);
	$title_box_opt['sub_title_instead'] = array(
		'label'   => __( 'Texto en lugar de Título', STM_POST_TYPE ),
		'type'    => 'text'
	);
	$title_box_opt['disable_title_box_overlay'] = array(
		'label'   => __( 'Desactivar Caja de Color Overlay', STM_POST_TYPE ),
		'type'    => 'checkbox'
	);
}

STM_PostType::addMetaBox( 'page_options', __( 'Opciones de Página', STM_POST_TYPE ), array( 'page', 'post', 'listings', 'product' ), '', '', '', array(
	'fields' => $title_box_opt
) );

STM_PostType::addMetaBox( 'test_drive_form', __( 'Credentials', STM_POST_TYPE ), array( 'test_drive_request' ), '', '', '', array(
	'fields' => array(
		'name' => array(
			'label'   => __( 'Nombre', STM_POST_TYPE ),
			'type'    => 'text'
		),
		'email' => array(
			'label'   => __( 'E-mail', STM_POST_TYPE ),
			'type'    => 'text'
		),
		'phone' => array(
			'label'   => __( 'Teléfono', STM_POST_TYPE ),
			'type'    => 'text'
		),
		'date' => array(
			'label'   => __( 'Día', STM_POST_TYPE ),
			'type'    => 'text'
		),
	)
));

STM_PostType::addMetaBox( 'special_offers', __( 'Configuraciones de Ofertas Especiales', 'stm-post-type' ), array( 'listings' ), '', '', '', array(
	'fields' => array(
		'special_car' => array(
			'label'   => __( 'Oferta Especial', 'stm-post-type' ),
			'type'    => 'checkbox'
		),
		'special_text' => array(
			'label'   => __( 'Texto de Oferta Especial', 'stm-post-type' ),
			'type'    => 'text'
		),
		'special_image' => array(
			'label' => __( 'Banner de Oferta Especial', 'stm-post-type' ),
			'type'  => 'image'
		),
		'divider_main' => array(
			'label'   => __( 'Estilo distintivo de páginas inferiores', STM_POST_TYPE ),
			'type'    => 'separator'
		),
		'badge_text' => array(
			'label' => __( 'Texto Distintivo (default - ESPECIAL)', STM_POST_TYPE ),
			'type'  => 'text'
		),
		'badge_bg_color' => array(
			'label' => __( 'Distintivo de Color de Fondo', STM_POST_TYPE ),
			'type'  => 'color_picker'
		),
	)
));

$args = array('post_type' => 'wpcf7_contact_form', 'posts_per_page' => -1);
$available_cf7 = array();
if( $cf7Forms = get_posts( $args ) ){
	foreach($cf7Forms as $cf7Form){
		$available_cf7[$cf7Form->ID] = $cf7Form->post_title;
	};
} else {
	$available_cf7['Formularios CF7 no encontrados'] = 'none';
};

$users_args = array(
	'blog_id'      => $GLOBALS['blog_id'],
	'role'         => '',
	'meta_key'     => '',
	'meta_value'   => '',
	'meta_compare' => '',
	'meta_query'   => array(),
	'date_query'   => array(),
	'include'      => array(),
	'exclude'      => array(),
	'orderby'      => 'registered',
	'order'        => 'ASC',
	'offset'       => '',
	'search'       => '',
	'number'       => '',
	'count_total'  => false,
	'fields'       => 'all',
	'who'          => ''
);
$users = get_users( $users_args );
$users_dropdown = array(
	'no' => esc_html__('No asignado', STM_POST_TYPE)
);
if(!is_wp_error($users)) {
	foreach($users as $user) {
		$users_dropdown[$user->data->ID] = $user->data->user_login;
	}
}

$single_car_options = array(
	'automanager_id' => array(
		'label'   => __( 'ID de Carro', STM_POST_TYPE ),
		'type'    => 'hidden'
	),
	'stm_car_user' => array(
		'label'   => __( 'Usuario Agregado', STM_POST_TYPE ),
		'type'    => 'select',
		'options' => $users_dropdown
	),
	'stm_car_views' => array(
		'label'   => __( 'Visitas del vehículo', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'divider_main' => array(
		'label'   => __( 'Opciones Principales', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'stock_number' => array(
		'label'   => __( 'Número de Stock', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'vin_number' => array(
		'label'   => __( 'Número de Serie', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'registration_date' => array(
		'label'   => __( 'Fecha de Registro', STM_POST_TYPE ),
		'type'    => 'datepicker'
	),
	'history' => array(
		'label'   => __( 'Historial', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'history_link' => array(
		'label'   => __( 'Enlace de Historial', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'car_brochure' => array(
		'label'   => __( 'Folleto (.pdf)', STM_POST_TYPE ),
		'type'    => 'file'
	),
	'stm_car_location' => array(
		'label'   => __( 'Localización', STM_POST_TYPE ),
		'type'    => 'location'
	),
	'stm_lat_car_admin' => array(
		'label'   => __( 'Latitud', STM_POST_TYPE ),
		'type'    => 'hidden'
	),
	'stm_lng_car_admin' => array(
		'label'   => __( 'Longtitud', STM_POST_TYPE ),
		'type'    => 'hidden'
	),
	'divider_mpg' => array(
		'label'   => __( 'KPG', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'city_mpg' => array(
		'label'   => __( 'Ciudad KPG', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'highway_mpg' => array(
		'label'   => __( 'Highway MPG', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'divider_0' => array(
		'label'   => __( 'Opciones de Precio', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'regular_price_label' => array(
		'label'   => __( 'Etiqueta de precio regular (predeterminado - Comprar)', STM_POST_TYPE ),
		'type'    => 'text',
		'default' => __( 'Comprar para', STM_POST_TYPE ),
	),
	'regular_price_description' => array(
		'label'   => __( 'Descripción del precio regular (por defecto - Impuestos incluidos y chequeo)', STM_POST_TYPE ),
		'type'    => 'text',
		'default' => __( 'Impuestos Incluidos y Chequeo', STM_POST_TYPE ),
	),
	'special_price_label' => array(
		'label'   => __( 'Etiqueta de precio especial (por defecto - MSRP)', STM_POST_TYPE ),
		'type'    => 'text',
		'default' => __( 'MSRP', STM_POST_TYPE ),
	),
	'instant_savings_label' => array(
		'label'   => __( 'Etiqueta de ahorro instantánea (predeterminada: ahorros instantáneos :)', STM_POST_TYPE ),
		'type'    => 'text',
		'default' => __( 'Ahorros instantáneos:', STM_POST_TYPE ),
	),
	'car_price_form' => array(
		'label'   => __( 'Habilitar el formulario "Obtener precio de auto"', STM_POST_TYPE ),
		'type'    => 'checkbox',
	),
	'car_price_form_label' => array(
		'label'   => __( 'Etiqueta personalizada en lugar de precio', STM_POST_TYPE ),
		'type'    => 'text',
		'description' => __('Este texto aparecerá en lugar del precio', STM_POST_TYPE )
	),
	'divider' => array(
		'label'   => __( 'Opciones de Galería', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'gallery' => array(
		'label'   => __( 'Galería', STM_POST_TYPE ),
		'type'    => 'images'
	),
	'divider_2' => array(
		'label'   => __( 'Opciones de Video', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'video_preview' => array(
		'label'   => __( 'Previsualización de video', STM_POST_TYPE ),
		'type'    => 'image'
	),
	'gallery_video' => array(
		'label'   => __( 'Galería de Videos <br/> (URL de Video Embebido)', STM_POST_TYPE ),
		'type'    => 'text'
	),
	'gallery_videos' => array(
		'label'   => __( 'Videos adicionales <br/> (URL de Video Embebido)', STM_POST_TYPE ),
		'type'    => 'repeat_single_text'
	),
	'divider_3' => array(
		'label'   => __( 'Comparar Opciones', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'additional_features' => array(
		'label'   => __( 'Características adicionales', STM_POST_TYPE ),
		'type'    => 'text',
		'description' => __('Características separadas con comas, por ejemplo: Calefacción auxiliar, Bluetooth, Reproductor de CD, Cierre centralizado', STM_POST_TYPE)
	),
	'divider_4' => array(
		'label'   => __( 'Logotipos Certificados del Vehículo', STM_POST_TYPE ),
		'type'    => 'separator'
	),
	'certified_logo_1' => array(
		'label'   => __( 'Logo Certificado 1', STM_POST_TYPE ),
		'type'    => 'image'
	),
	'certified_logo_2' => array(
		'label'   => __( 'Logo Certificado 2', STM_POST_TYPE ),
		'type'    => 'image'
	),
	'certified_logo_2_link' => array(
		'label'   => __( 'Enlace de Historial 2', STM_POST_TYPE ),
		'type'    => 'text',
	),
);

if(get_option('stm_motors_chosen_template') == 'boats') {
	$single_car_options['gallery_videos_posters'] = array(
		'label'   => __( 'Videos adicionales <br/> Posters)', STM_POST_TYPE ),
		'type'    => 'repeat_single_image'
	);
}

STM_PostType::addMetaBox( 'single_car_options', __( 'Opciones de coche individual', STM_POST_TYPE ), array( 'listings' ), '', '', '', array(
	'fields' => $single_car_options
));

STM_PostType::addMetaBox( 'service_info', esc_html__( 'Options', STM_POST_TYPE ), array( 'service' ), '', '', '', array(
	'fields' => array(
		'icon' => array(
			'label' => esc_html__( 'Icon', STM_POST_TYPE ),
			'type'  => 'iconpicker'
		),
		'icon_bg' => array(
			'label' => esc_html__( 'Color de fondo del Icono', STM_POST_TYPE ),
			'type'  => 'color_picker'
		)
	)
) );

$listing = get_option('stm_motors_chosen_template');

if($listing == 'listing') {

	STM_PostType::registerPostType( 'dealer_review', __( 'Dealer Review', STM_POST_TYPE ),
		array(
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'editor' ),
			'exclude_from_search' => true,
			'publicly_queryable'  => false
		)
	);

	$rates = array();
	for($i=1; $i < 6; $i++) {
		$rates[$i] = $i;
	}

	$likes = array(
		'neutral' => esc_html__('Neutral', 'motors'),
		'yes' => esc_html__('Yes', 'motors'),
		'no' => esc_html__('No', 'motors'),
	);

	STM_PostType::addMetaBox( 'dealer_reviews', esc_html__( 'Reviews', STM_POST_TYPE ), array( 'dealer_review' ), '', '', '', array(
		'fields' => array(
			'stm_review_added_by' => array(
				'label'   => __( 'Usuario agregado por', STM_POST_TYPE ),
				'type'    => 'select',
				'options' => $users_dropdown
			),
			'stm_review_added_on' => array(
				'label'   => __( 'Usuario agregado en', STM_POST_TYPE ),
				'type'    => 'select',
				'options' => $users_dropdown
			),
			'stm_rate_1' => array(
				'label'   => __( 'Tarifa 1', STM_POST_TYPE ),
				'type'    => 'select',
				'options' => $rates
			),
			'stm_rate_2' => array(
				'label'   => __( 'Tarifa 2', STM_POST_TYPE ),
				'type'    => 'select',
				'options' => $rates
			),
			'stm_rate_3' => array(
				'label'   => __( 'Tarifa 3', STM_POST_TYPE ),
				'type'    => 'select',
				'options' => $rates
			),
			'stm_recommended' => array(
				'label'   => __( 'Recomendado', STM_POST_TYPE ),
				'type'    => 'select',
				'opciones' => $likes
			),
		)
	) );

}

function stm_plugin_styles() {
    $plugin_url =  plugins_url('', __FILE__);

    wp_enqueue_style( 'admin-styles', $plugin_url . '/assets/css/admin.css', null, null, 'all' );

    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker');

    wp_enqueue_style( 'stmcss-datetimepicker', $plugin_url . '/assets/css/jquery.stmdatetimepicker.css', null, null, 'all' );
    wp_enqueue_script( 'stmjs-datetimepicker', $plugin_url . '/assets/js/jquery.stmdatetimepicker.js', array( 'jquery' ), null, true );
	
	$google_api_key = get_theme_mod( 'google_api_key', '' );
	if( !empty($google_api_key) ) {
		$google_api_map = 'https://maps.googleapis.com/maps/api/js?libraries=places&key='.$google_api_key.'&';
	} else {
		$google_api_map = 'https://maps.googleapis.com/maps/api/js?libraries=places';
	}

	wp_register_script( 'stm_gmap_admin', $google_api_map, array( 'jquery' ), null, true );

	wp_enqueue_script( 'stm_gmap_admin' );

	wp_enqueue_script( 'stmjs-admin-places', $plugin_url . '/assets/js/stm-admin-places.js', array( 'jquery' ), null, true );

    wp_enqueue_media();
}

add_action( 'admin_enqueue_scripts', 'stm_plugin_styles' );

require_once $plugin_path . '/rewrite.php';

