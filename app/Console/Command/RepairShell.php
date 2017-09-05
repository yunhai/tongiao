<?php

App::uses('ComponentCollection', 'Controller');
App::uses('UtilityComponent', 'Controller/Component');

class RepairShell extends AppShell
{
    public function main()
    {
        $this->out('Hello world.');
    }

    public function number()
    {
        $collection = new ComponentCollection();
        $this->Utility = new UtilityComponent($collection);
        
        
        /**
         * Cột tongiao_dacap_gcn_quyensudungdat có chứa tongiao_dacap_dientich
         * tongiao_gcn______:00543______,tongiao_cqc_nc______:UBND huyện Định Quán ngày 23/10/2002______,tongiao_dacap_dientich______:1397.8______,tongiao_dacap_to_thua______:Tờ 24, thửa 60
         * 
         * 
         * Cột nnlnntts_dacap_gcn_quyensudungdat có chứa nnlnntts_dacap_dientich
         * nnlnntts_gcn______:AL 932265______,nnlnntts_cqc_nc______:16/5/2012______,nnlnntts_dacap_dientich______:50200
         * 
         * 
         * Cột gdyt_dacap_gcn_quyensudungdat có chứa gdyt_dacap_dientich
         * 
         * 
         * Cột dsdmdk_dacap_gcn_quyensudungdat có chứa dsdmdk_dacap_dientich
         * 
         * 
         * Cột dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_tongiao_dacap_dientich
         * dattrongkhuonvien_tongiao_gcn______:CT 07478 và CT 04777______,dattrongkhuonvien_tongiao_cqc_nc______:Sở TN & MT tỉnh Đồng Nai ______,dattrongkhuonvien_tongiao_dacap_dientich______:462.5 và 796.6______,dattrongkhuonvien_tongiao_dacap_to_thua______:tờ 93, thửa  135 và tờ 93, thửa 40
         * 
         * 
         * Cột dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_nnlnntts_dacap_dientich
         * dattrongkhuonvien_nnlnntts_gcn______:AK 193338______,dattrongkhuonvien_nnlnntts_cqc_nc______:UBND thành phố Biên Hòa ngày 30/01/2008 cấp cho cá nhân bà Nguyễn Thị Thanh Hà______,dattrongkhuonvien_nnlnntts_dacap_dientich______:1001.4______,dattrongkhuonvien_nnlnntts_dacap_to_thua______:tờ 50, thửa 252
         * 
         * 
         * Cột dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_gdyt_dacap_dientich
         * dattrongkhuonvien_gdyt_gcn______:S 1017______,dattrongkhuonvien_gdyt_cqc_nc______:UBND tỉnh Đồng Nai ngày 21/10/2010______,dattrongkhuonvien_gdyt_dacap_dientich______:260______,dattrongkhuonvien_gdyt_dacap_to_thua______:10, 639
         * 
         * 
         * Cột dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat có chứa dattrongkhuonvien_dsdmdk_dacap_dientich
         * dattrongkhuonvien_dsdmdk_gcn______:AB 603105______,dattrongkhuonvien_dsdmdk_cqc_nc______:UBND huyện Định Quán 27/6/2005______,dattrongkhuonvien_dsdmdk_dacap_dientich______:15020______,dattrongkhuonvien_dsdmdk_dacap_to_thua______:tờ 02 thửa 796
         * 
         * Cột datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_tongiao_dacap_dientich_1
         * datngoaikhuonvien_tongiao_gcn_1______:CT 18862______,datngoaikhuonvien_tongiao_cqc_nc_1______:UBND tỉnh Đồng Nai ______,datngoaikhuonvien_tongiao_dacap_dientich_1______:3056.9______,datngoaikhuonvien_tongiao_dacap_to_thua_1______:tờ 14, thửa 24
         * 
         * 
         * Cột datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_nnlnntts_dacap_dientich_1
         * datngoaikhuonvien_nnlnntts_gcn_1______:AD 325550______,datngoaikhuonvien_nnlnntts_cqc_nc_1______:UBND huyện Long Thành, ngày 18/10/2005 ______,datngoaikhuonvien_nnlnntts_dacap_dientich_1______:938______,datngoaikhuonvien_nnlnntts_dacap_to_thua_1______:59, 273
         * 
         * Cột datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_gdyt_dacap_dientich_1
         * datngoaikhuonvien_gdyt_gcn_1______:AH 250117______,datngoaikhuonvien_gdyt_cqc_nc_1______:UBND huyện Long Thành ______,datngoaikhuonvien_gdyt_dacap_dientich_1______:1720______,datngoaikhuonvien_gdyt_dacap_to_thua_1______:6, 525
         * 
         * 
         * Cột datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1 có chứa datngoaikhuonvien_dsdmdk_dacap_dientich_1
         * datngoaikhuonvien_dsdmdk_gcn_1______:AN 582114______,datngoaikhuonvien_dsdmdk_cqc_nc_1______:UBND tỉnh Đồng Nai cấp ngày 29/9/2008______,datngoaikhuonvien_dsdmdk_dacap_dientich_1______:3142______,datngoaikhuonvien_dsdmdk_dacap_to_thua_1______:27/116______;datngoaikhuonvien_dsdmdk_gcn_1______:AN 582115______,datngoaikhuonvien_dsdmdk_cqc_nc_1______:UBND tỉnh Đồng Nai cấp ngày 29/9/2008______,datngoaikhuonvien_dsdmdk_dacap_dientich_1______:15441.8______,datngoaikhuonvien_dsdmdk_dacap_to_thua_1______:27/133______;datngoaikhuonvien_dsdmdk_gcn_1______:AN 582117______,datngoaikhuonvien_dsdmdk_cqc_nc_1______:UBND tỉnh Đồng Nai cấp ngày 29/9/2008______,datngoaikhuonvien_dsdmdk_dacap_dientich_1______:5885.7______,datngoaikhuonvien_dsdmdk_dacap_to_thua_1______:27/132
         * 
         * 
         * Cột datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_tongiao_dacap_dientich_2
         * datngoaikhuonvien_tongiao_gcn_2______:011061______,datngoaikhuonvien_tongiao_cqc_nc_2______:03/12/2007______,datngoaikhuonvien_tongiao_dacap_dientich_2______:527,2______,datngoaikhuonvien_tongiao_dacap_to_thua_2______:tờ 05,  thửa 128
         * 
         * 
         * Cột datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_nnlnntts_dacap_dientich_2
         * datngoaikhuonvien_nnlnntts_gcn_2______:BD 223461______,datngoaikhuonvien_nnlnntts_cqc_nc_2______:UBND huyện Long Thành, ngày 07/02/2014______,datngoaikhuonvien_nnlnntts_dacap_dientich_2______:121______,datngoaikhuonvien_nnlnntts_dacap_to_thua_2______:09, 1460
         * 
         * 
         * Cột datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_gdyt_dacap_dientich_2
         * 
         * 
         * Cột datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2 có chứa datngoaikhuonvien_dsdmdk_dacap_dientich_2
         * 
         * 
         * Cột datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_tongiao_dacap_dientich_3
         * 
         * 
         * Cột datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_nnlnntts_dacap_dientich_3
         * 
         * 
         * Cột datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_gdyt_dacap_dientich_3
         * 
         * 
         * Cột datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3 có chứa datngoaikhuonvien_dsdmdk_dacap_dientich_3
         * 
         */
        
        $arrays = array(
            'tongiao_dacap_gcn_quyensudungdat' => 'tongiao_dacap_dientich',
            'nnlnntts_dacap_gcn_quyensudungdat' => 'nnlnntts_dacap_dientich',
            'gdyt_dacap_gcn_quyensudungdat' => 'gdyt_dacap_dientich',
            'dsdmdk_dacap_gcn_quyensudungdat' => 'dsdmdk_dacap_dientich',
            'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat' => 'dattrongkhuonvien_dsdmdk_dacap_dientich',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1' => 'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2' => 'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
            'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3' => 'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
            
        );

        $string = [
            '1300',
            '1,300',
            '1,300,000',
            '1.300',
            '1.300.000',
            '1300,25',
            '1300.25',
            '1300.32',
            '1.300,25',
            '1,300.25',
            '900m2',
            '900 m2',
            'khoảng 900 m2',
            'khoang 900 m2',
            'chieu. chungtoi, 900m2',
            
            '2000 + 1.637,8',
            '462.5 và 796.6',
            '3142; 15441.8; 5885.7',
            '412.715',
            '947,2 m2',
            '606.5 m2',
            '13461,5 m2; 1512 m2; 14383 m2; 571,5 m2',
            '16983,3 (17163,3)',    //Hodaocaodais/add/22
            '2047+16983,3 m2',  
            '1690 m2 + 217 m2',
            '709, 7 m2 (đất họ đạo 357 m2)',    //Hodaocaodais/add/40
            'mượn 25/1080 m2 (tờ 9, thửa 122)', //Hodaocaodais/add/47
            'đát thánh thất là 1,209 m2; đất Điện thờ Phật mẫu: 1.078 m2',      //Hodaocaodais/add/21
            '13.700.4 m2',
            'Đất ơ nông thôn 150 m2, đất trồng cây lâu năm',        //Chihoitinhdocusiphatgiaovietnams/add/5
            'đất nông thôn 150 m2, đất trồng cây lâu năm 919 m2',   //Chihoitinhdocusiphatgiaovietnams/add/14
            '2.045,4m2',
            '58.411,3 m2',
            '1132 m2 đất lộ giới',
            //'638m2 thuộc tờ 30, thửa 603. 533m2 thuộc tờ 20, thửa 600. 2634 m2 thuộc tờ 30, thửa 602. 1576 m2 thuộc tờ 37, thửa 143'    //Tuvienphatgiaos/add/579
        ];
        foreach ($string as $id => $string) {
            $this->out($string);
            $this->out($this->Utility->retrieveNumberFromString($string));
            $this->out(' ');
        }
    }
}
