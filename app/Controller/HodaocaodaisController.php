<?php
App::uses('DataController', 'Controller');
/**
 * Hodaocaodais Controller
 *
 * @property Hodaocaodai $Hodaocaodai
 * @property PaginatorComponent $Paginator
 */
class HodaocaodaisController extends DataController {

/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator');
    public $uses = array("Hodaocaodai");
    public $helpers = array('CustomPaginator');
    public $nameTable = "hodaocaodai"; //name table 
    public $model = "Hodaocaodai";
    public $controller = "Hodaocaodais";
    public $result_table = array();
    public $showField =  array(
        "Tên họ đạo (Ban Nghi lễ)" => "tenhodao",
        "Tên gọi khác (nếu có)" => "tenhodao_tengoikhac",
        "Số" => "tenhodao_diachi_so",
        "Đường" => "tenhodao_diachi_duong",
        "Ấp (Khu phố)" => "tenhodao_diachi_ap",
        "Xã (phường, thị trấn)" => "tenhodao_diachi_xa",
        "Huyện (thị xã, thành phố)" => "tenhodao_diachi_huyen",
        "Tỉnh" => "tenhodao_diachi_tinh"
    );
    public $title_for_layout = "Họ đạo Cao đài";
    
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
            "soho_dantoc_soho_sonhankhau" => "soho_dantoc_soho_sonhankhau",
            "Các công trình trong khuôn viên của họ đạo" => "caccongtrinhtrongkhuonviencuahodao",
            "Các công trình ngoài khuôn viên của họ đạo" => "caccongtrinhngoaikhuonviencuahodao",
            "Số thành viên trong Ban Cai quản" => "sothanhvientrongbancaiquan",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do họ đạo tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Tổ chức trong khuôn viên họ đạo" => "tochuctrongcongvienhodao",
            "Tổ chức ngoài khuôn viên họ đạo" => "tochucngoaikhuonvienhodao",
        );
        
        $this->result_table = $this->hoDaoCaoDai();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
