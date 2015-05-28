<?php
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-style' )
	);
	wp_enqueue_script( 'isc-scripts', get_stylesheet_directory_uri() . '/js/isc-scripts.js', array( 'jquery' ) );
}

function maera_child_mime_types( $mimes ) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter( 'upload_mimes', 'maera_child_mime_types');

function jptweak_remove_share() {
    remove_filter( 'the_content', 'sharing_display',19 );
    remove_filter( 'the_excerpt', 'sharing_display',19 );
    if ( class_exists( 'Jetpack_Likes' ) ) {
        remove_filter( 'the_content', array( Jetpack_Likes::init(), 'post_likes' ), 30, 1 );
    }
}
//add_action( 'loop_start', 'jptweak_remove_share' );

function maera_child_jetpack_sharing_buttons( $atts ) {
	require_once( WP_PLUGIN_DIR . '/jetpack/modules/likes.php' );
	if ( function_exists( 'sharing_display' ) ) {
		//sharing_display( '', true );
	}
 
	if ( class_exists( 'Jetpack_Likes' ) ) {
		$custom_likes = new Jetpack_Likes;
		return $custom_likes->post_likes( '' );
	}
	return '';
}
//add_action( 'theme_mod_header_content', 'maera_child_jetpack_sharing_buttons', 100, 1 );
//add_shortcode( 'maera_child_jetpack_sharing_buttons', 'maera_child_jetpack_sharing_buttons' );

function maera_child_vc_jetpack_sharing_buttons() {
	if ( ! function_exists( 'vc_map' ) ) {
		return;
	}

	vc_map( array(
		'name' => __( 'Jetpack Sharing Buttons', 'maera-child' ),
		'base' => 'maera_child_jetpack_sharing_buttons',
		'class' => '',
		'category' => __( 'Content', 'maera-child'),
		//'icon' => 'icon-wpb-row',
		//'weight' => 1000,
		'show_settings_on_create' => false,
		'params' => array(	
		)
	) );	
}
//add_action( 'vc_before_init', 'maera_child_vc_jetpack_sharing_buttons' );

function maera_child_header_content( $content ) {
	return html_entity_decode( $content );
}
add_filter( 'theme_mod_header_content', 'maera_child_header_content' );

/**
 * Register our sidebars and widgetized areas.
 *
 */
function maera_child_widgets_init() {

	register_sidebar( array(
		'name'          => 'Left Sidebar',
		'id'            => 'left_sidebar',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'maera_child_widgets_init' );

function maera_child_widgets_context( $context ) {
	$context['left_sidebar'] = Timber::get_widgets( 'left_sidebar' );
	return $context;
}
add_filter( 'maera/timber/context', 'maera_child_widgets_context' );

function maera_child_footer_copyright() {
	?>
	<div class="footer-copyright">
		<div class="container">
			&copy; <?php echo date('Y'); ?> Institute for Sustainable Communities
		</div>
  	</div>
}
add_action( 'maera/footer/after', 'maera_child_footer_copyright' );
