<?php

App::uses('DataController', 'Controller');

/**
 * Tuvienphatgiaos Controller
 *
 * @property Tuvienphatgiao $Tuvienphatgiao
 * @property PaginatorComponent $Paginator
 */
class TuvienphatgiaosController extends DataController {

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');
    public $uses = array("Tuvienphatgiao");
    public $helpers = array('CustomPaginator');
    public $nameTable = "tuvienphatgiao"; //name table 
    public $model = "Tuvienphatgiao";
    public $controller = "Tuvienphatgiaos";
    public $result_table = array();
    public $showField = array(
        "Tên tự, viện" => "tentuvien",
        "Tên gọi khác (nếu có)" => "tengoikhac",
        "Số" => "diachi_so",
        "Đường" => "diachi_duong",
        "Ấp (Khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh",
    );
    public $title_for_layout = "Tự, Viện Phật giáo";

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
            "Các công trình trong khuôn viên của tự, viện" => "caccongtrinhtrongkhuonviencuatuvien",
            "Các công trình ngoài khuôn viên của tự, viện" => "caccongtrinhngoaikhuonviencuatuvien",
            "Tu sĩ đang tu học tại tự, viện" => "tusidangtuhoctaituvien",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do tự, viện tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Tổ chức trong khuôn viên tự, viện" => "tochuctrongkhuonvientuvien",
            "Tổ chức ngoài khuôn viên tự, viện" => "tochucngoaikhuonvientuvien",
            "Quan hệ với các tổ chức, cá nhân tôn giáo nước ngoài (được tài trợ kinh phí để thực hiện)" => "quanhevoicactochuccanhantongiaonuocngoai"
        );

        $this->result_table = $this->tuVienPhatGiao();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
