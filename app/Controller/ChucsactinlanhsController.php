<?php

App::uses('DataController', 'Controller');

/**
 * Chucsactinlanhs Controller
 *
 * @property Chucsactinlanh $Chucsactinlanh
 * @property PaginatorComponent $Paginator
 */
class ChucsactinlanhsController extends DataController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator', 'PhpExcel', 'Excel');
    public $uses = array("Chucsactinlanh");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucsactinlanh"; //name table 
    public $model = "Chucsactinlanh";
    public $controller = "Chucsactinlanhs";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên" => "hovaten",
        "Số điện thoại" => "sodienthoai",
        "Ngày, tháng, năm, sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich",
    );
    public $title_for_layout = "Chức sắc tin lành";

    //field show index

    public function beforeFilter() {
        parent::beforeFilter();
        $this->fiedlAuto = array(
            "Anh chị em ruột" => "anhchiemruot",
            "Anh chị em vợ (chồng)" => "anhchiemvochong",
            "Vợ (chồng) và con" => "vochongvacon",
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ thần học" => "trinhdothanhoc",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Quá trình hoạt động tôn giáo ở trong nước" => "quatrinhhoatdongtongiaootrongnuoc",
            "Quá trình hoạt động tôn giáo ở nước ngoài" => "quatrinhhoatdongtongiaoongoainuoc",
        );
       
        $this->result_table = $this->chucSacTinLanh();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
