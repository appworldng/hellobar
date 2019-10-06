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
        self::registerCustomPostTypes();
    }

    /**
	 * Defines Custom Post Type declaration...
	 *
	 * @since   06/10/2019
	 * @return  void
	 */
	private static function registerCustomPostTypes() {	
        	add_action('init', array(get_called_class(), 'postTypeInit'));	
        	add_action('init', array(get_called_class(), 'setPostTypes'));
	}

    /**
	 * Register Menu Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerMenu() {
        add_menu_page(
            'Post Types', 
            'Post Types', 
            'manage_options', 
            'Post Types', 
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
        //require_once('wp-posttypes-html.php');
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
		'name'                => _x('Types', 'Post Type General Name'),
		'singular_name'       => _x('Type', 'Post Type Singular Name'),
		'menu_name'           => __('Types'),
		'parent_item_colon'   => __('Parent Type'),
		'all_items'           => __('All Types'),
		'view_item'           => __('View Type'),
		'add_new_item'        => __('Add New Type'),
		'add_new'             => __('Add New'),
		'edit_item'           => __('Edit Type'),
		'update_item'         => __('Update Type'),
		'search_items'        => __('Search Type'),
		'not_found'           => __('Not Found'),
		'not_found_in_trash'  => __('Not found in Trash')
	);
	$args = array(
		'label'               => __('Type'),
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
	register_post_type('type', $args);
    }

    /**
	 * Set Post Types Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function setPostTypes() {
	    global $post;
	    $args = array(
		'post_type'         => 'type',
		'numberposts'       => -1,
		'posts_per_page'    => -1,
		'orderby'           => 'date',
		'order'             => 'ASC'
	    );
	    $posts = get_posts($args);
	    foreach($posts as $post) {
		setup_postdata($post); $title = get_the_title();
		$labels = array(
			'name'                => _x($title.'s', 'Post Type General Name'),
			'singular_name'       => _x($title, 'Post Type Singular Name'),
			'menu_name'           => __($title.'s'),
			'parent_item_colon'   => __('Parent '.$title),
			'all_items'           => __('All '.$title.'s'),
			'view_item'           => __('View '.$title),
			'add_new_item'        => __('Add New '.$title),
			'add_new'             => __('Add New'),
			'edit_item'           => __('Edit '.$title),
			'update_item'         => __('Update '.$title),
			'search_items'        => __('Search '.$title),
			'not_found'           => __('Not Found'),
			'not_found_in_trash'  => __('Not found in Trash'),
		);

		$args = array(
			'label'               => __($title),
			'description'         => __( 'News and Reviews'),
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
		register_post_type(strtolower($title), $args );
	    }
	    wp_reset_postdata();
     }
	
}

?>
