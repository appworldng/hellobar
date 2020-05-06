<?php
/**
 * Plugin Name: HelloBar
 * Plugin URI:  https://github.com/chigozieorunta/hellobar
 * Description: A simple WordPress plugin to help you display a hello bar on every page of your site.
 * Version:     1.0.0
 * Author:      Chigozie Orunta
 * Author URI:  https://github.com/chigozieorunta
 * License:     MIT
 * Text Domain: hellobar
 * Domain Path: ./
 */

//Define Plugin Path
define("HELLOBAR", plugin_dir_path(__FILE__));

hellobar::getInstance();

/**
 * Class hellobar
 */
class hellobar {
    /**
	 * Constructor
	 *
	 * @since  1.0.0
	 */
    public function __construct() {
		add_action("admin_init", array(get_called_class(), 'registerHelloBarFields'));
        add_action('admin_menu', array(get_called_class(), 'registerMenu'));
		add_action('wp_enqueue_scripts', array(get_called_class(), 'registerScripts'));
		add_action('get_footer', array($this, 'registerHelloBar'));
	}

	/**
	 * Register Menu Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerMenu() {
        add_menu_page(
            'HelloBar', 
            'HelloBar', 
            'manage_options', 
            'HelloBar', 
            array(get_called_class(), 'registerAdmin')
        );
	} 
	
	/**
	 * Register Admin Method
	 *
     * @access public
	 * @since  1.0.0
	 */
    public static function registerAdmin() {
        require_once('hellobar-admin-html.php');	
	?>
		<div class="wrap">
			<form method="post" action="options.php">
				<?php
				settings_fields("section");
				do_settings_sections("hellobar-options");      
				submit_button(); 
				?>          
			</form>
		</div>
	<?php
	}
	
	public static function registerHelloBarFields() {
		add_settings_section(
			"section", 
			"", 
			null, 
			"hellobar-options"
		);

		add_settings_field(
			"hellobar_text", 
			"HelloBar Text", 
            array(get_called_class(), "hellobar_admin_text"),
			"hellobar-options", 
			"section"
		);

		add_settings_field(
			"hellobar_position", 
			"HelloBar Position", 
            array(get_called_class(), "hellobar_admin_position"),
			"hellobar-options", 
			"section"
		);

		register_setting(
			"section", "hellobar_text"
		);

		register_setting(
			"section", "hellobar_position"
		);
	}

	public static function hellobar_admin_text() {
	?>
		<input type="text" name="hellobar_text" id="hellobar_text" value="<?php echo get_option('hellobar_text'); ?>" />
	<?php
	}

	public static function hellobar_admin_position() {
	?>
		<select name="hellobar_position" id="hellobar_position">
			<?php 
				$positions = ['top', 'bottom'] ;
				foreach($positions as $position):
			?>
			<option <?php if(get_option('hellobar_position') == $position): ?>selected<?php endif; ?> value="<?php echo $position ?>"><?php echo $position; ?></option>
			<?php
				endforeach;
			?>
		</select>
	<?php
	}

    /**
	 * Register Scripts Method
	 *
     * @access public 
	 * @since  1.0.0
	 */
    public static function registerScripts() {
		wp_register_style('hellobar-css', plugin_dir_url(__FILE__).'css/hellobar.css');
		wp_enqueue_style('hellobar-css');
		/*wp_register_script('hellobar-js', plugin_dir_url(__FILE__).'js/hellobar.js', array('jquery'), '1', true);
		wp_enqueue_script('hellobar-js');*/
	}
	
	/**
	 * Register HelloBar Method
	 *
     * @access public
	 * @since  1.0.0
	 */

	public static function registerHelloBar() {
		require_once('hellobar-html.php');
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

}

?>
