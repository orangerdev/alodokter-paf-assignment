<?php

namespace AloDokter\Admin;

use Carbon_Fields\Field;
use Carbon_Fields\Container;

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://ridwan-arifandi.com
 * @since      1.0.0
 *
 * @package    Alodokter
 * @subpackage Alodokter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Alodokter
 * @subpackage Alodokter/admin
 * @author     Ridwan Arifandi <orangerdigiart@gmail.com>
 */
class User {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register custom user roles
	 * @hook       init ( action )
	 * @priority   10
	 * @since      1.0.0
	 */
	public function register_user_roles() {

        global $wp_roles;

		if( !isset( $wp_roles) ) :
			$wp_roles = new WP_Roles();
		endif;

        /**
         * Add custom capabilities to administrator
         * @since   1.0.0
         */
        $wp_roles->add_cap('administrator', 'alodokter-product');
        $wp_roles->add_cap('administrator', 'alodokter-order');

        /**
		 * Create custom partner roles
		 * @since   1.0.0
		 */
		$partner_role = $wp_roles->get_role('subscriber');

        $wp_roles->add_role('partner-x', 'Partner X', $partner_role->capabilities);

        $wp_roles->add_cap('partner-x', 'alodokter-product');

        $wp_roles->add_role('partner-b', 'Partner B', $partner_role->capabilities);

        $wp_roles->add_cap('partner-b', 'alodokter-product');
        $wp_roles->add_cap('partner-b', 'alodokter-order');


	}

}
