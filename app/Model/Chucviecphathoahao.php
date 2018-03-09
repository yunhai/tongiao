<?php
App::uses('AppModel', 'Model');
/**
 * Chucviecphathoahao Model
 *
 */
class Chucviecphathoahao extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucviecphathoahao';
	
    public function getDataExcelDSCSDTBD() {
        $chucviecphathoahao = $this->find('all', array(
            'fields' => array('hovaten', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'phobantrisu', 'truongbantrisu', 'thanhvienbandaidientinh', 'thanhvienbantrisu',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'daquacaclopdaotaoboiduongvetongiaootrongnuoc',
            'is_add'
            ),
            'conditions' => array(
                'Chucviecphathoahao.is_add' => 1,
                'OR' => array(
                    'Chucviecphathoahao.daquacaclopdaotaoboiduongvetongiaootrongnuoc <>' => ''
                )
            )
        ));
        
        $chuc_viec_phat_hoahao = $cosotongiaodanghoatdong = array();
        foreach ($chucviecphathoahao as $key => $value) {
            $value['Chucviecphathoahao']['chucvu'] = '';
            if ($value['Chucviecphathoahao']['phobantrisu'] == true) {
                $value['Chucviecphathoahao']['chucvu'] = 'Phó Ban trị sự xã, phường, thị trấn';
            }
            if ($value['Chucviecphathoahao']['truongbantrisu'] == true) {
                $value['Chucviecphathoahao']['chucvu'] = 'Trưởng Ban trị sự xã, phường, thị trấn';
            }
            if ($value['Chucviecphathoahao']['thanhvienbandaidientinh'] == true) {
                $value['Chucviecphathoahao']['chucvu'] = 'Thành viên Ban Đại diện tỉnh';
            }
            if ($value['Chucviecphathoahao']['thanhvienbantrisu'] == true) {
                $value['Chucviecphathoahao']['chucvu'] = 'Thành viên Ban Trị sự Trưng ương';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucviecphathoahao']['hoatdongtongiaotai'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_so'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaootrongnuoc = explode(';', $value['Chucviecphathoahao']['daquacaclopdaotaoboiduongvetongiaootrongnuoc']);
            foreach ($daquacaclopdaotaoboiduongvetongiaootrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHocTrongNuoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_viec_phat_hoahao[] = array(
                        'hovaten' => $value['Chucviecphathoahao']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => $value['Chucviecphathoahao']['taicoso'],
                        'ngaythangnamsinh' => $value['Chucviecphathoahao']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucviecphathoahao']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucviecphathoahao']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucviecphathoahao']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_viec_phat_hoahao;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecPhatHoaHaoKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'phobantrisu <>' => '',
            'truongbantrisu <>' => '',
            'thanhvienbandaidientinh <>' => '',
            'thanhvienbantrisu <>' => ''
        );
        $data = $this->getDataExcelChucViecPhatHoaHao24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecPhatHoaHaoCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'phobantrisu <>' => '',
                'truongbantrisu <>' => '',
                'thanhvienbandaidientinh <>' => '',
                'thanhvienbantrisu <>' => ''
            )
        );
        $data = $this->getDataExcelChucViecPhatHoaHao24($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecPhatHoaHao24($conditions) {
        $chucviecphathoahao = $this->find('all', array(
            'fields' => array('hovaten', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'phobantrisu', 'truongbantrisu', 'thanhvienbandaidientinh', 'thanhvienbantrisu',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        
        $chuc_viec_phat_hoahao = $cosotongiaodanghoatdong = array();
        foreach ($chucviecphathoahao as $key => $value) {
            $value['Chucviecphathoahao']['chucvu'] = '';
            if (!empty($value['Chucviecphathoahao']['phobantrisu'])) {
                $value['Chucviecphathoahao']['chucvu'] = 'Phó Ban trị sự xã, phường, thị trấn';
            }
            if (!empty($value['Chucviecphathoahao']['truongbantrisu'])) {
                $value['Chucviecphathoahao']['chucvu'] = 'Trưởng Ban trị sự xã, phường, thị trấn';
            }
            if (!empty($value['Chucviecphathoahao']['thanhvienbandaidientinh'])) {
                $value['Chucviecphathoahao']['chucvu'] = 'Thành viên Ban Đại diện tỉnh';
            }
            if (!empty($value['Chucviecphathoahao']['thanhvienbantrisu'])) {
                $value['Chucviecphathoahao']['chucvu'] = 'Thành viên Ban Trị sự Trưng ương';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucviecphathoahao']['hoatdongtongiaotai'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_so'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucviecphathoahao']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $chuc_viec_phat_hoahao[] = array(
                'hovaten' => $value['Chucviecphathoahao']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => $value['Chucviecphathoahao']['taicoso'],
                'ngaythangnamsinh' => $value['Chucviecphathoahao']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucviecphathoahao']['chungminhnhandan'],
                'chucvu' => $value['Chucviecphathoahao']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => '',
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucviecphathoahao']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_viec_phat_hoahao;
    }
}