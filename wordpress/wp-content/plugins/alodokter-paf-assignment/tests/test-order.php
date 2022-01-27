<?php
/**
 * Class SampleTest
 *
 * @package Alodokter_Paf_Assignment
 */

/**
 * Sample test case.
 */
class OrderTest extends MainTest {

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
	public function test_order_as_partner_x() {

		$this->setUp();
		$this->set_partner_x();
		$this->create_product();

        $_POST = array(
            'user_id' => get_current_user_id(),
            'product_id' => $this->product->ID
        );

		$respond = $this->rests['order']->add_to_cart();

		$this->assertTrue( is_a($respond, 'WP_Error') );
        $this->assertSame( $respond->get_error_code(), 'invalid-access' );

        $respond = $this->rests['order']->get_cart_detail(array('id' => get_current_user_id()));

		$this->assertTrue( is_a($respond, 'WP_Error') );
        $this->assertSame( $respond->get_error_code(), 'invalid-access' );

        $respond = $this->rests['order']->do_checkout();

		$this->assertTrue( is_a($respond, 'WP_Error') );
        $this->assertSame( $respond->get_error_code(), 'invalid-access' );

	}

	/**
	 * Access product request as partner b
	 */
	public function test_order_as_partner_b() {

		$this->setUp();
		$this->set_partner_b();
        $this->create_product();

        $_POST = array(
            'user_id' => get_current_user_id(),
            'product_id' => $this->product->ID
        );

		$respond = $this->rests['order']->add_to_cart();

		$this->assertTrue( is_a($respond, 'WP_REST_Response') );

        $respond = $this->rests['order']->get_cart_detail(array('id' => get_current_user_id()));

		$this->assertTrue( is_a($respond, 'WP_REST_Response') );

        $respond = $this->rests['order']->do_checkout();

		$this->assertTrue( is_a($respond, 'WP_REST_Response') );

	}

	/**
	 * Access product request as subscriber
	 */
	public function test_order_as_subscriber() {

		$this->setUp();
		$this->set_subscriber();
        $this->create_product();

        $_POST = array(
            'user_id' => get_current_user_id(),
            'product_id' => $this->product->ID
        );

        $respond = $this->rests['order']->add_to_cart();

		$this->assertTrue( is_a($respond, 'WP_Error') );
        $this->assertSame( $respond->get_error_code(), 'invalid-access' );

        $respond = $this->rests['order']->get_cart_detail(array('id' => get_current_user_id()));

		$this->assertTrue( is_a($respond, 'WP_Error') );
        $this->assertSame( $respond->get_error_code(), 'invalid-access' );

        $respond = $this->rests['order']->do_checkout();

		$this->assertTrue( is_a($respond, 'WP_Error') );
        $this->assertSame( $respond->get_error_code(), 'invalid-access' );
	}
}
