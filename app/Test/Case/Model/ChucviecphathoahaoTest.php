<?php
App::uses('Chucviecphathoahao', 'Model');

/**
 * Chucviecphathoahao Test Case
 *
 */
class ChucviecphathoahaoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucviecphathoahao'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucviecphathoahao = ClassRegistry::init('Chucviecphathoahao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucviecphathoahao);

		parent::tearDown();
	}

}
