<?php
App::uses('Chucsactinlanh', 'Model');

/**
 * Chucsactinlanh Test Case
 *
 */
class ChucsactinlanhTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucsactinlanh'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucsactinlanh = ClassRegistry::init('Chucsactinlanh');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucsactinlanh);

		parent::tearDown();
	}

}
