<?php
App::uses('DataController', 'Controller');
/**
 * Giaoxus Controller
 *
 * @property Giaoxus $Giaoxus
 * @property PaginatorComponent $Paginator
 */
class GiaoxusController extends DataController {

/**
 * Components
 *
 * @var array
 */
    public $components = array('Paginator');
    public $uses = array("Giaoxu");
    public $helpers = array('CustomPaginator');
    public $nameTable = "giaoxu"; //name table 
    public $model = "Giaoxu";
    public $controller = "Giaoxus";
    public $result_table = array();
    public $showField =  array(
        "Tên giáo xứ" => "tengiaoxu",
        "Tên gọi khác (nếu có)" => "tengoikhac",
        "Thánh bổn mạng giáo xứ" => "thanhbonmanggiaoxu",
        "Ngày bổn mạng" => "ngaybonmang",
        "Số" => "diachi_so",
        "Đường" => "diachi_duong",
        "Ấp (Khu phố)" => "diachi_ap",
        "Xã (phường, thị trấn)" => "diachi_xa",
        "Huyện (thị xã, thành phố)" => "diachi_huyen",
        "Tỉnh" => "diachi_tinh",
    );
    public $title_for_layout = "Giáo xứ";
    
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
            "Số hộ" => "soho_dantoc_soho_sonhankhau",
            "Giáo họ" => "giaoho",
            "Hội đoàn phục vụ lễ nghi tôn giáo" => "hoidoanphucvulenghitongiao",
            "Số hội đoàn đã được cấp phép hoạt động" => "sohoidoanduoccapphephoatdong_sohoidoan",
            "Số hội đoàn chưa được cấp phép hoạt động" => "sohoidoanchuaduoccapphephoatdong_sohoidoan",
            "Các công trình trong khuôn viên của nhà thờ xứ" => "caccongtrinhtrongkhuonviencuanhathoxu",
            "Các công trình ngoài khuôn viên của nhà thờ xứ" => "caccongtrinhngoaikhuonviencuanhathoxu",
            "Ủy viên" => "uyvien",
            "Tại giáo xứ có cộng đoàn, dòng tu, tu viện, đan viện nào đang hoạt động tôn giáo" => "taigiaoxucocongdoan_danghoatdongtongiao",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do giáo xứ tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai_dogiaoxu",
            "Các hoạt động bác ái, từ thiện xã hội, y tế, giáo dục do dòng tu (cộng đoàn, tu viện) hoạt động tôn giáo giáo xứ tổ chức thực hiện (cơ sở bảo trợ xã hội, giáo dục, y tế, từ thiện và ghi rõ người phụ trách)" => "cachoatdongbacai_dodongtu",
            "Tổ chức trong khuôn viên giáo xứ" => "tochuctrongkhuonviengiaoxu",
            "Tổ chức ngoài cơ sở thờ tự" => "tochucngoaicosothotu",
            "Quan hệ với các tổ chức, cá nhân tôn giáo nước ngoài (được tài trợ kinh phí để thực hiện)" => "quanhevoicactochuccanhantongiaonuocngoai"
        );
        
        $this->result_table = $this->giaoXu();
        $this->set(array(
            "model" => $this->model,
            "controller" => $this->controller,
        ));
    }
    
}
