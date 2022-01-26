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
class Product {

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
	 * Register product post type
	 * @hook       init ( action )
	 * @priority   10
	 * @since      1.0.0
	 */
	public function register_post_type() {

        $labels = [
    		'name'               => _x( 'Products', 'post type general name', 'alodokter' ),
    		'singular_name'      => _x( 'Product', 'post type singular name', 'alodokter' ),
    		'menu_name'          => _x( 'Products', 'admin menu', 'alodokter' ),
    		'name_admin_bar'     => _x( 'Product', 'add new on admin bar', 'alodokter' ),
    		'add_new'            => _x( 'Add New', 'product', 'alodokter' ),
    		'add_new_item'       => __( 'Add New Product', 'alodokter' ),
    		'new_item'           => __( 'New Product', 'alodokter' ),
    		'edit_item'          => __( 'Edit Product', 'alodokter' ),
    		'view_item'          => __( 'View Product', 'alodokter' ),
    		'all_items'          => __( 'All Products', 'alodokter' ),
    		'search_items'       => __( 'Search Products', 'alodokter' ),
    		'parent_item_colon'  => __( 'Parent Products:', 'alodokter' ),
    		'not_found'          => __( 'No products found.', 'alodokter' ),
    		'not_found_in_trash' => __( 'No products found in Trash.', 'alodokter' )
    	];

    	$args = [
    		'labels'             => $labels,
            'description'        => __( 'Description.', 'alodokter' ),
    		'public'             => true,
    		'publicly_queryable' => true,
    		'show_ui'            => true,
    		'show_in_menu'       => true,
    		'query_var'          => true,
    		'rewrite'            => [ 'slug' => 'product' ],
    		'has_archive'        => true,
    		'hierarchical'       => false,
    		'menu_position'      => null,
    		'supports'           => [ 'title', 'editor', 'thumbnail' ],
    	];

    	register_post_type( ALODOKTER_PRODUCT_CPT, $args );

	}

    /**
     * Register post meta fields for product post type
     * @hook        carbon_fields_register_fields ( action )
     * @priority    10
     * @since       1.0.0
     * @return      void
     */
    public function register_post_meta_fields() {

        Container::make('post_meta', __('Product Setting', 'alodokter'))
            ->where('post_type', '=', ALODOKTER_PRODUCT_CPT)
            ->add_fields(array(
                Field::make('text', 'price', __('Price', 'alodokter'))
                    ->set_required( true )
                    ->set_attribute( 'type', 'number')
            ));

    }

}
