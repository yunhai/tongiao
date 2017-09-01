<?php
App::uses('DataController', 'Controller');
/**
 * Chucsacnhatuhanhconggiaotrieus Controller
 *
 * @property Chucsacnhatuhanhconggiaotrieus $Chucsacnhatuhanhconggiaotrieus
 * @property PaginatorComponent $Paginator
 */
class ChucsacnhatuhanhconggiaotrieusController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Chucsacnhatuhanhconggiaotrieu");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucsacnhatuhanhconggiaotrieu"; //name table 
    public $model = "Chucsacnhatuhanhconggiaotrieu";
    public $controller = "Chucsacnhatuhanhconggiaotrieus";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên (ghi cả tên Thánh)" => "hovaten",
        "Ngày bổn mạng" => "ngaybonmang",
        "Số điện thoại liên hệ" => "sodienthoai",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich",
    );
    public $title_for_layout = "Chức sắc, nhà tu hành Công giáo (triều)";
    
    public function beforeFilter() {
        parent::beforeFilter();
        $this->fiedlAuto = array(
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ chuyên môn về tôn giáo" => "trinhdochuyenmonvetongiao",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Anh chị em ruột" => "anhchiemruot",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo trong nước" => "daquacaclopdaotaoboiduongvetongiaotrongnuoc",
            "Quá trình hoạt động tôn giáo ở trong nước" => "quatrinhhoatdongtongiaootrongnuoc",
            "Đã qua các lớp đào tạo, bồi dưỡng về tôn giáo ở nước ngoài" => "daquacaclopdaotaoboiduongvetongiaoonuocngoai",
            "Quá trình hoạt động tôn giáo ở nước ngoài" => "quatrinhhoatdongtongiaoonuocngoai",
        );
        
        $this->result_table = $this->chucSacNhaTuHanhCongGiaoTrieu();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
