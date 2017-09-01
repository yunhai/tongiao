<?php
App::uses('Chucviectinhdocusiphathoivietnam', 'Model');

/**
 * Chucviectinhdocusiphathoivietnam Test Case
 *
 */
class ChucviectinhdocusiphathoivietnamTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.chucviectinhdocusiphathoivietnam'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Chucviectinhdocusiphathoivietnam = ClassRegistry::init('Chucviectinhdocusiphathoivietnam');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Chucviectinhdocusiphathoivietnam);

		parent::tearDown();
	}

}
