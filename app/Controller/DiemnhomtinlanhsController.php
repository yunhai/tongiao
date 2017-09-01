<?php

App::uses('DataController', 'Controller');

/**
 * Diemnhomtinlanhs Controller
 *
 * @property Diemnhomtinlanh $Diemnhomtinlanh
 * @property PaginatorComponent $Paginator
 */
class DiemnhomtinlanhsController extends DataController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $uses = array("Diemnhomtinlanh");
    public $helpers = array('CustomPaginator');
    public $nameTable = "diemnhomtinlanh"; //name table 
    public $model = "Diemnhomtinlanh";
    public $controller = "Diemnhomtinlanhs";
    public $result_table = array();
    public $showField =  array(
        "Tên điểm nhóm" => "tendiemnhom",
        "Tên gọi khác (nếu có)" => "tengoikhac",
        "Số" => "diachi_so",
        "Đường" => "diachi_duong",
        "Ấp (khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh"
    );
    public $title_for_layout = "Điểm nhóm";
    
    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "tongiao_dacap_gcn_quyensudungdat" => "tongiao_dacap_gcn_quyensudungdat",
            "nnlnntts_dacap_gcn_quyensudungdat" => "nnlnntts_dacap_gcn_quyensudungdat",
            "gdyt_dacap_gcn_quyensudungdat" => "gdyt_dacap_gcn_quyensudungdat",
            "dsdmdk_dacap_gcn_quyensudungdat" => "dsdmdk_dacap_gcn_quyensudungdat",
            "soho_dantoc_soho_sonhankhau" => "soho_dantoc_soho_sonhankhau",
            "Số thành viên tham gia phụ trách điểm nhóm" => "sothanhvienthamgiaphutrachdiemnhom",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do cơ sở tín ngưỡng tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
        );
        
        $this->result_table = $this->diemNhomTinLanh();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
