<?php
App::uses('DataController', 'Controller');


class ExportsController extends DataController {

    public $components = array('Excel', 'Utility');
    
    public function index() {
        $header = array(
            'a' => ' CƠ SỞ TÔN GIÁO',
            'b' => ' CHỨC SẮC TÔN GIÁO'
        );
        $arrayButtonLable1 = array(
            '1' => 'BẢNG TỔNG HỢP THỐNG KÊ ĐẤT CÁC TỔ CHỨC TÔN GIÁO VÀ CƠ SỞ TÍN NGƯỠNG ĐANG QUẢN LÝ VÀ SỬ DỤNG',
            '2' => 'THỐNG KÊ TỔ CHỨC TÔN GIÁO CƠ SỞ TRÊN ĐỊA BÀN TỈNH',
            '3' => 'TỔNG HỢP CƠ SỞ TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH',//TH CO SO TON GIAO
            '4' => 'TỔNG HỢP CƠ SỞ TÔN GIÁO, TÍN NGƯỠNG ĐƯỢC XẾP HẠNG DI TÍCH TRÊN ĐỊA BÀN TỈNH',//TONG HOP DI TICH
            //'5' => 'TỔNG HỢP  CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG ĐƯỢC XÂY DỰNG MỚI',//TONG HOP CSTT XAY DUNG
            '6' => 'TỔNG HỢP CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG ĐÃ ĐƯỢC TRÙNG TU, TÔN TẠO',//TONG HOP CSTG TRUNG TU
            '7' => 'BẢNG TỔNG HỢP TÍN ĐỒ CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH',// BANG TONG HOP TIN DO
            '8' => 'DANH SÁCH CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH',//ds cstt
            '9' => 'DANH SÁCH CƠ SỞ HOẠT ĐỘNG XÃ HỘI CỦA CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH'//DSCS BAO TRO XA HOI
        );
        
        $arrayButtonLable2 = array(
            '11' => 'DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ',//DS CS THAM GIA CT-XH CAP XA
            '12' => 'DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP HUYỆN',//DS CS THAM GIA CT-XH CAP HUYEN
            '13' => 'DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP TỈNH',//DS CS THAM GIA CT-XH CAP TINH
            '14' => 'TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ',//TH CS THAM GIA CT-XH CAP XA
            '15' => 'TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP HUYỆN',//TH CS THAM GIA CT-XH CAP HUYEN
            '16' => 'TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP TỈNH',//TH CS THAM GIA CT-XHCAP TINH
            '17' => 'DANH SÁCH CHỨC SẮC ĐÃ THAM GIA CÁC LỚP ĐÀO TẠO, BỒI DƯỠNG TÔN GIÁO',//DS CS ĐT-BD
            '18' => 'TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO ĐƯỢC BỔ NHIỆM, CHUẨN Y',//THBNCS
            '19' => 'DANH SÁCH CHỨC SẮC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM',//DS CHUC SAC PCPP
            '20' => 'TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM',//TH CHUC SAC PCPP
            '21' => 'TỔNG HỢP TRÌNH ĐỘ TÔN GIÁO CỦA CHỨC SẮC CÁC TÔN GIÁO',//TH TRINH DO TON GIAO
            '22' => 'TỔNG HỢP TRÌNH ĐỘ VĂN HÓA CỦA CHỨC SẮC CÁC TÔN GIÁO',//TH TRINH DO VH
            '23' => 'DANH SÁCH TU SĨ CÁC TÔN GIÁO',//DANH SACH TU SI
            '24' => 'DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)',//DS CHUC SAC KO CO CHUC VU
            '25' => 'DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)',//DS CHUC SAC CO CHUC VU
            '26' => 'BẢNG TỔNG HỢP CHỨC VIỆC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH',//TONG HOP CHUC VIEC
            '27' => 'BẢNG TỔNG HỢP TU SĨ CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH',//TONG HOP TU SI
            '28' => 'BẢNG TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH (KHÔNG CÓ CHỨC VỤ)',//TONG HOP CHUC SAC KO CHUC VU
            '29' => 'BẢNG TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH (CÓ CHỨC VỤ)',//TONG HOP CHUC SAC CO CHUC VU
            '30' => 'BẢNG TỔNG HỢP LỨA TUỔI CỦA CHỨC SẮC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH',//DO TUOI CUA CHAC SAC
            //'31' => 'BẢNG TỔNG HỢP LỨA TUỔI CỦA TU SĨ CÁC TÔN GIÁO'//DO TUOI CUA TU SĨ
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