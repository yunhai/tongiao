<?php
App::uses('AppModel', 'Model');
/**
 * Nguoihoatdongtinnguongchuyennghiep Model
 *
 */
class Nguoihoatdongtinnguongchuyennghiep extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'nguoihoatdongtinnguongchuyennghiep';

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
                'hoinongdan_capxa' => true,
                'hoichuthapdo_capxa' => true,
                'hoilienhiepthanhnien_capxa' => true,
                'hoilienhiepphunu_capxa' => true,
                'cactochuckhac_capxa' => true
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
        $nguoihoatdongtinnguongchuyennghiep = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotinnguong', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvu',
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosotinnguongdanghoatdong',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI
            'hoidongnhandan_capxa', 'ubmttqvn_capxa', 'hoinongdan_capxa', 'hoichuthapdo_capxa', 'hoilienhiepthanhnien_capxa', 'hoilienhiepphunu_capxa', 'cactochuckhac_capxa', 
            'is_add'
            ),
            'conditions' => $conditions
        ));
        $fields = array(
            'hoidongnhandan_capxa' => 'HĐND xã',
            'ubmttqvn_capxa' => 'UBMTTQ xã',
            'hoinongdan_capxa' => 'Hội Chữ thập đỏ',
            'hoichuthapdo_capxa' => 'Hội Nông dân xã',
            'hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'hoilienhiepphunu_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'cactochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
        );
        $nguoi_hoat_dong_tin_nguong_chuyen_nghiep = array();
        foreach ($nguoihoatdongtinnguongchuyennghiep as $key => $value) {
            foreach ($fields as $field => $text) {
                if ($value['Nguoihoatdongtinnguongchuyennghiep'][$field] == true) {
                    $nguoi_hoat_dong_tin_nguong_chuyen_nghiep[] = array(
                        'hovaten' => $value['Nguoihoatdongtinnguongchuyennghiep']['hovaten'],
                        'tengoitheotongiao' => $value['Nguoihoatdongtinnguongchuyennghiep']['tengoitheotinnguong'],
                        'thuoctochuctongiao' => $value['Nguoihoatdongtinnguongchuyennghiep']['tencosotinnguongdanghoatdong'],
                        'dantoc' => $value['Nguoihoatdongtinnguongchuyennghiep']['dantoc'],
                        'ngaythangnamsinh' => $value['Nguoihoatdongtinnguongchuyennghiep']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Nguoihoatdongtinnguongchuyennghiep']['chungminhnhandan'],
                        'chucvu' => $value['Nguoihoatdongtinnguongchuyennghiep']['chucvu'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => '',
                        'trinhdochuyenmon' => '',
                        'trinhdotongiao' => '',
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Nguoihoatdongtinnguongchuyennghiep']['noisinh'],
                        'cosotongiaodanghoatdong' => $value['Nguoihoatdongtinnguongchuyennghiep']['tencosotinnguongdanghoatdong']
                    );
                }
            }
        }
        
        return $nguoi_hoat_dong_tin_nguong_chuyen_nghiep;
    }
}
