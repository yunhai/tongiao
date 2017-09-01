<?php
/**
 * ChucsacnhatuhanhcongiaodongtuFixture
 *
 */
class ChucsacnhatuhanhcongiaodongtuFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'chucsacnhatuhanhcongiaodongtu';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'hoten' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'giotinh' => array('type' => 'boolean', 'null' => true, 'default' => null),
		'ngaybonmang' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'ngaythangnamsinh' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noisinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dantoc' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'quoctich' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'chungminhnhandan' => array('type' => 'integer', 'null' => true, 'default' => null),
		'ngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noicap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquanxa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquanhuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nguyenquantinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
		'tencosodanghoatdongtongiao' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tenquocte' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachiso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachiap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachixa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachihuyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachitinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sodienthoaicoso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tonchimucdich' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'linhvuchoatdong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'phamvihoatdong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_GCN' => array('type' => 'integer', 'null' => true, 'default' => null),
		'sogiaychungnhan' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'giaychungnhanngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'giaychungnhancoquancap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tructhuocdongtu' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tructhuocdongtu_tenquocte' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tructhuocdongtu_diachi' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'dongdiaphan' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'dongquocte' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'is_DKHD' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tructhuocdongtu_sogiaychungnhan' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tructhuocdongtu_ngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'tructhuocdongtu_coquancap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'namnhaptu' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noinhaptu' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thoigiankhanlandau' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noitochuclekhan1' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thoigiankhantam' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'noitochuclekhan2' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'thoigiankhantron' => array('type' => 'datetime', 'null' => true, 'default' => null),
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
			'hoten' => 'Lorem ipsum dolor sit amet',
			'giotinh' => 1,
			'ngaybonmang' => '2016-08-09 10:08:39',
			'ngaythangnamsinh' => '2016-08-09 10:08:39',
			'noisinh' => 'Lorem ipsum dolor sit amet',
			'dantoc' => 'Lorem ipsum dolor sit amet',
			'quoctich' => 'Lorem ipsum dolor sit amet',
			'chungminhnhandan' => 1,
			'ngaycap' => '2016-08-09 10:08:39',
			'noicap' => 'Lorem ipsum dolor sit amet',
			'nguyenquanxa' => 'Lorem ipsum dolor sit amet',
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
			'quanhetronggiadinh' => 'Lorem ipsum dolor sit amet',
			'tencosodanghoatdongtongiao' => 'Lorem ipsum dolor sit amet',
			'tenquocte' => 'Lorem ipsum dolor sit amet',
			'diachiso' => 'Lorem ipsum dolor sit amet',
			'diachiap' => 'Lorem ipsum dolor sit amet',
			'diachixa' => 'Lorem ipsum dolor sit amet',
			'diachihuyen' => 'Lorem ipsum dolor sit amet',
			'diachitinh' => 'Lorem ipsum dolor sit amet',
			'sodienthoaicoso' => 'Lorem ipsum dolor sit amet',
			'tonchimucdich' => 'Lorem ipsum dolor sit amet',
			'linhvuchoatdong' => 'Lorem ipsum dolor sit amet',
			'phamvihoatdong' => 'Lorem ipsum dolor sit amet',
			'is_GCN' => 1,
			'sogiaychungnhan' => 'Lorem ipsum dolor sit amet',
			'giaychungnhanngaycap' => '2016-08-09 10:08:39',
			'giaychungnhancoquancap' => 'Lorem ipsum dolor sit amet',
			'tructhuocdongtu' => 'Lorem ipsum dolor sit amet',
			'tructhuocdongtu_tenquocte' => 'Lorem ipsum dolor sit amet',
			'tructhuocdongtu_diachi' => 'Lorem ipsum dolor sit amet',
			'dongdiaphan' => 1,
			'dongquocte' => 1,
			'is_DKHD' => 1,
			'tructhuocdongtu_sogiaychungnhan' => 'Lorem ipsum dolor sit amet',
			'tructhuocdongtu_ngaycap' => '2016-08-09 10:08:39',
			'tructhuocdongtu_coquancap' => 'Lorem ipsum dolor sit amet',
			'namnhaptu' => '2016-08-09 10:08:39',
			'noinhaptu' => 'Lorem ipsum dolor sit amet',
			'thoigiankhanlandau' => '2016-08-09 10:08:39',
			'noitochuclekhan1' => 'Lorem ipsum dolor sit amet',
			'thoigiankhantam' => '2016-08-09 10:08:39',
			'noitochuclekhan2' => 'Lorem ipsum dolor sit amet',
			'thoigiankhantron' => '2016-08-09 10:08:39'
		),
	);

}
