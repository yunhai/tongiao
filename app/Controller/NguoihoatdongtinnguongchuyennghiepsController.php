<?php
App::uses('DataController', 'Controller');
/**
 * Nguoihoatdongtinnguongchuyennghieps Controller
 *
 * @property Nguoihoatdongtinnguongchuyennghiep $Nguoihoatdongtinnguongchuyennghiep
 * @property PaginatorComponent $Paginator
 */
class NguoihoatdongtinnguongchuyennghiepsController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Nguoihoatdongtinnguongchuyennghiep");
    public $helpers = array('CustomPaginator');
    public $nameTable = "nguoihoatdongtinnguongchuyennghiep"; //name table 
    public $model = "Nguoihoatdongtinnguongchuyennghiep";
    public $controller = "Nguoihoatdongtinnguongchuyennghieps";
    public $result_table = array();
    public $showField =  array(
        "Họ và tên" => "hovaten",
        "Tên gọi theo tín ngưỡng (nếu có)" => "tengoitheotinnguong",
        "Số điện thoại cá nhân" => "sodienthoai",
        "Chức vụ" => "chucvu",
        "Ngày, tháng, năm sinh" => "ngaythangnamsinh",
        "Nơi sinh" => "noisinh",
        "Dân tộc" => "dantoc",
        "Quốc tịch" => "quoctich",
    );
    public $title_for_layout = "Người hoạt động tín ngưỡng chuyên nghiệp";
    
    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "Trình độ học vấn" => "trinhdohocvan",
            "Trình độ ngoại ngữ" => "trinhdongoaingu",
            "Trình độ tin học" => "trinhdotinhoc",
            "Anh chị em ruột" => "anhchiemruot",
            "Anh chị em vợ (chồng)" => "anhchiemvochong",
            "Vợ (chồng) và con" => "vochongvacon",
            "Các chức danh tín ngưỡng đã kinh qua" => "cacchucdanhtinnguongdakinhqua",
            "Quá trình hoạt động tín ngưỡng ở trong nước" => "quatrinhhoatdongtinnguongotrongnuoc",
            "Quá trình hoạt động tín ngưỡng ở nước ngoài (nếu có)" => "quatrinhhoatdongtinnguongonuocngoaineuco",
        );
        
        $this->result_table = $this->nguoiHoatDongTinNguongChuyenNghiep();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
