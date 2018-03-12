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
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecHoiGiaoKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'chucvuhiennay_thanhvienbangiaoca' => false
        );
        $data = $this->getDataExcelChucViecHoiGiao24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecHoiGiaoCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'chucvuhiennay_thanhvienbangiaoca' => true
        );
        $data = $this->getDataExcelChucViecHoiGiao24($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucViecHoiGiao24($conditions) {
        $chucviechoigiao = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotongiao', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvuhiennay_thanhvienbangiaoca',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'is_add'
            ),
            'conditions' => $conditions
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
            $chuc_viec_hoi_giao[] = array(
                'hovaten' => $value['Chucviechoigiao']['hovaten'],
                'tengoitheotongiao' => $value['Chucviechoigiao']['tengoitheotongiao'],
                'thuoctochuctongiao' => $value['Chucviechoigiao']['taicoso'],
                'ngaythangnamsinh' => $value['Chucviechoigiao']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucviechoigiao']['chungminhnhandan'],
                'chucvu' => $value['Chucviechoigiao']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => '',
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucviechoigiao']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_viec_hoi_giao;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ
     */
    public function getDataExcelDSCSTHAMGIACTXHCAPXA() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoidongnhandan_capxa' => true,
                'ubmttqvn_capxa' => true,
                'hoichuthapdo_capxa' => true,
                'hoinongdan_capxa' => true,
                'hoilienhiepphunu_capxa' => true,
                'doanthanhnien_capxa' => true,
                'tochuckhac_capxa' => true
            )
        );
        $fields = array(
            'hoidongnhandan_capxa' => 'HĐND xã',
            'ubmttqvn_capxa' => 'UBMTTQ xã',
            'hoinongdan_capxa' => 'Hội Chữ thập đỏ xã',
            'hoichuthapdo_capxa' => 'Hội Nông dân xã',
            'doanthanhnien_capxa' => 'Đoàn thanh niên xã',
            'hoilienhiepphunu_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'tochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
        );
        $data = $this->getDataExcelDSCSTHAMGIACTXH($conditions, $fields);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP HUYỆN
     */
    public function getDataExcelDSCSTHAMGIACTXHCAPHUYEN() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoidongnhandan_caphuyen' => true,
                'ubmttqvn_caphuyen' => true,
                'hoichuthapdo_caphuyen' => true,
                'hoinongdan_caphuyen' => true,
                'hoilienhiepphunu_caphuyen' => true,
                'doanthanhnien_caphuyen' => true,
                'tochuckhac_caphuyen' => true
            )
        );
        $fields = array(
            'hoidongnhandan_caphuyen' => 'HĐND huyện',
            'ubmttqvn_caphuyen' => 'UBMTTQ huyện',
            'hoichuthapdo_caphuyen' => 'Hội Chữ thập đỏ huyện',
            'hoinongdan_caphuyen' => 'Hội Nông dân huyện',
            'doanthanhnien_caphuyen' => 'Đoàn thanh niên huyện',
            'hoilienhiepphunu_caphuyen' => 'Hội Liên hiệp Phụ nữ huyện',
            'tochuckhac_caphuyen' => 'Các tổ chức khác Cấp huyện'
        );
        $data = $this->getDataExcelDSCSTHAMGIACTXH($conditions, $fields);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP TỈNH
     */
    public function getDataExcelDSCSTHAMGIACTXHCAPTINH() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoidongnhandan_captinh' => true,
                'ubmttqvn_captinh' => true,
                'hoichuthapdo_captinh' => true,
                'hoinongdan_captinh' => true,
                'hoilienhiepphunu_captinh' => true,
                'doanthanhnien_captinh' => true,
                'tochuckhac_captinh' => true
            )
        );
        $fields = array(
            'hoidongnhandan_captinh' => 'HĐND tỉnh',
            'ubmttqvn_captinh' => 'UBMTTQ tỉnh',
            'hoichuthapdo_captinh' => 'Hội Chữ thập đỏ tỉnh',
            'hoinongdan_captinh' => 'Hội Nông dân tỉnh',
            'doanthanhnien_captinh' => 'Đoàn thanh niên tỉnh',
            'hoilienhiepphunu_captinh' => 'Hội Liên hiệp Phụ nữ tỉnh',
            'tochuckhac_captinh' => 'Các tổ chức khác Cấp tỉnh'
        );
        $data = $this->getDataExcelDSCSTHAMGIACTXH($conditions, $fields);
        return $data;
    }
    
    /**
     * Lay du lieu cho file excel:
     * - DS CS THAM GIA CT-XH CAP XA
     * - DS CS THAM GIA CT-XH CAP HUYEN
     * - DS CS THAM GIA CT-XH CAP TINH
     */
    public function getDataExcelDSCSTHAMGIACTXH($conditions, $fields) {
        $chucviechoigiao = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotongiao', 'dantoc', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvuhiennay_thanhvienbangiaoca',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 
            'hoatdongtongiaotai_diachi_so', 
            'hoatdongtongiaotai_diachi_ap', 
            'hoatdongtongiaotai_diachi_xa', 
            'hoatdongtongiaotai_diachi_huyen', 
            'hoatdongtongiaotai_diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP XÃ
            'hoidongnhandan_capxa',
            'ubmttqvn_capxa',
            'hoichuthapdo_capxa',
            'hoinongdan_capxa',
            'hoilienhiepphunu_capxa',
            'doanthanhnien_capxa',
            'tochuckhac_capxa',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP HUYỆN
            'hoidongnhandan_caphuyen',
            'ubmttqvn_caphuyen',
            'hoichuthapdo_caphuyen',
            'hoinongdan_caphuyen',
            'hoilienhiepphunu_caphuyen',
            'doanthanhnien_caphuyen',
            'tochuckhac_caphuyen',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP TỈNH
            'hoidongnhandan_captinh',
            'ubmttqvn_captinh',
            'hoichuthapdo_captinh',
            'hoinongdan_captinh',
            'hoilienhiepphunu_captinh',
            'doanthanhnien_captinh',
            'tochuckhac_captinh',
            'is_add'
            ),
            'conditions' => $conditions
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
            foreach ($fields as $field => $text) {
                if ($value['Chucviechoigiao'][$field] == true) {
                    $chuc_viec_hoi_giao[] = array(
                        'hovaten' => $value['Chucviechoigiao']['hovaten'],
                        'tengoitheotongiao' => $value['Chucviechoigiao']['tengoitheotongiao'],
                        'thuoctochuctongiao' => $value['Chucviechoigiao']['tencosotinnguongdanghoatdong'],
                        'dantoc' => $value['Chucviechoigiao']['dantoc'],
                        'ngaythangnamsinh' => $value['Chucviechoigiao']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucviechoigiao']['chungminhnhandan'],
                        'chucvu' => $value['Chucviechoigiao']['chucvu'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => '',
                        'trinhdochuyenmon' => '',
                        'trinhdotongiao' => '',
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Chucviechoigiao']['noisinh'],
                        'cosotongiaodanghoatdong' => $value['Chucviechoigiao']['tencosotinnguongdanghoatdong']
                    );
                }
            }
        }
        
        return $chuc_viec_hoi_giao;
    }
}