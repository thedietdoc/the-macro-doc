<?php

/*
Plugin Name: The Macro Doc
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: A full featured macro-nutrient calcualtor provided by Dr. Joe Klemczewski
Version: 0.1.0
Author: The Zooxinator
Author URI: http://URI_Of_The_Plugin_Author
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: the-macro-doc
*/


if(! defined('ABSPATH')) exit;

if(! defined('MACRODOC_PLUGIN_NAME')) {
	define( "MACRODOC_PLUGIN_NAME", "the-macro-doc", false );
}



/**
 * Register a custom post type called "book".
 *
 * @see get_post_type_labels() for label keys.
 */
function macrodoc_register_profile() {
	$labels = array(
		'name'                  => _x( 'Profiles', 'Post type general name', 'the-macro-doc' ),
		'singular_name'         => _x( 'Profile', 'Post type singular name', 'the-macro-doc' ),
		'menu_name'             => _x( 'Profile', 'Admin Menu text', 'the-macro-doc' ),
		'name_admin_bar'        => _x( 'Profile', 'Add New on Toolbar', 'the-macro-doc' ),
		/*'add_new'               => __( 'Add New', 'the-macro-doc' ),
		'add_new_item'          => __( 'Add New Book', 'the-macro-doc' ),
		'new_item'              => __( 'New Book', 'the-macro-doc' ),
		'edit_item'             => __( 'Edit Book', 'the-macro-doc' ),
		'view_item'             => __( 'View Book', 'the-macro-doc' ),
		'all_items'             => __( 'All Books', 'the-macro-doc' ),
		'search_items'          => __( 'Search Books', 'the-macro-doc' ),
		'parent_item_colon'     => __( 'Parent Books:', 'the-macro-doc' ),
		'not_found'             => __( 'No books found.', 'the-macro-doc' ),
		'not_found_in_trash'    => __( 'No books found in Trash.', 'the-macro-doc' ),
		'featured_image'        => _x( 'Book Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'the-macro-doc' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'the-macro-doc' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'the-macro-doc' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'the-macro-doc' ),
		'archives'              => _x( 'Book archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'the-macro-doc' ),
		'insert_into_item'      => _x( 'Insert into book', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'the-macro-doc' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this book', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'the-macro-doc' ),
		'filter_items_list'     => _x( 'Filter books list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'the-macro-doc' ),
		'items_list_navigation' => _x( 'Books list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'the-macro-doc' ),
		'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'the-macro-doc' ),*/
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'profile' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
		'menu-icon'          => 'dashicons-screenoptions'
	);

	register_post_type( 'profile', $args );
}

//add_action( 'init', 'macrodoc_register_profile' );


//add_action('my_custom_action', 'something_to_do');

//add_action('init', 'macrodoc_register');
//add_action('wp_footer', 'macrodoc_append_scripts');


function macrodoc_register() {

    my_custom_action();

    //wp_register_script('macrodoc_script', plugins_url() . '/$MACRODOC_PLUGIN_NAME/fitness_body_calculator.js');
    //wp_register_script('modernizr', plugins_url() . '/bmi-bmr-calculator/includes/js/modernizr.js');
    //wp_register_script('bootstrapjs', plugins_url() . '/bmi-bmr-calculator/assets/bootstrap/js/bootstrap.js');

    //wp_register_style('bmibmr_style', plugins_url('style_bmi.css', __FILE__));
    //wp_register_style('typicons', plugins_url('assets/icons/typicons.min.css', __FILE__));
    //wp_register_style('bootstrapcss', plugins_url('assets/bootstrap/css/bootstrap.css', __FILE__));
}

function my_custom_action() {
    do_action('my_custom_action', 0);
}

function something_to_do() {
    echo "This is awesome";
}