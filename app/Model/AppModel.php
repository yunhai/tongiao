<?php
/**
 * Application model for CakePHP.
 *
 * This file is application-wide model file. You can put all
 * application-wide model-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Model
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Model', 'Model');
App::uses('CakeSession', 'Model/Datasource');


/**
 * Application model for Cake.
 *
 * Add your application-wide methods in the class below, your models
 * will inherit them.
 *
 * @package       app.Model
 */
class AppModel extends Model
{
    public function convertDataSave($data)
    {
        $alias = $this->alias;

        //trinhdohocvan
        //trinhdothanhoc
        //trinhdongoaingu
        //trinhdotinhoc

        //trinhdohocvan
        if (isset($data[$alias]['trinhdohocvan'])) {
            $trinhdohocvan = $data[$alias]['trinhdohocvan'];

            unset($trinhdohocvan['trinhdohocvan_totnghieptruong'][0], $trinhdohocvan['trinhdohocvan_nam'][0]);
            

            $trinhdohocvan_totnghieptruong = $trinhdohocvan['trinhdohocvan_totnghieptruong'];
            $trinhdohocvan_nam = $trinhdohocvan['trinhdohocvan_nam'];

            $count = count($trinhdohocvan_totnghieptruong);

            $hocvan = $tmp_hocvan = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($trinhdohocvan_totnghieptruong[$i])) {
                    //$hocvan[$i][] = $trinhdohocvan_totnghieptruong[$i];
                    $tmp_hocvan[$i][] = $trinhdohocvan_totnghieptruong[$i];
                }
                if (!empty($trinhdohocvan_nam[$i])) {
                    //$hocvan[$i][] = $trinhdohocvan_nam[$i];
                    $tmp_hocvan[$i][] = $trinhdohocvan_nam[$i];
                }

                $hocvan[] = implode($tmp_hocvan[$i], ',');
            }

            $implode = implode($hocvan, ';');

