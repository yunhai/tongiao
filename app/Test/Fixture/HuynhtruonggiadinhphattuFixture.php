<?php
/**
 * HuynhtruonggiadinhphattuFixture
 *
 */
class HuynhtruonggiadinhphattuFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'huynhtruonggiadinhphattu';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hoten' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phapdanh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sodienthoai' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaythangnamsinh' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noisinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dantoc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'quoctich' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'chungminhnhandan' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noicap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquan' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruduong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruxa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtruhuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'hokhauthuongtrutinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennay' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayduong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayxa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennayhuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'noiohiennaytinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'quanhetronggiadinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'chucvutrongdaohiennay' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dangsinhhoattaigdgp' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thuoctuvien' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachiso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachiduong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachiap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachixa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachihuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachitinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thamgiatochuc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thamgiacap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lamviectochuc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'lamvieccap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'cacthongtinkhac' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'kiennghi' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'hoten' => 'Lorem ipsum dolor sit amet',
			'phapdanh' => 'Lorem ipsum dolor sit amet',
			'sodienthoai' => 'Lorem ipsum dolor sit amet',
			'ngaythangnamsinh' => '2016-08-09 15:05:40',
			'noisinh' => 'Lorem ipsum dolor sit amet',
			'dantoc' => 'Lorem ipsum dolor sit amet',
			'quoctich' => 'Lorem ipsum dolor sit amet',
			'chungminhnhandan' => 'Lorem ipsum dolor sit amet',
			'ngaycap' => '2016-08-09 15:05:40',
			'noicap' => 'Lorem ipsum dolor sit amet',
			'nguyenquan' => 'Lorem ipsum dolor sit amet',
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
			'quanhetronggiadinh' => 'Lorem ipsum dolor sit amet',
			'chucvutrongdaohiennay' => 'Lorem ipsum dolor sit amet',
			'dangsinhhoattaigdgp' => 'Lorem ipsum dolor sit amet',
			'thuoctuvien' => 'Lorem ipsum dolor sit amet',
			'diachiso' => 'Lorem ipsum dolor sit amet',
			'diachiduong' => 'Lorem ipsum dolor sit amet',
			'diachiap' => 'Lorem ipsum dolor sit amet',
			'diachixa' => 'Lorem ipsum dolor sit amet',
			'diachihuyen' => 'Lorem ipsum dolor sit amet',
			'diachitinh' => 'Lorem ipsum dolor sit amet',
			'thamgiatochuc' => 'Lorem ipsum dolor sit amet',
			'thamgiacap' => 'Lorem ipsum dolor sit amet',
			'lamviectochuc' => 'Lorem ipsum dolor sit amet',
			'lamvieccap' => 'Lorem ipsum dolor sit amet',
			'cacthongtinkhac' => 'Lorem ipsum dolor sit amet',
			'kiennghi' => 'Lorem ipsum dolor sit amet'
		),
	);

}
