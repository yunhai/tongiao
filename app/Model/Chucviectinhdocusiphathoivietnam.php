<?php
App::uses('AppModel', 'Model');
/**
 * Chucviectinhdocusiphathoivietnam Model
 *
 */
class Chucviectinhdocusiphathoivietnam extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucviectinhdocusiphathoivietnam';
	
    public function getDataExcelDSCSDTBD() {
        $chucviectinhdocusiphathoivietnam = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotongiao', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'phobanytephuocthien', 'truongbanytephuocthien', 'thanhvienbantrisucaptinh', 'thanhvienbantrisucaptrunguong',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'daquacaclopdaotaoboiduongvetongiaootrongnuoc',
            'is_add'
            ),
            'conditions' => array(
                'Chucviectinhdocusiphathoivietnam.is_add' => 1,
                'OR' => array(
                    'Chucviectinhdocusiphathoivietnam.daquacaclopdaotaoboiduongvetongiaootrongnuoc <>' => ''
                )
            )
        ));
        
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $cosotongiaodanghoatdong = array();
        foreach ($chucviectinhdocusiphathoivietnam as $key => $value) {
            $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = '';
            if ($value['Chucviectinhdocusiphathoivietnam']['phobanytephuocthien'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Phó Ban Y tế Phước thiện';
            }
            if ($value['Chucviectinhdocusiphathoivietnam']['truongbanytephuocthien'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Trưởng Ban Y tế Phước thiện';
            }
            if ($value['Chucviectinhdocusiphathoivietnam']['thanhvienbantrisucaptinh'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Thành viên Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucviectinhdocusiphathoivietnam']['thanhvienbantrisucaptrunguong'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Thành viên Ban Trị sự Trưng ương';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_so'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaootrongnuoc = explode(';', $value['Chucviectinhdocusiphathoivietnam']['daquacaclopdaotaoboiduongvetongiaootrongnuoc']);
            foreach ($daquacaclopdaotaoboiduongvetongiaootrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHocChucViecTinhDoCuSiPhatHoiVietNamTrongNuoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam[] = array(
                        'hovaten' => $value['Chucviectinhdocusiphathoivietnam']['hovaten'],
                        'tengoitheotongiao' => $value['Chucviectinhdocusiphathoivietnam']['tengoitheotongiao'],
                        'thuoctochuctongiao' => $value['Chucviectinhdocusiphathoivietnam']['taicoso'],
                        'ngaythangnamsinh' => $value['Chucviectinhdocusiphathoivietnam']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucviectinhdocusiphathoivietnam']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucviectinhdocusiphathoivietnam']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucviectinhdocusiphathoivietnam']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecTinhDoCuSiPhatHoiVietNamKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'phobanytephuocthien' => false,
            'truongbanytephuocthien' => false,
            'thanhvienbantrisucaptinh' => false,
            'thanhvienbantrisucaptrunguong' => false
        );
        $data = $this->getDataExcelChucViecTinhDoCuSiPhatHoiVietNam24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecTinhDoCuSiPhatHoiVietNamCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'phobanytephuocthien' => false,
                'truongbanytephuocthien' => false,
                'thanhvienbantrisucaptinh' => false,
                'thanhvienbantrisucaptrunguong' => false
            )
        );
        $data = $this->getDataExcelChucViecTinhDoCuSiPhatHoiVietNam24($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecTinhDoCuSiPhatHoiVietNam24($conditions) {
        $chucviectinhdocusiphathoivietnam = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotongiao', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'phobanytephuocthien', 'truongbanytephuocthien', 'thanhvienbantrisucaptinh', 'thanhvienbantrisucaptrunguong',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $cosotongiaodanghoatdong = array();
        foreach ($chucviectinhdocusiphathoivietnam as $key => $value) {
            $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = '';
            if ($value['Chucviectinhdocusiphathoivietnam']['phobanytephuocthien'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Phó Ban Y tế Phước thiện';
            }
            if ($value['Chucviectinhdocusiphathoivietnam']['truongbanytephuocthien'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Trưởng Ban Y tế Phước thiện';
            }
            if ($value['Chucviectinhdocusiphathoivietnam']['thanhvienbantrisucaptinh'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Thành viên Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucviectinhdocusiphathoivietnam']['thanhvienbantrisucaptrunguong'] == true) {
                $value['Chucviectinhdocusiphathoivietnam']['chucvu'] = 'Thành viên Ban Trị sự Trưng ương';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_so'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucviectinhdocusiphathoivietnam']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam[] = array(
                'hovaten' => $value['Chucviectinhdocusiphathoivietnam']['hovaten'],
                'tengoitheotongiao' => $value['Chucviectinhdocusiphathoivietnam']['tengoitheotongiao'],
                'thuoctochuctongiao' => $value['Chucviectinhdocusiphathoivietnam']['taicoso'],
                'ngaythangnamsinh' => $value['Chucviectinhdocusiphathoivietnam']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucviectinhdocusiphathoivietnam']['chungminhnhandan'],
                'chucvu' => $value['Chucviectinhdocusiphathoivietnam']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => '',
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucviectinhdocusiphathoivietnam']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam;
    }
}