<?php
App::uses('DetailCountry', 'Model');

/**
 * DetailCountry Test Case
 *
 */
class DetailCountryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.detail_country',
		'app.country'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->DetailCountry = ClassRegistry::init('DetailCountry');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->DetailCountry);

		parent::tearDown();
	}

}
