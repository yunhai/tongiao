<?php
App::uses('AppModel', 'Model');
/**
 * Chucsacnhatuhanhcongiaodongtu Model
 *
 */
class Chucsacnhatuhanhcongiaodongtu extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'chucsacnhatuhanhcongiaodongtu';
	
	public function getDataExcelDSCSDTBD() {
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = array();
        $chucsacnhatuhanhcongiaodongtu = $this->find('all', array(
            'fields' => array('hovaten', 'tructhuocdongtu', 'ngaythangnamsinh', 'chungminhnhandan', //'phamsactrongtongiao', 
            //CHỨC VỤ
            'hoatdongtongiao_betrendong', 'hoatdongtongiao_betrentinhdong', 'hoatdongtongiao_betrenmiendong', 
            'hoatdongtongiao_betrencongdoan', 'hoatdongtongiao_thanhvienbantuvantgmxl', 'hoatdongtongiao_thanhvienhoidonglinhmuc', 'hoatdongtongiao_linhhuongcuahoidoan',
            'daquacaclopdaotaoboiduongvetongiaotrongnuoc', 'daquacaclopdaotaoboiduongvetongiaoonuocngoai',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosodanghoatdongtongiao', 'tenquocte', 'diachi_so', 'diachi_ap', 'diachi_xa', 'diachi_huyen', 'diachi_tinh',
            'is_add'
            ),
            'conditions' => array(
                'Chucsacnhatuhanhcongiaodongtu.is_add' => 1,
                'OR' => array(
                    'Chucsacnhatuhanhcongiaodongtu.daquacaclopdaotaoboiduongvetongiaotrongnuoc <>' => '',
                    'Chucsacnhatuhanhcongiaodongtu.daquacaclopdaotaoboiduongvetongiaoonuocngoai <>' => ''
                )
            )
        ));
        foreach ($chucsacnhatuhanhcongiaodongtu as $key => $value) {
            $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrentinhdong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên tỉnh dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrenmiendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên miền dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrencongdoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Cộng đoàn (Tu viện, đan viện)';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienbantuvantgmxl'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Ban tư vấn TGMXL';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienhoidonglinhmuc'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Hội đồng Linh mục';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_linhhuongcuahoidoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Linh hướng của hội đoàn';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhcongiaodongtu']['tencosodanghoatdongtongiao'],
                $value['Chucsacnhatuhanhcongiaodongtu']['tenquocte'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_so'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_ap'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_xa'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $daquacaclopdaotaoboiduongvetongiaotrongnuoc = explode(';', $value['Chucsacnhatuhanhcongiaodongtu']['daquacaclopdaotaoboiduongvetongiaotrongnuoc']);
            $daquacaclopdaotaoboiduongvetongiaoonuocngoai = explode(';', $value['Chucsacnhatuhanhcongiaodongtu']['daquacaclopdaotaoboiduongvetongiaoonuocngoai']);
            $trongnuoc_chitiet = array();
            foreach ($daquacaclopdaotaoboiduongvetongiaotrongnuoc as $key_dt_bd_trongnuoc => $value_dt_bd_trongnuoc) {
                $dt_bd_trongnuoc = explode('______,',$value_dt_bd_trongnuoc);
                $trongnuoc = $this->khoaHoc($dt_bd_trongnuoc);
                if ((isset($trongnuoc['tu']) && !empty($trongnuoc['tu'])) || (isset($trongnuoc['tuhoc']) && !empty($trongnuoc['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_con_giao_dong_tu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhcongiaodongtu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => $value['Chucsacnhatuhanhcongiaodongtu']['tructhuocdongtu'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhcongiaodongtu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhcongiaodongtu']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'],
                        'nam_dt_bd' => isset($trongnuoc['tu']) ? $trongnuoc['tu']: '',
                        'tenkhoa_dt_bd' => isset($trongnuoc['tuhoc']) ? $trongnuoc['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhcongiaodongtu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(',', $cosotongiaodanghoatdong)
                    );
                }
            }
            foreach ($daquacaclopdaotaoboiduongvetongiaoonuocngoai as $key_dt_bd_nuocngoai => $value_dt_bd_nuocngoai) {
                $dt_bd_nuocngoai = explode('______,',$value_dt_bd_nuocngoai);
                $nuocngoai = $this->khoaHoc($dt_bd_nuocngoai);
                if ((isset($nuocngoai['tu']) && !empty($nuocngoai['tu'])) || (isset($nuocngoai['tuhoc']) && !empty($nuocngoai['tuhoc']))) {
                    $chuc_sac_nha_tu_hanh_con_giao_dong_tu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhcongiaodongtu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => $value['Chucsacnhatuhanhcongiaodongtu']['tructhuocdongtu'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhcongiaodongtu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhcongiaodongtu']['chungminhnhandan'],
                        'phamsac' => '',
                        'chucvu' => $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'],
                        'nam_dt_bd' => isset($nuocngoai['tu']) ? $nuocngoai['tu']: '',
                        'tenkhoa_dt_bd' => isset($nuocngoai['tuhoc']) ? $nuocngoai['tuhoc'] : '',
                        'quequan' => $value['Chucsacnhatuhanhcongiaodongtu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_nha_tu_hanh_con_giao_dong_tu;
	}
	
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhConGiaoDongTuKhongCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'hoatdongtongiao_betrendong' => false,
            'hoatdongtongiao_betrentinhdong' => false,
            'hoatdongtongiao_betrenmiendong' => false,
            'hoatdongtongiao_betrencongdoan' => false,
            'hoatdongtongiao_thanhvienbantuvantgmxl' => false,
            'hoatdongtongiao_thanhvienhoidonglinhmuc' => false,
            'hoatdongtongiao_linhhuongcuahoidoan' => false
        );
        $data = $this->getDataExcelChucSacNhaTuHanhConGiaoDongTu24($conditions);
        return $data;
    }
    
    /**
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhConGiaoDongTuCoChuVu() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'hoatdongtongiao_betrendong' => false,
                'hoatdongtongiao_betrentinhdong' => false,
                'hoatdongtongiao_betrenmiendong' => false,
                'hoatdongtongiao_betrencongdoan' => false,
                'hoatdongtongiao_thanhvienbantuvantgmxl' => false,
                'hoatdongtongiao_thanhvienhoidonglinhmuc' => false,
                'hoatdongtongiao_linhhuongcuahoidoan' => false
            )
        );
        $data = $this->getDataExcelChucSacNhaTuHanhConGiaoDongTu24($conditions);
        return $data;
    }
	
    /**
     * Lay du lieu cho 2 file excel:
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     * - DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    public function getDataExcelChucSacNhaTuHanhConGiaoDongTu24($conditions) {
        $chucsacnhatuhanhcongiaodongtu = $this->find('all', array(
            'fields' => array('hovaten', 'tructhuocdongtu', 'ngaythangnamsinh', 'chungminhnhandan', //'phamsactrongtongiao', 
            //CHỨC VỤ
            'hoatdongtongiao_betrendong', 'hoatdongtongiao_betrentinhdong', 'hoatdongtongiao_betrenmiendong', 
            'hoatdongtongiao_betrencongdoan', 'hoatdongtongiao_thanhvienbantuvantgmxl', 'hoatdongtongiao_thanhvienhoidonglinhmuc', 'hoatdongtongiao_linhhuongcuahoidoan',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosodanghoatdongtongiao', 'tenquocte', 'diachi_so', 'diachi_ap', 'diachi_xa', 'diachi_huyen', 'diachi_tinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = array();
        foreach ($chucsacnhatuhanhcongiaodongtu as $key => $value) {
            $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrentinhdong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên tỉnh dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrenmiendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên miền dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrencongdoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Cộng đoàn (Tu viện, đan viện)';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienbantuvantgmxl'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Ban tư vấn TGMXL';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienhoidonglinhmuc'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Hội đồng Linh mục';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_linhhuongcuahoidoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Linh hướng của hội đoàn';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhcongiaodongtu']['tencosodanghoatdongtongiao'],
                $value['Chucsacnhatuhanhcongiaodongtu']['tenquocte'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_so'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_ap'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_xa'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu[] = array(
                'hovaten' => $value['Chucsacnhatuhanhcongiaodongtu']['hovaten'],
                'tengoitheotongiao' => '',
                'thuoctochuctongiao' => $value['Chucsacnhatuhanhcongiaodongtu']['tructhuocdongtu'],
                'ngaythangnamsinh' => $value['Chucsacnhatuhanhcongiaodongtu']['ngaythangnamsinh'],
                'gioitinh' => '',
                'chungminhnhandan' => $value['Chucsacnhatuhanhcongiaodongtu']['chungminhnhandan'],
                'chucvu' => $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'],
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => '',
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsacnhatuhanhcongiaodongtu']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_con_giao_dong_tu;
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
        $data = $this->getDataExcelDSCSTHAMGIACTXH($conditions);
        return $data;
    }
    
    /**
     * Lay du lieu cho file excel:
     * - DS CS THAM GIA CT-XH CAP XA
     */
    public function getDataExcelDSCSTHAMGIACTXH($conditions) {
        $chucsacnhatuhanhcongiaodongtu = $this->find('all', array(
            'fields' => array('hovaten', 'tructhuocdongtu', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', //'phamsactrongtongiao', 
            //CHỨC VỤ
            'hoatdongtongiao_betrendong', 'hoatdongtongiao_betrentinhdong', 'hoatdongtongiao_betrenmiendong', 
            'hoatdongtongiao_betrencongdoan', 'hoatdongtongiao_thanhvienbantuvantgmxl', 'hoatdongtongiao_thanhvienhoidonglinhmuc', 'hoatdongtongiao_linhhuongcuahoidoan',
            'noisinh',
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosodanghoatdongtongiao', 'tenquocte', 'diachi_so', 'diachi_ap', 'diachi_xa', 'diachi_huyen', 'diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI
            'hoatdongtongiao_thamgia_hoidongnhandan_capxa', 'hoatdongtongiao_thamgia_ubmttqvn_capxa', 'hoatdongtongiao_thamgia_hoichuthapdo_capxa', 'hoatdongtongiao_thamgia_hoinongdan_capxa', 'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa', 'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa', 'hoatdongtongiao_thamgia_cactochuckhac_capxa',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        $fields = array(
            'hoatdongtongiao_thamgia_hoidongnhandan_capxa' => 'HĐND xã',
            'hoatdongtongiao_thamgia_ubmttqvn_capxa' => 'UBMTTQ xã',
            'hoatdongtongiao_thamgia_hoichuthapdo_capxa' => 'Hội Chữ thập đỏ',
            'hoatdongtongiao_thamgia_hoinongdan_capxa' => 'Hội Nông dân xã',
            'hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'hoatdongtongiao_thamgia_hoilienhiepphunu_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'hoatdongtongiao_thamgia_cactochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
        );
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = array();
        foreach ($chucsacnhatuhanhcongiaodongtu as $key => $value) {
            $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = '';
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrentinhdong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên tỉnh dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrenmiendong'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên miền dòng';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_betrencongdoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Bề trên Cộng đoàn (Tu viện, đan viện)';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienbantuvantgmxl'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Ban tư vấn TGMXL';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_thanhvienhoidonglinhmuc'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Thành viên Hội đồng Linh mục';
            }
            if ($value['Chucsacnhatuhanhcongiaodongtu']['hoatdongtongiao_linhhuongcuahoidoan'] == true) {
                $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'] = 'Linh hướng của hội đoàn';
            }
            $cosotongiaodanghoatdong = array(
                $value['Chucsacnhatuhanhcongiaodongtu']['tencosodanghoatdongtongiao'],
                $value['Chucsacnhatuhanhcongiaodongtu']['tenquocte'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_so'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_ap'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_xa'],
                $value['Chucsacnhatuhanhcongiaodongtu']['diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            foreach ($fields as $field => $text) {
                if ($value['Chucsacnhatuhanhcongiaodongtu'][$field] == true) {
                    $chuc_sac_nha_tu_hanh_cong_giao_trieu[] = array(
                        'hovaten' => $value['Chucsacnhatuhanhcongiaodongtu']['hovaten'],
                        'tengoitheotongiao' => '',
                        'thuoctochuctongiao' => '',
                        'dantoc' => $value['Chucsacnhatuhanhcongiaodongtu']['dantoc'],
                        'ngaythangnamsinh' => $value['Chucsacnhatuhanhcongiaodongtu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Chucsacnhatuhanhcongiaodongtu']['chungminhnhandan'],
                        'chucvu' => $value['Chucsacnhatuhanhcongiaodongtu']['chucvu'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => '',
                        'trinhdochuyenmon' => '',
                        'trinhdotongiao' => '',
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Chucsacnhatuhanhcongiaodongtu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $chuc_sac_nha_tu_hanh_con_giao_dong_tu;
    }
}