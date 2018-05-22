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
	
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhCongGiaoDongTrieuKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'hoatdongtongiao_chucvuhiennay_chanhxu' => false,
            'hoatdongtongiao_chucvuhiennay_phoxu' => false,
            'hoatdongtongiao_chucvuhiennay_phutaxu' => false,
            'hoatdongtongiao_chucvuhiennay_quannhiemxu' => false,
            'hoatdongtongiao_chucvuhiennay_hattruong' => false,
            'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon' => false,
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan' => false,
            'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc' => false,
            'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan' => false
        );
        $data = $this->getDataExcelChucSacNhaTuHanhCongGiaoDongTrieu24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhCongGiaoDongTrieuCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoatdongtongiao_chucvuhiennay_chanhxu' => false,
                'hoatdongtongiao_chucvuhiennay_phoxu' => false,
                'hoatdongtongiao_chucvuhiennay_phutaxu' => false,
                'hoatdongtongiao_chucvuhiennay_quannhiemxu' => false,
                'hoatdongtongiao_chucvuhiennay_hattruong' => false,
                'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon' => false,
                'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan' => false,
                'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc' => false,
                'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan' => false
            )
        );
        $data = $this->getDataExcelChucSacNhaTuHanhCongGiaoDongTrieu24($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhCongGiaoDongTrieu24($conditions) {
        $chucsacnhatuhanhconggiaotrieu = $this->find('all', array(
            'fields' => array('id', 'hovaten', 'ngaythangnamsinh', 'chungminhnhandan', 'phamsactrongtongiao', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_chanhxu', 'hoatdongtongiao_chucvuhiennay_phoxu', 'hoatdongtongiao_chucvuhiennay_phutaxu', 
            'hoatdongtongiao_chucvuhiennay_quannhiemxu', 'hoatdongtongiao_chucvuhiennay_hattruong', 'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan', 'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc', 'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiao_tencoso', 'hoatdongtongiao_giaohat', 'hoatdongtongiao_giaohat_diachi_so', 'hoatdongtongiao_giaohat_diachi_duong', 'hoatdongtongiao_giaohat_diachi_ap', 'hoatdongtongiao_giaohat_diachi_xa', 'hoatdongtongiao_giaohat_diachi_huyen', 'hoatdongtongiao_giaohat_diachi_tinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = array();
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
            $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                'hovaten' => $value['Chucsacnhatuhanhconggiaotrieu']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => '',
                'ngaythangnamsinh' => $value['Chucsacnhatuhanhconggiaotrieu']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsacnhatuhanhconggiaotrieu']['chungminhnhandan'],
                'chucvu' => $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsacnhatuhanhconggiaotrieu']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_cong_giao_trieu;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ
     */
    public function getDataExcelDSCSTHAMGIACTXHCAPXA() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoatdongtongiao_thamgia_hoidongnhandan_capxa' => true,
                'hoatdongtongiao_thamgia_ubmttqvn_capxa' => true,
                'hoatdongtongiao_thamgia_hoichuthapdo_capxa' => true,
                'hoatdongtongiao_thamgia_hoinongdan_capxa' => true,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa' => true,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa' => true,
                'hoatdongtongiao_thamgia_cactochuckhac_capxa' => true
            )
        );
        $fields = array(
            'hoatdongtongiao_thamgia_hoidongnhandan_capxa' => 'HĐND xã',
            'hoatdongtongiao_thamgia_ubmttqvn_capxa' => 'UBMTTQ xã',
            'hoatdongtongiao_thamgia_hoichuthapdo_capxa' => 'Hội Chữ thập đỏ xã',
            'hoatdongtongiao_thamgia_hoinongdan_capxa' => 'Hội Nông dân xã',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'hoatdongtongiao_thamgia_cactochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
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
                'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen' => true,
                'hoatdongtongiao_thamgia_ubmttqvn_caphuyen' => true,
                'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen' => true,
                'hoatdongtongiao_thamgia_hoinongdan_caphuyen' => true,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen' => true,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen' => true,
                'hoatdongtongiao_thamgia_cactochuckhac_caphuyen' => true
            )
        );
        $fields = array(
            'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen' => 'HĐND huyện',
            'hoatdongtongiao_thamgia_ubmttqvn_caphuyen' => 'UBMTTQ huyện',
            'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen' => 'Hội Chữ thập đỏ huyện',
            'hoatdongtongiao_thamgia_hoinongdan_caphuyen' => 'Hội Nông dân huyện',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen' => 'Hội Liên hiệp Thanh niên huyện',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen' => 'Hội Liên hiệp Phụ nữ huyện',
            'hoatdongtongiao_thamgia_cactochuckhac_caphuyen' => 'Các tổ chức khác Cấp huyện'
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
                'hoatdongtongiao_thamgia_hoidongnhandan_captinh' => true,
                'hoatdongtongiao_thamgia_ubmttqvn_captinh' => true,
                'hoatdongtongiao_thamgia_hoichuthapdo_captinh' => true,
                'hoatdongtongiao_thamgia_hoinongdan_captinh' => true,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh' => true,
                'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh' => true,
                'hoatdongtongiao_thamgia_cactochuckhac_captinh' => true
            )
        );
        $fields = array(
            'hoatdongtongiao_thamgia_hoidongnhandan_captinh' => 'HĐND tỉnh',
            'hoatdongtongiao_thamgia_ubmttqvn_captinh' => 'UBMTTQ tỉnh',
            'hoatdongtongiao_thamgia_hoichuthapdo_captinh' => 'Hội Chữ thập đỏ tỉnh',
            'hoatdongtongiao_thamgia_hoinongdan_captinh' => 'Hội Nông dân tỉnh',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh' => 'Hội Liên hiệp Thanh niên tỉnh',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh' => 'Hội Liên hiệp Phụ nữ tỉnh',
            'hoatdongtongiao_thamgia_cactochuckhac_captinh' => 'Các tổ chức khác Cấp tỉnh'
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
        $chucsacnhatuhanhconggiaotrieu = $this->find('all', array(
            'fields' => array('id', 'hovaten', 'ngaythangnamsinh', 'dantoc', 'chungminhnhandan', 'phamsactrongtongiao', 
            //HỌC VẤN
            'trinhdohocvan_bangcap', 'trinhdochuyenmonvetongiao_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_chanhxu', 'hoatdongtongiao_chucvuhiennay_phoxu', 'hoatdongtongiao_chucvuhiennay_phutaxu', 
            'hoatdongtongiao_chucvuhiennay_quannhiemxu', 'hoatdongtongiao_chucvuhiennay_hattruong', 'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan', 'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc', 'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiao_tencoso', 'hoatdongtongiao_giaohat', 'hoatdongtongiao_giaohat_diachi_so', 'hoatdongtongiao_giaohat_diachi_duong', 'hoatdongtongiao_giaohat_diachi_ap', 'hoatdongtongiao_giaohat_diachi_xa', 'hoatdongtongiao_giaohat_diachi_huyen', 'hoatdongtongiao_giaohat_diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP XÃ
            'hoatdongtongiao_thamgia_hoidongnhandan_capxa', 
            'hoatdongtongiao_thamgia_ubmttqvn_capxa', 
            'hoatdongtongiao_thamgia_hoichuthapdo_capxa', 
            'hoatdongtongiao_thamgia_hoinongdan_capxa', 
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa', 
            'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa', 
            'hoatdongtongiao_thamgia_cactochuckhac_capxa',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP HUYỆN
            'hoatdongtongiao_thamgia_hoidongnhandan_caphuyen', 
            'hoatdongtongiao_thamgia_ubmttqvn_caphuyen', 
            'hoatdongtongiao_thamgia_hoichuthapdo_caphuyen', 
            'hoatdongtongiao_thamgia_hoinongdan_caphuyen', 
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen', 
            'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen', 
            'hoatdongtongiao_thamgia_cactochuckhac_caphuyen',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP TỈNH
            'hoatdongtongiao_thamgia_hoidongnhandan_captinh',
            'hoatdongtongiao_thamgia_ubmttqvn_captinh',
            'hoatdongtongiao_thamgia_hoichuthapdo_captinh',
            'hoatdongtongiao_thamgia_hoinongdan_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh',
            'hoatdongtongiao_thamgia_cactochuckhac_captinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = array();
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
            foreach ($fields as $field => $text) {
                if ($value['Chucsacnhatuhanhconggiaotrieu'][$field] == true) {
                    $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhconggiaotrieu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => '',
                        'dantoc' => $value['Chucsacnhatuhanhconggiaotrieu']['dantoc'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhconggiaotrieu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhconggiaotrieu']['chungminhnhandan'],
                        'chucvu' => $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                        'trinhdochuyenmon' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                        'trinhdotongiao' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdochuyenmonvetongiao_bangcap'],
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Chucsacnhatuhanhconggiaotrieu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_nha_tu_hanh_cong_giao_trieu;
    }
    
    /**
     * DANH SÁCH TU SĨ CÁC TÔN GIÁO
     */
    public function getDataExcelDSTSCTG() {
        $chucsacnhatuhanhconggiaotrieu = $this->find('all', array(
            'fields' => array('id', 'hovaten', 'ngaythangnamsinh', 'dantoc', 'chungminhnhandan', 'phamsactrongtongiao', 'phamsactrongtongiao_namphong_phote',
            //HỌC VẤN
            'trinhdohocvan_bangcap', 'trinhdochuyenmonvetongiao_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_chanhxu', 'hoatdongtongiao_chucvuhiennay_phoxu', 'hoatdongtongiao_chucvuhiennay_phutaxu', 
            'hoatdongtongiao_chucvuhiennay_quannhiemxu', 'hoatdongtongiao_chucvuhiennay_hattruong', 'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan', 'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc', 'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiao_tencoso', 'hoatdongtongiao_giaohat', 'hoatdongtongiao_giaohat_diachi_so', 'hoatdongtongiao_giaohat_diachi_duong', 'hoatdongtongiao_giaohat_diachi_ap', 'hoatdongtongiao_giaohat_diachi_xa', 'hoatdongtongiao_giaohat_diachi_huyen', 'hoatdongtongiao_giaohat_diachi_tinh',
            //CHỖ Ở HIỆN NAY
            'noiohiennay', 'noiohiennay_so', 'noiohiennay_duong', 'noiohiennay_ap', 'noiohiennay_xa', 'noiohiennay_huyen', 'noiohiennay_tinh',
            'is_add'
            ),
            'conditions' => array(
                'hovaten <>' => '',
                'is_add' => 1
            )
        ));
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = array();
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
            $choohiennay = array(
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay'],
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay_so'],
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay_duong'],
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay_ap'],
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay_xa'],
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay_huyen'],
                $value['Chucsacnhatuhanhconggiaotrieu']['noiohiennay_tinh']
            );
            $choohiennay = array_filter($choohiennay, 'strlen');
            $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                'hovaten' => $value['Chucsacnhatuhanhconggiaotrieu']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => '',
                'ngaythangnamsinh' => $value['Chucsacnhatuhanhconggiaotrieu']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsacnhatuhanhconggiaotrieu']['chungminhnhandan'],
                'chucvu' => $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'],
                'namduocphongchuc' => $value['Chucsacnhatuhanhconggiaotrieu']['phamsactrongtongiao_namphong_phote'],
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                'trinhdotongiao' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdochuyenmonvetongiao_bangcap'],
                'quequan' => $value['Chucsacnhatuhanhconggiaotrieu']['noisinh'],
                'choohiennay' => implode(",\n", $choohiennay)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_cong_giao_trieu;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM
     */
    public function getDataExcelDSCHUCSACPCPP() {
        $chucsacnhatuhanhconggiaotrieu = $this->find('all', array(
            'fields' => array('id', 'hovaten', 'ngaythangnamsinh', 'dantoc', 'chungminhnhandan', 'phamsactrongtongiao', 'phamsactrongtongiao_namphong_phote',
            //HỌC VẤN
            'trinhdohocvan_bangcap', 'trinhdochuyenmonvetongiao_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_chanhxu', 'hoatdongtongiao_chucvuhiennay_phoxu', 'hoatdongtongiao_chucvuhiennay_phutaxu', 
            'hoatdongtongiao_chucvuhiennay_quannhiemxu', 'hoatdongtongiao_chucvuhiennay_hattruong', 'hoatdongtongiao_chucvuhiennay_truongbanchuyenmon', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantuvan', 'hoatdongtongiao_chucvuhiennay_thanhvienhoidonglinhmuc', 'hoatdongtongiao_chucvuhiennay_linhhuongcuahoidoan',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiao_tencoso', 'hoatdongtongiao_giaohat', 'hoatdongtongiao_giaohat_diachi_so', 'hoatdongtongiao_giaohat_diachi_duong', 'hoatdongtongiao_giaohat_diachi_ap', 'hoatdongtongiao_giaohat_diachi_xa', 'hoatdongtongiao_giaohat_diachi_huyen', 'hoatdongtongiao_giaohat_diachi_tinh',
            //CHỖ Ở HIỆN NAY
            'noiohiennay', 'noiohiennay_so', 'noiohiennay_duong', 'noiohiennay_ap', 'noiohiennay_xa', 'noiohiennay_huyen', 'noiohiennay_tinh',
            'is_add'
            ),
            'conditions' => array(
                'phamsactrongtongiao <>' => '',
                'hovaten <>' => '',
                'is_add' => 1
            )
        ));
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = array();
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
            $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                'hovaten' => $value['Chucsacnhatuhanhconggiaotrieu']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => '',
                'ngaythangnamsinh' => $value['Chucsacnhatuhanhconggiaotrieu']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsacnhatuhanhconggiaotrieu']['chungminhnhandan'],
                'namduocphongchuc' => $value['Chucsacnhatuhanhconggiaotrieu']['phamsactrongtongiao_namphong_phote'],
                'phamsactruockhiphong' => '',
                'phamsacduocphong' => $value['Chucsacnhatuhanhconggiaotrieu']['phamsactrongtongiao'],
                'chucvu' => $value['Chucsacnhatuhanhconggiaotrieu']['chucvu'],
                'trinhdohocvan' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdohocvan_bangcap'],
                'trinhdotongiao' => $value['Chucsacnhatuhanhconggiaotrieu']['trinhdochuyenmonvetongiao_bangcap'],
                'quequan' => $value['Chucsacnhatuhanhconggiaotrieu']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_cong_giao_trieu;
    }
}