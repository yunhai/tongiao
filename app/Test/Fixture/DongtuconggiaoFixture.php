<?php
/**
 * DongtuconggiaoFixture
 *
 */
class DongtuconggiaoFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'dongtuconggiao';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'tentuvien' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 225, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tengoikhac' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 225, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_so' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'tentuvien' => 'Lorem ipsum dolor sit amet',
			'tengoikhac' => 'Lorem ipsum dolor sit amet',
			'diachi_so' => 'Lorem ipsum dolor sit amet'
		),
	);

}
