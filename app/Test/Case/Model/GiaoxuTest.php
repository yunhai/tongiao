<?php
App::uses('Giaoxu', 'Model');

/**
 * Giaoxu Test Case
 *
 */
class GiaoxuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.giaoxu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Giaoxu = ClassRegistry::init('Giaoxu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Giaoxu);

		parent::tearDown();
	}

}
