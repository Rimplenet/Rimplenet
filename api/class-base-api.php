<?php
/**
 * The api-facing functionality of the plugin.
 *
 * @link       https://rimplenet.com/
 * @since      1.0.0
 *
 * @package    Rimplenet_Admin_Tools_Extended
 * @subpackage Rimplenet_Admin_Tools_Extended/api
 */
/**
 * The api-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * @package    Rimplenet_Admin_Tools_Extended
 * @subpackage Rimplenet_Admin_Tools_Extended/api
 * @author     Rimplenet <info@rimplenet.com>
 */
class Rimplenet_Admin_Tools_Extended_Api {
	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct() {
		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->load_required_files();
	}
    private function load_required_files() {
   	 //Add Required Files to Load
	 require_once plugin_dir_path( dirname( __FILE__ ) ) . 'api/wallets/get-wallet.php';
    }
	
}


$Rimplenet_Admin_Tools_Extended_Api = new Rimplenet_Admin_Tools_Extended_Api();