            //$data[$alias]['trinhdohocvan'] = !empty($hocvan) ? json_encode($hocvan) : '';
            $data[$alias]['trinhdohocvan'] = !empty($implode) ? json_encode($implode) : '';
        }
        pr($data);
        exit;
        //trinhdothanhoc
        if (isset($data[$alias]['trinhdothanhoc'])) {
            $trinhdothanhoc = $data[$alias]['trinhdothanhoc'];

            unset($trinhdothanhoc['trinhdothanhoc_totnghieptruong'][0], $trinhdothanhoc['trinhdothanhoc_nam'][0]);
            

            $trinhdothanhoc_totnghieptruong = $trinhdothanhoc['trinhdothanhoc_totnghieptruong'];
            $trinhdothanhoc_nam = $trinhdothanhoc['trinhdothanhoc_nam'];

            $count = count($trinhdothanhoc_totnghieptruong);

            $thanhoc = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($trinhdothanhoc_totnghieptruong[$i])) {
                    $thanhoc[$i][] = $trinhdohocvan_totnghieptruong[$i];
                }
                if (!empty($trinhdothanhoc_nam[$i])) {
                    $thanhoc[$i][] = $trinhdohocvan_nam[$i];
                }
            }

            $data[$alias]['trinhdothanhoc'] = !empty($thanhoc) ? json_encode($thanhoc) : '';
        }

        //trinhdongoaingu
        if (isset($data[$alias]['trinhdongoaingu'])) {
            $trinhdongoaingu = $data[$alias]['trinhdongoaingu'];

            unset($trinhdongoaingu['trinhdongoaingu_totnghieptruong'][0], $trinhdongoaingu['trinhdongoaingu_nam'][0]);
            

            $trinhdongoaingu_totnghieptruong = $trinhdongoaingu['trinhdongoaingu_totnghieptruong'];
            $trinhdongoaingu_nam = $trinhdongoaingu['trinhdongoaingu_nam'];

            $count = count($trinhdongoaingu_totnghieptruong);

            $ngoaingu = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($trinhdongoaingu_totnghieptruong[$i])) {
                    $ngoaingu[$i][] = $trinhdongoaingu_totnghieptruong[$i];
                }
                if (!empty($trinhdongoaingu_nam[$i])) {
                    $ngoaingu[$i][] = $trinhdongoaingu_nam[$i];
                }
            }

            $data[$alias]['trinhdongoaingu'] = !empty($ngoaingu) ? json_encode($ngoaingu) : '';
        }

        //trinhdotinhoc
        if (isset($data[$alias]['trinhdotinhoc'])) {
            $trinhdotinhoc = $data[$alias]['trinhdotinhoc'];

            unset($trinhdotinhoc['trinhdotinhoc_totnghieptruong'][0], $trinhdotinhoc['trinhdotinhoc_nam'][0]);
            

            $trinhdotinhoc_totnghieptruong = $trinhdotinhoc['trinhdotinhoc_totnghieptruong'];
            $trinhdotinhoc_nam = $trinhdotinhoc['trinhdotinhoc_nam'];

            $count = count($trinhdotinhoc_totnghieptruong);

            $tinhoc = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($trinhdotinhoc_totnghieptruong[$i])) {
                    $tinhoc[$i][] = $trinhdotinhoc_totnghieptruong[$i];
                }
                if (!empty($trinhdotinhoc_nam[$i])) {
                    $tinhoc[$i][] = $trinhdotinhoc_nam[$i];
                }
            }

            $data[$alias]['trinhdotinhoc'] = !empty($tinhoc) ? json_encode($tinhoc) : '';
        }

        //anhchiemruot
        //anhchiemvochong
        //vochongvacon

        //anhchiemruot
        if (isset($data[$alias]['anhchiemruot'])) {
            $anhchiemruot = $data[$alias]['anhchiemruot'];

            unset($anhchiemruot['anhchiemruot_quanhe'][0], $anhchiemruot['anhchiemruot_hoten'][0], $anhchiemruot['anhchiemruot_namsinh'][0], $anhchiemruot['anhchiemruot_nguyenquan'][0]);
            
            
            

            $anhchiemruot_quanhe = $anhchiemruot['anhchiemruot_quanhe'];
            $anhchiemruot_hoten = $anhchiemruot['anhchiemruot_hoten'];
            $anhchiemruot_namsinh = $anhchiemruot['anhchiemruot_namsinh'];
            $anhchiemruot_nguyenquan = $anhchiemruot['anhchiemruot_nguyenquan'];

            $count = count($anhchiemruot_quanhe);

            $arranhchiemruot = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($anhchiemruot_quanhe[$i])) {
                    $arranhchiemruot[$i][] = $anhchiemruot_quanhe[$i];
                }
                if (!empty($anhchiemruot_hoten[$i])) {
                    $arranhchiemruot[$i][] = $anhchiemruot_hoten[$i];
                }
                if (!empty($anhchiemruot_namsinh[$i])) {
                    $arranhchiemruot[$i][] = $anhchiemruot_namsinh[$i];
                }
                if (!empty($anhchiemruot_nguyenquan[$i])) {
                    $arranhchiemruot[$i][] = $anhchiemruot_nguyenquan[$i];
                }
            }

            $data[$alias]['anhchiemruot'] = !empty($arranhchiemruot) ? json_encode($arranhchiemruot) : '';
        }

        //anhchiemvochong
        if (isset($data[$alias]['anhchiemvochong'])) {
            $anhchiemvochong = $data[$alias]['anhchiemvochong'];

            unset($anhchiemvochong['anhchiemvochong_quanhe'][0], $anhchiemvochong['anhchiemvochong_hoten'][0], $anhchiemvochong['anhchiemvochong_namsinh'][0], $anhchiemvochong['anhchiemvochong_nguyenquan'][0]);
            
            
            

            $anhchiemvochong_quanhe = $anhchiemvochong['anhchiemvochong_quanhe'];
            $anhchiemvochong_hoten = $anhchiemvochong['anhchiemvochong_hoten'];
            $anhchiemvochong_namsinh = $anhchiemvochong['anhchiemvochong_namsinh'];
            $anhchiemvochong_nguyenquan = $anhchiemvochong['anhchiemvochong_nguyenquan'];

            $count = count($anhchiemvochong_quanhe);

            $arranhchiemvochong = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($anhchiemvochong_quanhe[$i])) {
                    $arranhchiemvochong[$i][] = $anhchiemvochong_quanhe[$i];
                }
                if (!empty($anhchiemvochong_hoten[$i])) {
                    $arranhchiemvochong[$i][] = $anhchiemvochong_hoten[$i];
                }
                if (!empty($anhchiemvochong_namsinh[$i])) {
                    $arranhchiemvochong[$i][] = $anhchiemvochong_namsinh[$i];
                }
                if (!empty($anhchiemvochong_nguyenquan[$i])) {
                    $arranhchiemvochong[$i][] = $anhchiemvochong_nguyenquan[$i];
                }
            }

            $data[$alias]['anhchiemvochong'] = !empty($arranhchiemvochong) ? json_encode($arranhchiemvochong) : '';
        }

        //vochongvacon
        if (isset($data[$alias]['vochongvacon'])) {
            $vochongvacon = $data[$alias]['vochongvacon'];

            unset($vochongvacon['vochongvacon_quanhe'][0], $vochongvacon['vochongvacon_hoten'][0], $vochongvacon['vochongvacon_namsinh'][0], $vochongvacon['vochongvacon_nguyenquan'][0]);
            
            
            

            $vochongvacon_quanhe = $vochongvacon['vochongvacon_quanhe'];
            $vochongvacon_hoten = $vochongvacon['vochongvacon_hoten'];
            $vochongvacon_namsinh = $vochongvacon['vochongvacon_namsinh'];
            $vochongvacon_nguyenquan = $vochongvacon['vochongvacon_nguyenquan'];

            $count = count($vochongvacon_quanhe);

            $arrvochongvacon = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($vochongvacon_quanhe[$i])) {
                    $arrvochongvacon[$i][] = $vochongvacon_quanhe[$i];
                }
                if (!empty($vochongvacon_hoten[$i])) {
                    $arrvochongvacon[$i][] = $vochongvacon_hoten[$i];
                }
                if (!empty($vochongvacon_namsinh[$i])) {
                    $arrvochongvacon[$i][] = $vochongvacon_namsinh[$i];
                }
                if (!empty($vochongvacon_nguyenquan[$i])) {
                    $arrvochongvacon[$i][] = $vochongvacon_nguyenquan[$i];
                }
            }

            $data[$alias]['vochongvacon'] = !empty($arrvochongvacon) ? json_encode($arrvochongvacon) : '';
        }

        //quatrinhhoatdongtongiaootrongnuoc
        //quatrinhhoatdongtongiaoongoainuoc

        //quatrinhhoatdongtongiaootrongnuoc
        if (isset($data[$alias]['quatrinhhoatdongtongiaootrongnuoc'])) {
            $quatrinhhoatdongtongiaootrongnuoc = $data[$alias]['quatrinhhoatdongtongiaootrongnuoc'];

            unset($quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_tungaythangnam'][0], $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_denngaythangnam'][0], $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_noihoatdong'][0], $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_chucvu'][0]);
            
            
            

            $qthdtqtn_tungaythangnam = $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_tungaythangnam'];
            $qthdtqtn_denngaythangnam = $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_denngaythangnam'];
            $qthdtqtn_noihoatdong = $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_noihoatdong'];
            $qthdtqtn_chucvu = $quatrinhhoatdongtongiaootrongnuoc['qthdtqtn_chucvu'];

            $count = count($qthdtqtn_tungaythangnam);

            $arrquatrinhhoatdongtongiaootrongnuoc = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($qthdtqtn_tungaythangnam[$i])) {
                    $arrquatrinhhoatdongtongiaootrongnuoc[$i][] = $qthdtqtn_tungaythangnam[$i];
                }
                if (!empty($qthdtqtn_denngaythangnam[$i])) {
                    $arrquatrinhhoatdongtongiaootrongnuoc[$i][] = $qthdtqtn_denngaythangnam[$i];
                }
                if (!empty($qthdtqtn_noihoatdong[$i])) {
                    $arrquatrinhhoatdongtongiaootrongnuoc[$i][] = $qthdtqtn_noihoatdong[$i];
                }
                if (!empty($qthdtqtn_chucvu[$i])) {
                    $arrquatrinhhoatdongtongiaootrongnuoc[$i][] = $qthdtqtn_chucvu[$i];
                }
            }

            $data[$alias]['quatrinhhoatdongtongiaootrongnuoc'] = !empty($arrquatrinhhoatdongtongiaootrongnuoc) ? json_encode($arrquatrinhhoatdongtongiaootrongnuoc) : '';
        }

        //quatrinhhoatdongtongiaoongoainuoc
        if (isset($data[$alias]['quatrinhhoatdongtongiaoongoainuoc'])) {
            $quatrinhhoatdongtongiaoongoainuoc = $data[$alias]['quatrinhhoatdongtongiaoongoainuoc'];

            unset($quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_tungaythangnam'][0], $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_denngaythangnam'][0], $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_noidunghoatdong'][0], $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_tennuocden'][0]);
            
            
            

            $qthdtqnn_tungaythangnam = $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_tungaythangnam'];
            $qthdtqnn_denngaythangnam = $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_denngaythangnam'];
            $qthdtqnn_noidunghoatdong = $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_noidunghoatdong'];
            $qthdtqnn_tennuocden = $quatrinhhoatdongtongiaoongoainuoc['qthdtqnn_tennuocden'];

            $count = count($qthdtqnn_tungaythangnam);

            $arrquatrinhhoatdongtongiaoongoainuoc = array();

            for ($i = 1; $i <= $count; $i++) {
                if (!empty($qthdtqnn_tungaythangnam[$i])) {
                    $arrquatrinhhoatdongtongiaoongoainuoc[$i][] = $qthdtqnn_tungaythangnam[$i];
                }
                if (!empty($qthdtqnn_denngaythangnam[$i])) {
                    $arrquatrinhhoatdongtongiaoongoainuoc[$i][] = $qthdtqnn_denngaythangnam[$i];
                }
                if (!empty($qthdtqnn_noidunghoatdong[$i])) {
                    $arrquatrinhhoatdongtongiaoongoainuoc[$i][] = $qthdtqnn_noidunghoatdong[$i];
                }
                if (!empty($qthdtqnn_tennuocden[$i])) {
                    $arrquatrinhhoatdongtongiaoongoainuoc[$i][] = $qthdtqnn_tennuocden[$i];
                }
            }

            $data[$alias]['quatrinhhoatdongtongiaoongoainuoc'] = !empty($arrquatrinhhoatdongtongiaoongoainuoc) ? json_encode($arrquatrinhhoatdongtongiaoongoainuoc) : '';
        }

        return $data;
    }

    public function convertDataView($data)
    {
        $alias = $this->alias;

        //trinhdohocvan
        if (isset($data[$alias]['trinhdohocvan'])) {
            $trinhdohocvan = $data[$alias]['trinhdohocvan'];

            $json_decode = json_decode($trinhdohocvan);
            /*print "<pre>";
            print_r($json_decode);
            print "</pre>";*/
        }

        return $data;
    }

    public function beforeSave($options = array())
    {
        $admin = CakeSession::read('admin');

        $this->data[$this->alias]['created_user'] = $admin['Admin']['id'];
    }

    public function getQueries()
    {
        $dbo = $this->getDatasource();
        $logs = $dbo->getLog();
        $queries = array();
        if (empty($logs) == false) {
            foreach ($logs['log'] as $log) {
                $queries[] = $log['query'];
            }
        }

        return $queries;
    }
}
