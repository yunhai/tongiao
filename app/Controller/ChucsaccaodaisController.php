<?php
App::uses('DataController', 'Controller');
/**
 * Chucsaccaodais Controller
 *
 * @property Chucsaccaodai $Chucsaccaodai
 * @property PaginatorComponent $Paginator
 */
class ChucsaccaodaisController extends DataController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');
    public $uses = array("Chucsaccaodai");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucsaccaodai"; //name table 
    public $model = "Chucsaccaodai";
    public $controller = "Chucsaccaodais";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên" => "hovaten",
        "Thánh danh" => "thanhdanh",
        "Số điện thoại liên hệ" => "sodienthoai",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich"
    );
    public $title_for_layout = "Chức sắc Cao đài";
    
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
        
        $this->result_table = $this->chucSacCaoDai();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }
    
}
