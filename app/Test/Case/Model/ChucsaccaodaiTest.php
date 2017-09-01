<?php
App::uses('Chucsaccaodai', 'Model');

/**
 * Chucsaccaodai Test Case
 *
 */
class ChucsaccaodaiTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucsaccaodai'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucsaccaodai = ClassRegistry::init('Chucsaccaodai');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucsaccaodai);

		parent::tearDown();
	}

}
