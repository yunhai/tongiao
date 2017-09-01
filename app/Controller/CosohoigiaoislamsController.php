<?php
App::uses('DataController', 'Controller');
/**
 * Cosohoigiaoislams Controller
 *
 * @property Cosohoigiaoislam $Cosohoigiaoislam
 * @property PaginatorComponent $Paginator
 */
class CosohoigiaoislamsController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Cosohoigiaoislam");
    public $helpers = array('CustomPaginator');
    public $nameTable = "cosohoigiaoislam"; //name table 
    public $model = "Cosohoigiaoislam";
    public $controller = "Cosohoigiaoislams";
    public $result_table = array();
    public $showField = array(
        "Tên thánh đường/tiểu thánh đường" => "tenthanhduong",
        "Tên gọi khác (nếu có)" => "tenthanhduong_tengoikhac",
        "Số" => "tenthanhduong_diachi_so",
        "Đường" => "tenthanhduong_diachi_duong",
        "Ấp (khu phố)" => "tenthanhduong_diachi_ap",
        "Xã (phường, thị trấn)" => "tenthanhduong_diachi_xa",
        "Huyện (thị xã, thành phố)" => "tenthanhduong_diachi_huyen",
        "Tỉnh" => "tenthanhduong_diachi_tinh"
    );
    public $title_for_layout = "Cơ sở Hồi giáo Islam";

    public function beforeFilter() {
         parent::beforeFilter();
        $this->fiedlAuto = array(
            "dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat",
            "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3",
            "Dân tộc" => "soho_dantoc_soho_sonhankhau",
            "Các công trình tôn giáo trong khuôn viên thánh đường/tiểu thánh đường" => "caccongtrinhtongiaotrongkhuonvienthanhduong",
            "Các công trình ngoài khuôn viên của thánh đường/tiểu thánh đường" => "caccongtrinhngoaikhuonviencuathanhduong",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do Thánh đường/Tiểu Thánh đường tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Tổ chức trong khuôn viên thánh đường/tiểu thánh đường" => "tochuctrongkhuonvienthanhduong",
            "Tổ chức ngoài khuôn viên thánh đường/tiểu thánh đường" => "tochucngoaikhuonvienthanhduong",
        );
        
        $this->result_table = $this->coSoHoiGiaoIsLam();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }
}
