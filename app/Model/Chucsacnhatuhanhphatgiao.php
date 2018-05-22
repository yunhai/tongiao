<?php
App::uses('AppModel', 'Model');
/**
 * Chucsacnhatuhanhphatgiao Model
 *
 */
class Chucsacnhatuhanhphatgiao extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucsacnhatuhanhphatgiao';
	
    public function getDataExcelDSCSDTBD() {
        $chucsacnhatuhanhphatgiao = $this->find('all', array(
            'fields' => array('hovaten', 'phapdanh', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_trutri', 'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen', 'hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh', 'cm_bantrisu_captinh', 'tv_hoidong_trisu', 'tv_hoidong_chungminh', 
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosohoatdongtongiao_tencoso', 'tencosohoatdongtongiao_diachi_so', 'tencosohoatdongtongiao_diachi_duong', 
            'tencosohoatdongtongiao_diachi_ap', 'tencosohoatdongtongiao_diachi_xa', 'tencosohoatdongtongiao_diachi_huyen', 'tencosohoatdongtongiao_diachi_tinh', 
            'daquacaclopdaotaoboiduongvetongiaotrongnuoc',
            'is_add'
            ),
            'conditions' => array(
                'is_add' => 1,
                'OR' => array(
                    'daquacaclopdaotaoboiduongvetongiaotrongnuoc <>' => ''
                )
            )
        ));
        
        $chuc_sac_nha_tu_hanh_phat_giao = $cosotongiaodanghoatdong = array();
        foreach ($chucsacnhatuhanhphatgiao as $key => $value) {
            $value['Chucsacnhatuhanhphatgiao']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_trutri'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Trụ trì';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['cm_bantrisu_captinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_trisu'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Trị sự';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_chungminh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Chứng minh';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_tencoso'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_so'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_duong'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_ap'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_xa'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_huyen'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaootrongnuoc = explode(';', $value['Chucsacnhatuhanhphatgiao']['daquacaclopdaotaoboiduongvetongiaotrongnuoc']);
            foreach ($daquacaclopdaotaoboiduongvetongiaootrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHocChucSacNhaTuHanhPhatGiaoTrongNuoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_phat_giao[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhphatgiao']['hovaten'],
                        'tengoitheotongiao' => $value['Chucsacnhatuhanhphatgiao']['phapdanh'],
                        'thuoctochuctongiao' => $value['Chucsacnhatuhanhphatgiao']['taicoso'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhphatgiao']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhphatgiao']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucsacnhatuhanhphatgiao']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhphatgiao']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        return $chuc_sac_nha_tu_hanh_phat_giao;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhPhatGiaoKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'hoatdongtongiao_chucvuhiennay_trutri' => false,
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen' => false,
            'hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen' => false,
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh' => false,
            'cm_bantrisu_captinh' => false,
            'tv_hoidong_trisu' => false,
            'tv_hoidong_chungminh' => false
        );
        $data = $this->getDataExcelChucSacNhaTuHanhPhatGiao24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhPhatGiaoCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoatdongtongiao_chucvuhiennay_trutri' => false,
                'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen' => false,
                'hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen' => false,
                'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh' => false,
                'cm_bantrisu_captinh' => false,
                'tv_hoidong_trisu' => false,
                'tv_hoidong_chungminh' => false
            )
        );
        $data = $this->getDataExcelChucSacNhaTuHanhPhatGiao24($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhPhatGiao24($conditions) {
        $chucsacnhatuhanhphatgiao = $this->find('all', array(
            'fields' => array('hovaten', 'phapdanh', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_trutri', 'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen', 'hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh', 'cm_bantrisu_captinh', 'tv_hoidong_trisu', 'tv_hoidong_chungminh', 
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosohoatdongtongiao_tencoso', 'tencosohoatdongtongiao_diachi_so', 'tencosohoatdongtongiao_diachi_duong', 
            'tencosohoatdongtongiao_diachi_ap', 'tencosohoatdongtongiao_diachi_xa', 'tencosohoatdongtongiao_diachi_huyen', 'tencosohoatdongtongiao_diachi_tinh', 
            'is_add'
            ),
            'conditions' => $conditions
        ));
        
        $chuc_sac_nha_tu_hanh_phat_giao = $cosotongiaodanghoatdong = array();
        foreach ($chucsacnhatuhanhphatgiao as $key => $value) {
            $value['Chucsacnhatuhanhphatgiao']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_trutri'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Trụ trì';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['cm_bantrisu_captinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_trisu'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Trị sự';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_chungminh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Chứng minh';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_tencoso'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_so'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_duong'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_ap'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_xa'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_huyen'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $chuc_sac_nha_tu_hanh_phat_giao[] = array(
                'hovaten' => $value['Chucsacnhatuhanhphatgiao']['hovaten'],
                'tengoitheotongiao' => $value['Chucsacnhatuhanhphatgiao']['phapdanh'],
                'thuoctochuctongiao' => $value['Chucsacnhatuhanhphatgiao']['taicoso'],
                'ngaythangnamsinh' => $value['Chucsacnhatuhanhphatgiao']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsacnhatuhanhphatgiao']['chungminhnhandan'],
                'chucvu' => $value['Chucsacnhatuhanhphatgiao']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsacnhatuhanhphatgiao']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsacnhatuhanhphatgiao']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_phat_giao;
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
                'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa' => true,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa' => true,
                'hoatdongtongiao_thamgia_cactochuckhac_capxa' => true
            )
        );
        $fields = array(
            'hoatdongtongiao_thamgia_hoidongnhandan_capxa' => 'HĐND xã',
            'hoatdongtongiao_thamgia_ubmttqvn_capxa' => 'UBMTTQ xã',
            'hoatdongtongiao_thamgia_hoichuthapdo_capxa' => 'Hội Chữ thập đỏ xã',
            'hoatdongtongiao_thamgia_hoinongdan_capxa' => 'Hội Nông dân xã',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Phụ nữ xã',
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
                'hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen' => true,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen' => true,
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
                'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh' => true,
                'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh' => true,
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
        $chucsacnhatuhanhphatgiao = $this->find('all', array(
            'fields' => array('hovaten', 'phapdanh', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //HỌC VẤN
            'trinhdohocvan_bangcap', 'trinhdochuyenmonvetongiao_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_trutri', 'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen', 'hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh', 'cm_bantrisu_captinh', 'tv_hoidong_trisu', 'tv_hoidong_chungminh', 
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosohoatdongtongiao_tencoso', 'tencosohoatdongtongiao_diachi_so', 'tencosohoatdongtongiao_diachi_duong', 
            'tencosohoatdongtongiao_diachi_ap', 'tencosohoatdongtongiao_diachi_xa', 'tencosohoatdongtongiao_diachi_huyen', 'tencosohoatdongtongiao_diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI XÃ
            'hoatdongtongiao_thamgia_hoidongnhandan_capxa', 
            'hoatdongtongiao_thamgia_ubmttqvn_capxa', 
            'hoatdongtongiao_thamgia_hoichuthapdo_capxa', 
            'hoatdongtongiao_thamgia_hoinongdan_capxa', 
            'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa', 
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa', 
            'hoatdongtongiao_thamgia_cactochuckhac_capxa', 
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI HUYỆN
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
            'hoatdongtongiao_thamgia_hoilienhiepphunu_captinh',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh',
            'hoatdongtongiao_thamgia_cactochuckhac_captinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        $chuc_sac_nha_tu_hanh_phat_giao = $cosotongiaodanghoatdong = array();
        foreach ($chucsacnhatuhanhphatgiao as $key => $value) {
            $value['Chucsacnhatuhanhphatgiao']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_trutri'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Trụ trì';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['cm_bantrisu_captinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_trisu'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Trị sự';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_chungminh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Chứng minh';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_tencoso'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_so'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_duong'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_ap'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_xa'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_huyen'],
                $value['Chucsacnhatuhanhphatgiao']['tencosohoatdongtongiao_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            foreach ($fields as $field => $text) {
                if ($value['Chucsacnhatuhanhphatgiao'][$field] == true) {
                    $chuc_sac_nha_tu_hanh_phat_giao[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhphatgiao']['hovaten'],
                        'tengoitheotongiao' => $value['Chucsacnhatuhanhphatgiao']['phapdanh'],
                        'thuoctochuctongiao' => $value['Chucsacnhatuhanhphatgiao']['taicoso'],
                        'dantoc' => '',
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhphatgiao']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhphatgiao']['chungminhnhandan'],
                        'chucvu' => $value['Chucsacnhatuhanhphatgiao']['chucvu'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => $value['Chucsacnhatuhanhphatgiao']['trinhdohocvan_bangcap'],
                        'trinhdochuyenmon' => $value['Chucsacnhatuhanhphatgiao']['trinhdohocvan_bangcap'],
                        'trinhdotongiao' => $value['Chucsacnhatuhanhphatgiao']['trinhdohocvan_bangcap'],
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Chucsacnhatuhanhphatgiao']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_nha_tu_hanh_phat_giao;
    }
    
    /**
     * DANH SÁCH TU SĨ CÁC TÔN GIÁO
     */
    public function getDataExcelDSTSCTG() {
        $chucsacnhatuhanhphatgiao = $this->find('all', array(
            'fields' => array('hovaten', 'phapdanh', 'taicoso', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'hoatdongtongiao_chucvuhiennay_trutri', 'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen', 'hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen', 
            'hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh', 'cm_bantrisu_captinh', 'tv_hoidong_trisu', 'tv_hoidong_chungminh', 
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosohoatdongtongiao_tencoso', 'tencosohoatdongtongiao_diachi_so', 'tencosohoatdongtongiao_diachi_duong', 
            'tencosohoatdongtongiao_diachi_ap', 'tencosohoatdongtongiao_diachi_xa', 'tencosohoatdongtongiao_diachi_huyen', 'tencosohoatdongtongiao_diachi_tinh',
            //CHỖ Ở HIỆN NAY
            'noiohiennay', 'noiohiennay_sonha', 'noiohiennay_duong', 'noiohiennay_ap', 'noiohiennay_xa', 'noiohiennay_huyen', 'noiohiennay_tinh',
            'is_add'
            ),
            'conditions' => array(
                'hovaten <>' => '',
                'is_add' => 1
            )
        ));
        $chuc_sac_nha_tu_hanh_phat_giao = $cosotongiaodanghoatdong = array();
        foreach ($chucsacnhatuhanhphatgiao as $key => $value) {
            $value['Chucsacnhatuhanhphatgiao']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_trutri'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Trụ trì';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_chungminhbantrisucaphuyen'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp huyện';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['hoatdongtongiao_chucvuhiennay_thanhvienbantrisucaptinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['cm_bantrisu_captinh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Chứng minh Ban Trị sự cấp tỉnh';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_trisu'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Trị sự';
            }
            if ($value['Chucsacnhatuhanhphatgiao']['tv_hoidong_chungminh'] == true) {
                $value['Chucsacnhatuhanhphatgiao']['chucvu'] = 'Thành viên Hội đồng Chứng minh';
            }
            $choohiennay = array(
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay'],
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay_sonha'],
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay_duong'],
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay_ap'],
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay_xa'],
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay_huyen'],
                $value['Chucsacnhatuhanhphatgiao']['noiohiennay_tinh']
            );
            $choohiennay = array_filter($choohiennay, 'strlen');
            $chuc_sac_nha_tu_hanh_phat_giao[] = array(
                'hovaten' => $value['Chucsacnhatuhanhphatgiao']['hovaten'],
                'tengoitheotongiao' => $value['Chucsacnhatuhanhphatgiao']['phapdanh'],
                'thuoctochuctongiao' => $value['Chucsacnhatuhanhphatgiao']['taicoso'],
                'ngaythangnamsinh' => $value['Chucsacnhatuhanhphatgiao']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsacnhatuhanhphatgiao']['chungminhnhandan'],
                'chucvu' => $value['Chucsacnhatuhanhphatgiao']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsacnhatuhanhphatgiao']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsacnhatuhanhphatgiao']['noisinh'],
                'choohiennay' => implode(",\n", $choohiennay)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_phat_giao;
    }
}