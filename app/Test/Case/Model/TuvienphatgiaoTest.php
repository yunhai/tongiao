<?php
App::uses('Tuvienphatgiao', 'Model');

/**
 * Tuvienphatgiao Test Case
 *
 */
class TuvienphatgiaoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.tuvienphatgiao'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Tuvienphatgiao = ClassRegistry::init('Tuvienphatgiao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Tuvienphatgiao);

		parent::tearDown();
	}

}
