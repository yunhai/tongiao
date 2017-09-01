<?php
App::uses('Cosohoigiaoislam', 'Model');

/**
 * Cosohoigiaoislam Test Case
 *
 */
class CosohoigiaoislamTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.cosohoigiaoislam'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Cosohoigiaoislam = ClassRegistry::init('Cosohoigiaoislam');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Cosohoigiaoislam);

		parent::tearDown();
	}

}
