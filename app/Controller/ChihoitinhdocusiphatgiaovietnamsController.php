<?php
App::uses('DataController', 'Controller');
/**
 * Chihoitinhdocusiphatgiaovietnams Controller
 *
 * @property Chihoitinhdocusiphatgiaovietnam $Chihoitinhdocusiphatgiaovietnam
 * @property PaginatorComponent $Paginator
 */
class ChihoitinhdocusiphatgiaovietnamsController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Chihoitinhdocusiphatgiaovietnam");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chihoitinhdocusiphatgiaovietnam"; //name table 
    public $model = "Chihoitinhdocusiphatgiaovietnam";
    public $controller = "Chihoitinhdocusiphatgiaovietnams";
    public $result_table = array();
    public $showField =  array(
        "Tên chi hội/hội quán" => "tenchihoi",
        "Tên gọi khác (nếu có)" => "tengoikhac",
        "Số" => "tenchihoi_diachi_so",
        "Đường" => "tenchihoi_diachi_duong",
        "Ấp (khu phố)" => "tenchihoi_diachi_ap",
        "Xã (phường, thị trấn)" => "tenchihoi_diachi_xa",
        "Huyện (thị xã, thành phố)" => "tenchihoi_diachi_huyen",
        "Tỉnh" => "tenchihoi_diachi_tinh"
    );
    public $title_for_layout = "Chi hội/ Hội quán";
    
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
            "Các công trình tôn giáo trong khuôn viên của chi hội/hội quán" => "caccongtrinhtongiaotrongkhuonvienchihoi",
            "Các công trình ngoài khuôn viên của chi hội/hội quán" => "caccongtrinhngoaikhuonviencuachihoi",
            "Số thành viên trong Ban Hộ đạo" => "sothanhvientrongbanhodao",
            "Số thành viên trong Ban Chấp hành đạo đức" => "sothanhvientrongbanchaphanhdaoduc",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do chi hội/hội quán tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Tổ chức trong khuôn viên chi hội/hội quán" => "tochuctrongkhuonvienchihoi",
            "Tổ chức ngoài khuôn viên chi hội/hội quán" => "tochucngoaikhuonvienchihoi",
            "Kiểm soát Ban Y tế Phước thiện" => "kiemsoatbanytephuocthien",
            "Cố vấn Ban Y tế Phước thiện" => "covanbanytephuocthien"
        );
        
        $this->result_table = $this->chiHoiTinhDoCuSiPhatGiaoVietNam();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
