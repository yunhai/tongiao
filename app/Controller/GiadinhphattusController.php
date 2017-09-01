<?php
App::uses('DataController', 'Controller');
/**
 * Giadinhphattus Controller
 *
 * @property Giadinhphattus $Giadinhphattus
 * @property PaginatorComponent $Paginator
 * @property AclComponent $Acl
 */
class GiadinhphattusController extends DataController {

/**
 * Helpers
 *
 * @var array
 */

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Giadinhphattu");
    public $helpers = array('CustomPaginator');
    public $nameTable = "giadinhphattu"; //name table 
    public $model = "Giadinhphattu";
    public $controller = "Giadinhphattus";
    public $result_table = array();
    public $showField =  array(
        "Tên Gia đình phật tử" => "tengiadinhphattu",
        "Năm thành lập" => "namthanhlap",
        "Thuộc cơ sở tự, viện" => "thuoccosotuvien",
        "Số" => "diachi_so",
        "Đường" => "diachi_duong",
        "Ấp (Khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh",
    );
    public $title_for_layout = "Gia đình Phật tử";
    
    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "Nhân sự đã được thọ cấp tính đến nay" => "nhansudaduocthocaptinhdennay",
            "Nhân sự đã qua đào tạo, bồi dưỡng tính đến nay" => "nhansudaquadaotaoboiduongtinhdennay",
            "Nhân sự đã qua các trại huấn luyện tính đến nay" => "nhansudaquacactraihuanluyentinhdennay",
            "Các hoạt động tổ chức trong khuôn viên tự, viện" => "cachoatdongtochuctrongkhuonvientuvien",
            "Các hoạt động tổ chức ngoài: khuôn viên tự, viện" => "cachoatdongtochucngoaikhuonvientuvien",
        );
        
        $this->result_table = $this->giaDinhPhatTu();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
