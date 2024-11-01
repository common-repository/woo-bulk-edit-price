<?php 
/*
Plugin Name: Woo bulk edit price
Plugin URI: https://wpnik.com
Description: Woo bulk edit price is a plugin that is created to help you edit price of your 100s of products within few minutes. 
Version: 1.0.1
Author: Pramod Jodhani
Author URI: http://pramodjodhani.com
Text Domain: woobep
*/
require_once "admin/init.php";

define("WPEP_FILE" , __FILE__);

class WBEP_Main {

	function __construct() {
		add_action( 'wp_enqueue_scripts', array($this , "front_scripts") );
		add_action( 'admin_enqueue_scripts', array($this , "backend_scripts") );
	}
	
	function front_scripts() {
	}


	function backend_scripts() {
		//wp_enqueue_style
		$url = plugins_url( "" , WPEP_FILE);
		wp_enqueue_script( "wpep-backend-script", $url."/js/admin.js" , array("jquery") );
		wp_enqueue_style( "wpep-backend-style", $url."/css/admin.css" );

	}


}

new WBEP_Main();


function WPEP_admin_notice() {
    if ( class_exists( 'WooCommerce' ) ) return;
    ?>
    <div class="notice notice-error is-dismissible">
        <p><?php _e( 'Woocommerce Bulk Edit Price needs Woocommerce to be installed and activated', 'wpep' ); ?></p>
    </div>
    <?php
}
add_action( 'admin_notices', 'WPEP_admin_notice' );