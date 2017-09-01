<?php
/**
 * NguoihoatdongtinnguongchuyennghiepFixture
 *
 */
class NguoihoatdongtinnguongchuyennghiepFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'nguoihoatdongtinnguongchuyennghiep';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'hovaten' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tengoitheotinnguong' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sodienthoai' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'chucvu' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaythangnamsinh' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noisinh' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dantoc' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'quoctich' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'chungminhnhandan' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'chungminhnhandan_ngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'chungminhnhandan_noicap' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquan_xa' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquan_huyen' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 125),
		'nguyenquan_tinh' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 125),
		'noi_dangky_hokhauthuongtru_sonha' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 125),
		'noi_dangky_hokhauthuongtru_duong' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noi_dangky_hokhauthuongtru_ap' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noi_dangky_hokhauthuongtru_xa' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noi_dangky_hokhauthuongtru_huyen' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noi_dangky_hokhauthuongtru_tinh' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 125, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'tengoitheotinnguong' => 'Lorem ipsum dolor sit amet',
			'sodienthoai' => 'Lorem ipsum dolor sit amet',
			'chucvu' => 'Lorem ipsum dolor sit amet',
			'ngaythangnamsinh' => '2016-08-13 20:36:54',
			'noisinh' => 'Lorem ipsum dolor sit amet',
			'dantoc' => 'Lorem ipsum dolor sit amet',
			'quoctich' => 'Lorem ipsum dolor sit amet',
			'chungminhnhandan' => 1,
			'chungminhnhandan_ngaycap' => '2016-08-13 20:36:54',
			'chungminhnhandan_noicap' => 'Lorem ipsum dolor sit amet',
			'nguyenquan_xa' => 'Lorem ipsum dolor sit amet',
			'nguyenquan_huyen' => 1,
			'nguyenquan_tinh' => 1,
			'noi_dangky_hokhauthuongtru_sonha' => 1,
			'noi_dangky_hokhauthuongtru_duong' => 'Lorem ipsum dolor sit amet',
			'noi_dangky_hokhauthuongtru_ap' => 'Lorem ipsum dolor sit amet',
			'noi_dangky_hokhauthuongtru_xa' => 'Lorem ipsum dolor sit amet',
			'noi_dangky_hokhauthuongtru_huyen' => 'Lorem ipsum dolor sit amet',
			'noi_dangky_hokhauthuongtru_tinh' => 'Lorem ipsum dolor sit amet'
		),
	);

}
