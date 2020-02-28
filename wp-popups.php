<?php
/**
 * Plugin Name: Popups
 * Plugin URI:  https://github.com/chigozieorunta/wp-popups
 * Description: A simple WordPress plugin to help you create popups that appear on your homepage easily..
 * Version:     1.0.0
 * Author:      Chigozie Orunta
 * Author URI:  https://github.com/chigozieorunta
 * License:     MIT
 * Text Domain: wp-popups
 * Domain Path: ./
 */

//Define Plugin Path
define("WPPOPUPS", plugin_dir_path(__FILE__));

wpPostTypes::getInstance();

/**
 * Class wpPopups
 */
class wpPopups {
    /**
	 * Constructor
	 *
	 * @since  1.0.0
	 */
    public function __construct() {
        add_action('admin_menu', array(get_called_class(), 'registerMenu'));
        self::registerPopupType();
    }

    /**
	 * Defines Custom Post Type declaration...
	 *
	 * @since   06/10/2019
	 * @return  void
	 */
	private static function registerPopupType() {	
        	add_action('init', array(get_called_class(), 'postTypeInit'));
	}

    /**
	 * Register Menu Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerMenu() {
        add_menu_page(
            'Pop Ups', 
            'Pop Ups', 
            'manage_options', 
            'Pop Ups', 
            array(get_called_class(), 'registerHTML')
        );
    }

    /**
	 * Register HTML Method
	 *
     * @access public
	 * @since  1.0.0
	 */
    public static function registerHTML() {
        require_once('wp-popups-html.php');
    }

    /**
	 * Points the class, singleton.
	 *
	 * @access public
	 * @since  1.0.0
	 */
    public static function getInstance() {
        static $instance;
        if($instance === null) $instance = new self();
        return $instance;
    }

    /**
	 * Post Type Initialization Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function postTypeInit() {
        $labels = array(
		'name'                => _x('Pop Up', 'Post Type General Name'),
		'singular_name'       => _x('Pop Up', 'Post Type Singular Name'),
		'menu_name'           => __('Pop Ups'),
		'parent_item_colon'   => __('Parent Pop Up'),
		'all_items'           => __('All Pop Ups'),
		'view_item'           => __('View Popup'),
		'add_new_item'        => __('Add New Popup'),
		'add_new'             => __('Add New'),
		'edit_item'           => __('Edit Popup'),
		'update_item'         => __('Update Popup'),
		'search_items'        => __('Search Popup'),
		'not_found'           => __('Not Found'),
		'not_found_in_trash'  => __('Not found in Trash')
	);
	$args = array(
		'label'               => __('Popup'),
		'description'         => __('News & Reviews'),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields' ),
		'hierarchical'        => true,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 30,
	    'menu_icon'           => 'dashicons-admin-tools',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page'
	);
	register_post_type('popup', $args);
    }
	
}

?>
