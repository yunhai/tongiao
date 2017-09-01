<?php
/**
 * ChucviechoigiaoFixture
 *
 */
class ChucviechoigiaoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chucviechoigiao';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hovaten' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tengoitheotongiao' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaythangnamsinh' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'hovaten' => 'Lorem ipsum dolor sit amet',
			'tengoitheotongiao' => 'Lorem ipsum dolor sit amet',
			'ngaythangnamsinh' => '2016-08-23 21:38:48'
		),
	);

}
