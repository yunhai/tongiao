<?php
App::uses('Chihoitinhdocusiphatgiaovietnam', 'Model');

/**
 * Chihoitinhdocusiphatgiaovietnam Test Case
 *
 */
class ChihoitinhdocusiphatgiaovietnamTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chihoitinhdocusiphatgiaovietnam'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chihoitinhdocusiphatgiaovietnam = ClassRegistry::init('Chihoitinhdocusiphatgiaovietnam');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chihoitinhdocusiphatgiaovietnam);

		parent::tearDown();
	}

}
