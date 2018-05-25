<?php

define('LIMIT_PAGE', 20);

define('MODE_1', "______:");
define('MODE_2', "______,");
define('MODE_3', "______;");

define('LIMIT_ARRAY_DATA', 10);
define('LOCAL_STORE', "Lưu");

define('GIOI_TINH', serialize(array(
        '0' => 'Nam',
        '1' => 'Nữ'
        )
    )
);

//define('TONG_HOP_CHUC_SAC', 0); //template0.xls
define('TONG_HOP_DAT_DAI', 1); //template1.xls
define('TH_TON_GIAO_CO_SO', 2); //template2.xls
define('TH_CO_SO_TON_GIAO', 3); //template3.xls
define('TONG_HOP_DI_TICH', 4); //template4.xls
define('TONG_HOP_CSTT_XAY_DUNG', 5); //template5.xls
define('TONG_HOP_CSTG_TRUNG_TU', 6); //template6.xls
define('BANG_TONG_HOP_TIN_DO', 7); //template7.xls
define('DS_CSTT', 8); //template8.xls
define('DSCS_BAO_TRO_XA_HOI', 9); //template9.xls
define('DS_CS_THAM_GIA_CT_XH_CAP_XA', 11); //template11.xls
define('DS_CS_THAM_GIA_CT_XH_CAP_HUYEN', 12); //template12.xls
define('DS_CS_THAM_GIA_CT_XH_CAP_TINH', 13); //template13.xls
define('TH_CS_THAM_GIA_CT_XH_CAP_XA', 14); //template14.xls
define('TH_CS_THAM_GIA_CT_XH_CAP_HUYEN', 15); //template15.xls
define('TH_CS_THAM_GIA_CT_XH_CAP_TINH', 16); //template16.xls
define('DS_CS_DT_BD', 17); //template17.xls
define('THBNCS', 18); //template18.xls
define('DS_CHUC_SAC_PCPP', 19); //template19.xls
define('TH_CHUC_SAC_PCPP', 20); //template20.xls
define('TH_TRINH_DO_TON_GIAO', 21); //template21.xls
define('TH_TRINH_DO_VH', 22); //template22.xls
define('DANH_SACH_TU_SI', 23); //template23.xls
define('DS_CHUC_SAC_KO_CO_CHUC_VU', 24); //template24.xls
define('DS_CHUC_SAC_CO_CHUC_VU', 25); //template25.xls
define('TONG_HOP_CHUC_VIEC', 26); //template26.xls
define('TONG_HOP_TU_SI', 27); //template27.xls
define('TONG_HOP_CHUC_SAC_KO_CHUC_VU', 28); //template28.xls
define('TONG_HOP_CHUC_SAC_CO_CHUC_VU', 29); //template29.xls
define('DO_TUOI_CUA_CHAC_SAC', 30); //template30.xls
define('DO_TUOI_CUA_TU_SI', 31); //template31.xls

define('LOAITONGIAO', serialize(array(
            1 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'CAO ĐÀI',
                'TĐCSPHVN',
                'HỒI GIÁO',
                'PHẬT GIÁO HÒA HẢO',
                'TÍN NGƯỠNG'
            ),
            2 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ VIỆT NAM',
                'HỒI GIÁO',
                'PHẬT GIÁO HÒA HẢO'
            ),
            3 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ VIỆT NAM',
                'HỒI GIÁO',
                'PHẬT GIÁO HÒA HẢO',
                'TÍN NGƯỠNG'
            ),
            4 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ VIỆT NAM',
                'PHẬT GIÁO HÒA HẢO',
                'HỒI GIÁO'
            ),
            5 => array(
                'Công giáo',
                'Phật giáo',
                'Tin lành',
                'Cao đài',
                'Tịnh độ Cư sĩ Phật hội VN',
                'Phật giáo Hòa Hảo',
                'Hồi giáo',
                'Tín ngưỡng'
            ),
            6 => array(
                'Công giáo',
                'Phật giáo',
                'Tin lành',
                'Cao đài',
                'Tịnh độ Cư sĩ Phật hội VN',
                'Phật giáo Hòa Hảo',
                'Hồi giáo',
                'Tín ngưỡng'
            ),
            7 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TĐCSPHVN',
                'PHẬT GIÁO HÒA HẢO',
                'HỒI GIÁO',
                //'CÁC TÔN GIÁO KHÁC'
            ),
            14 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                'PHẬT GIÁO HÒA HẢO',
                'HỒI GIÁO'
            ),
            15 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                'PHẬT GIÁO HÒA HẢO',
                'HỒI GIÁO'
            ),
            16 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                'PHẬT GIÁO HÒA HẢO',
                'HỒI GIÁO'
            ),
            18 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'HỒI GIÁO',
                'TĐCSPHVN'
            ),
            20 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'HỒI GIÁO',
                'TĐCSPHVN'
            ),
            21 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                'HỒI GIÁO'
            ),
            22 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                'HỒI GIÁO'
            ),
            26 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'PHẬT GIÁO HÒA HẢO',
                'TĐCSPHVN'
            ),
            27 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
            ),
            28 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'HỒI GIÁO',
                'TĐCSPHVN'
            ),
            29 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'TIN LÀNH',
                'CAO ĐÀI',
                'HỒI GIÁO',
                'TĐCSPHVN'
            ),
            30 => array(
                'CÔNG GIÁO',
                'PHẬT GIÁO',
                'CAO ĐÀI',
                'TĐCSPHVN',
                'HỒI GIÁO',
                'PHẬT GIÁO HÒA HẢO',
                'TÍN NGƯỠNG'
            )
        )
    )
);