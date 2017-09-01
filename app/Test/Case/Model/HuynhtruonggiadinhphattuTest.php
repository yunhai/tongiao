<?php
App::uses('Huynhtruonggiadinhphattu', 'Model');

/**
 * Huynhtruonggiadinhphattu Test Case
 *
 */
class HuynhtruonggiadinhphattuTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.huynhtruonggiadinhphattu'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Huynhtruonggiadinhphattu = ClassRegistry::init('Huynhtruonggiadinhphattu');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Huynhtruonggiadinhphattu);

		parent::tearDown();
	}

}
