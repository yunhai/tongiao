<?php
App::uses('AppModel', 'Model');
/**
 * Chucsacnhatuhanhcongiaodongtu Model
 *
 */
class Chucsacnhatuhanhcongiaodongtu extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucsacnhatuhanhcongiaodongtu';
	
	public function getDataExcelDSCSDTBD() {
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = array();
        $chucsacnhatuhanhcongiaodongtu = $this->find('all', array(
            'fields' => array('hovaten', 'tructhuocdongtu', 'ngaythangnamsinh', 'chungminhnhandan', //'phamsactrongtongiao', 
            //CHỨC VỤ
            'hoatdongtongiao_betrendong', 'hoatdongtongiao_betrentinhdong', 'hoatdongtongiao_betrenmiendong', 
            'hoatdongtongiao_betrencongdoan', 'hoatdongtongiao_thanhvienbantuvantgmxl', 'hoatdongtongiao_thanhvienhoidonglinhmuc', 'hoatdongtongiao_linhhuongcuahoidoan',
            'daquacaclopdaotaoboiduongvetongiaotrongnuoc', 'daquacaclopdaotaoboiduongvetongiaoonuocngoai',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosodanghoatdongtongiao', 'tenquocte', 'diachi_so', 'diachi_ap', 'diachi_xa', 'diachi_huyen', 'diachi_tinh',
            'is_add'
            ),
            'conditions' => array(
                'Chucsacnhatuhanhcongiaodongtu.is_add' => 1,
                'OR' => array(
                    'Chucsacnhatuhanhcongiaodongtu.daquacaclopdaotaoboiduongvetongiaotrongnuoc <>' => '',
                    'Chucsacnhatuhanhcongiaodongtu.daquacaclopdaotaoboiduongvetongiaoonuocngoai <>' => ''
                )
            )
        ));
        foreach ($chucsacnhatuhanhcongiaodongtu as $key => $value) {
            $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrentinhdong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên tỉnh dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrenmiendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên miền dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrencongdoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Cộng đoàn (Tu viện, đan viện)';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienbantuvantgmxl'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Ban tư vấn TGMXL';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienhoidonglinhmuc'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Hội đồng Linh mục';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_linhhuongcuahoidoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Linh hướng của hội đoàn';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhcongiaodongtu']['tencosodanghoatdongtongiao'],
                $value['Chucsacnhatuhanhcongiaodongtu']['tenquocte'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_so'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_ap'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_xa'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaotrongnuoc = explode(';', $value['Chucsacnhatuhanhcongiaodongtu']['daquacaclopdaotaoboiduongvetongiaotrongnuoc']);
            $daquacaclopdaotaoboiduongvetongiaoonuocngoai = explode(';', $value['Chucsacnhatuhanhcongiaodongtu']['daquacaclopdaotaoboiduongvetongiaoonuocngoai']);
            $trongnuoc_chitiet = array();
            foreach ($daquacaclopdaotaoboiduongvetongiaotrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_con_giao_dong_tu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhcongiaodongtu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => $value['Chucsacnhatuhanhcongiaodongtu']['tructhuocdongtu'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhcongiaodongtu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhcongiaodongtu']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhcongiaodongtu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(',', $cosotongiaodanghoatdong)
                    );
                }
            }
            foreach ($daquacaclopdaotaoboiduongvetongiaoonuocngoai as $key_dt_bd_nuocngoai => $value_dt_bd_nuocngoai) {
                $dt_bd_nuocngoai = explode('______,',$value_dt_bd_nuocngoai);
                $nuocngoai = $this->khoaHoc($dt_bd_nuocngoai);
                if ((isset($nuocngoai['tu']) && !empty($nuocngoai['tu'])) || (isset($nuocngoai['tuhoc']) && !empty($nuocngoai['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_con_giao_dong_tu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhcongiaodongtu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => $value['Chucsacnhatuhanhcongiaodongtu']['tructhuocdongtu'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhcongiaodongtu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhcongiaodongtu']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'],
                        'nam_dt_bd' => isset($nuocngoai['tu']) ? $nuocngoai['tu']: '',
                        'tenkhoa_dt_bd' => isset($nuocngoai['tuhoc']) ? $nuocngoai['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhcongiaodongtu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_nha_tu_hanh_con_giao_dong_tu;
	}
}