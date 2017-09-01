<?php
App::uses('DataController', 'Controller');
/**
 * Cosotinnguongs Controller
 *
 * @property Cosotinnguong $Cosotinnguong
 * @property PaginatorComponent $Paginator
 */
class CosotinnguongsController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Cosotinnguong");
    public $helpers = array('CustomPaginator');
    public $nameTable = "cosotinnguong"; //name table 
    public $model = "Cosotinnguong";
    public $controller = "Cosotinnguongs";
    public $result_table = array();
    public $showField = array(
        "Tên cơ sở" => "tencoso",
        "Tên gọi khác (nếu có)" => "tengoikhac",
        "Số" => "diachi_so",
        "Đường" => "diachi_duong",
        "Ấp (khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh"
    );
    public $title_for_layout = "Cơ sở tín ngưỡng";

    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "tongiao_dacap_gcn_quyensudungdat" => "tongiao_dacap_gcn_quyensudungdat",
            "nnlnntts_dacap_gcn_quyensudungdat" => "nnlnntts_dacap_gcn_quyensudungdat",
            "gdyt_dacap_gcn_quyensudungdat" => "gdyt_dacap_gcn_quyensudungdat",
            "dsdmdk_dacap_gcn_quyensudungdat" => "dsdmdk_dacap_gcn_quyensudungdat",
            "Đối tượng thờ cúng" => "doituongthocung",
            "Các công trình của cơ sở tín ngưỡng" => "caccongtrinhcuacosotinnguong",
            "Thành phần ban trị sự/ ban đại diện/ ban quản lý/ ban quý tế/ ..." => "thanhphanbantrisu",
            "Người hoạt động tín ngưỡng chuyên nghiệp của cơ sở" => "nguoihoatdongtinnguongchuyennghiepcuacoso",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do cơ sở tín ngưỡng tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Một số lễ nghi tín ngưỡng cơ sở thường xuyên tổ chức hàng năm" => "motsolenghitinnguongcosothuongxuyentochuchangnam"
        );
        
        $this->result_table = $this->coSoTinNguong();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
