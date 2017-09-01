<?php
/**
 * ChihoitinhdocusiphatgiaovietnamFixture
 *
 */
class ChihoitinhdocusiphatgiaovietnamFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chihoitinhdocusiphatgiaovietnam';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'tenchihoi' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_so' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_duong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'tenchihoi' => 'Lorem ipsum dolor sit amet',
			'diachi_so' => 'Lorem ipsum dolor sit amet',
			'diachi_duong' => 'Lorem ipsum dolor sit amet'
		),
	);

}
