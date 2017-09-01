<?php
App::uses('DataController', 'Controller');
/**
 * Chucviectinhdocusiphathoivietnams Controller
 *
 * @property Chucviectinhdocusiphathoivietnam $Chucviectinhdocusiphathoivietnam
 * @property PaginatorComponent $Paginator
 */
class ChucviectinhdocusiphathoivietnamsController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Chucviectinhdocusiphathoivietnam");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chucviectinhdocusiphathoivietnam"; //name table 
    public $model = "Chucviectinhdocusiphathoivietnam";
    public $controller = "Chucviectinhdocusiphathoivietnams";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên" => "hovaten",
        "Tên gọi theo tôn giáo" => "tengoitheotongiao",
        "Số điện thoại liên hệ" => "sodienthoai",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich"
    );
    public $title_for_layout = "Chức việc Tịnh độ cư sĩ phật hội";
    
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
        
        $this->result_table = $this->chucViecTinhDoCuSiPhatHoiVietNam();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }
}
