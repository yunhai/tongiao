<?php
/**
 * CosohoigiaoislamFixture
 *
 */
class CosohoigiaoislamFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'cosohoigiaoislam';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'tenthanhduong_tieuthanhduong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tenthanhduong_tieuthanhduong_diachi_so' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tenthanhduong_tieuthanhduong_diachi_duong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'tenthanhduong_tieuthanhduong' => 'Lorem ipsum dolor sit amet',
			'tenthanhduong_tieuthanhduong_diachi_so' => 'Lorem ipsum dolor sit amet',
			'tenthanhduong_tieuthanhduong_diachi_duong' => 'Lorem ipsum dolor sit amet'
		),
	);

}
