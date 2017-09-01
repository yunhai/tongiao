<?php
/**
 * ChucsacnhatuhanhphatgiaoFixture
 *
 */
class ChucsacnhatuhanhphatgiaoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chucsacnhatuhanhphatgiao';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hovaten_thedanh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phapdanh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phaphieu' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'hovaten_thedanh' => 'Lorem ipsum dolor sit amet',
			'phapdanh' => 'Lorem ipsum dolor sit amet',
			'phaphieu' => 'Lorem ipsum dolor sit amet'
		),
	);

}
