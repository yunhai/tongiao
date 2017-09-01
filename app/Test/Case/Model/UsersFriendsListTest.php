<?php
App::uses('UsersFriendsList', 'Model');

/**
 * UsersFriendsList Test Case
 *
 */
class UsersFriendsListTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.users_friends_list',
		'app.user',
		'app.facebook',
		'app.facebook_friend',
		'app.user_language',
		'app.user_event',
		'app.event',
		'app.user_friend'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UsersFriendsList = ClassRegistry::init('UsersFriendsList');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UsersFriendsList);

		parent::tearDown();
	}

}
