<?php
App::uses('DataController', 'Controller');
/**
 * Huynhtruonggiadinhphattus Controller
 *
 * @property Huynhtruonggiadinhphattus $Huynhtruonggiadinhphattus
 * @property PaginatorComponent $Paginator
 */
class HuynhtruonggiadinhphattusController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Huynhtruonggiadinhphattu");
    public $helpers = array('CustomPaginator');
    public $nameTable = "huynhtruonggiadinhphattu"; //name table 
    public $model = "Huynhtruonggiadinhphattu";
    public $controller = "Huynhtruonggiadinhphattus";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên (thế danh)" => "hovaten",
        "Pháp danh (khi quy y do Bổn sư đặt)" => "phapdanh",
        "Số điện thoại cá nhân" => "sodienthoai",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich",
    );
    public $title_for_layout = "Huynh trưởng gia đình phật tử";
    
    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ Thần học" => "trinhdothanhoc",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Anh chị em ruột" => "anhchiemruot",
            "Anh chị em vợ (chồng)" => "anhchiemvochong",
            "Vợ (chồng) và con" => "vochongvacon",
            "Quá trình hoạt động tôn giáo ở trong nước" => "quatrinhhoatdongtongiaootrongnuoc",
            "Quá trình hoạt động tôn giáo ở nước ngoài (nếu có)" => "quatrinhhoatdongtongiaoonuocngoaineuco",
        );
        
        $this->result_table = $this->huynhTruongGiaDinhPhatTu();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
