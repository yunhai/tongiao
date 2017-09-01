<?php
App::uses('Diemnhomtinlanh', 'Model');

/**
 * Diemnhomtinlanh Test Case
 *
 */
class DiemnhomtinlanhTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.diemnhomtinlanh'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Diemnhomtinlanh = ClassRegistry::init('Diemnhomtinlanh');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Diemnhomtinlanh);

		parent::tearDown();
	}

}
