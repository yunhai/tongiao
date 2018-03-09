<?php
App::uses('AppModel', 'Model');
/**
 * Chucsacnhatuhanhconggiaotrieu Model
 *
 */
class Chucsacnhatuhanhconggiaotrieu extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucsacnhatuhanhconggiaotrieu';
	
	public function getDataExcelDSCSDTBD() {
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = array();
        $chucsacnhatuhanhconggiaotrieu = $this->find('all', array(
            'fields' => array('id', 'hovaten', 'ngaythangnamsinh', 'chungminhnhandan', 'phamsactrongtongiao', 
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_chanhxu', 'hoatdongtongiao_chucvuhiennay_phoxu', 'hoatdongtongiao_chucvuhiennay_phutaxu', 
            'hoatdongtongiao_chucvuhiennay_quannhiemxu', 'hoatdongtongiao_chucvuhiennay_hattruong', 'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan', 'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc', 'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan',
            'daquacaclopdaotaoboiduongvetongiaotrongnuoc', 'daquacaclopdaotaoboiduongvetongiaoonuocngoai',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiao_tencoso', 'hoatdongtongiao_giaohat', 'hoatdongtongiao_giaohat_diachi_so', 'hoatdongtongiao_giaohat_diachi_duong', 'hoatdongtongiao_giaohat_diachi_ap', 'hoatdongtongiao_giaohat_diachi_xa', 'hoatdongtongiao_giaohat_diachi_huyen', 'hoatdongtongiao_giaohat_diachi_tinh',
            'is_add'
            ),
            'conditions' => array(
                'Chucsacnhatuhanhconggiaotrieu.is_add' => 1,
                'OR' => array(
                    'Chucsacnhatuhanhconggiaotrieu.daquacaclopdaotaoboiduongvetongiaotrongnuoc <>' => '',
                    'Chucsacnhatuhanhconggiaotrieu.daquacaclopdaotaoboiduongvetongiaoonuocngoai <>' => ''
                )
            )
        ));
        
        foreach ($chucsacnhatuhanhconggiaotrieu as $key => $value) {
            $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_chanhxu'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Chánh xứ';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_phoxu'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Phó xứ';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_phutaxu'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Phụ tá xứ';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_quannhiemxu'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Quản nhiệm xứ';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_hattruong'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Hạt trưởng';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_truongbanchuyenmon'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Trưởng ban chuyên môn';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_thanhvienbantuvan'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Thành viên Ban tư vấn';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Thành viên Hội đồng Linh mục';
            }
            if ($value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan'] == true) {
                $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'] = 'Linh hướng của hội đoàn';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_tencoso'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat_diachi_so'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat_diachi_duong'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat_diachi_ap'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat_diachi_xa'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat_diachi_huyen'],
                $value['Chucsacnhatuhanhconggiaotrieu']['hoatdongtongiao_giaohat_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaotrongnuoc = explode(';', $value['Chucsacnhatuhanhconggiaotrieu']['daquacaclopdaotaoboiduongvetongiaotrongnuoc']);
            $daquacaclopdaotaoboiduongvetongiaoonuocngoai = explode(';', $value['Chucsacnhatuhanhconggiaotrieu']['daquacaclopdaotaoboiduongvetongiaoonuocngoai']);
            $trongnuoc_chitiet = array();
            foreach ($daquacaclopdaotaoboiduongvetongiaotrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhconggiaotrieu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => '',
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhconggiaotrieu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhconggiaotrieu']['chungminhnhandan'],
                        'phamsac' => $value['Chucsacnhatuhanhconggiaotrieu']['phamsactrongtongiao'],
                        'chucvu' => $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhconggiaotrieu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
            foreach ($daquacaclopdaotaoboiduongvetongiaoonuocngoai as $key_dt_bd_nuocngoai => $value_dt_bd_nuocngoai) {
                $dt_bd_nuocngoai = explode('______,',$value_dt_bd_nuocngoai);
                $nuocngoai = $this->khoaHoc($dt_bd_nuocngoai);
                if ((isset($nuocngoai['tu']) && !empty($nuocngoai['tu'])) || (isset($nuocngoai['tuhoc']) && !empty($nuocngoai['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhconggiaotrieu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => '',
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhconggiaotrieu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhconggiaotrieu']['chungminhnhandan'],
                        'phamsac' => $value['Chucsacnhatuhanhconggiaotrieu']['phamsactrongtongiao'],
                        'chucvu' => $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'],
                        'nam_dt_bd' => isset($nuocngoai['tu']) ? $nuocngoai['tu']: '',
                        'tenkhoa_dt_bd' => isset($nuocngoai['tuhoc']) ? $nuocngoai['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhconggiaotrieu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        return $chuc_sac_nha_tu_hanh_cong_giao_trieu;
	}
}