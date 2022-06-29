<?php
/**
 * Understrap Child Theme functions and definitions
 *
 * @package UnderstrapChild
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;



/**
 * Removes the parent themes stylesheet and scripts from inc/enqueue.php
 */
function understrap_remove_scripts() {
	wp_dequeue_style( 'understrap-styles' );
	wp_deregister_style( 'understrap-styles' );

	wp_dequeue_script( 'understrap-scripts' );
	wp_deregister_script( 'understrap-scripts' );
}
add_action( 'wp_enqueue_scripts', 'understrap_remove_scripts', 20 );



/**
 * Enqueue our stylesheet and javascript file
 */
function theme_enqueue_styles() {

	// Get the theme data.
	$the_theme = wp_get_theme();

	$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
	// Grab asset urls.
	$theme_styles  = "/css/child-theme{$suffix}.css";
	$theme_scripts = "/js/child-theme{$suffix}.js";

	wp_enqueue_style( 'child-understrap-styles', get_stylesheet_directory_uri() . $theme_styles, array(), $the_theme->get( 'Version' ) );
	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'child-understrap-scripts', get_stylesheet_directory_uri() . $theme_scripts, array(), $the_theme->get( 'Version' ), true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );



/**
 * Load the child theme's text domain
 */
function add_child_theme_textdomain() {
	load_child_theme_textdomain( 'understrap-child', get_stylesheet_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'add_child_theme_textdomain' );



/**
 * Overrides the theme_mod to default to Bootstrap 5
 *
 * This function uses the `theme_mod_{$name}` hook and
 * can be duplicated to override other theme settings.
 *
 * @param string $current_mod The current value of the theme_mod.
 * @return string
 */
function understrap_default_bootstrap_version( $current_mod ) {
	return 'bootstrap5';
}
add_filter( 'theme_mod_understrap_bootstrap_version', 'understrap_default_bootstrap_version', 20 );



/**
 * Loads javascript for showing customizer warning dialog.
 */
function understrap_child_customize_controls_js() {
	wp_enqueue_script(
		'understrap_child_customizer',
		get_stylesheet_directory_uri() . '/js/customizer-controls.js',
		array( 'customize-preview' ),
		'20130508',
		true
	);
}
add_action( 'customize_controls_enqueue_scripts', 'understrap_child_customize_controls_js' );


function my_connection_types() {
	p2p_register_connection_type( array(
		'name' => 'realty_to_city',
		'from' => 'realty',
		'to' => 'city',
		'cardinality' => 'many-to-one',
	) );
}
add_action('p2p_init', 'my_connection_types');


function get_price() {
	return number_format(get_field('price', get_the_ID()), 0, '', ' ') . ' 〒';
}

function get_realty_title() {
	$terms = get_the_terms(get_the_ID(), 'realty_type');
	$type = array_pop($terms);

  $title = [
    $type->name,
    get_field('address'),
  ];

	return implode(', ', $title);
}


add_action('wp_ajax_create_realty', 'create_realty_handler');
add_action('wp_ajax_nopriv_create_realty', 'create_realty_handler');
function create_realty_handler() {
	$type = get_term($_POST['realty_type'], 'realty_type');
	
	$post_data = array(
		'post_title'    => implode(', ', [$type->name, $_POST['address']]),
		'post_type'     => 'realty',
		'post_status'   => 'publish'
	);
	
	$post_id = wp_insert_post( $post_data );
	
	update_field( 'living-area', $_POST['living-area'], $post_id );
	update_field( 'area', $_POST['area'], $post_id );
	update_field( 'price', $_POST['price'], $post_id );
	update_field( 'floor', $_POST['floor'], $post_id );
	update_field( 'address', $_POST['address'], $post_id );
	update_field( 'floor-count', $_POST['floor-count'], $post_id );
	
	wp_set_post_terms($post_id, $type->name, 'realty_type');
	
	global $wpdb;
	$wpdb->insert( 'wp_p2p', ['p2p_type' => 'realty_to_city', 'p2p_to' => $_POST['city'], 'p2p_from' => $post_id] );
}