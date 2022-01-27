<?php

class MainTest extends WP_UnitTestCase {

	protected $rests;

	public function setUp() {

		parent::setUp();

		$this->rests = array(
			'order'   => new \AloDokter\Rest\Order,
			'product' => new \AloDokter\Rest\Product,
		);
	}

    /**
	 * Set new user as administrator
	 * @since  1.0.0
	 */
	protected function set_administrator() {

		$user_id = $this->factory->user->create(
                        array(
                            'user_login' => 'administrator',
                            'role'       => 'administrator'
                        ));

		wp_set_current_user( $user_id );

	}

    /**
     * Set new user as partner x
     * @since   1.0.0
     */
    protected function set_partner_x() {

        $user_id = $this->factory->user->create(
                        array(
                            'user_login' => 'partner_x',
                            'role' => 'partner-x'
                        ) );

		wp_set_current_user( $user_id );

    }

    /**
     * Set new user as partner x
     * @since   1.0.0
     */
    protected function set_partner_b() {

        $user_id = $this->factory->user->create(
                        array(
                            'user_login' => 'partner_b',
                            'role' => 'partner-b'
                        ) );

		wp_set_current_user( $user_id );

    }

	/**
     * Set new user as subscriber
     * @since   1.0.0
     */
    protected function set_subscriber() {

        $user_id = $this->factory->user->create(
                        array(
                            'user_login' => 'subscriber',
                            'role' => 'subscriber'
                        ) );

		wp_set_current_user( $user_id );

    }

}
