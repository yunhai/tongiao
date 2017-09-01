<?php
App::uses('Hodaocaodai', 'Model');

/**
 * Hodaocaodai Test Case
 *
 */
class HodaocaodaiTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.hodaocaodai'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Hodaocaodai = ClassRegistry::init('Hodaocaodai');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Hodaocaodai);

		parent::tearDown();
	}

}
