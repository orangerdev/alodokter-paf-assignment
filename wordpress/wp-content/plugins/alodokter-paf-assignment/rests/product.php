<?php

namespace AloDokter\Rest;

/**
 * Main class responsible for rest api functions
 * @since   1.0.0
 */
class Product extends \AloDokter\Rest {

	/**
	 * Register class routes
	 * Hooked via action rest_api_init, priority 10
	 * @since    1.0.0
	 */
	public function do_register() {

		$routes = array(
			'lists' => array(
				'endpoint'				=> '/lists',
	    		'methods'				=> 'GET',
	    		'callback'				=> array( $this, 'list_product' ),
	    		'permission_callback' 	=> '__return_true',
	    	),
            'product_detail' => array(
				'endpoint'				=> '/detail/(?P<id>\d+)',
	    		'methods'				=> 'GET',
	    		'callback'				=> array( $this, 'get_product_detail' ),
	    		'permission_callback' 	=> '__return_true',
	    	),
	    );

	    self::register_routes( $routes );
	}

    /**
	 * List product
	 * @param 	$data data from api request
	 * @return   array|WP_Error
	 * @since    1.0.0
	 */
	public function list_product() {

		if(
			is_user_logged_in() &&
			current_user_can('alodokter-product')
		) :

			$query = new \WP_Query(array(
				'post_type'      => ALODOKTER_PRODUCT_CPT,
				'posts_per_page' => -1
			));

			if( $query->have_posts() ) :

				$posts = array();

				while($query->have_posts()) :

					$query->the_post();

					$posts[] = array(
						'id'      => get_the_ID(),
						'title'   => get_the_title(),
						'picture' => wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ), 'full' ),
						'price'   => '$' . carbon_get_the_post_meta('price')
					);

				endwhile;

				wp_reset_query();

				return $this->respond_success($posts);

			else :

				return $this->respond_error();

			endif;

		endif;

		return $this->respond_error('unauthorized');
	}

    /**
	 * List product
	 * @param 	$data data from api request
	 * @return   array|WP_Error
	 * @since    1.0.0
	 */
	public function get_product_detail( $data ) {

		if(
			is_user_logged_in() &&
			current_user_can('alodokter-product')
		) :

			$params = array(
				'id'	=> $data['id']
			);

			$product = get_post( $params['id'] );

			if(
				is_a($product, 'WP_Post') &&
				ALODOKTER_PRODUCT_CPT === $product->post_type
			) :

				return $this->respond_success( array(
					'product' => array(
						'id'          => $product->ID,
						'title'       => $product->post_title,
						'picture'     => wp_get_attachment_url( get_post_thumbnail_id( $product->ID ), 'full' ),
						'price'       => '$' . carbon_get_post_meta( $product->ID, 'price'),
						'description' => $product->post_content
					)
				));

			else :

				return $this->respond_error( );

			endif;

		endif;

		return $this->respond_error('unauthorized');
	}
}
