<?php
App::uses('Cosotinnguong', 'Model');

/**
 * Cosotinnguong Test Case
 *
 */
class CosotinnguongTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cosotinnguong'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cosotinnguong = ClassRegistry::init('Cosotinnguong');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cosotinnguong);

		parent::tearDown();
	}

}
