<?php
App::uses('DataController', 'Controller');
/**
 * Chucsacnhatuhanhcongiaodongtus Controller
 *
 * @property Chucsacnhatuhanhcongiaodongtus $Chucsacnhatuhanhcongiaodongtus
 * @property PaginatorComponent $Paginator
 */
class ChucsacnhatuhanhcongiaodongtusController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Chucsacnhatuhanhcongiaodongtu");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucsacnhatuhanhcongiaodongtu"; //name table 
    public $model = "Chucsacnhatuhanhcongiaodongtu";
    public $controller = "Chucsacnhatuhanhcongiaodongtus";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên (ghi cả tên Thánh)" => "hovaten",
        "Ngày bổn mạng" => "ngaybonmang",
        "Số điện thoại liên hệ" => "sodienthoai",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
    );
    public $title_for_layout = "Chức sắc, nhà tu hành Công giáo (dòng tu)";
    
    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ Thần học" => "trinhdothanhoc",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Anh chị em ruột" => "anhchiemruot",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo trong nước" => "daquacaclopdaotaoboiduongvetongiaotrongnuoc",
            "Quá trình hoạt động tôn giáo ở trong nước" => "quatrinhhoatdongtongiaootrongnuoc",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở nước ngoài" => "daquacaclopdaotaoboiduongvetongiaoonuocngoai",
            "Quá trình hoạt động tôn giáo ở nước ngoài" => "quatrinhhoatdongtongiaoonuocngoai",
        );
        
        $this->result_table = $this->chucSacNhaTuHanhCongGiaoDongTu();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
