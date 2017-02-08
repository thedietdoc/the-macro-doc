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



add_action('init', 'macrodoc_register');
add_action('wp_footer', 'macrodoc_append_scripts');

function macrodoc_register() {
    wp_register_script('macrodoc_script', plugins_url() . '/the-macro-doc/fitness_body_calculator.js');
    wp_register_script('modernizr', plugins_url() . '/the-macro-doc/includes/js/modernizr.js');
    wp_register_script('bootstrapjs', plugins_url() . '/the-macro-doc/assets/bootstrap/js/bootstrap.js');

    wp_register_style('macrodoc_style', plugins_url('style_bmi.css', __FILE__));
    wp_register_style('typicons', plugins_url('assets/icons/typicons.min.css', __FILE__));
    wp_register_style('bootstrapcss', plugins_url('assets/bootstrap/css/bootstrap.css', __FILE__));
}

function macrodoc_append_scripts() {
    global $add_my_script;

    if (!$add_my_script)
        return;

    wp_print_scripts('modernizr');
    wp_print_scripts('bootstrapjs');
    wp_enqueue_style('macrodoc_style');
    wp_enqueue_style('typicons');
    wp_enqueue_style('bootstrapcss');
    wp_print_scripts('macrodoc_script');
}

add_shortcode('macrodoc', 'macrodoc_init');

function macrodoc_init($atts) {
    global $add_my_script;
    $add_my_script = true;
    include('bmi_calc.php');
}

//The css and the js will be loaded only on the page where shortcode is used - end
//Admin settings
function macrodoc_register_settings() {
    add_option('macrodoc_use_api', '1');
    add_option('macrodoc_api_callback', 'alpha');
    register_setting('default', 'macrodoc_use_api');
    register_setting('default', 'macrodoc_api_callback');
}

add_action('admin_init', 'macrodoc_register_settings');

function macrodoc_register_options_page() {
    add_options_page('Macro Doc Calculator', 'Macro Doc Calculator', 'manage_options', 'wphub-options', 'macrodoc_options_page');
}

add_action('admin_menu', 'macrodoc_register_options_page');

function macrodoc_options_page() {
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2>Bmi Bmr Calculator</h2>
        <h3>Details and information</h3>
        <p>The <i>css</i> and the <i>js</i> will be loaded only on the page/post where shortcode is used.</p>
        <p>Use <code>[macrodoc]</code> shortcode on post or page to display BMI and BMR forms.</p>
        <p>After registration users can save their calculations for later review!</p>
        <br>
        <small>*All the results calculated with this plugin are approximate based on user entered data. If you want real and accurate data that will help you get the results you want, contact Maria on <a href="mailto:mariatresoglavic@gmail.com">mariatresoglavic@gmail.com</a>.</small><hr>
        <footer>
            For technical questions about plugin contact  <a href="mailto:paleka@gmail.com">paleka@gmail.com</a>
        </footer>
    </div>
    <?php
}

//Admin settings
?><?php

//db table installation ** start
function macrodoc_create_db_table() {

    global $wpdb;
    $macrodoc_tablename = $wpdb->prefix . "macrodoc";

    $macrodoc_sql = "CREATE TABLE IF NOT EXISTS $macrodoc_tablename (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `userid` int(11) NOT NULL,
				  `formdata` text NOT NULL,
				  `timeof` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`id`)
				)";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($macrodoc_sql);
}

/* run the table creation function only on plugin activation */
register_activation_hook(__FILE__, 'macrodoc_create_db_table');
//db table installation ** end
//@todo Delete table on deactivation of plugin
//db
register_activation_hook(__FILE__, 'get_saved_macrodoc');

function get_saved_macrodoc($iduser = null) {
    global $wpdb;

    if ( isset($iduser))  {
        $userid = $iduser;
    }
    else {
        $userid = get_current_user_id();
    }

    $table_name = $wpdb->prefix . 'macrodoc';


    $savedRows = $wpdb->get_results($wpdb->prepare('SELECT * FROM ' . $table_name . ' WHERE userid = %d order by id desc', $userid));

    return $savedRows;
    //print_r($savedRows);
}

function macrodoc_front_calc() {
    if (isset($_REQUEST)) {

        //$calcFront = $_REQUEST['calcFrontData'];

        print_r($_POST);
        // $dbCalc = json_encode($holdData);
        //print_r($dbCalc);
        //echo $dbCalc;
    }
    die();
}

add_action('wp_ajax_macrodoc_front_calc', 'macrodoc_front_calc');

function macrodoc_save() {
    if (isset($_REQUEST)) {

        $holdData = $_REQUEST['holdData'];

        //print_r ($holdData);
        $dbCalc = json_encode($holdData);
        // print_r($_REQUEST);
        //echo $dbCalc;

        global $wpdb;
        $userid = get_current_user_id();

        $wpdb->insert($wpdb->prefix . 'macrodoc', array(
            'userid' => $userid,
            'formdata' => $dbCalc,
        ), array(
                '%d',
                '%s'
            )
        );
    }
    die();
}

add_action('wp_ajax_macrodoc_save', 'macrodoc_save');

add_action('wp_head', 'macrodoc_custom_head');

function macrodoc_custom_head() {
    echo '<script type="text/javascript">var ajaxurl = \'' . admin_url('admin-ajax.php') . '\';</script>';
}

//todo
//create join with custom table for users data from wp_macrodoc_users
function get_macrodoc_users( $id = '' ) {

    global $wpdb, $blog_id;
    $userid = get_current_user_id();//get all the users except the current one logged in
    if ( empty($id) )
        $id = (int) $blog_id;
    $blog_prefix = $wpdb->get_blog_prefix($id);
    $users = $wpdb->get_results( "SELECT user_id, user_id AS ID, user_login, display_name, user_email, meta_value FROM $wpdb->users, $wpdb->usermeta WHERE {$wpdb->users}.ID = {$wpdb->usermeta}.user_id AND {$wpdb->usermeta}.user_id != ".$userid." AND meta_key = '{$blog_prefix}capabilities' ORDER BY {$wpdb->usermeta}.user_id" );
    return $users;
}









































/*

if(! defined('ABSPATH')) exit;

if(! defined('MACRODOC_PLUGIN_NAME')) {
	define( "MACRODOC_PLUGIN_NAME", "the-macro-doc", false );
}




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
		'items_list'            => _x( 'Books list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'the-macro-doc' ),*//*
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
}*/