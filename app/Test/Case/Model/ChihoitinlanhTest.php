<?php
App::uses('Chihoitinlanh', 'Model');

/**
 * Chihoitinlanh Test Case
 *
 */
class ChihoitinlanhTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chihoitinlanh'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chihoitinlanh = ClassRegistry::init('Chihoitinlanh');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chihoitinlanh);

		parent::tearDown();
	}

}
