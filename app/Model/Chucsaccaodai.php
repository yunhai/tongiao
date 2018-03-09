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
            'fields' => array('hovaten', 'thanhdanh', 'thuoctochuc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
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
                'namduocphongchuc' => '',
                'phamtrat' => '',
                'namduocphongpham' => '',
                'trinhdohocvan' => '',
                'trinhdochuyenmon' => '',
                'trinhdotongiao' => '',
                'quequan' => $value['Chucsaccaodai']['noisinh'],
                'cosotongiaodanghoatdong' => implode(',', $cosotongiaodanghoatdong)
            );
        }
        
        return $chuc_sac_cao_dai;
    }
}