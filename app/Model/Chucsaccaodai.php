<?php
App::uses('AppModel', 'Model');
/**
 * Chucsaccaodai Model
 *
 */
class Chucsaccaodai extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucsaccaodai';

    public function getDataExcelDSCSDTBD() {
        $chucsaccaodai = $this->find('all', array(
            'fields' => array('hovaten', 'thanhdanh', 'thuoctochuc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvuhiennay_phobancaiquan', 'chucvuhiennay_caiquan', 'chucvuhiennay_thanhvienbddct',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'daquacaclopdaotaoboiduongvetongiaootrongnuoc',
            'is_add'
            ),
            'conditions' => array(
                'Chucsaccaodai.is_add' => 1,
                'OR' => array(
                    'Chucsaccaodai.daquacaclopdaotaoboiduongvetongiaootrongnuoc <>' => ''
                )
            )
        ));
        
        $chuc_sac_cao_dai = $cosotongiaodanghoatdong = array();
        foreach ($chucsaccaodai as $key => $value) {
            $value['Chucsaccaodai']['chucvu'] = '';
            if (!empty($value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'];
            } elseif (!empty($value['Chucsaccaodai']['chucvuhiennay_caiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_caiquan'];
            } else {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_thanhvienbddct'];
            }
            
            $cosotongiaodanghoatdong = array(
                $value['Chucsaccaodai']['hoatdongtongiaotai'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_so'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaootrongnuoc = explode(';', $value['Chucsaccaodai']['daquacaclopdaotaoboiduongvetongiaootrongnuoc']);
            foreach ($daquacaclopdaotaoboiduongvetongiaootrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHocChucSacCaoDai($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_sac_cao_dai[] = array(
                        'hovaten' => $value['Chucsaccaodai']['hovaten'],
                        'tengoitheotongiao' => $value['Chucsaccaodai']['thanhdanh'],
                        'thuoctochuctongiao' => $value['Chucsaccaodai']['thuoctochuc'],
                        'ngaythangnamsinh' => $value['Chucsaccaodai']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsaccaodai']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucsaccaodai']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucsaccaodai']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(',', $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_cao_dai;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacCaoDaiKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'chucvuhiennay_phobancaiquan' => false,
            'chucvuhiennay_caiquan' => false,
            'chucvuhiennay_thanhvienbddct' => false
        );
        $data = $this->getDataExcelChucSacCaoDai24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacCaoDaiCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'chucvuhiennay_phobancaiquan' => false,
                'chucvuhiennay_caiquan' => false,
                'chucvuhiennay_thanhvienbddct' => false
            )
        );
        $data = $this->getDataExcelChucSacCaoDai24($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacCaoDai24($conditions) {
        $chucsaccaodai = $this->find('all', array(
            'fields' => array('hovaten', 'thanhdanh', 'thuoctochuc', 'ngaythangnamsinh', 'chungminhnhandan', 'phamsac_ntn_cauphong_lesanh', 
            'noisinh', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'chucvuhiennay_phobancaiquan', 'chucvuhiennay_caiquan', 'chucvuhiennay_thanhvienbddct',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        
        $chuc_sac_cao_dai = $cosotongiaodanghoatdong = array();
        foreach ($chucsaccaodai as $key => $value) {
            $value['Chucsaccaodai']['chucvu'] = '';
            if (!empty($value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'];
            } elseif (!empty($value['Chucsaccaodai']['chucvuhiennay_caiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_caiquan'];
            } else {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_thanhvienbddct'];
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsaccaodai']['hoatdongtongiaotai'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_so'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $chuc_sac_cao_dai[] = array(
                'hovaten' => $value['Chucsaccaodai']['hovaten'],
                'tengoitheotongiao' => $value['Chucsaccaodai']['thanhdanh'],
                'thuoctochuctongiao' => $value['Chucsaccaodai']['thuoctochuc'],
                'ngaythangnamsinh' => $value['Chucsaccaodai']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsaccaodai']['chungminhnhandan'],
                'chucvu' => $value['Chucsaccaodai']['chucvu'],
                'namduocphongchuc' => $value['Chucsaccaodai']['phamsac_ntn_cauphong_lesanh'],
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsaccaodai']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => $value['Chucsaccaodai']['trinhdohocvan_bangcap'],
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsaccaodai']['noisinh'],
                'cosotongiaodanghoatdong' => implode(',', $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_cao_dai;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ
     */
    public function getDataExcelDSCSTHAMGIACTXHCAPXA() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'thamgiacactcctxh_hoidongnhandan_capxa' => true,
                'thamgiacactcctxh_uybanmttqvn_capxa' => true,
                'thamgiacactcctxh_hoichuthapdo_capxa' => true,
                'thamgiacactcctxh_hoinongdan_capxa' => true,
                'thamgiacactcctxh_hoilienhiepphunu_capxa' => true,
                'thamgiacactcctxh_doanthanhnien_capxa' => true,
                'thamgiacactcctxh_tochuckhac_capxa' => true
            )
        );
        $fields = array(
            'thamgiacactcctxh_hoidongnhandan_capxa' => 'HĐND xã',
            'thamgiacactcctxh_uybanmttqvn_capxa' => 'UBMTTQ xã',
            'thamgiacactcctxh_hoichuthapdo_capxa' => 'Hội Chữ thập đỏ xã',
            'thamgiacactcctxh_hoinongdan_capxa' => 'Hội Nông dân xã',
            'thamgiacactcctxh_hoilienhiepphunu_capxa' => 'Đoàn thanh niên xã',
            'thamgiacactcctxh_doanthanhnien_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'thamgiacactcctxh_tochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
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
                'thamgiacactcctxh_hoidongnhandan_caphuyen' => true,
                'thamgiacactcctxh_uybanmttqvn_caphuyen' => true,
                'thamgiacactcctxh_hoichuthapdo_caphuyen' => true,
                'thamgiacactcctxh_hoinongdan_caphuyen' => true,
                'thamgiacactcctxh_hoilienhiepphunu_caphuyen' => true,
                'thamgiacactcctxh_doanthanhnien_caphuyen' => true,
                'thamgiacactcctxh_tochuckhac_caphuyen' => true
            )
        );
        $fields = array(
            'thamgiacactcctxh_hoidongnhandan_caphuyen' => 'HĐND huyện',
            'thamgiacactcctxh_uybanmttqvn_caphuyen' => 'UBMTTQ huyện',
            'thamgiacactcctxh_hoichuthapdo_caphuyen' => 'Hội Chữ thập đỏ huyện',
            'thamgiacactcctxh_hoinongdan_caphuyen' => 'Hội Nông dân huyện',
            'thamgiacactcctxh_doanthanhnien_caphuyen' => 'Hội Liên hiệp Thanh niên huyện',
            'thamgiacactcctxh_hoilienhiepphunu_caphuyen' => 'Hội Liên hiệp Phụ nữ huyện',
            'thamgiacactcctxh_tochuckhac_caphuyen' => 'Các tổ chức khác Cấp huyện'
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
                'thamgiacactcctxh_hoidongnhandan_captinh' => true,
                'thamgiacactcctxh_uybanmttqvn_captinh' => true,
                'thamgiacactcctxh_hoichuthapdo_captinh' => true,
                'thamgiacactcctxh_hoinongdan_captinh' => true,
                'thamgiacactcctxh_hoilienhiepphunu_captinh' => true,
                'thamgiacactcctxh_doanthanhnien_captinh' => true,
                'thamgiacactcctxh_tochuckhac_captinh' => true
            )
        );
        $fields = array(
            'thamgiacactcctxh_hoidongnhandan_captinh' => 'HĐND tỉnh',
            'thamgiacactcctxh_uybanmttqvn_captinh' => 'UBMTTQ tỉnh',
            'thamgiacactcctxh_hoichuthapdo_captinh' => 'Hội Chữ thập đỏ tỉnh',
            'thamgiacactcctxh_hoinongdan_captinh' => 'Hội Nông dân tỉnh',
            'thamgiacactcctxh_doanthanhnien_captinh' => 'Đoàn thanh niên tỉnh',
            'thamgiacactcctxh_hoilienhiepphunu_captinh' => 'Hội Liên hiệp Phụ nữ tỉnh',
            'thamgiacactcctxh_tochuckhac_captinh' => 'Các tổ chức khác Cấp tỉnh'
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
        $chucsaccaodai = $this->find('all', array(
            'fields' => array('hovaten', 'thanhdanh', 'thuoctochuc', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 'phamsac_ntn_cauphong_lesanh',
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'chucvuhiennay_phobancaiquan', 'chucvuhiennay_caiquan', 'chucvuhiennay_thanhvienbddct',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP XÃ
            'thamgiacactcctxh_hoidongnhandan_capxa', 
            'thamgiacactcctxh_uybanmttqvn_capxa', 
            'thamgiacactcctxh_hoichuthapdo_capxa', 
            'thamgiacactcctxh_hoinongdan_capxa', 
            'thamgiacactcctxh_hoilienhiepphunu_capxa', 
            'thamgiacactcctxh_doanthanhnien_capxa', 
            'thamgiacactcctxh_tochuckhac_capxa',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP HUYỆN
            'thamgiacactcctxh_hoidongnhandan_caphuyen', 
            'thamgiacactcctxh_uybanmttqvn_caphuyen', 
            'thamgiacactcctxh_hoichuthapdo_caphuyen',
            'thamgiacactcctxh_hoinongdan_caphuyen', 
            'thamgiacactcctxh_doanthanhnien_caphuyen', 
            'thamgiacactcctxh_hoilienhiepphunu_caphuyen',
            'thamgiacactcctxh_tochuckhac_caphuyen',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP TỈNH
            'thamgiacactcctxh_hoidongnhandan_captinh',
            'thamgiacactcctxh_uybanmttqvn_captinh',
            'thamgiacactcctxh_hoichuthapdo_captinh',
            'thamgiacactcctxh_hoinongdan_captinh',
            'thamgiacactcctxh_hoilienhiepphunu_captinh',
            'thamgiacactcctxh_doanthanhnien_captinh',
            'thamgiacactcctxh_tochuckhac_captinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        $chuc_sac_cao_dai = $cosotongiaodanghoatdong = array();
        foreach ($chucsaccaodai as $key => $value) {
            $value['Chucsaccaodai']['chucvu'] = '';
            if (!empty($value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'];
            } elseif (!empty($value['Chucsaccaodai']['chucvuhiennay_caiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_caiquan'];
            } else {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_thanhvienbddct'];
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsaccaodai']['hoatdongtongiaotai'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_so'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_ap'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_xa'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_huyen'],
                $value['Chucsaccaodai']['hoatdongtongiaotai_diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            foreach ($fields as $field => $text) {
                if ($value['Chucsaccaodai'][$field] == true) {
                    $chuc_sac_cao_dai[] = array(
                        'hovaten' => $value['Chucsaccaodai']['hovaten'],
                        'tengoitheotongiao' => $value['Chucsaccaodai']['thanhdanh'],
                        'thuoctochuctongiao' => $value['Chucsaccaodai']['thuoctochuc'],
                        'dantoc' => $value['Chucsaccaodai']['dantoc'],
                        'ngaythangnamsinh' => $value['Chucsaccaodai']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsaccaodai']['chungminhnhandan'],
                        'chucvu' => $value['Chucsaccaodai']['chucvu'],
                        'namduocphongchuc' => $value['Chucsaccaodai']['phamsac_ntn_cauphong_lesanh'],
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => $value['Chucsaccaodai']['trinhdohocvan_bangcap'],
                        'trinhdochuyenmon' => $value['Chucsaccaodai']['trinhdohocvan_bangcap'],
                        'trinhdotongiao' => '',
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Chucsaccaodai']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_cao_dai;
    }
    
    /**
     * DANH SÁCH TU SĨ CÁC TÔN GIÁO
     */
    public function getDataExcelDSTSCTG() {
        $chucsaccaodai = $this->find('all', array(
            'fields' => array('hovaten', 'thanhdanh', 'thuoctochuc', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //HỌC VẤN
            'trinhdohocvan_bangcap',
            //CHỨC VỤ
            'chucvuhiennay_phobancaiquan', 'chucvuhiennay_caiquan', 'chucvuhiennay_thanhvienbddct',
            //CSTG ĐANG HOẠT ĐỘNG
            'hoatdongtongiaotai', 'hoatdongtongiaotai_diachi_so', 'hoatdongtongiaotai_diachi_ap', 'hoatdongtongiaotai_diachi_xa', 'hoatdongtongiaotai_diachi_huyen', 'hoatdongtongiaotai_diachi_tinh',
            //CHỖ Ở HIỆN NAY
            'noiohiennay', 'noiohiennay_so', 'noiohiennay_duong', 'noiohiennay_ap', 'noiohiennay_xa', 'noiohiennay_huyen', 'noiohiennay_tinh',
            'is_add'
            ),
            'conditions' => array(
                'hovaten <>' => '',
                'is_add' => 1
            )
        ));
        $chuc_sac_cao_dai = $cosotongiaodanghoatdong = array();
        foreach ($chucsaccaodai as $key => $value) {
            $value['Chucsaccaodai']['chucvu'] = '';
            if (!empty($value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_phobancaiquan'];
            } elseif (!empty($value['Chucsaccaodai']['chucvuhiennay_caiquan'])) {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_caiquan'];
            } else {
                $value['Chucsaccaodai']['chucvu'] = $value['Chucsaccaodai']['chucvuhiennay_thanhvienbddct'];
            }
            $choohiennay = array(
                $value['Chucsaccaodai']['noiohiennay'],
                $value['Chucsaccaodai']['noiohiennay_so'],
                $value['Chucsaccaodai']['noiohiennay_duong'],
                $value['Chucsaccaodai']['noiohiennay_ap'],
                $value['Chucsaccaodai']['noiohiennay_xa'],
                $value['Chucsaccaodai']['noiohiennay_huyen'],
                $value['Chucsaccaodai']['noiohiennay_tinh']
            );
            $choohiennay = array_filter($choohiennay, 'strlen');
            $chuc_sac_cao_dai[] = array(
                'hovaten' => $value['Chucsaccaodai']['hovaten'],
                'tengoitheotongiao' => $value['Chucsaccaodai']['thanhdanh'],
                'thuoctochuctongiao' => $value['Chucsaccaodai']['thuoctochuc'],
                'ngaythangnamsinh' => $value['Chucsaccaodai']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsaccaodai']['chungminhnhandan'],
                'chucvu' => $value['Chucsaccaodai']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => $value['Chucsaccaodai']['trinhdohocvan_bangcap'],
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsaccaodai']['noisinh'],
                'choohiennay' => implode(",\n", $choohiennay)
            );
        }
        
        return $chuc_sac_cao_dai;
    }
}