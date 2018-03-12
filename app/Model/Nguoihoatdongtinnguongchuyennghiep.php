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
        $fields = array(
            'hoidongnhandan_capxa' => 'HĐND xã',
            'ubmttqvn_capxa' => 'UBMTTQ xã',
            'hoinongdan_capxa' => 'Hội Chữ thập đỏ xã',
            'hoichuthapdo_capxa' => 'Hội Nông dân xã',
            'hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'hoilienhiepphunu_capxa' => 'Hội Liên hiệp Thanh niên xã',
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
                'ubmttqvn_caphuyen' => true,
                'hoinongdan_caphuyen' => true,
                'hoichuthapdo_caphuyen' => true,
                'hoilienhiepthanhnien_caphuyen' => true,
                'hoilienhiepphunu_caphuyen' => true,
                'cactochuckhac_caphuyen' => true
            )
        );
        $fields = array(
            'hoidongnhandan_caphuyen' => 'HĐND huyện',
            'ubmttqvn_caphuyen' => 'UBMTTQ huyện',
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
                'ubmttqvn_captinh' => true,
                'hoinongdan_captinh' => true,
                'hoichuthapdo_captinh' => true,
                'hoilienhiepthanhnien_captinh' => true,
                'hoilienhiepphunu_captinh' => true,
                'cactochuckhac_captinh' => true
            )
        );
        $fields = array(
            'hoidongnhandan_captinh' => 'HĐND tỉnh',
            'ubmttqvn_captinh' => 'UBMTTQ tỉnh',
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
        $nguoihoatdongtinnguongchuyennghiep = $this->find('all', array(
            'fields' => array('hovaten', 'tengoitheotinnguong', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvu',
            //CSTG ĐANG HOẠT ĐỘNG
            'tencosotinnguongdanghoatdong',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP XÃ
            'hoidongnhandan_capxa', 
            'ubmttqvn_capxa', 
            'hoinongdan_capxa', 
            'hoichuthapdo_capxa', 
            'hoilienhiepthanhnien_capxa', 
            'hoilienhiepphunu_capxa', 
            'cactochuckhac_capxa', 
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP HUYỆN
            'hoidongnhandan_caphuyen',
            'ubmttqvn_caphuyen',
            'hoinongdan_caphuyen',
            'hoichuthapdo_caphuyen',
            'hoilienhiepthanhnien_caphuyen',
            'hoilienhiepphunu_caphuyen',
            'cactochuckhac_caphuyen',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI CẤP TỈNH
            'hoidongnhandan_captinh',
            'ubmttqvn_captinh',
            'hoinongdan_captinh',
            'hoichuthapdo_captinh',
            'hoilienhiepthanhnien_captinh',
            'hoilienhiepphunu_captinh',
            'cactochuckhac_captinh',
            'is_add'
            ),
            'conditions' => $conditions
        ));
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
