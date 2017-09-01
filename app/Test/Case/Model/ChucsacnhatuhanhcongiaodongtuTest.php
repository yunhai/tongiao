<?php
App::uses('Chucsacnhatuhanhcongiaodongtu', 'Model');

/**
 * Chucsacnhatuhanhcongiaodongtu Test Case
 *
 */
class ChucsacnhatuhanhcongiaodongtuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucsacnhatuhanhcongiaodongtu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucsacnhatuhanhcongiaodongtu = ClassRegistry::init('Chucsacnhatuhanhcongiaodongtu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucsacnhatuhanhcongiaodongtu);

		parent::tearDown();
	}

}
