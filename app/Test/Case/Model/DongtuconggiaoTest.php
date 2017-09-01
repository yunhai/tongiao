<?php
App::uses('Dongtuconggiao', 'Model');

/**
 * Dongtuconggiao Test Case
 *
 */
class DongtuconggiaoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.dongtuconggiao'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Dongtuconggiao = ClassRegistry::init('Dongtuconggiao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Dongtuconggiao);

		parent::tearDown();
	}

}
