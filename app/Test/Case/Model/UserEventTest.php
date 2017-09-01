<?php
App::uses('UserEvent', 'Model');

/**
 * UserEvent Test Case
 *
 */
class UserEventTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_event',
		'app.user',
		'app.event'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserEvent = ClassRegistry::init('UserEvent');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserEvent);

		parent::tearDown();
	}

}
