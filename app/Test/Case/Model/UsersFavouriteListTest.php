<?php
App::uses('UsersFavouriteList', 'Model');

/**
 * UsersFavouriteList Test Case
 *
 */
class UsersFavouriteListTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.users_favourite_list',
		'app.user',
		'app.facebook',
		'app.facebook_friend',
		'app.user_language',
		'app.user_event',
		'app.event',
		'app.user_favourite'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UsersFavouriteList = ClassRegistry::init('UsersFavouriteList');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UsersFavouriteList);

		parent::tearDown();
	}

}
