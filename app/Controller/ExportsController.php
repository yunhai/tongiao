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
            '0' => 'TH TÔN GIÁO CƠ SỞ',
            'TH CO SO TON GIAO' => 'TH CO SO TON GIAO',
            'TONG HOP DI TICH' => 'TONG HOP DI TICH',
            'TONG HOP CSTT XAY DUNG' => 'TONG HOP CSTT XAY DUNG',
            'TONG HOP CSTG TRUNG TU' => 'TONG HOP CSTG TRUNG TU',
            'BANG TONG HOP TIN DO' => 'BANG TONG HOP TIN DO',
            'ds cstt' => 'ds cstt',
            'DSCS BAO TRO XA HOI' => 'DSCS BAO TRO XA HOI'
        );

        $result = array(
            'title_for_layout' => 'TỔNG HỢP',
            'header' => $header,
            'arrayButtonLable1' => $arrayButtonLable1
        );
        $this->set($result);
    }

}