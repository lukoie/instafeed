<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://
 * @since      1.0.0
 *
 * @package    InstaFeed
 * @subpackage InstaFeed/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    InstaFeed
 * @subpackage InstaFeed/includes
 * @author     TOTKTOCEETBETEP
 */
class InstaFeed {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      InstaFeed_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $instafeed    The string used to uniquely identify this plugin.
	 */
	protected $instafeed;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PLUGIN_NAME_VERSION' ) ) {
			$this->version = PLUGIN_NAME_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->instafeed = 'instafeed';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}
	
	const INSTAFEED_PLUGIN_ID = 'instafeed';
	const INSTAFEED_PLUGIN_NAME = 'InstaFeed';
	const INSTAFEED_USER_ID_OPTION = 'instafeed_user_id';
	const INSTAFEED_CLIENT_ID_OPTION = 'instafeed_client_id';
	const INSTAFEED_ACCESS_TOKEN_OPTION = 'instafeed_access_token';


// We are including the settings page view
public function render_instafeed_settings_page(){
	include 'options_page.php';
}

// Now we are getting the pictures from the Instagram 
public function instafeed_picture(){
	$client_id = 'c1c13f3cad61427dacfa7b0a0a9b812e';
	$access_token = '5690537263.c1c13f3.bf6153da8e734a11b453fef45a6dcf16';
	// The numbers before the first dot in the ACCESS_TOKEN
	$user_id = '5690537263'; 
	
	$res = file_get_contents('https://api.instagram.com/v1/users/' . $user_id . '/media/recent/?client_id=' . $client_id . '&access_token=' . $access_token . '&count=3');
	
	$res = json_decode($res, true);
	if (!empty($res['data'])) {
		echo '<div class="insta_outer" style="background-color:blue;">';
		foreach ($res['data'] as $row) {
			// We are good to show the pictures on the page
			echo '<div class="insta_back" style="background-color:red;"><img src="' . $row['images']['standard_resolution']['url'] . '"></div>';
			echo '<div class="insta_photolink" style="color:yellow;">This photo on Instagram</div>';
		}
		echo '</div>';
		echo '<div class="insta_link" style="color:cyan;">Instagram page';
	}
}




	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - InstaFeed_Loader. Orchestrates the hooks of the plugin.
	 * - InstaFeed_i18n. Defines internationalization functionality.
	 * - InstaFeed_Admin. Defines all hooks for the admin area.
	 * - InstaFeed_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-instafeed-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-instafeed-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-instafeed-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-instafeed-public.php';

		$this->loader = new InstaFeed_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the InstaFeed_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new InstaFeed_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new InstaFeed_Admin( $this->get_instafeed(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'instafeed_settings_menu' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new InstaFeed_Public( $this->get_instafeed(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_instafeed() {
		return $this->instafeed;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    InstaFeed_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
