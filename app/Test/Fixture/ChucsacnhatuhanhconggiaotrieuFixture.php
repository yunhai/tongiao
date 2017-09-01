<?php
/**
 * ChucsacnhatuhanhconggiaotrieuFixture
 *
 */
class ChucsacnhatuhanhconggiaotrieuFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chucsacnhatuhanhconggiaotrieu';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hovaten' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaybonmang' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'sodienthoai' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'ngaybonmang' => '2016-08-23 16:42:11',
			'sodienthoai' => 'Lorem ipsum dolor sit amet'
		),
	);

}
