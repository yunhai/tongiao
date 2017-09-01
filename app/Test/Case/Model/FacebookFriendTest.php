<?php
App::uses('FacebookFriend', 'Model');

/**
 * FacebookFriend Test Case
 *
 */
class FacebookFriendTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.facebook_friend',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->FacebookFriend = ClassRegistry::init('FacebookFriend');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->FacebookFriend);

		parent::tearDown();
	}

}
