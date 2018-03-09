<?php
App::uses('AppModel', 'Model');
/**
 * Chucviechoigiao Model
 *
 */
class Chucviechoigiao extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucviechoigiao';

    public function getDataExcelDSCSDTBD() {
        $chucviechoigiao = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotongiao', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvuhiennay_thanhvienbangiaoca',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'daquacaclopdaotaoboiduongvetongiaootrongnuoc',
            'is_add'
            ),
            'conditions' => array(
                'is_add' => 1,
                'OR' => array(
                    'daquacaclopdaotaoboiduongvetongiaootrongnuoc <>' => ''
                )
            )
        ));
        
        $chuc_viec_hoi_giao = $cosotongiaodanghoatdong = array();
        foreach ($chucviechoigiao as $key => $value) {
            $value['Chucviechoigiao']['chucvu'] = '';
            if ($value['Chucviechoigiao']['chucvuhiennay_thanhvienbangiaoca'] == true) {
                $value['Chucviechoigiao']['chucvu'] = 'Thành viên Ban Giáo cả/Ban Quản trị';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucviechoigiao']['hoatdongtongiaotai'],
                $value['Chucviechoigiao']['hoatdongtongiaotai_diachi_so'],
                $value['Chucviechoigiao']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucviechoigiao']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucviechoigiao']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucviechoigiao']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaootrongnuoc = explode(';', $value['Chucviechoigiao']['daquacaclopdaotaoboiduongvetongiaootrongnuoc']);
            foreach ($daquacaclopdaotaoboiduongvetongiaootrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHocChucViecHoiGiaoTrongNuoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_viec_hoi_giao[] = array(
                        'hovaten' => $value['Chucviechoigiao']['hovaten'],
                        'tengoitheotongiao' => $value['Chucviechoigiao']['tengoitheotongiao'],
                        'thuoctochuctongiao' => $value['Chucviechoigiao']['taicoso'],
                        'ngaythangnamsinh' => $value['Chucviechoigiao']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucviechoigiao']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucviechoigiao']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucviechoigiao']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_viec_hoi_giao;
    }
}