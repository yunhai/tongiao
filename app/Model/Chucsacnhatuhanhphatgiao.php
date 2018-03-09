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
                'trinhdohocvan' => '',
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsacnhatuhanhphatgiao']['noisinh'],
                'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_nha_tu_hanh_phat_giao;
    }
}