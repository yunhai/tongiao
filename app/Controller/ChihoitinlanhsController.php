<?php

App::uses('DataController', 'Controller');

/**
 * Chihoitinlanhs Controller
 *
 * @property Chihoitinlanh $Chihoitinlanh
 * @property PaginatorComponent $Paginator
 */
class ChihoitinlanhsController extends DataController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $uses = array("Chihoitinlanh");
    public $helpers = array('CustomPaginator');
    public $nameTable = "chihoitinlanh"; //name table 
    public $model = "Chihoitinlanh";
    public $controller = "Chihoitinlanhs";
    public $result_table = array();
    public $showField = array(
        "Tên chi hội" => "tenchihoi",
        "Tên gọi khác (nếu có)" => "tengoikhac",
        "Số" => "diachi_so",
        "Ấp (khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh"
    );
    public $title_for_layout = "Chi hội";

    public function beforeFilter() {
        parent::beforeFilter();
        $this->fiedlAuto = array(
            "dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_nghiadia_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_nghiadia_dacap_gcn_quyensudungdat",
            "dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat" => "dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat",
            "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1" => "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1",
            "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2" => "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2",
            "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_nghiadia_dacap_gcn_quyensudungdat_3",
            "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3" => "datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3",
            "soho_dantoc_soho_sonhankhau" => "soho_dantoc_soho_sonhankhau",
            "Điểm nhóm" => "diemnhom",
            "Hội đoàn" => "hoidoan",
            "Các công trình trong khuôn viên nhà thờ chi hội" => "caccongtrinhtrongkhuonviennhathochihoi",
            "Các công trình ngoài khuôn viên nhà thờ của chi hội (kể cả nơi sinh hoạt của điểm nhóm)" => "caccongtrinhngoaikhuonviennhathocuachihoi",
            "sothanhvientrongbanchapsu_hovaten_namsinh_chucvu" => "sothanhvientrongbanchapsu_hovaten_namsinh_chucvu",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do chi hội tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Tổ chức tại cơ sở thờ tự" => "tochuctaicosothotu",
            "Tổ chức ngoài cơ sở thờ tự" => "tochucngoaicosothotu",
            "Quan hệ với các tổ chức, cá nhân tôn giáo nước ngoài (được tài trợ kinh phí để thực hiện)" => "quanhevoicactochuccanhantongiaonuocngoai"
        );
        
        $this->result_table = $this->chiHoiTinlanh();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
