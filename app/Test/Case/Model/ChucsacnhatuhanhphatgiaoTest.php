<?php
App::uses('Chucsacnhatuhanhphatgiao', 'Model');

/**
 * Chucsacnhatuhanhphatgiao Test Case
 *
 */
class ChucsacnhatuhanhphatgiaoTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucsacnhatuhanhphatgiao'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucsacnhatuhanhphatgiao = ClassRegistry::init('Chucsacnhatuhanhphatgiao');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucsacnhatuhanhphatgiao);

		parent::tearDown();
	}

}
