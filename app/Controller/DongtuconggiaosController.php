<?php
App::uses('DataController', 'Controller');
/**
 * Dongtuconggiaos Controller
 *
 * @property Dongtuconggiao $Dongtuconggiao
 * @property PaginatorComponent $Paginator
 */
class DongtuconggiaosController extends DataController {

/**
 * Components
 *
 * @var array
 */
public $components = array('Paginator');
    public $uses = array("Dongtuconggiao");
    public $helpers = array('CustomPaginator');
    public $nameTable = "dongtuconggiao"; //name table 
    public $model = "Dongtuconggiao";
    public $controller = "Dongtuconggiaos";
    public $result_table = array();
    public $showField =  array(
        "Tên tu viện/đan viện/cộng đoàn" => "tentuvien",
        "Tên gọi khác (tên quốc tế nếu có)" => "tengoikhac",
        "Số" => "diachi_so",
        "Đường" => "diachi_duong",
        "Ấp (khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh",
    );
    public $title_for_layout = "Giáo xứ, dòng tu (tu viện, cộng đoàn, đan viện)";
    
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
            "Các công trình tôn giáo trong khuôn viên cộng đoàn/tu viện/đan viện" => "caccongtrinhtongiaotrongkhuonviencongdoan",
            "Các công trình ngoài khuôn viên của cộng đoàn/tu viện/đan viện" => "caccongtrinhngoaikhuonviencuacongdoan",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do cộng đoàn/tu viện/đan viện đang tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai",
            "Một số lễ nghi cơ sở thường xuyên tổ chức tại cơ sở" => "motsolenghicosothuongxuyentochuctaicoso",
        );
        
        $this->result_table = $this->dongTuCongGiao();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }

}
