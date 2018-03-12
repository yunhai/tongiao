<?php
App::uses('AppModel', 'Model');
/**
 * Huynhtruonggiadinhphattu Model
 *
 */
class Huynhtruonggiadinhphattu extends AppModel {

/**
 * Use table
 *
 * @var mixed False or table name
 */
	public $useTable = 'huynhtruonggiadinhphattu';

    /**
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ
     */
    public function getDataExcelDSCSTHAMGIACTXHCAPXA() {
        $conditions = array(
            'hovaten <>' => '',
            'is_add' => 1,
            'OR' => array(
                'thamgia_hoidongnhandan_capxa' => true,
                'thamgia_ubmttqvn_capxa' => true,
                'thamgia_hoinongdan_capxa' => true,
                'thamgia_hoichuthapdo_capxa' => true,
                'thamgia_hoilienhiepthanhnien_capxa' => true,
                'thamgia_hoilienhiepphunu_capxa' => true,
                'thamgia_cactochuckhac_capxa' => true
            )
        );
        $fields = array(
            'thamgia_hoidongnhandan_capxa' => 'HĐND xã',
            'thamgia_ubmttqvn_capxa' => 'UBMTTQ xã',
            'thamgia_hoinongdan_capxa' => 'Hội Chữ thập đỏ xã',
            'thamgia_hoichuthapdo_capxa' => 'Hội Nông dân xã',
            'thamgia_hoilienhiepphunu_capxa' => 'Hội Liên hiệp Thanh niên xã',
            'thamgia_hoilienhiepthanhnien_capxa' => 'Hội Liên hiệp Phụ nữ xã',
            'thamgia_cactochuckhac_capxa' => 'Các tổ chức khác Cấp xã'
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
                'thamgia_hoidongnhandan_caphuyen' => true,
                'thamgia_ubmttqvn_caphuyen' => true,
                'thamgia_hoinongdan_caphuyen' => true,
                'thamgia_hoichuthapdo_caphuyen' => true,
                'thamgia_hoilienhiepthanhnien_caphuyen' => true,
                'thamgia_hoilienhiepphunu_caphuyen' => true,
                'thamgia_cactochuckhac_caphuyen' => true
            )
        );
        $fields = array(
            'thamgia_hoidongnhandan_caphuyen' => 'HĐND huyện',
            'thamgia_ubmttqvn_caphuyen' => 'UBMTTQ huyện',
            'thamgia_hoichuthapdo_caphuyen' => 'Hội Chữ thập đỏ huyện',
            'thamgia_hoinongdan_caphuyen' => 'Hội Nông dân huyện',
            'thamgia_hoilienhiepthanhnien_caphuyen' => 'Hội Liên hiệp Thanh niên huyện',
            'thamgia_hoilienhiepphunu_caphuyen' => 'Hội Liên hiệp Phụ nữ huyện',
            'thamgia_cactochuckhac_caphuyen' => 'Các tổ chức khác Cấp huyện'
        );
        $data = $this->getDataExcelDSCSTHAMGIACTXH($conditions, $fields);
        return $data;
    }
    
    /**
     * Lay du lieu cho file excel:
     * - DS CS THAM GIA CT-XH CAP XA
     * - DS CS THAM GIA CT-XH CAP HUYEN
     */
    public function getDataExcelDSCSTHAMGIACTXH($conditions, $fields) {
        $huynhtruonggiadinhphattu = $this->find('all', array(
            'fields' => array('hovaten', 'phapdanh', 'dantoc', 'ngaythangnamsinh', 'chungminhnhandan', 
            'noisinh', 
            //CHỨC VỤ
            'chucvutrongdaohiennay',
            //CSTG ĐANG HOẠT ĐỘNG
            'dangsinhhoattaigdpt', 'thuoctuvien', 'diachi_so', 'diachi_ap', 'diachi_xa', 'diachi_huyen', 'diachi_tinh',
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI XÃ
            'thamgia_hoidongnhandan_capxa', 
            'thamgia_ubmttqvn_capxa', 
            'thamgia_hoinongdan_capxa', 
            'thamgia_hoichuthapdo_capxa', 
            'thamgia_hoilienhiepthanhnien_capxa', 
            'thamgia_hoilienhiepphunu_capxa', 
            'thamgia_cactochuckhac_capxa', 
            //THAM GIA TỔ CHỨC CHÍNH TRỊ XÃ HỘI HUYỆN
            'thamgia_hoidongnhandan_caphuyen',
            'thamgia_ubmttqvn_caphuyen',
            'thamgia_hoinongdan_caphuyen',
            'thamgia_hoichuthapdo_caphuyen',
            'thamgia_hoilienhiepthanhnien_caphuyen',
            'thamgia_hoilienhiepphunu_caphuyen',
            'thamgia_cactochuckhac_caphuyen',
            'is_add'
            ),
            'conditions' => $conditions
        ));
        $huynh_truong_gia_dinh_phat_tu = $cosotongiaodanghoatdong = array();
        foreach ($huynhtruonggiadinhphattu as $key => $value) {
            $cosotongiaodanghoatdong = array(
                $value['Huynhtruonggiadinhphattu']['dangsinhhoattaigdpt'],
                $value['Huynhtruonggiadinhphattu']['diachi_so'],
                $value['Huynhtruonggiadinhphattu']['diachi_ap'],
                $value['Huynhtruonggiadinhphattu']['diachi_xa'],
                $value['Huynhtruonggiadinhphattu']['diachi_huyen'],
                $value['Huynhtruonggiadinhphattu']['diachi_tinh']
            );
            $cosotongiaodanghoatdong = array_filter($cosotongiaodanghoatdong, 'strlen');
            foreach ($fields as $field => $text) {
                if ($value['Huynhtruonggiadinhphattu'][$field] == true) {
                    $huynh_truong_gia_dinh_phat_tu[] = array(
                        'hovaten' => $value['Huynhtruonggiadinhphattu']['hovaten'],
                        'tengoitheotongiao' => $value['Huynhtruonggiadinhphattu']['phapdanh'],
                        'thuoctochuctongiao' => $value['Huynhtruonggiadinhphattu']['thuoctuvien'],
                        'dantoc' => $value['Huynhtruonggiadinhphattu']['dantoc'],
                        'ngaythangnamsinh' => $value['Huynhtruonggiadinhphattu']['ngaythangnamsinh'],
                        'gioitinh' => '',
                        'chungminhnhandan' => $value['Huynhtruonggiadinhphattu']['chungminhnhandan'],
                        'chucvu' => $value['Huynhtruonggiadinhphattu']['chucvutrongdaohiennay'],
                        'namduocphongchuc' => '',
                        'phamtrat' => '',
                        'namduocphongpham' => '',
                        'trinhdohocvan' => '',
                        'trinhdochuyenmon' => '',
                        'trinhdotongiao' => '',
                        'thamgiatochucchinhtrixahoi' => $text,
                        'quequan' => $value['Huynhtruonggiadinhphattu']['noisinh'],
                        'cosotongiaodanghoatdong' => implode(",\n", $cosotongiaodanghoatdong)
                    );
                }
            }
        }
        
        return $huynh_truong_gia_dinh_phat_tu;
    }
}
