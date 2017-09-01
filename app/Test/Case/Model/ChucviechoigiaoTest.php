<?php
App::uses('Chucviechoigiao', 'Model');

/**
 * Chucviechoigiao Test Case
 *
 */
class ChucviechoigiaoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucviechoigiao'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucviechoigiao = ClassRegistry::init('Chucviechoigiao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucviechoigiao);

		parent::tearDown();
	}

}
