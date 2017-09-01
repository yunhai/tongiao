<?php
App::uses('UserLanguage', 'Model');

/**
 * UserLanguage Test Case
 *
 */
class UserLanguageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user_language',
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->UserLanguage = ClassRegistry::init('UserLanguage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->UserLanguage);

		parent::tearDown();
	}

}
