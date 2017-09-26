<?php
App::uses('DataController', 'Controller');


class ExportsController extends DataController {

    public $components = array('Excel', 'Utility');
    
    public function index() {
        $header = array(
            'I. CƠ SỞ TÔN GIÁO',
            'II. CHỨC SẮC TÔN GIÁO'
        );
        $arrayButtonLable1 = array(
            '1' => 'TỔNG HỢP ĐẤT ĐAI',
            '2' => 'TH TÔN GIÁO CƠ SỞ',
            '3' => 'TH CƠ SỞ TÔN GIÁO',
            '4' => 'TỔNG HỢP DI TÍCH',
            '5' => 'TỔNG HỢP CSTT XÂY DỰNG',
            '6' => 'TỔNG HỢP CSTG TRÙNG TU',
            '7' => 'BẢNG TỔNG HỢP TÍN ĐỒ',
            '8' => 'DANH SÁCH CƠ SỞ THỜ TỰ',
            '9' => 'DSCS BẢO TRỢ XÃ HỘI'
        );
        
        $arrayButtonLable2 = array(
            'DS CS THAM GIA CT-XH' => 'DS CS THAM GIA CT-XH',
            'TH CS THAM GIA CT-XH' => 'TH CS THAM GIA CT-XH',
            'DS CS ĐT-BD' => 'DS CS ĐT-BD',
            'DS CS XUAT NHAP CANH' => 'DS CS XUAT NHAP CANH',
            'BANG TONG HOP TIN DO' => 'BANG TONG HOP TIN DO',
            'TH CS XUAT NHAP CANH' => 'TH CS XUAT NHAP CANH',
            'DS THUYEN CHUYEN' => 'DS THUYEN CHUYEN',
            'TH THUYEN CHUYEN' => 'TH THUYEN CHUYEN',
            'THBNCS' => 'THBNCS',
            'DS CHUC SAC PCPP' => 'DS CHUC SAC PCPP',
            'TH CHUC SAC PCPP' => 'TH CHUC SAC PCPP',
            'TH TRINH DO TON GIAO' => 'TH TRINH DO TON GIAO',
            'TH TRINH DO VH' => 'TH TRINH DO VH',
            'DANH SACH TU SI' => 'DANH SACH TU SI',
            'DANH SACH CHUC SAC' => 'DANH SACH CHUC SAC',
            'TONG HOP CHUC VIEC' => 'TONG HOP CHUC VIEC',
            'TONG HOP TU SI' => 'TONG HOP TU SI',
            'TONG HOP CHUC SAC' => 'TONG HOP CHUC SAC'
        );

        $result = array(
            'title_for_layout' => 'TỔNG HỢP',
            'header' => $header,
            'arrayButtonLable1' => $arrayButtonLable1,
            'arrayButtonLable2' => $arrayButtonLable2
        );
        $this->set($result);
    }

}