<?php
App::uses('AppModel', 'Model');
/**
 * Chucsactinlanh Model
 *
 */
class Chucsactinlanh extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucsactinlanh';

	public function getDataExcelDSCSDTBD() {
	   $chucsactinlanh = $this->find('all', array(
            'fields' => array('hovaten', 'gioitinh', 'thuoctochuc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'trongnuoc_boiduongthanhocnganhan', 'trongnuoc_boiduongthanhocnganhan_thoigian',
            'trongnuoc_boiduongthanhocdaihan', 'trongnuoc_boiduongthanhocdaihan_thoigian', 
            'trongnuoc_hocvienthanhkinhthanhoc', 'trongnuoc_hocvienthanhkinhthanhoc_thoigian',
            'nuocngoai_boiduongthanhocnganhan', 'nuocngoai_boiduongthanhocnganhan_thoigian',
            'nuocngoai_boiduongthanhocdaihan', 'nuocngoai_boiduongthanhocdaihan_thoigian',
            'nuocngoai_hocvienthanhkinhthanhoc', 'nuocngoai_hocvienthanhkinhthanhoc_thoigian',
            'noisinh', 'gioitinh', 'phamsactrongtongiao', 
            //CHỨC VỤ
            'phutrachdiemnhom', 'phutaquannhiem', 'quannhiem', 'tvbandaidiencaptinh', 'tvbanchaphanh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotaichihoi', 'diemnhom', 'diemnhom_diachi_so', 'diemnhom_diachi_ap', 'diemnhom_diachi_xa', 'diemnhom_diachi_huyen', 'diemnhom_diachi_tinh'
            ),
            'conditions' => array(
                'OR' => array(
                    'Chucsactinlanh.trongnuoc_boiduongthanhocnganhan <>' => '',
                    'Chucsactinlanh.trongnuoc_boiduongthanhocdaihan <>' => '',
                    'Chucsactinlanh.trongnuoc_hocvienthanhkinhthanhoc <>' => '',
                    'nuocngoai_boiduongthanhocnganhan <>' => '',
                    'nuocngoai_boiduongthanhocdaihan <>' => '',
                    'nuocngoai_hocvienthanhkinhthanhoc <>' => ''
                )
            )
        ));
        
        $chuc_sac_tin_lanh = $cosotongiaodanghoatdong = array();
        foreach ($chucsactinlanh as $key => $value) {
            $value['Chucsactinlanh']['chucvu'] = '';
            if ($value['Chucsactinlanh']['phamsactrongtongiao'] == true) {
                $value['Chucsactinlanh']['chucvu'] = 'Phụ trách Điểm nhóm';
            }
            if ($value['Chucsactinlanh']['phutaquannhiem'] == true) {
                $value['Chucsactinlanh']['chucvu'] = 'Phụ tá Quản nhiệm';
            }
            if ($value['Chucsactinlanh']['quannhiem'] == true) {
                $value['Chucsactinlanh']['chucvu'] = 'Quản nhiệm';
            }
            if ($value['Chucsactinlanh']['tvbandaidiencaptinh'] == true) {
                $value['Chucsactinlanh']['chucvu'] = 'Thành viên Ban Đại diện cấp tỉnh';
            }
            if ($value['Chucsactinlanh']['tvbanchaphanh'] == true) {
                $value['Chucsactinlanh']['chucvu'] = 'Thành viên Ban Chấp hành/Hội đồng trị sự/Ban Quản trị/Ban Trị sự (cấp trung ương)';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsactinlanh']['hoatdongtongiaotaichihoi'],
                $value['Chucsactinlanh']['diemnhom'],
                $value['Chucsactinlanh']['diemnhom_diachi_so'],
                $value['Chucsactinlanh']['diemnhom_diachi_ap'],
                $value['Chucsactinlanh']['diemnhom_diachi_xa'],
                $value['Chucsactinlanh']['diemnhom_diachi_huyen'],
                $value['Chucsactinlanh']['diemnhom_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            if (!empty($value['Chucsactinlanh']['trongnuoc_boiduongthanhocnganhan'])) {
                $chuc_sac_tin_lanh[] = array(
                    'hovaten' => $value['Chucsactinlanh']['hovaten'],
                    'tengoitheotongiao' => '',
                    'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                    'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                    'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                    'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                    'phamsac' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                    'chucvu' => $value['Chucsactinlanh']['chucvu'],
                    'nam_dt_bd' => $value['Chucsactinlanh']['trongnuoc_boiduongthanhocnganhan'],
                    'tenkhoa_dt_bd' => $value['Chucsactinlanh']['trongnuoc_boiduongthanhocnganhan_thoigian'],
                    'quequan' => $value['Chucsactinlanh']['noisinh'],
                    'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                );
            }
            if (!empty($value['Chucsactinlanh']['trongnuoc_boiduongthanhocdaihan'])) {
                $chuc_sac_tin_lanh[] = array(
                    'hovaten' => $value['Chucsactinlanh']['hovaten'],
                    'tengoitheotongiao' => '',
                    'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                    'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                    'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                    'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                    'phamsac' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                    'chucvu' => $value['Chucsactinlanh']['chucvu'],
                    'nam_dt_bd' => $value['Chucsactinlanh']['trongnuoc_boiduongthanhocdaihan_thoigian'],
                    'tenkhoa_dt_bd' => $value['Chucsactinlanh']['trongnuoc_boiduongthanhocdaihan'],
                    'quequan' => $value['Chucsactinlanh']['noisinh'],
                    'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                );
            }
            if (!empty($value['Chucsactinlanh']['trongnuoc_hocvienthanhkinhthanhoc'])) {
                $chuc_sac_tin_lanh[] = array(
                    'hovaten' => $value['Chucsactinlanh']['hovaten'],
                    'tengoitheotongiao' => '',
                    'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                    'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                    'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                    'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                    'phamsac' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                    'chucvu' => $value['Chucsactinlanh']['chucvu'],
                    'nam_dt_bd' => $value['Chucsactinlanh']['trongnuoc_hocvienthanhkinhthanhoc_thoigian'],
                    'tenkhoa_dt_bd' => $value['Chucsactinlanh']['trongnuoc_hocvienthanhkinhthanhoc'],
                    'quequan' => $value['Chucsactinlanh']['noisinh'],
                    'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                );
            }
            if (!empty($value['Chucsactinlanh']['nuocngoai_boiduongthanhocnganhan'])) {
                $chuc_sac_tin_lanh[] = array(
                    'hovaten' => $value['Chucsactinlanh']['hovaten'],
                    'tengoitheotongiao' => '',
                    'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                    'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                    'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                    'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                    'phamsac' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                    'chucvu' => $value['Chucsactinlanh']['chucvu'],
                    'nam_dt_bd' => $value['Chucsactinlanh']['trongnuoc_hocvienthanhkinhthanhoc_thoigian'],
                    'tenkhoa_dt_bd' => $value['Chucsactinlanh']['nuocngoai_boiduongthanhocnganhan'],
                    'quequan' => $value['Chucsactinlanh']['noisinh'],
                    'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                );
            }
            if (!empty($value['Chucsactinlanh']['nuocngoai_boiduongthanhocdaihan'])) {
                $chuc_sac_tin_lanh[] = array(
                    'hovaten' => $value['Chucsactinlanh']['hovaten'],
                    'tengoitheotongiao' => '',
                    'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                    'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                    'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                    'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                    'phamsac' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                    'chucvu' => $value['Chucsactinlanh']['chucvu'],
                    'nam_dt_bd' => $value['Chucsactinlanh']['nuocngoai_boiduongthanhocdaihan_thoigian'],
                    'tenkhoa_dt_bd' => $value['Chucsactinlanh']['nuocngoai_boiduongthanhocdaihan_thoigian'],
                    'quequan' => $value['Chucsactinlanh']['noisinh'],
                    'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                );
            }
            if (!empty($value['Chucsactinlanh']['nuocngoai_hocvienthanhkinhthanhoc'])) {
                $chuc_sac_tin_lanh[] = array(
                    'hovaten' => $value['Chucsactinlanh']['hovaten'],
                    'tengoitheotongiao' => '',
                    'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                    'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                    'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                    'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                    'phamsac' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                    'chucvu' => $value['Chucsactinlanh']['chucvu'],
                    'nam_dt_bd' => $value['Chucsactinlanh']['nuocngoai_hocvienthanhkinhthanhoc_thoigian'],
                    'tenkhoa_dt_bd' => $value['Chucsactinlanh']['nuocngoai_hocvienthanhkinhthanhoc'],
                    'quequan' => $value['Chucsactinlanh']['noisinh'],
                    'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                );
            }
        }
        
        return $chuc_sac_tin_lanh;
	}
}