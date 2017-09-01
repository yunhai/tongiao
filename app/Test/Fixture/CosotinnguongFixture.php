<?php
/**
 * CosotinnguongFixture
 *
 */
class CosotinnguongFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'cosotinnguong';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'tencoso' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tengoikhac' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_so' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_duong' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_ap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_xa' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_huyen' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'diachi_tinh' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'sodienthoai' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'is_GCN' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'sogiaychungnhan' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'ngaycap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'coquancap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tntquoctohungvuong' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tntcungtotien' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tntanhhungdantoc' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tntthanhhoang' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tntmau' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tndantochoa' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'loaihinhtnkhac' => array('type' => 'string', 'null' => true, 'default' => '0', 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'doituongthocung' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'namthanhlap' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'namxaydung' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'solan_trungtu_tontao' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nam_gannhat_trungtu_tontao' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'tongkinhphu_trungtu_tontao_gannhat' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tongkinhphu_trungtu_tontao_gannhat_bangchu' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tongdientichdat' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tongiao_dientich' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tongiao_soGCNQSDD' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tongiao_coquancap_ngaycap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'tongiao_dacap_dientich' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tongiao_dacap_soto_thua' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tongiao_chuacap_dientich' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'tongiao_chuacap_soto_thua' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nn_ln_ntts_dientich' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nn_ln_ntts_soGCNQSDD' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nn_ln_ntts_coquancap_ngaycap' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
		'nn_ln_ntts_dacap_dientich' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nn_ln_ntts_dacap_soto_thua' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nn_ln_ntts_chuacap_dientich' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'nn_ln_ntts_chuacap_soto_thua' => array('type' => 'integer', 'null' => true, 'default' => '0'),
		'caccongtrinhcuacosotn' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_unicode_ci', 'charset' => 'utf8'),
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
			'tencoso' => 'Lorem ipsum dolor sit amet',
			'tengoikhac' => 'Lorem ipsum dolor sit amet',
			'diachi_so' => 'Lorem ipsum dolor sit amet',
			'diachi_duong' => 'Lorem ipsum dolor sit amet',
			'diachi_ap' => 'Lorem ipsum dolor sit amet',
			'diachi_xa' => 'Lorem ipsum dolor sit amet',
			'diachi_huyen' => 'Lorem ipsum dolor sit amet',
			'diachi_tinh' => 'Lorem ipsum dolor sit amet',
			'sodienthoai' => 'Lorem ipsum dolor sit amet',
			'is_GCN' => 1,
			'sogiaychungnhan' => 'Lorem ipsum dolor sit amet',
			'ngaycap' => '2016-08-13 00:01:25',
			'coquancap' => 'Lorem ipsum dolor sit amet',
			'tntquoctohungvuong' => 1,
			'tntcungtotien' => 1,
			'tntanhhungdantoc' => 1,
			'tntthanhhoang' => 1,
			'tntmau' => 1,
			'tndantochoa' => 1,
			'loaihinhtnkhac' => 'Lorem ipsum dolor sit amet',
			'doituongthocung' => 'Lorem ipsum dolor sit amet',
			'namthanhlap' => '2016-08-13 00:01:25',
			'namxaydung' => '2016-08-13 00:01:25',
			'solan_trungtu_tontao' => 1,
			'nam_gannhat_trungtu_tontao' => '2016-08-13 00:01:25',
			'tongkinhphu_trungtu_tontao_gannhat' => 1,
			'tongkinhphu_trungtu_tontao_gannhat_bangchu' => 'Lorem ipsum dolor sit amet',
			'tongdientichdat' => 1,
			'tongiao_dientich' => 1,
			'tongiao_soGCNQSDD' => 'Lorem ipsum dolor sit amet',
			'tongiao_coquancap_ngaycap' => 'Lorem ipsum dolor sit amet',
			'tongiao_dacap_dientich' => 1,
			'tongiao_dacap_soto_thua' => 1,
			'tongiao_chuacap_dientich' => 1,
			'tongiao_chuacap_soto_thua' => 1,
			'nn_ln_ntts_dientich' => 1,
			'nn_ln_ntts_soGCNQSDD' => 'Lorem ipsum dolor sit amet',
			'nn_ln_ntts_coquancap_ngaycap' => 'Lorem ipsum dolor sit amet',
			'nn_ln_ntts_dacap_dientich' => 1,
			'nn_ln_ntts_dacap_soto_thua' => 1,
			'nn_ln_ntts_chuacap_dientich' => 1,
			'nn_ln_ntts_chuacap_soto_thua' => 1,
			'caccongtrinhcuacosotn' => 'Lorem ipsum dolor sit amet'
		),
	);

}
