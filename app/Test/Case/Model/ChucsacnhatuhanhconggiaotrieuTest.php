<?php
App::uses('Chucsacnhatuhanhconggiaotrieu', 'Model');

/**
 * Chucsacnhatuhanhconggiaotrieu Test Case
 *
 */
class ChucsacnhatuhanhconggiaotrieuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucsacnhatuhanhconggiaotrieu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucsacnhatuhanhconggiaotrieu = ClassRegistry::init('Chucsacnhatuhanhconggiaotrieu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucsacnhatuhanhconggiaotrieu);

		parent::tearDown();
	}

}
