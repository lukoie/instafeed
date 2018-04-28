<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://
 * @since      1.0.0
 *
 * @package    InstaFeed
 * @subpackage InstaFeed/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    InstaFeed
 * @subpackage InstaFeed/public
 * @author     TOTKTOCEETBETEP
 */
class InstaFeed_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $instafeed    The ID of this plugin.
	 */
	private $instafeed;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $instafeed       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $instafeed, $version ) {

		$this->instafeed = $instafeed;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in InstaFeed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The InstaFeed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->instafeed, plugin_dir_url( __FILE__ ) . 'css/instafeed-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in InstaFeed_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The InstaFeed_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->instafeed, plugin_dir_url( __FILE__ ) . 'js/instafeed-public.js', array( 'jquery' ), $this->version, false );

	}

}
