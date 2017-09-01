<?php
App::uses('DataController', 'Controller');
/**
 * Chucsacnhatuhanhphatgiaos Controller
 *
 * @property Chucsacnhatuhanhphatgiao $Chucsacnhatuhanhphatgiao
 * @property PaginatorComponent $Paginator
 */
class ChucsacnhatuhanhphatgiaosController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Chucsacnhatuhanhphatgiao");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucsacnhatuhanhphatgiao"; //name table 
    public $model = "Chucsacnhatuhanhphatgiao";
    public $controller = "Chucsacnhatuhanhphatgiaos";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên (thế danh)" => "hovaten",
        "Pháp danh" => "phapdanh",
        "Pháp hiệu" => "phaphieu",
        "Số điện thoại liên hệ" => "sodienthoai",
        "Ngày, tháng, năm, sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Nguyên Quán" => "nguyenquan_huyen"
    );
    public $title_for_layout = "Chức sắc, nhà tu hành Phật giáo";

    //field show index

    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ chuyên môn về tôn giáo" => "trinhdochuyenmonvetongiao",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Anh chị em ruột" => "anhchiemruot",
            "Anh chị em vợ (chồng)" => "anhchiemvochong",
            "Vợ (chồng) và con" => "vochongvacon",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo trong nước" => "daquacaclopdaotaoboiduongvetongiaotrongnuoc",
            "Quá trình hoạt động tôn giáo ở trong nước" => "quatrinhhoatdongtongiaootrongnuoc",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở ngoài nước" => "daquacaclopdaotaoboiduongvetongiaoongoainuoc",
            "Quá trình hoạt động tôn giáo ở nước ngoài" => "quatrinhhoatdongtongiaoonuocngoai",
        );
       
        $this->result_table = $this->chucSacNhaTuHanhPhatGiao();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
