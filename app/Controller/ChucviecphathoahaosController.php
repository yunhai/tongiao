<?php
App::uses('DataController', 'Controller');
/**
 * Chucviecphathoahaos Controller
 *
 * @property Chucviecphathoahao $Chucviecphathoahao
 * @property PaginatorComponent $Paginator
 */
class ChucviecphathoahaosController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Chucviecphathoahao");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucviecphathoahao"; //name table 
    public $model = "Chucviecphathoahao";
    public $controller = "Chucviecphathoahaos";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên" => "hovaten",
        "Số điện thoại liên hệ" => "sodienthoai",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich",
    );
    public $title_for_layout = "Chức việc phật giáo Hòa hảo";
    
    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Anh chị em ruột" => "anhchiemruot",
            "Anh chị em vợ (chồng)" => "anhchiemvochong",
            "Vợ (chồng) và con" => "vochongvacon",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở trong nước" => "daquacaclopdaotaoboiduongvetongiaootrongnuoc",
            "Quá trình hoạt động tôn giáo ở trong nước" => "quatrinhhoatdongtongiaootrongnuoc",
            "Quá trình tu học và hoạt động tôn giáo ở nước ngoài" => "quatrinhtuhocvahoatdongtongiaoonuocngoai",
        );
        
        $this->result_table = $this->chucViecPhatGiaoHoaHao();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
