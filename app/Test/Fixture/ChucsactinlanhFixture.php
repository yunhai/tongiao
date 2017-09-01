<?php
/**
 * ChucsactinlanhFixture
 *
 */
class ChucsactinlanhFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chucsactinlanh';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'hovaten' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'gioitinh' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sodienthoai' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaythangnamsinh' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noisinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dantoc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'quoctich' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'chungminhnhandan' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'ngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noicap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquanhuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquantinh' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruduong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruxa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruhuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtrutinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennay' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayso' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayduong' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayap' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayxa' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayhuyen' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennaytinh' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'trinhdohocvan' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'trinhdothanhoc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'trinhdongoaingu' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'trinhdotinhoc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'quanhetronggiadinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hoatdongtongiaotaichihoi' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diemnhom' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diemnhom_diachiso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diemnhom_diachiap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diemnhom_diachixa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diemnhom_diachihuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diemnhom_diachitinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'gioitinh' => 1,
			'sodienthoai' => 'Lorem ipsum dolor sit amet',
			'ngaythangnamsinh' => '2016-08-20 20:39:09',
			'noisinh' => 'Lorem ipsum dolor sit amet',
			'dantoc' => 'Lorem ipsum dolor sit amet',
			'quoctich' => 'Lorem ipsum dolor sit amet',
			'chungminhnhandan' => 1,
			'ngaycap' => '2016-08-20 20:39:09',
			'noicap' => 'Lorem ipsum dolor sit amet',
			'nguyenquanhuyen' => 'Lorem ipsum dolor sit amet',
			'nguyenquantinh' => 'Lorem ipsum dolor sit amet',
			'hokhauthuongtruso' => 'Lorem ipsum dolor sit amet',
			'hokhauthuongtruduong' => 'Lorem ipsum dolor sit amet',
			'hokhauthuongtruap' => 'Lorem ipsum dolor sit amet',
			'hokhauthuongtruxa' => 'Lorem ipsum dolor sit amet',
			'hokhauthuongtruhuyen' => 'Lorem ipsum dolor sit amet',
			'hokhauthuongtrutinh' => 'Lorem ipsum dolor sit amet',
			'noiohiennay' => 'Lorem ipsum dolor sit amet',
			'noiohiennayso' => 'Lorem ipsum dolor sit amet',
			'noiohiennayduong' => 'Lorem ipsum dolor sit amet',
			'noiohiennayap' => 'Lorem ipsum dolor sit amet',
			'noiohiennayxa' => 'Lorem ipsum dolor sit amet',
			'noiohiennayhuyen' => 'Lorem ipsum dolor sit amet',
			'noiohiennaytinh' => 'Lorem ipsum dolor sit amet',
			'trinhdohocvan' => 'Lorem ipsum dolor sit amet',
			'trinhdothanhoc' => 'Lorem ipsum dolor sit amet',
			'trinhdongoaingu' => 'Lorem ipsum dolor sit amet',
			'trinhdotinhoc' => 'Lorem ipsum dolor sit amet',
			'quanhetronggiadinh' => 'Lorem ipsum dolor sit amet',
			'hoatdongtongiaotaichihoi' => 'Lorem ipsum dolor sit amet',
			'diemnhom' => 'Lorem ipsum dolor sit amet',
			'diemnhom_diachiso' => 'Lorem ipsum dolor sit amet',
			'diemnhom_diachiap' => 'Lorem ipsum dolor sit amet',
			'diemnhom_diachixa' => 'Lorem ipsum dolor sit amet',
			'diemnhom_diachihuyen' => 'Lorem ipsum dolor sit amet',
			'diemnhom_diachitinh' => 'Lorem ipsum dolor sit amet'
		),
	);

}
