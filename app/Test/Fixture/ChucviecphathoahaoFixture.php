<?php
/**
 * ChucviecphathoahaoFixture
 *
 */
class ChucviecphathoahaoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chucviecphathoahao';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hovaten' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaythangnamsinh' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noisinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
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
			'ngaythangnamsinh' => '2016-08-22 22:19:11',
			'noisinh' => 'Lorem ipsum dolor sit amet'
		),
	);

}
