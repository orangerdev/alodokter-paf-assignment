<?php
/**
 * Class SampleTest
 *
 * @package Alodokter_Paf_Assignment
 */

/**
 * Sample test case.
 */
class ProductTest extends MainTest {

	protected $product;

	protected function create_product() {
		$this->product = $this->factory->post->create_and_get(array(
			'post_type' => 'product'
		));

		update_post_meta( $this->product->ID, '_price', 10);
	}

	/**
	 * Access product request as partner X
	 */
	public function test_access_product_as_partner_x() {

		$this->setUp();
		$this->set_partner_x();
		$this->create_product();

		$respond = $this->rests['product']->list_product();

		$this->assertTrue( is_a($respond, 'WP_REST_Response') );

		$respond = $this->rests['product']->get_product_detail( array('id' => $this->product->ID));

		if( is_a($respond, 'WP_REST_Response') ) :

			$this->assertArrayHasKey('data', 	$respond->data,);
			$this->assertArrayHasKey('product', $respond->data['data']);
			$this->assertGreaterThan(0, count($respond->data['data']['product']));

		else :
			$this->assertTrue( false );
		endif;

	}

	/**
	 * Access product request as partner b
	 */
	public function test_access_product_as_partner_b() {

		$this->setUp();
		$this->set_partner_b();
		$this->create_product();

		$respond = $this->rests['product']->list_product();

		$this->assertTrue( is_a($respond, 'WP_REST_Response') );

		$respond = $this->rests['product']->get_product_detail( array('id' => $this->product->ID));

		if( is_a($respond, 'WP_REST_Response') ) :

			$this->assertArrayHasKey('data', 	$respond->data,);
			$this->assertArrayHasKey('product', $respond->data['data']);
			$this->assertGreaterThan(0, count($respond->data['data']['product']));

		else :
			$this->assertTrue( false );
		endif;
	}

	/**
	 * Access product request as subscriber
	 */
	public function test_access_product_as_subscriber() {

		$this->setUp();
		$this->set_subscriber();
		$this->create_product();

		$respond = $this->rests['product']->list_product();

		$this->assertTrue( is_a($respond, 'WP_Error') );

		$respond = $this->rests['product']->get_product_detail( array('id' => $this->product->ID));

		$this->assertTrue( is_a($respond, 'WP_Error') );
	}
}
