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
                'is_add' => 1,
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
	/**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacTinLanhKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'phutrachdiemnhom' => false,
            'phutaquannhiem' => false,
            'quannhiem' => false,
            'tvbandaidiencaptinh' => false,
            'tvbanchaphanh' => false,
        );
        $data = $this->getDataExcelChucSacTinLanh24($conditions);
        return $data;
    }
	/**
	 * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
	 */
    public function getDataExcelChucSacTinLanhCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'phutrachdiemnhom' => true,
                'phutaquannhiem' => true,
                'quannhiem' => true,
                'tvbandaidiencaptinh' => true,
                'tvbanchaphanh' => true
            )
        );
        $data = $this->getDataExcelChucSacTinLanh24($conditions);
        return $data;
    }
	
	/**
	 * Lay du lieu cho 2 file excel:
	 * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
	 * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
	 */
	public function getDataExcelChucSacTinLanh24($conditions) {
        $chucsactinlanh = $this->find('all', array(
            'fields' => array('hovaten', 'gioitinh', 'thuoctochuc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 'gioitinh', 'phamsactrongtongiao', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'phutrachdiemnhom', 'phutaquannhiem', 'quannhiem', 'tvbandaidiencaptinh', 'tvbanchaphanh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotaichihoi', 'diemnhom', 'diemnhom_diachi_so', 'diemnhom_diachi_ap', 'diemnhom_diachi_xa', 'diemnhom_diachi_huyen', 'diemnhom_diachi_tinh'
            ),
            'conditions' => $conditions
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
            $chuc_sac_tin_lanh[] = array(
                'hovaten' => $value['Chucsactinlanh']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                'chucvu' => $value['Chucsactinlanh']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsactinlanh']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsactinlanh']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        /*print "<pre>";
        print_r($chuc_sac_tin_lanh);
        print "</pre>";
        exit;*/
        return $chuc_sac_tin_lanh;
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
                'uybanmttqvn_capxa' => true,
                'hoichuthapdo_capxa' => true,
                'hoinongdan_capxa' => true,
                'hoilienhiepthanhnien_capxa' => true,
                'hoilienhiepphunu_capxa' => true,
                'cactochuckhac_capxa' => true
            )
        );
        $fields = array(
            'hoidongnhandan_capxa' => 'HĐND xã',
            'uybanmttqvn_capxa' => 'UBMTTQ xã',
            'hoichuthapdo_capxa' => 'Hội Chữ thập đỏ xã',
            'hoinongdan_capxa' => 'Hội Nông dân xã',
            'hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'hoilienhiepphunu_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'cactochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
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
                'uybanmttqvn_caphuyen' => true,
                'hoichuthapdo_caphuyen' => true,
                'hoinongdan_caphuyen' => true,
                'hoilienhiepthanhnien_caphuyen' => true,
                'hoilienhiepphunu_caphuyen' => true,
                'cactochuckhac_caphuyen' => true
            )
        );
        $fields = array(
            'hoidongnhandan_caphuyen' => 'HĐND huyện',
            'uybanmttqvn_caphuyen' => 'UBMTTQ huyện',
            'hoichuthapdo_caphuyen' => 'Hội Chữ thập đỏ huyện',
            'hoinongdan_caphuyen' => 'Hội Nông dân huyện',
            'hoilienhiepthanhnien_caphuyen' => 'Hội Liên hiệp Thanh niên huyện',
            'hoilienhiepphunu_caphuyen' => 'Hội Liên hiệp Phụ nữ huyện',
            'cactochuckhac_caphuyen' => 'Các tổ chức khác Cấp huyện'
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
                'uybanmttqvn_captinh' => true,
                'hoichuthapdo_captinh' => true,
                'hoinongdan_captinh' => true,
                'hoilienhiepthanhnien_captinh' => true,
                'hoilienhiepphunu_captinh' => true,
                'cactochuckhac_captinh' => true
            )
        );
        $fields = array(
            'hoidongnhandan_captinh' => 'HĐND tỉnh',
            'uybanmttqvn_captinh' => 'UBMTTQ tỉnh',
            'hoichuthapdo_captinh' => 'Hội Chữ thập đỏ tỉnh',
            'hoinongdan_captinh' => 'Hội Nông dân tỉnh',
            'hoilienhiepthanhnien_captinh' => 'Hội Liên hiệp Thanh niên tỉnh',
            'hoilienhiepphunu_captinh' => 'Hội Liên hiệp Phụ nữ tỉnh',
            'cactochuckhac_captinh' => 'Các tổ chức khác Cấp tỉnh'
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
        $chucsactinlanh = $this->find('all', array(
            'fields' => array('hovaten', 'gioitinh', 'thuoctochuc', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 'gioitinh', 'phamsactrongtongiao', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'phutrachdiemnhom', 'phutaquannhiem', 'quannhiem', 'tvbandaidiencaptinh', 'tvbanchaphanh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotaichihoi', 'diemnhom', 'diemnhom_diachi_so', 'diemnhom_diachi_ap', 'diemnhom_diachi_xa', 'diemnhom_diachi_huyen', 'diemnhom_diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP XÃ
            'hoidongnhandan_capxa', 
            'uybanmttqvn_capxa', 
            'hoichuthapdo_capxa', 
            'hoinongdan_capxa', 
            'hoilienhiepthanhnien_capxa', 
            'hoilienhiepphunu_capxa', 
            'cactochuckhac_capxa',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP HUYỆN
            'hoidongnhandan_caphuyen', 
            'uybanmttqvn_caphuyen', 
            'hoichuthapdo_caphuyen', 
            'hoinongdan_caphuyen', 
            'hoilienhiepthanhnien_caphuyen', 
            'hoilienhiepphunu_caphuyen', 
            'cactochuckhac_caphuyen',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP TỈNH
            'hoidongnhandan_captinh',
            'uybanmttqvn_captinh',
            'hoichuthapdo_captinh',
            'hoinongdan_captinh',
            'hoilienhiepthanhnien_captinh',
            'hoilienhiepphunu_captinh',
            'cactochuckhac_captinh',
            'is_add'
            ),
            'conditions' => $conditions
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
            foreach ($fields as $field => $text) {
                if ($value['Chucsactinlanh'][$field] == true) {
                    $chuc_sac_tin_lanh[] = array(
                        'hovaten' => $value['Chucsactinlanh']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                        'dantoc' => $value['Chucsactinlanh']['dantoc'],
                        'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                        'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                        'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                        'chucvu' => $value['Chucsactinlanh']['chucvu'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => $value['Chucsactinlanh']['trinhdohocvan_bangcap'],
                        'trinhdochuyenmon' => '',
                        'trinhdotongiao' => '',
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Chucsactinlanh']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_tin_lanh;
    }
    
    /**
     * DANH SÁCH TU SĨ CÁC TÔN GIÁO
     */
    public function getDataExcelDSTSCTG() {
        $chucsactinlanh = $this->find('all', array(
            'fields' => array('hovaten', 'gioitinh', 'thuoctochuc', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 'gioitinh', 'phamsactrongtongiao', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'phutrachdiemnhom', 'phutaquannhiem', 'quannhiem', 'tvbandaidiencaptinh', 'tvbanchaphanh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotaichihoi', 'diemnhom', 
            'diemnhom_diachi_so', 'diemnhom_diachi_ap', 'diemnhom_diachi_xa', 'diemnhom_diachi_huyen', 'diemnhom_diachi_tinh',
            //CHỖ Ở HIỆN NAY
            'noiohiennay', 'noiohiennay_sonha', 'noiohiennay_duong', 'noiohiennay_ap', 'noiohiennay_xa', 'noiohiennay_huyen', 'noiohiennay_tinh',
            'is_add'
            ),
            'conditions' => array(
                'hovaten <>' => '',
                'is_add' => 1
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
            $choohiennay = array(
                $value['Chucsactinlanh']['noiohiennay'],
                $value['Chucsactinlanh']['noiohiennay_sonha'],
                $value['Chucsactinlanh']['noiohiennay_duong'],
                $value['Chucsactinlanh']['noiohiennay_ap'],
                $value['Chucsactinlanh']['noiohiennay_xa'],
                $value['Chucsactinlanh']['noiohiennay_huyen'],
                $value['Chucsactinlanh']['noiohiennay_tinh']
            );
            $choohiennay = array_filter($choohiennay, 'strlen');
            $chuc_sac_tin_lanh[] = array(
                'hovaten' => $value['Chucsactinlanh']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                'chucvu' => $value['Chucsactinlanh']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsactinlanh']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsactinlanh']['noisinh'],
                'choohiennay' => implode(",\n", $choohiennay)
            );
        }
        
        return $chuc_sac_tin_lanh;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM
     */
    public function getDataExcelDSCHUCSACPCPP() {
        $chucsactinlanh = $this->find('all', array(
            'fields' => array('hovaten', 'gioitinh', 'thuoctochuc', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 'gioitinh', 'phamsactrongtongiao', 'phamsactrongtongiao_ntn_duocphong_truyendao',
            //HỌC VẤN
            'trinhdohocvan_bangcap', 'trinhdothanhoc_bangcap',
            //CHỨC VỤ
            'phutrachdiemnhom', 'phutaquannhiem', 'quannhiem', 'tvbandaidiencaptinh', 'tvbanchaphanh',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotaichihoi', 'diemnhom', 
            'diemnhom_diachi_so', 'diemnhom_diachi_ap', 'diemnhom_diachi_xa', 'diemnhom_diachi_huyen', 'diemnhom_diachi_tinh',
            //CHỖ Ở HIỆN NAY
            'noiohiennay', 'noiohiennay_sonha', 'noiohiennay_duong', 'noiohiennay_ap', 'noiohiennay_xa', 'noiohiennay_huyen', 'noiohiennay_tinh',
            'is_add'
            ),
            'conditions' => array(
                'phamsactrongtongiao <>' => '',
                'hovaten <>' => '',
                'is_add' => 1
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
            $chuc_sac_tin_lanh[] = array(
                'hovaten' => $value['Chucsactinlanh']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => $value['Chucsactinlanh']['thuoctochuc'],
                'ngaythangnamsinh' => $value['Chucsactinlanh']['ngaythangnamsinh'],
                'gioitinh' => $value['Chucsactinlanh']['gioitinh'],
                'chungminhnhandan' => $value['Chucsactinlanh']['chungminhnhandan'],
                'namduocphongchuc' => $value['Chucsactinlanh']['phamsactrongtongiao_ntn_duocphong_truyendao'],
                'phamsactruockhiphong' => '',
                'phamsacduocphong' => $value['Chucsactinlanh']['phamsactrongtongiao'],
                'chucvu' => $value['Chucsactinlanh']['chucvu'],
                'trinhdohocvan' => $value['Chucsactinlanh']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => $value['Chucsactinlanh']['trinhdohocvan_bangcap'],
                'trinhdotongiao' => $value['Chucsactinlanh']['trinhdothanhoc_bangcap'],
                'quequan' => $value['Chucsactinlanh']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_tin_lanh;
    }
}