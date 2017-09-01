<?php
App::uses('Nguoihoatdongtinnguongchuyennghiep', 'Model');

/**
 * Nguoihoatdongtinnguongchuyennghiep Test Case
 *
 */
class NguoihoatdongtinnguongchuyennghiepTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.nguoihoatdongtinnguongchuyennghiep'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Nguoihoatdongtinnguongchuyennghiep = ClassRegistry::init('Nguoihoatdongtinnguongchuyennghiep');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Nguoihoatdongtinnguongchuyennghiep);

		parent::tearDown();
	}

}
