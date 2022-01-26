<?php

namespace AloDokter\Rest;

/**
 * Main class responsible for rest api functions
 * @since   1.0.0
 */
class Order extends \AloDokter\Rest {

	/**
	 * Register class routes
	 * Hooked via action rest_api_init, priority 10
	 * @since    1.0.0
	 */
	public function do_register() {

		$routes = array(
			'add_to_cart' => array(
				'endpoint'				=> '/add_to_cart',
	    		'methods'				=> 'POST',
	    		'callback'				=> array( $this, 'add_to_cart' ),
	    		'permission_callback' 	=> '__return_true',
	    	),
            'cart_detail' => array(
				'endpoint'				=> '/cart/detail/(?P<id>\d+)',
	    		'methods'				=> 'GET',
	    		'callback'				=> array( $this, 'get_cart_detail' ),
	    		'permission_callback' 	=> '__return_true',
	    	),
            'checkout' => array(
				'endpoint'				=> '/cart/checkout',
	    		'methods'				=> 'POST',
	    		'callback'				=> array( $this, 'do_checkout' ),
	    		'permission_callback' 	=> '__return_true',
	    	),
	    );

	    self::register_routes( $routes );
	}

	/**
	 * Add item to cart
	 * @param 	 $data data from api request
	 * @return   array|WP_Error
	 * @since    1.0.0
	 */
	public function add_to_cart( $data ) {

		if(
			is_user_logged_in() &&
			current_user_can('alodokter-order')
		) :

			$params = wp_parse_args($_POST, array(
				'product_id'	=> 0,
				'user_id'		=> 0,
			));

			$product = get_post( $params['product_id'] );

			if(
				is_a($product, 'WP_Post') &&
				ALODOKTER_PRODUCT_CPT === $product->post_type
			) :

				$user_id   = ( 0 === $params['user_id'] ) ? get_current_user_id() : $params['user_id'];
				$user_cart = (array) get_user_meta( $user_id, 'cart', true );

				if(!isset($user_cart[ $product->ID ])) :
					$user_cart[ $product->ID ] = 0;
				endif;

				$user_cart[ $product->ID ]++;

				update_user_meta( $user_id, 'cart', $user_cart );

				return $this->respond_success( array(
					'message' => sprintf( __('Successfully add %s to cart.', 'alodokter'), $product->post_title )
				));

			else :

				return $this->respond_error( );

			endif;

		endif;

		return $this->respond_error( 'unauthorized' );
	}

	/**
	 * Get cart detail
	 * @param 	$data data from api request
	 * @return   array|WP_Error
	 * @since    1.0.0
	 */
	public function get_cart_detail( $data ) {

		if(
			is_user_logged_in() &&
			current_user_can('alodokter-order')
		) :

			$user_id = $data['id'];
			$cart    = (array) get_user_meta( $user_id, 'cart', true);
			$data 	 = array();

			foreach($cart as $product_id => $quantity ) :

				if( 0 < absint($product_id) ) :
					$product = get_post( $product_id );

					$data[] = array(
						'id'      => $product->ID,
						'title'   => $product->post_title,
						'picture' => wp_get_attachment_url( get_post_thumbnail_id( $product->ID ), 'full' ),
						'price'   => '$' . carbon_get_post_meta( $product->ID, 'price'),
						'qty'     => $quantity
					);
				endif;

			endforeach;

			return $this->respond_success( array(
				'products' => $data
			));

		endif;

		return $this->respond_error( 'unauthorized' );
	}

	/**
	 * Complete checkout
	 * @param 	$data data from api request
	 * @return   array|WP_Error
	 * @since    1.0.0
	 */
	public function do_checkout( $data ) {

		if(
			is_user_logged_in() &&
			current_user_can('alodokter-order')
		) :

			$params = wp_parse_args($_POST, array(
				'user_id'		=> 0,
			));

			if( !empty($params['user_id']) ) :

				$cart     = get_user_meta( $params['user_id'], 'cart', true);
				$checkout = (array) get_user_meta( $params['user_id'], 'checkout', true);

				$checkout[] = array(
					'date'	=> date('Y-m-d H:i:s'),
					'items'	=> $checkout
				);

				update_user_meta( $params['user_id'], 'checkout', $checkout);

				delete_user_meta( $params['user_id'], 'cart' );

				return $this->respond_success( array(
					'message' => __('Successfully checkout.', 'alodokter'),
				));

			endif;

			return $this->respond_error();

		endif;

		return $this->respond_error( 'unauthorized' );
	}

}
