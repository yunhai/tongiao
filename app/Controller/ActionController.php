<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class ActionController extends AppController
{
    public $components = array('Utility');

    public function beforeFilter()
    {
        //parent::beforeFilter();
        $this->_type_text = array(
            TONG_HOP_CHUC_SAC => 'TONG HOP CHUC SAC',
            TONG_HOP_DAT_DAI => 'TONG HOP DAT DAI',
        );
    }

    public function createTable()
    {
        $this->resultModel = array();
        for ($i = 1; $i <= LIMIT_ARRAY_DATA; $i++) {
            if (!empty($this->result_table["array_{$i}"])) {
                foreach ($this->result_table["array_{$i}"] as $val) {
                    $this->getLast($val);
                }
            }
        }
        foreach ($this->result_table['cacThongTinKhac'] as $val) {
            $this->getLast($val);
        }
        foreach ($this->result_table['kienNghi'] as $val) {
            $this->getLast($val);
        }

        $this->TableHelper->table($this->nameTable, $this->resultModel);
        echo 'Sucessfull';
        exit;
    }

    public function addAjax($model = null, $fiedlAuto = '')
    {
        $is_error = 0;
        if (empty($model)) {
            $is_error = 1;
        }
        $this->model = $model;
        $this->fiedlAuto = explode(',', $fiedlAuto);
        $dataRequest = $this->request->data;
        $this->autoLayout = false;
        $this->autoRender = false;
        $this->response->type('json');
        if (empty($dataRequest[$this->model]['id'])) {
            $is_error = 1;
        }
        if ($is_error == 0) {
            $this->add($dataRequest[$this->model]['id'], 1);
        }

        return $this->response->body(json_encode(array(
                    'errors' => $is_error,
        )));
    }

    public function add($id = null, $is_ajax = 0)
    {
        $str = LOCAL_INSERT;
        if (!empty($id)) {
            $str = LOCAL_EDIT;
        }
        $model = $this->model;
        if ($this->request->is('post') || $this->request->is('put') || $is_ajax == 1) {
            $dataRequest = $this->request->data;
            $result = $this->TableHelper->decodeDataSave($dataRequest[$this->model], $this->fiedlAuto);
            APP::import('Model', $model);
            $this->$model = new $model();
            $this->$model->create();
            $result['is_add'] = 1;
            $res = $this->$model->save($result);
            if ($is_ajax == 0) {
                if ($res) {
                    $local = $str . ' ' . SUCCESSFULL;
                    $this->Session->setFlash(__("{$local}"), 'messages/flash_success');

                    return $this->redirect('index');
                } else {
                    $local = $str . ' ' . FAILED;
                    $this->Session->setFlash(__("{$local}"), 'messages/flash_error');
                }
            }
        } else {
            if ($is_ajax == 1) {
                return;
            }
            if (!empty($id)) {
                $data = $this->$model->find('first', array(
                    'conditions' => array(
                        "{$model}.id" => $id
                    )
                ));
                if (empty($data)) {
                    return $this->redirect('index');
                }
                $data[$this->model] = $this->TableHelper->encodeDataSave($data[$this->model], $this->fiedlAuto);
                $this->request->data = $data;
            } else {
                $result = array();
                $this->$model->create();
                $res = $this->$model->save($result);
                $this->request->data = $res;

                return $this->redirect(
                                array(
                                    'controller' => $this->controller,
                                    'action' => 'add',
                                    $res[$this->model]['id'],
                )
                );
            }
        }
        if ($is_ajax == 1) {
            return;
        }
        $title_for_layout = mb_strtolower($this->title_for_layout);
        $fiedlAuto = implode(',', $this->fiedlAuto);
        $this->set(array(
              'is_show_add' => 1,
            'fiedlAuto' => $fiedlAuto,
            'is_add' => !empty($this->request->data[$this->model]['is_add']) ? $this->request->data[$this->model]['is_add'] : 0,
            'title_for_layout' => "{$str} {$title_for_layout}",
        ));
    }

    public function index()
    {
        $model = $this->model;
        $admin = CakeSession::read('admin');

        //created_user
        $createdUser = $admin['Admin']['id'];
        $userName = $admin['Admin']['username'];

        $conditions[] = array(
            "{$model}.is_add" => true,
            //"{$model}.created_user" => $createdUser,
        );

        if ($userName != 'admin') {
            $conditions[] = array(
                "{$model}.created_user" => $createdUser,
            );
        }

        $order = '';
        if (!empty($this->request->query['search'])) {
            $search = $this->request->query['search'];
            $value = '';
            foreach ($this->showField as $val) {
                $value = $val;
                break;
            }

            if (!empty($value)) {
                $conditions[] = array(
                    "LOWER({$model}.{$value}) LIKE" => '%' . mb_strtolower($search) . '%'
                );
            }
        }
        $this->CustomPaginator->settings = array(
            'conditions' => $conditions,
            'order' => $order,
            'limit' => LIMIT_PAGE,
            'recurisve' => -1,
        );
        $data = $this->CustomPaginator->paginate($this->model);
        $result = array();
        foreach ($data as $val) {
            $result[] = $val;
        }
        $this->set(array(
            'showField' => $this->showField,
            'data' => $result,
            'search' => !empty($search) ? $search : '',
            'page' => $this->request->params['paging'][$this->model]['page'],
            'title_for_layout' => $this->title_for_layout,
        ));
        $this->render('../common/index');
    }

    public function delete($id = null)
    {
        $model = $this->model;
        $condition["{$model}.id"] = $id;
        $data = $this->$model->find('first', array(
            'conditions' => $condition,
        ));
        if (!empty($data)) {
            $this->$model->delete($id);
        }
        $local = LOCAL_DELETE . ' ' . SUCCESSFULL;
        $this->Session->setFlash(__("{$local}"), 'messages/flash_success');
        $this->redirect($this->referer());
    }

    public function download($type)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        //$this->test();
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . "template{$type}.xls";
        $filename = "{$this->_type_text[$type]}";
        $data = $this->{"__getType{$type}Data"}();
        $this->Excel->load($source);
        $this->Excel->setVariableArray($data);
        $this->Excel->compile();
        $this->Excel->save($filename);
    }

    //TONG HOP CHUC SAC
    protected function __getType0Data()
    {
        $data = array(
            //BIÊN HÒA
            'bienhoa_tongconggiao' => 900,'bienhoa_conggiao_tong' => 900, 'bienhoa_conggiao_giammuc' => 900,
            'bienhoa_conggiao_betrentongquyen' => 100,'bienhoa_conggiao_giamtinh' => 200,'bienhoa_conggiao_linhmuc' => 300,

            //LONG KHÁNH
            'longkhanh_tongconggiao' => 900,'longkhanh_conggiao_tong' => 900,'longkhanh_conggiao_giammuc' => 900,
            'longkhanh_conggiao_betrentongquyen' => 900,'longkhanh_conggiao_giamtinh' => 900,'longkhanh_conggiao_linhmuc' => 900,

            //XUÂN LỘC
            'xuanloc_tongconggiao' => 900,'xuanloc_conggiao_tong' => 900,'xuanloc_conggiao_giammuc' => 900,
            'xuanloc_conggiao_betrentongquyen' => 900,'xuanloc_conggiao_giamtinh' => 900,'xuanloc_conggiao_linhmuc' => 900,

            //CẨM MỸ
            'cammy_tongconggiao' => 900,'cammy_conggiao_tong' => 900,'cammy_conggiao_giammuc' => 900,
            'cammy_conggiao_betrentongquyen' => 900,'cammy_conggiao_giamtinh' => 900,'cammy_conggiao_linhmuc' => 900,

            //TÂN PHÚ
            'tanphu_tongconggiao' => 900,'tanphu_conggiao_tong' => 900,'tanphu_conggiao_giammuc' => 900,
            'tanphu_conggiao_betrentongquyen' => 900,'tanphu_conggiao_giamtinh' => 900,'tanphu_conggiao_linhmuc' => 900,

            //ĐỊNH QUÁN
            'dinhquan_tongconggiao' => 900,'dinhquan_conggiao_tong' => 900,'dinhquan_conggiao_giammuc' => 900,
            'dinhquan_conggiao_betrentongquyen' => 900,'dinhquan_conggiao_giamtinh' => 900,'dinhquan_conggiao_linhmuc' => 900,

            //THỐNG NHẤT
            'thongnhat_tongconggiao' => 900,'thongnhat_conggiao_tong' => 900,'thongnhat_conggiao_giammuc' => 900,
            'thongnhat_conggiao_betrentongquyen' => 900,'thongnhat_conggiao_giamtinh' => 900,'thongnhat_conggiao_linhmuc' => 900,

            //TRẢNG BOM
            'trangbom_tongconggiao' => 900,'trangbom_conggiao_tong' => 900,'trangbom_conggiao_giammuc' => 900,
            'trangbom_conggiao_betrentongquyen' => 900,'trangbom_conggiao_giamtinh' => 900,'trangbom_conggiao_linhmuc' => 900,

            //VĨNH CỬU
            'vinhcuu_tongconggiao' => 900,'vinhcuu_conggiao_tong' => 900,'vinhcuu_conggiao_giammuc' => 900,
            'vinhcuu_conggiao_betrentongquyen' => 900,'vinhcuu_conggiao_giamtinh' => 900,'vinhcuu_conggiao_linhmuc' => 900,

            //NHƠN TRẠCH
            'nhontrach_tongconggiao' => 900,'nhontrach_conggiao_tong' => 900,'nhontrach_conggiao_giammuc' => 900,
            'nhontrach_conggiao_betrentongquyen' => 900,'nhontrach_conggiao_giamtinh' => 900,'nhontrach_conggiao_linhmuc' => 900,

            //LONG THÀNH
            'longthanh_tongconggiao' => 900,'longthanh_conggiao_tong' => 900,'longthanh_conggiao_giammuc' => 900,
            'longthanh_conggiao_betrentongquyen' => 900,'longthanh_conggiao_giamtinh' => 900,'longthanh_conggiao_linhmuc' => 900,
        );

        return $data;
    }

    //tổng hop dat dai
    protected function __getType1Data()
    {
        $result = $this->test2();

        $data = array(
            /*BIÊN HÒA*/
            //SỐ DIỆN TÍCH ĐẤT
            'bienhoa_tongdt' => $result['bien-hoa']['3'],//$bienhoa_tongdt,
            'bienhoa_sodientichdat_dacapgcn_tong' => $result['bien-hoa']['4'],//$bienhoa_sodientichdat_dacapgcn_tong,
            'bienhoa_sodientichdat_dacapgcn_tongiao' => $result['bien-hoa']['5'],//$bienhoa_sodientichdat_dacapgcn_tongiao,
            'bienhoa_sodientichdat_dacapgcn_khac' => $result['bien-hoa']['6'],//$bienhoa_sodientichdat_dacapgcn_khac,
            'bienhoa_sodientichdat_chuacapgcn' => $result['bien-hoa']['7'],//$bienhoa_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'bienhoa_congiao_tongdt' => $result['bien-hoa']['8'],//$bienhoa_congiao_tongdt,
            'bienhoa_congiao_dacapgcn_tongiao' => $result['bien-hoa']['9'],//$bienhoa_congiao_dacapgcn_tongiao,
            'bienhoa_congiao_dacapgcn_khac' => $result['bien-hoa']['10'],//$bienhoa_congiao_dacapgcn_khac,
            'bienhoa_congiao_chuacapgcn' => $result['bien-hoa']['11'],$bienhoa_congiao_chuacapgcn,
            //PHẬT GIÁO
            'bienhoa_phatgiao_tongdt' => $result['bien-hoa']['12'],//$bienhoa_phatgiao_tongdt,
            'bienhoa_phatgiao_dacapgcn_tongiao' => $result['bien-hoa']['13'],//$bienhoa_phatgiao_dacapgcn_tongiao,
            'bienhoa_phatgiao_dacapgcn_khac' => $result['bien-hoa']['14'],//$bienhoa_phatgiao_dacapgcn_khac,
            'bienhoa_phatgiao_chuacapgcn' => $result['bien-hoa']['15'],//$bienhoa_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'bienhoa_caodai_tongdt' => $result['bien-hoa']['16'],//$bienhoa_caodai_tongdt,
            'bienhoa_caodai_dacapgcn_tongiao' => $result['bien-hoa']['17'],//$bienhoa_caodai_dacapgcn_tongiao,
            'bienhoa_caodai_dacapgcn_khac' => $result['bien-hoa']['18'],//$bienhoa_caodai_dacapgcn_khac,
            'bienhoa_caodai_chuacapgcn' => $result['bien-hoa']['19'],//$bienhoa_caodai_chuacapgcn,
            //TĐCSPHVN
            'bienhoa_tdcsphvn_tongdt' => $result['bien-hoa']['20'],//$bienhoa_tdcsphvn_tongdt,
            'bienhoa_tdcsphvn_dacapgcn_tongiao' => $result['bien-hoa']['21'],//$bienhoa_tdcsphvn_dacapgcn_tongiao,
            'bienhoa_tdcsphvn_dacapgcn_khac' => $result['bien-hoa']['22'],//$bienhoa_tdcsphvn_dacapgcn_khac,
            'bienhoa_tdcsphvn_chuacapgcn' => $result['bien-hoa']['23'],//$bienhoa_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'bienhoa_hoigiao_tongdt' => $result['bien-hoa']['24'],//$bienhoa_hoigiao_tongdt,
            'bienhoa_hoigiao_dacapgcn_tongiao' => $result['bien-hoa']['25'],//$bienhoa_hoigiao_dacapgcn_tongiao,
            'bienhoa_hoigiao_dacapgcn_khac' => $result['bien-hoa']['26'],//$bienhoa_hoigiao_dacapgcn_khac,
            'bienhoa_hoigiao_chuacapgcn' => $result['bien-hoa']['27'],//$bienhoa_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'bienhoa_phatgiaohoahao_tongdt' => 0, //$bienhoa_phatgiaohoahao_tongdt,
            'bienhoa_phatgiaohoahao_dacapgcn_tongiao' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_tongiao,
            'bienhoa_phatgiaohoahao_dacapgcn_khac' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_khac,
            'bienhoa_phatgiaohoahao_chuacapgcn' => 0, //$bienhoa_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'bienhoa_tinnguong_tongdt' => $result['bien-hoa']['32'],//$bienhoa_tinnguong_tongdt,
            'bienhoa_tinnguong_dacapgcn_tongiao' => $result['bien-hoa']['33'],//$bienhoa_tinnguong_dacapgcn_tongiao,
            'bienhoa_tinnguong_dacapgcn_khac' => $result['bien-hoa']['34'],//$bienhoa_tinnguong_dacapgcn_khac,
            'bienhoa_tinnguong_chuacapgcn' => $result['bien-hoa']['35'],//$bienhoa_tinnguong_chuacapgcn,

            /*LONG KHÁNH*/
            'longkhanh_tongdt' => $result['long-khanh']['3'],//$longkhanh_tongdt,
            'longkhanh_sodientichdat_dacapgcn_tong' => $result['long-khanh']['4'],//$longkhanh_sodientichdat_dacapgcn_tong,
            'longkhanh_sodientichdat_dacapgcn_tongiao' => $result['long-khanh']['5'],//$longkhanh_sodientichdat_dacapgcn_tongiao,
            'longkhanh_sodientichdat_dacapgcn_khac' => $result['long-khanh']['6'],//$longkhanh_sodientichdat_dacapgcn_khac,
            'longkhanh_sodientichdat_chuacapgcn' => $result['long-khanh']['7'],//$longkhanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longkhanh_congiao_tongdt' => $result['long-khanh']['8'],//$longkhanh_congiao_tongdt,
            'longkhanh_congiao_dacapgcn_tongiao' => $result['long-khanh']['9'],//$longkhanh_congiao_dacapgcn_tongiao,
            'longkhanh_congiao_dacapgcn_khac' => $result['long-khanh']['10'],//$longkhanh_congiao_dacapgcn_khac,
            'longkhanh_congiao_chuacapgcn' => $result['long-khanh']['11'],//$longkhanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longkhanh_phatgiao_tongdt' => $result['long-khanh']['12'],//$longkhanh_phatgiao_tongdt,
            'longkhanh_phatgiao_dacapgcn_tongiao' => $result['long-khanh']['13'],//$longkhanh_phatgiao_dacapgcn_tongiao,
            'longkhanh_phatgiao_dacapgcn_khac' => $result['long-khanh']['14'],//$longkhanh_phatgiao_dacapgcn_khac,
            'longkhanh_phatgiao_chuacapgcn' => $result['long-khanh']['15'],//$longkhanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longkhanh_caodai_tongdt' => $result['long-khanh']['16'],//$longkhanh_caodai_tongdt,
            'longkhanh_caodai_dacapgcn_tongiao' => $result['long-khanh']['17'],//$longkhanh_caodai_dacapgcn_tongiao,
            'longkhanh_caodai_dacapgcn_khac' => $result['long-khanh']['18'],//$longkhanh_caodai_dacapgcn_khac,
            'longkhanh_caodai_chuacapgcn' => $result['long-khanh']['19'],//$longkhanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longkhanh_tdcsphvn_tongdt' => $result['long-khanh']['20'],//$longkhanh_tdcsphvn_tongdt,
            'longkhanh_tdcsphvn_dacapgcn_tongiao' => $result['long-khanh']['21'],//$longkhanh_tdcsphvn_dacapgcn_tongiao,
            'longkhanh_tdcsphvn_dacapgcn_khac' => $result['long-khanh']['22'],//$longkhanh_tdcsphvn_dacapgcn_khac,
            'longkhanh_tdcsphvn_chuacapgcn' => $result['long-khanh']['23'],//$longkhanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longkhanh_hoigiao_tongdt' => $result['long-khanh']['24'],//$longkhanh_hoigiao_tongdt,
            'longkhanh_hoigiao_dacapgcn_tongiao' => $result['long-khanh']['25'],//$longkhanh_hoigiao_dacapgcn_tongiao,
            'longkhanh_hoigiao_dacapgcn_khac' => $result['long-khanh']['26'],//$longkhanh_hoigiao_dacapgcn_khac,
            'longkhanh_hoigiao_chuacapgcn' => $result['long-khanh']['27'],//$longkhanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longkhanh_phatgiaohoahao_tongdt' => 0, //$longkhanh_phatgiaohoahao_tongdt,
            'longkhanh_phatgiaohoahao_dacapgcn_tongiao' => 0, //$longkhanh_phatgiaohoahao_dacapgcn_tongiao,
            'longkhanh_phatgiaohoahao_dacapgcn_khac' => 0, //$longkhanh_phatgiaohoahao_dacapgcn_khac,
            'longkhanh_phatgiaohoahao_chuacapgcn' => 0, //$longkhanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longkhanh_tinnguong_tongdt' => $result['long-khanh']['32'],//$longkhanh_tinnguong_tongdt,
            'longkhanh_tinnguong_dacapgcn_tongiao' => $result['long-khanh']['33'],//$longkhanh_tinnguong_dacapgcn_tongiao,
            'longkhanh_tinnguong_dacapgcn_khac' => $result['long-khanh']['34'],//$longkhanh_tinnguong_dacapgcn_khac,
            'longkhanh_tinnguong_chuacapgcn' => $result['long-khanh']['35'],//$longkhanh_tinnguong_chuacapgcn,

            /*XUÂN LỘC*/
            'xuanloc_tongdt' => $result['xuan-loc']['3'],//$xuanloc_tongdt,
            'xuanloc_sodientichdat_dacapgcn_tong' => $result['xuan-loc']['4'],//$xuanloc_sodientichdat_dacapgcn_tong,
            'xuanloc_sodientichdat_dacapgcn_tongiao' => $result['xuan-loc']['5'],//$xuanloc_sodientichdat_dacapgcn_tongiao,
            'xuanloc_sodientichdat_dacapgcn_khac' => $result['xuan-loc']['6'],//$xuanloc_sodientichdat_dacapgcn_khac,
            'xuanloc_sodientichdat_chuacapgcn' => $result['xuan-loc']['7'],//$xuanloc_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'xuanloc_congiao_tongdt' => $result['xuan-loc']['8'],//$xuanloc_congiao_tongdt,
            'xuanloc_congiao_dacapgcn_tongiao' => $result['xuan-loc']['9'],//$xuanloc_congiao_dacapgcn_tongiao,
            'xuanloc_congiao_dacapgcn_khac' => $result['xuan-loc']['10'],//$xuanloc_congiao_dacapgcn_khac,
            'xuanloc_congiao_chuacapgcn' => $result['xuan-loc']['11'],//$xuanloc_congiao_chuacapgcn,
            //PHẬT GIÁO
            'xuanloc_phatgiao_tongdt' => $result['xuan-loc']['12'],//$xuanloc_phatgiao_tongdt,
            'xuanloc_phatgiao_dacapgcn_tongiao' => $result['xuan-loc']['13'],//$xuanloc_phatgiao_dacapgcn_tongiao,
            'xuanloc_phatgiao_dacapgcn_khac' => $result['xuan-loc']['14'],//$xuanloc_phatgiao_dacapgcn_khac,
            'xuanloc_phatgiao_chuacapgcn' => $result['xuan-loc']['15'],//$xuanloc_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'xuanloc_caodai_tongdt' => $result['xuan-loc']['16'],//$xuanloc_caodai_tongdt,
            'xuanloc_caodai_dacapgcn_tongiao' => $result['xuan-loc']['17'],//$xuanloc_caodai_dacapgcn_tongiao,
            'xuanloc_caodai_dacapgcn_khac' => $result['xuan-loc']['18'],//$xuanloc_caodai_dacapgcn_khac,
            'xuanloc_caodai_chuacapgcn' => $result['xuan-loc']['19'],//$xuanloc_caodai_chuacapgcn,
            //TĐCSPHVN
            'xuanloc_tdcsphvn_tongdt' => $result['xuan-loc']['20'],//$xuanloc_tdcsphvn_tongdt,
            'xuanloc_tdcsphvn_dacapgcn_tongiao' => $result['xuan-loc']['21'],//$xuanloc_tdcsphvn_dacapgcn_tongiao,
            'xuanloc_tdcsphvn_dacapgcn_khac' => $result['xuan-loc']['22'],//$xuanloc_tdcsphvn_dacapgcn_khac,
            'xuanloc_tdcsphvn_chuacapgcn' => $result['xuan-loc']['23'],//$xuanloc_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'xuanloc_hoigiao_tongdt' => $result['xuan-loc']['24'],//$xuanloc_hoigiao_tongdt,
            'xuanloc_hoigiao_dacapgcn_tongiao' => $result['xuan-loc']['25'],//$xuanloc_hoigiao_dacapgcn_tongiao,
            'xuanloc_hoigiao_dacapgcn_khac' => $result['xuan-loc']['26'],//$xuanloc_hoigiao_dacapgcn_khac,
            'xuanloc_hoigiao_chuacapgcn' => $result['xuan-loc']['27'],//$xuanloc_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'xuanloc_phatgiaohoahao_tongdt' => 0, //$xuanloc_phatgiaohoahao_tongdt,
            'xuanloc_phatgiaohoahao_dacapgcn_tongiao' => 0, //$xuanloc_phatgiaohoahao_dacapgcn_tongiao,
            'xuanloc_phatgiaohoahao_dacapgcn_khac' => 0, //$xuanloc_phatgiaohoahao_dacapgcn_khac,
            'xuanloc_phatgiaohoahao_chuacapgcn' => 0, //$xuanloc_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'xuanloc_tinnguong_tongdt' => $result['xuan-loc']['32'],//$xuanloc_tinnguong_tongdt,
            'xuanloc_tinnguong_dacapgcn_tongiao' => $result['xuan-loc']['33'],//$xuanloc_tinnguong_dacapgcn_tongiao,
            'xuanloc_tinnguong_dacapgcn_khac' => $result['xuan-loc']['34'],//$xuanloc_tinnguong_dacapgcn_khac,
            'xuanloc_tinnguong_chuacapgcn' => $result['xuan-loc']['35'],//$xuanloc_tinnguong_chuacapgcn,

            /*CẨM MỸ*/
            'cammy_tongdt' => $result['cam-my']['3'],//$cammy_tongdt,
            'cammy_sodientichdat_dacapgcn_tong' => $result['cam-my']['4'],//$cammy_sodientichdat_dacapgcn_tong,
            'cammy_sodientichdat_dacapgcn_tongiao' => $result['cam-my']['5'],//$cammy_sodientichdat_dacapgcn_tongiao,
            'cammy_sodientichdat_dacapgcn_khac' => $result['cam-my']['6'],//$cammy_sodientichdat_dacapgcn_khac,
            'cammy_sodientichdat_chuacapgcn' => $result['cam-my']['7'],//$cammy_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'cammy_congiao_tongdt' => $result['cam-my']['8'],//$cammy_congiao_tongdt,
            'cammy_congiao_dacapgcn_tongiao' => $result['cam-my']['9'],//$cammy_congiao_dacapgcn_tongiao,
            'cammy_congiao_dacapgcn_khac' => $result['cam-my']['10'],//$cammy_congiao_dacapgcn_khac,
            'cammy_congiao_chuacapgcn' => $result['cam-my']['11'],//$cammy_congiao_chuacapgcn,
            //PHẬT GIÁO
            'cammy_phatgiao_tongdt' => $result['cam-my']['12'],//$cammy_phatgiao_tongdt,
            'cammy_phatgiao_dacapgcn_tongiao' => $result['cam-my']['13'],//$cammy_phatgiao_dacapgcn_tongiao,
            'cammy_phatgiao_dacapgcn_khac' => $result['cam-my']['14'],//$cammy_phatgiao_dacapgcn_khac,
            'cammy_phatgiao_chuacapgcn' => $result['cam-my']['15'],//$cammy_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'cammy_caodai_tongdt' => $result['cam-my']['16'],//$cammy_caodai_tongdt,
            'cammy_caodai_dacapgcn_tongiao' => $result['cam-my']['17'],//$cammy_caodai_dacapgcn_tongiao,
            'cammy_caodai_dacapgcn_khac' => $result['cam-my']['18'],//$cammy_caodai_dacapgcn_khac,
            'cammy_caodai_chuacapgcn' => $result['cam-my']['19'],//$cammy_caodai_chuacapgcn,
            //TĐCSPHVN
            'cammy_tdcsphvn_tongdt' => $result['cam-my']['20'],//$cammy_tdcsphvn_tongdt,
            'cammy_tdcsphvn_dacapgcn_tongiao' => $result['cam-my']['21'],//$cammy_tdcsphvn_dacapgcn_tongiao,
            'cammy_tdcsphvn_dacapgcn_khac' => $result['cam-my']['22'],//$cammy_tdcsphvn_dacapgcn_khac,
            'cammy_tdcsphvn_chuacapgcn' => $result['cam-my']['23'],//$cammy_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'cammy_hoigiao_tongdt' => $result['cam-my']['24'],//$cammy_hoigiao_tongdt,
            'cammy_hoigiao_dacapgcn_tongiao' => $result['cam-my']['25'],//$cammy_hoigiao_dacapgcn_tongiao,
            'cammy_hoigiao_dacapgcn_khac' => $result['cam-my']['26'],//$cammy_hoigiao_dacapgcn_khac,
            'cammy_hoigiao_chuacapgcn' => $result['cam-my']['27'],//$cammy_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'cammy_phatgiaohoahao_tongdt' => 0, //$cammy_phatgiaohoahao_tongdt,
            'cammy_phatgiaohoahao_dacapgcn_tongiao' => 0, //$cammy_phatgiaohoahao_dacapgcn_tongiao,
            'cammy_phatgiaohoahao_dacapgcn_khac' => 0, //$cammy_phatgiaohoahao_dacapgcn_khac,
            'cammy_phatgiaohoahao_chuacapgcn' => 0, //$cammy_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'cammy_tinnguong_tongdt' => $result['cam-my']['32'],//$cammy_tinnguong_tongdt,
            'cammy_tinnguong_dacapgcn_tongiao' => $result['cam-my']['33'],//$cammy_tinnguong_dacapgcn_tongiao,
            'cammy_tinnguong_dacapgcn_khac' => $result['cam-my']['34'],//$cammy_tinnguong_dacapgcn_khac,
            'cammy_tinnguong_chuacapgcn' => $result['cam-my']['35'],//$cammy_tinnguong_chuacapgcn,

            /*TÂN PHÚ*/
            'tanphu_tongdt' => $result['tan-phu']['3'],//$tanphu_tongdt,
            'tanphu_sodientichdat_dacapgcn_tong' => $result['tan-phu']['4'],//$tanphu_sodientichdat_dacapgcn_tong,
            'tanphu_sodientichdat_dacapgcn_tongiao' => $result['tan-phu']['5'],//$tanphu_sodientichdat_dacapgcn_tongiao,
            'tanphu_sodientichdat_dacapgcn_khac' => $result['tan-phu']['6'],//$tanphu_sodientichdat_dacapgcn_khac,
            'tanphu_sodientichdat_chuacapgcn' => $result['tan-phu']['7'],//$tanphu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'tanphu_congiao_tongdt' => $result['tan-phu']['8'],//$tanphu_congiao_tongdt,
            'tanphu_congiao_dacapgcn_tongiao' => $result['tan-phu']['9'],//$tanphu_congiao_dacapgcn_tongiao,
            'tanphu_congiao_dacapgcn_khac' => $result['tan-phu']['10'],//$tanphu_congiao_dacapgcn_khac,
            'tanphu_congiao_chuacapgcn' => $result['tan-phu']['11'],//$tanphu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'tanphu_phatgiao_tongdt' => $result['tan-phu']['12'],//$tanphu_phatgiao_tongdt,
            'tanphu_phatgiao_dacapgcn_tongiao' => $result['tan-phu']['13'],//$tanphu_phatgiao_dacapgcn_tongiao,
            'tanphu_phatgiao_dacapgcn_khac' => $result['tan-phu']['14'],//$tanphu_phatgiao_dacapgcn_khac,
            'tanphu_phatgiao_chuacapgcn' => $result['tan-phu']['15'],//$tanphu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'tanphu_caodai_tongdt' => $result['tan-phu']['16'],//$tanphu_caodai_tongdt,
            'tanphu_caodai_dacapgcn_tongiao' => $result['tan-phu']['17'],//$tanphu_caodai_dacapgcn_tongiao,
            'tanphu_caodai_dacapgcn_khac' => $result['tan-phu']['18'],//$tanphu_caodai_dacapgcn_khac,
            'tanphu_caodai_chuacapgcn' => $result['tan-phu']['19'],//$tanphu_caodai_chuacapgcn,
            //TĐCSPHVN
            'tanphu_tdcsphvn_tongdt' => $result['tan-phu']['20'],//$tanphu_tdcsphvn_tongdt,
            'tanphu_tdcsphvn_dacapgcn_tongiao' => $result['tan-phu']['21'],//$tanphu_tdcsphvn_dacapgcn_tongiao,
            'tanphu_tdcsphvn_dacapgcn_khac' => $result['tan-phu']['22'],//$tanphu_tdcsphvn_dacapgcn_khac,
            'tanphu_tdcsphvn_chuacapgcn' => $result['tan-phu']['23'],//$tanphu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'tanphu_hoigiao_tongdt' => $result['tan-phu']['24'],//$tanphu_hoigiao_tongdt,
            'tanphu_hoigiao_dacapgcn_tongiao' => $result['tan-phu']['25'],//$tanphu_hoigiao_dacapgcn_tongiao,
            'tanphu_hoigiao_dacapgcn_khac' => $result['tan-phu']['26'],//$tanphu_hoigiao_dacapgcn_khac,
            'tanphu_hoigiao_chuacapgcn' => $result['tan-phu']['27'],//$tanphu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'tanphu_phatgiaohoahao_tongdt' => 0, //$tanphu_phatgiaohoahao_tongdt,
            'tanphu_phatgiaohoahao_dacapgcn_tongiao' => 0, //$tanphu_phatgiaohoahao_dacapgcn_tongiao,
            'tanphu_phatgiaohoahao_dacapgcn_khac' => 0, //$tanphu_phatgiaohoahao_dacapgcn_khac,
            'tanphu_phatgiaohoahao_chuacapgcn' => 0, //$tanphu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'tanphu_tinnguong_tongdt' => $result['tan-phu']['32'],//$tanphu_tinnguong_tongdt,
            'tanphu_tinnguong_dacapgcn_tongiao' => $result['tan-phu']['33'],//$tanphu_tinnguong_dacapgcn_tongiao,
            'tanphu_tinnguong_dacapgcn_khac' => $result['tan-phu']['34'],//$tanphu_tinnguong_dacapgcn_khac,
            'tanphu_tinnguong_chuacapgcn' => $result['tan-phu']['35'],//$tanphu_tinnguong_chuacapgcn,

            /*ĐỊNH QUÁN*/
            'dinhquan_tongdt' => $result['dinh-quan']['3'],//$dinhquan_tongdt,
            'dinhquan_sodientichdat_dacapgcn_tong' => $result['dinh-quan']['4'],//$dinhquan_sodientichdat_dacapgcn_tong,
            'dinhquan_sodientichdat_dacapgcn_tongiao' => $result['dinh-quan']['5'],//$dinhquan_sodientichdat_dacapgcn_tongiao,
            'dinhquan_sodientichdat_dacapgcn_khac' => $result['dinh-quan']['6'],//$dinhquan_sodientichdat_dacapgcn_khac,
            'dinhquan_sodientichdat_chuacapgcn' => $result['dinh-quan']['7'],//$dinhquan_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'dinhquan_congiao_tongdt' => $result['dinh-quan']['8'],//$dinhquan_congiao_tongdt,
            'dinhquan_congiao_dacapgcn_tongiao' => $result['dinh-quan']['9'],//$dinhquan_congiao_dacapgcn_tongiao,
            'dinhquan_congiao_dacapgcn_khac' => $result['dinh-quan']['10'],//$dinhquan_congiao_dacapgcn_khac,
            'dinhquan_congiao_chuacapgcn' => $result['dinh-quan']['11'],//$dinhquan_congiao_chuacapgcn,
            //PHẬT GIÁO
            'dinhquan_phatgiao_tongdt' => $result['dinh-quan']['12'],//$dinhquan_phatgiao_tongdt,
            'dinhquan_phatgiao_dacapgcn_tongiao' => $result['dinh-quan']['13'],//$dinhquan_phatgiao_dacapgcn_tongiao,
            'dinhquan_phatgiao_dacapgcn_khac' => $result['dinh-quan']['14'],//$dinhquan_phatgiao_dacapgcn_khac,
            'dinhquan_phatgiao_chuacapgcn' => $result['dinh-quan']['15'],//$dinhquan_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'dinhquan_caodai_tongdt' => $result['dinh-quan']['16'],//$dinhquan_caodai_tongdt,
            'dinhquan_caodai_dacapgcn_tongiao' => $result['dinh-quan']['17'],//$dinhquan_caodai_dacapgcn_tongiao,
            'dinhquan_caodai_dacapgcn_khac' => $result['dinh-quan']['18'],//$dinhquan_caodai_dacapgcn_khac,
            'dinhquan_caodai_chuacapgcn' => $result['dinh-quan']['19'],//$dinhquan_caodai_chuacapgcn,
            //TĐCSPHVN
            'dinhquan_tdcsphvn_tongdt' => $result['dinh-quan']['20'],//$dinhquan_tdcsphvn_tongdt,
            'dinhquan_tdcsphvn_dacapgcn_tongiao' => $result['dinh-quan']['21'],//$dinhquan_tdcsphvn_dacapgcn_tongiao,
            'dinhquan_tdcsphvn_dacapgcn_khac' => $result['dinh-quan']['22'],//$dinhquan_tdcsphvn_dacapgcn_khac,
            'dinhquan_tdcsphvn_chuacapgcn' => $result['dinh-quan']['23'],//$dinhquan_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'dinhquan_hoigiao_tongdt' => $result['dinh-quan']['24'],//$dinhquan_hoigiao_tongdt,
            'dinhquan_hoigiao_dacapgcn_tongiao' => $result['dinh-quan']['25'],//$dinhquan_hoigiao_dacapgcn_tongiao,
            'dinhquan_hoigiao_dacapgcn_khac' => $result['dinh-quan']['26'],//$dinhquan_hoigiao_dacapgcn_khac,
            'dinhquan_hoigiao_chuacapgcn' => $result['dinh-quan']['27'],//$dinhquan_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'dinhquan_phatgiaohoahao_tongdt' => 0, //$dinhquan_phatgiaohoahao_tongdt,
            'dinhquan_phatgiaohoahao_dacapgcn_tongiao' => 0, //$dinhquan_phatgiaohoahao_dacapgcn_tongiao,
            'dinhquan_phatgiaohoahao_dacapgcn_khac' => 0, //$dinhquan_phatgiaohoahao_dacapgcn_khac,
            'dinhquan_phatgiaohoahao_chuacapgcn' => 0, //$dinhquan_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'dinhquan_tinnguong_tongdt' => $result['dinh-quan']['32'],//$dinhquan_tinnguong_tongdt,
            'dinhquan_tinnguong_dacapgcn_tongiao' => $result['dinh-quan']['33'],//$dinhquan_tinnguong_dacapgcn_tongiao,
            'dinhquan_tinnguong_dacapgcn_khac' => $result['dinh-quan']['34'],//$dinhquan_tinnguong_dacapgcn_khac,
            'dinhquan_tinnguong_chuacapgcn' => $result['dinh-quan']['35'],//$dinhquan_tinnguong_chuacapgcn,

            /*THỐNG NHẤT*/
            'thongnhat_tongdt' => $result['thong-nhat']['3'],//$thongnhat_tongdt,
            'thongnhat_sodientichdat_dacapgcn_tong' => $result['thong-nhat']['4'],//$thongnhat_sodientichdat_dacapgcn_tong,
            'thongnhat_sodientichdat_dacapgcn_tongiao' => $result['thong-nhat']['5'],//$thongnhat_sodientichdat_dacapgcn_tongiao,
            'thongnhat_sodientichdat_dacapgcn_khac' => $result['thong-nhat']['6'],//$thongnhat_sodientichdat_dacapgcn_khac,
            'thongnhat_sodientichdat_chuacapgcn' => $result['thong-nhat']['7'],//$thongnhat_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'thongnhat_congiao_tongdt' => $result['thong-nhat']['8'],//$thongnhat_congiao_tongdt,
            'thongnhat_congiao_dacapgcn_tongiao' => $result['thong-nhat']['9'],//$thongnhat_congiao_dacapgcn_tongiao,
            'thongnhat_congiao_dacapgcn_khac' => $result['thong-nhat']['10'],//$thongnhat_congiao_dacapgcn_khac,
            'thongnhat_congiao_chuacapgcn' => $result['thong-nhat']['11'],//$thongnhat_congiao_chuacapgcn,
            //PHẬT GIÁO
            'thongnhat_phatgiao_tongdt' => $result['thong-nhat']['12'],//$thongnhat_phatgiao_tongdt,
            'thongnhat_phatgiao_dacapgcn_tongiao' => $result['thong-nhat']['13'],//$thongnhat_phatgiao_dacapgcn_tongiao,
            'thongnhat_phatgiao_dacapgcn_khac' => $result['thong-nhat']['14'],//$thongnhat_phatgiao_dacapgcn_khac,
            'thongnhat_phatgiao_chuacapgcn' => $result['thong-nhat']['15'],//$thongnhat_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'thongnhat_caodai_tongdt' => $result['thong-nhat']['16'],//$thongnhat_caodai_tongdt,
            'thongnhat_caodai_dacapgcn_tongiao' => $result['thong-nhat']['17'],//$thongnhat_caodai_dacapgcn_tongiao,
            'thongnhat_caodai_dacapgcn_khac' => $result['thong-nhat']['18'],//$thongnhat_caodai_dacapgcn_khac,
            'thongnhat_caodai_chuacapgcn' => $result['thong-nhat']['19'],//$thongnhat_caodai_chuacapgcn,
            //TĐCSPHVN
            'thongnhat_tdcsphvn_tongdt' => $result['thong-nhat']['20'],//$thongnhat_tdcsphvn_tongdt,
            'thongnhat_tdcsphvn_dacapgcn_tongiao' => $result['thong-nhat']['21'],//$thongnhat_tdcsphvn_dacapgcn_tongiao,
            'thongnhat_tdcsphvn_dacapgcn_khac' => $result['thong-nhat']['22'],//$thongnhat_tdcsphvn_dacapgcn_khac,
            'thongnhat_tdcsphvn_chuacapgcn' => $result['thong-nhat']['23'],//$thongnhat_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'thongnhat_hoigiao_tongdt' => $result['thong-nhat']['24'],//$thongnhat_hoigiao_tongdt,
            'thongnhat_hoigiao_dacapgcn_tongiao' => $result['thong-nhat']['25'],//$thongnhat_hoigiao_dacapgcn_tongiao,
            'thongnhat_hoigiao_dacapgcn_khac' => $result['thong-nhat']['26'],//$thongnhat_hoigiao_dacapgcn_khac,
            'thongnhat_hoigiao_chuacapgcn' => $result['thong-nhat']['27'],//$thongnhat_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'thongnhat_phatgiaohoahao_tongdt' => 0, //$thongnhat_phatgiaohoahao_tongdt,
            'thongnhat_phatgiaohoahao_dacapgcn_tongiao' => 0, // $thongnhat_phatgiaohoahao_dacapgcn_tongiao,
            'thongnhat_phatgiaohoahao_dacapgcn_khac' => 0, //$thongnhat_phatgiaohoahao_dacapgcn_khac,
            'thongnhat_phatgiaohoahao_chuacapgcn' => 0, //$thongnhat_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'thongnhat_tinnguong_tongdt' => $result['thong-nhat']['32'],//$thongnhat_tinnguong_tongdt,
            'thongnhat_tinnguong_dacapgcn_tongiao' => $result['thong-nhat']['33'],//$thongnhat_tinnguong_dacapgcn_tongiao,
            'thongnhat_tinnguong_dacapgcn_khac' => $result['thong-nhat']['34'],//$thongnhat_tinnguong_dacapgcn_khac,
            'thongnhat_tinnguong_chuacapgcn' => $result['thong-nhat']['35'],//$thongnhat_tinnguong_chuacapgcn,

            /*TRẢNG BOM*/
            'trangbom_tongdt' => $result['trang-bom']['3'],//$trangbom_tongdt,
            'trangbom_sodientichdat_dacapgcn_tong' => $result['trang-bom']['4'],//$trangbom_sodientichdat_dacapgcn_tong,
            'trangbom_sodientichdat_dacapgcn_tongiao' => $result['trang-bom']['5'],//$trangbom_sodientichdat_dacapgcn_tongiao,
            'trangbom_sodientichdat_dacapgcn_khac' => $result['trang-bom']['6'],//$trangbom_sodientichdat_dacapgcn_khac,
            'trangbom_sodientichdat_chuacapgcn' => $result['trang-bom']['7'],//$trangbom_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'trangbom_congiao_tongdt' => $result['trang-bom']['8'],//$trangbom_congiao_tongdt,
            'trangbom_congiao_dacapgcn_tongiao' => $result['trang-bom']['9'],//$trangbom_congiao_dacapgcn_tongiao,
            'trangbom_congiao_dacapgcn_khac' => $result['trang-bom']['10'],//$trangbom_congiao_dacapgcn_khac,
            'trangbom_congiao_chuacapgcn' => $result['trang-bom']['11'],//$trangbom_congiao_chuacapgcn,
            //PHẬT GIÁO
            'trangbom_phatgiao_tongdt' => $result['trang-bom']['12'],//$trangbom_phatgiao_tongdt,
            'trangbom_phatgiao_dacapgcn_tongiao' => $result['trang-bom']['13'],//$trangbom_phatgiao_dacapgcn_tongiao,
            'trangbom_phatgiao_dacapgcn_khac' => $result['trang-bom']['14'],//$trangbom_phatgiao_dacapgcn_khac,
            'trangbom_phatgiao_chuacapgcn' => $result['trang-bom']['15'],//$trangbom_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'trangbom_caodai_tongdt' => $result['trang-bom']['16'],//$trangbom_caodai_tongdt,
            'trangbom_caodai_dacapgcn_tongiao' => $result['trang-bom']['17'],//$trangbom_caodai_dacapgcn_tongiao,
            'trangbom_caodai_dacapgcn_khac' => $result['trang-bom']['18'],//$trangbom_caodai_dacapgcn_khac,
            'trangbom_caodai_chuacapgcn' => $result['trang-bom']['19'],//$trangbom_caodai_chuacapgcn,
            //TĐCSPHVN
            'trangbom_tdcsphvn_tongdt' => $result['trang-bom']['20'],//$trangbom_tdcsphvn_tongdt,
            'trangbom_tdcsphvn_dacapgcn_tongiao' => $result['trang-bom']['21'],//$trangbom_tdcsphvn_dacapgcn_tongiao,
            'trangbom_tdcsphvn_dacapgcn_khac' => $result['trang-bom']['22'],//$trangbom_tdcsphvn_dacapgcn_khac,
            'trangbom_tdcsphvn_chuacapgcn' => $result['trang-bom']['23'],//$trangbom_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'trangbom_hoigiao_tongdt' => $result['trang-bom']['24'],//$trangbom_hoigiao_tongdt,
            'trangbom_hoigiao_dacapgcn_tongiao' => $result['trang-bom']['25'],//$trangbom_hoigiao_dacapgcn_tongiao,
            'trangbom_hoigiao_dacapgcn_khac' => $result['trang-bom']['26'],//$trangbom_hoigiao_dacapgcn_khac,
            'trangbom_hoigiao_chuacapgcn' => $result['trang-bom']['27'],//$trangbom_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'trangbom_phatgiaohoahao_tongdt' => 0, //$trangbom_phatgiaohoahao_tongdt,
            'trangbom_phatgiaohoahao_dacapgcn_tongiao' => 0, //$trangbom_phatgiaohoahao_dacapgcn_tongiao,
            'trangbom_phatgiaohoahao_dacapgcn_khac' => 0, //$trangbom_phatgiaohoahao_dacapgcn_khac,
            'trangbom_phatgiaohoahao_chuacapgcn' => 0, //$trangbom_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'trangbom_tinnguong_tongdt' => $result['trang-bom']['32'],//$trangbom_tinnguong_tongdt,
            'trangbom_tinnguong_dacapgcn_tongiao' => $result['trang-bom']['33'],//$trangbom_tinnguong_dacapgcn_tongiao,
            'trangbom_tinnguong_dacapgcn_khac' => $result['trang-bom']['34'],//$trangbom_tinnguong_dacapgcn_khac,
            'trangbom_tinnguong_chuacapgcn' => $result['trang-bom']['35'],//$trangbom_tinnguong_chuacapgcn,

            /*VĨNH CỬU*/
            'vinhcuu_tongdt' => $result['vinh-cuu']['3'],//$vinhcuu_tongdt,
            'vinhcuu_sodientichdat_dacapgcn_tong' => $result['vinh-cuu']['4'],//$vinhcuu_sodientichdat_dacapgcn_tong,
            'vinhcuu_sodientichdat_dacapgcn_tongiao' => $result['vinh-cuu']['5'],//$vinhcuu_sodientichdat_dacapgcn_tongiao,
            'vinhcuu_sodientichdat_dacapgcn_khac' => $result['vinh-cuu']['6'],//$vinhcuu_sodientichdat_dacapgcn_khac,
            'vinhcuu_sodientichdat_chuacapgcn' => $result['vinh-cuu']['7'],//$vinhcuu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'vinhcuu_congiao_tongdt' => $result['vinh-cuu']['8'],//$vinhcuu_congiao_tongdt,
            'vinhcuu_congiao_dacapgcn_tongiao' => $result['vinh-cuu']['9'],//$vinhcuu_congiao_dacapgcn_tongiao,
            'vinhcuu_congiao_dacapgcn_khac' => $result['vinh-cuu']['10'],//$vinhcuu_congiao_dacapgcn_khac,
            'vinhcuu_congiao_chuacapgcn' => $result['vinh-cuu']['11'],//$vinhcuu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'vinhcuu_phatgiao_tongdt' => $result['vinh-cuu']['12'],//$vinhcuu_phatgiao_tongdt,
            'vinhcuu_phatgiao_dacapgcn_tongiao' => $result['vinh-cuu']['13'],//$vinhcuu_phatgiao_dacapgcn_tongiao,
            'vinhcuu_phatgiao_dacapgcn_khac' => $result['vinh-cuu']['14'],//$vinhcuu_phatgiao_dacapgcn_khac,
            'vinhcuu_phatgiao_chuacapgcn' => $result['vinh-cuu']['15'],//$vinhcuu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'vinhcuu_caodai_tongdt' => $result['vinh-cuu']['16'],//$vinhcuu_caodai_tongdt,
            'vinhcuu_caodai_dacapgcn_tongiao' => $result['vinh-cuu']['17'],//$vinhcuu_caodai_dacapgcn_tongiao,
            'vinhcuu_caodai_dacapgcn_khac' => $result['vinh-cuu']['18'],//$vinhcuu_caodai_dacapgcn_khac,
            'vinhcuu_caodai_chuacapgcn' => $result['vinh-cuu']['19'],//$vinhcuu_caodai_chuacapgcn,
            //TĐCSPHVN
            'vinhcuu_tdcsphvn_tongdt' => $result['vinh-cuu']['20'],//$vinhcuu_tdcsphvn_tongdt,
            'vinhcuu_tdcsphvn_dacapgcn_tongiao' => $result['vinh-cuu']['21'],//$vinhcuu_tdcsphvn_dacapgcn_tongiao,
            'vinhcuu_tdcsphvn_dacapgcn_khac' => $result['vinh-cuu']['22'],//$vinhcuu_tdcsphvn_dacapgcn_khac,
            'vinhcuu_tdcsphvn_chuacapgcn' => $result['vinh-cuu']['23'],//$vinhcuu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'vinhcuu_hoigiao_tongdt' => $result['vinh-cuu']['24'],//$vinhcuu_hoigiao_tongdt,
            'vinhcuu_hoigiao_dacapgcn_tongiao' => $result['vinh-cuu']['25'],//$vinhcuu_hoigiao_dacapgcn_tongiao,
            'vinhcuu_hoigiao_dacapgcn_khac' => $result['vinh-cuu']['26'],//$vinhcuu_hoigiao_dacapgcn_khac,
            'vinhcuu_hoigiao_chuacapgcn' => $result['vinh-cuu']['27'],//$vinhcuu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'vinhcuu_phatgiaohoahao_tongdt' => 0, //$vinhcuu_phatgiaohoahao_tongdt,
            'vinhcuu_phatgiaohoahao_dacapgcn_tongiao' => 0, //$vinhcuu_phatgiaohoahao_dacapgcn_tongiao,
            'vinhcuu_phatgiaohoahao_dacapgcn_khac' => 0, //$vinhcuu_phatgiaohoahao_dacapgcn_khac,
            'vinhcuu_phatgiaohoahao_chuacapgcn' => 0, //$vinhcuu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'vinhcuu_tinnguong_tongdt' => $result['vinh-cuu']['32'],//$vinhcuu_tinnguong_tongdt,
            'vinhcuu_tinnguong_dacapgcn_tongiao' => $result['vinh-cuu']['33'],//$vinhcuu_tinnguong_dacapgcn_tongiao,
            'vinhcuu_tinnguong_dacapgcn_khac' => $result['vinh-cuu']['34'],//$vinhcuu_tinnguong_dacapgcn_khac,
            'vinhcuu_tinnguong_chuacapgcn' => $result['vinh-cuu']['35'],//$vinhcuu_tinnguong_chuacapgcn,

            /*NHƠN TRẠCH*/
            'nhontrach_tongdt' => $result['nhon-trach']['3'],//$nhontrach_tongdt,
            'nhontrach_sodientichdat_dacapgcn_tong' => $result['nhon-trach']['4'],//$nhontrach_sodientichdat_dacapgcn_tong,
            'nhontrach_sodientichdat_dacapgcn_tongiao' => $result['nhon-trach']['5'],//$nhontrach_sodientichdat_dacapgcn_tongiao,
            'nhontrach_sodientichdat_dacapgcn_khac' => $result['nhon-trach']['6'],//$nhontrach_sodientichdat_dacapgcn_khac,
            'nhontrach_sodientichdat_chuacapgcn' => $result['nhon-trach']['7'],//$nhontrach_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'nhontrach_congiao_tongdt' => $result['nhon-trach']['8'],//$nhontrach_congiao_tongdt,
            'nhontrach_congiao_dacapgcn_tongiao' => $result['nhon-trach']['9'],//$nhontrach_congiao_dacapgcn_tongiao,
            'nhontrach_congiao_dacapgcn_khac' => $result['nhon-trach']['10'],//$nhontrach_congiao_dacapgcn_khac,
            'nhontrach_congiao_chuacapgcn' => $result['nhon-trach']['11'],//$nhontrach_congiao_chuacapgcn,
            //PHẬT GIÁO
            'nhontrach_phatgiao_tongdt' => $result['nhon-trach']['12'],//$nhontrach_phatgiao_tongdt,
            'nhontrach_phatgiao_dacapgcn_tongiao' => $result['nhon-trach']['13'],//$nhontrach_phatgiao_dacapgcn_tongiao,
            'nhontrach_phatgiao_dacapgcn_khac' => $result['nhon-trach']['14'],//$nhontrach_phatgiao_dacapgcn_khac,
            'nhontrach_phatgiao_chuacapgcn' => $result['nhon-trach']['15'],//$nhontrach_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'nhontrach_caodai_tongdt' => $result['nhon-trach']['16'],//$nhontrach_caodai_tongdt,
            'nhontrach_caodai_dacapgcn_tongiao' => $result['nhon-trach']['17'],//$nhontrach_caodai_dacapgcn_tongiao,
            'nhontrach_caodai_dacapgcn_khac' => $result['nhon-trach']['18'],//$nhontrach_caodai_dacapgcn_khac,
            'nhontrach_caodai_chuacapgcn' => $result['nhon-trach']['19'],//$nhontrach_caodai_chuacapgcn,
            //TĐCSPHVN
            'nhontrach_tdcsphvn_tongdt' => $result['nhon-trach']['20'],//$nhontrach_tdcsphvn_tongdt,
            'nhontrach_tdcsphvn_dacapgcn_tongiao' => $result['nhon-trach']['21'],//$nhontrach_tdcsphvn_dacapgcn_tongiao,
            'nhontrach_tdcsphvn_dacapgcn_khac' => $result['nhon-trach']['22'],//$nhontrach_tdcsphvn_dacapgcn_khac,
            'nhontrach_tdcsphvn_chuacapgcn' => $result['nhon-trach']['23'],//$nhontrach_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'nhontrach_hoigiao_tongdt' => $result['nhon-trach']['24'],//$nhontrach_hoigiao_tongdt,
            'nhontrach_hoigiao_dacapgcn_tongiao' => $result['nhon-trach']['25'],//$nhontrach_hoigiao_dacapgcn_tongiao,
            'nhontrach_hoigiao_dacapgcn_khac' => $result['nhon-trach']['26'],//$nhontrach_hoigiao_dacapgcn_khac,
            'nhontrach_hoigiao_chuacapgcn' => $result['nhon-trach']['27'],//$nhontrach_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'nhontrach_phatgiaohoahao_tongdt' => 0, //$nhontrach_phatgiaohoahao_tongdt,
            'nhontrach_phatgiaohoahao_dacapgcn_tongiao' => 0, //$nhontrach_phatgiaohoahao_dacapgcn_tongiao,
            'nhontrach_phatgiaohoahao_dacapgcn_khac' => 0, //$nhontrach_phatgiaohoahao_dacapgcn_khac,
            'nhontrach_phatgiaohoahao_chuacapgcn' => 0, //$nhontrach_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'nhontrach_tinnguong_tongdt' => $result['nhon-trach']['32'],//$nhontrach_tinnguong_tongdt,
            'nhontrach_tinnguong_dacapgcn_tongiao' => $result['nhon-trach']['33'],//$nhontrach_tinnguong_dacapgcn_tongiao,
            'nhontrach_tinnguong_dacapgcn_khac' => $result['nhon-trach']['34'],//$nhontrach_tinnguong_dacapgcn_khac,
            'nhontrach_tinnguong_chuacapgcn' => $result['nhon-trach']['35'],//$nhontrach_tinnguong_chuacapgcn,

            /*LONG THÀNH*/
            'longthanh_tongdt' => $longthanh_tongdt,
            'longthanh_sodientichdat_dacapgcn_tong' => $result['long-thanh']['4'],//$longthanh_sodientichdat_dacapgcn_tong,
            'longthanh_sodientichdat_dacapgcn_tongiao' => $result['long-thanh']['5'],//$longthanh_sodientichdat_dacapgcn_tongiao,
            'longthanh_sodientichdat_dacapgcn_khac' => $result['long-thanh']['6'],//$longthanh_sodientichdat_dacapgcn_khac,
            'longthanh_sodientichdat_chuacapgcn' => $result['long-thanh']['7'],//$longthanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longthanh_congiao_tongdt' => $result['long-thanh']['8'],//$longthanh_congiao_tongdt,
            'longthanh_congiao_dacapgcn_tongiao' => $result['long-thanh']['9'],//$longthanh_congiao_dacapgcn_tongiao,
            'longthanh_congiao_dacapgcn_khac' => $result['long-thanh']['10'],//$longthanh_congiao_dacapgcn_khac,
            'longthanh_congiao_chuacapgcn' => $result['long-thanh']['11'],//$longthanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longthanh_phatgiao_tongdt' => $result['long-thanh']['12'],//$longthanh_phatgiao_tongdt,
            'longthanh_phatgiao_dacapgcn_tongiao' => $result['long-thanh']['13'],//$longthanh_phatgiao_dacapgcn_tongiao,
            'longthanh_phatgiao_dacapgcn_khac' => $result['long-thanh']['14'],//$longthanh_phatgiao_dacapgcn_khac,
            'longthanh_phatgiao_chuacapgcn' => $result['long-thanh']['15'],//$longthanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longthanh_caodai_tongdt' => $result['long-thanh']['16'],//$longthanh_caodai_tongdt,
            'longthanh_caodai_dacapgcn_tongiao' => $result['long-thanh']['17'],//$longthanh_caodai_dacapgcn_tongiao,
            'longthanh_caodai_dacapgcn_khac' => $result['long-thanh']['18'],//$longthanh_caodai_dacapgcn_khac,
            'longthanh_caodai_chuacapgcn' => $result['long-thanh']['19'],//$longthanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longthanh_tdcsphvn_tongdt' => $result['long-thanh']['20'],//$longthanh_tdcsphvn_tongdt,
            'longthanh_tdcsphvn_dacapgcn_tongiao' => $result['long-thanh']['21'],//$longthanh_tdcsphvn_dacapgcn_tongiao,
            'longthanh_tdcsphvn_dacapgcn_khac' => $result['long-thanh']['22'],//$longthanh_tdcsphvn_dacapgcn_khac,
            'longthanh_tdcsphvn_chuacapgcn' => $result['long-thanh']['23'],//$longthanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longthanh_hoigiao_tongdt' => $result['long-thanh']['24'],//$longthanh_hoigiao_tongdt,
            'longthanh_hoigiao_dacapgcn_tongiao' => $result['long-thanh']['25'],//$longthanh_hoigiao_dacapgcn_tongiao,
            'longthanh_hoigiao_dacapgcn_khac' => $result['long-thanh']['26'],//$longthanh_hoigiao_dacapgcn_khac,
            'longthanh_hoigiao_chuacapgcn' => $result['long-thanh']['27'],//$longthanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longthanh_phatgiaohoahao_tongdt' => 0, //$longthanh_phatgiaohoahao_tongdt,
            'longthanh_phatgiaohoahao_dacapgcn_tongiao' => 0, //$longthanh_phatgiaohoahao_dacapgcn_tongiao,
            'longthanh_phatgiaohoahao_dacapgcn_khac' => 0, //$longthanh_phatgiaohoahao_dacapgcn_khac,
            'longthanh_phatgiaohoahao_chuacapgcn' => 0, //$longthanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longthanh_tinnguong_tongdt' => $result['long-thanh']['32'],$longthanh_tinnguong_tongdt,
            'longthanh_tinnguong_dacapgcn_tongiao' => $result['long-thanh']['33'],$longthanh_tinnguong_dacapgcn_tongiao,
            'longthanh_tinnguong_dacapgcn_khac' => $result['long-thanh']['34'],$longthanh_tinnguong_dacapgcn_khac,
            'longthanh_tinnguong_chuacapgcn' => $result['long-thanh']['35'],$longthanh_tinnguong_chuacapgcn,

            /*TỔNG*/
            'tongdt' => $tongdt,
            'sodientichdat_dacapgcn_tong' => $sodientichdat_dacapgcn_tong,
            'sodientichdat_dacapgcn_tongiao' => $sodientichdat_dacapgcn_tongiao,
            'sodientichdat_dacapgcn_khac' => $sodientichdat_dacapgcn_khac,
            'sodientichdat_chuacapgcn' => $sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'congiao_tongdt' => $congiao_tongdt,
            'congiao_dacapgcn_tongiao' => $congiao_dacapgcn_tongiao,
            'congiao_dacapgcn_khac' => $congiao_dacapgcn_khac,
            'congiao_chuacapgcn' => $congiao_chuacapgcn,
            //PHẬT GIÁO
            'phatgiao_tongdt' => $phatgiao_tongdt,
            'phatgiao_dacapgcn_tongiao' => $phatgiao_dacapgcn_tongiao,
            'phatgiao_dacapgcn_khac' => $phatgiao_dacapgcn_khac,
            'phatgiao_chuacapgcn' => $phatgiao_chuacapgcn,
            //CAO ĐÀI
            'caodai_tongdt' => $caodai_tongdt,
            'caodai_dacapgcn_tongiao' => $caodai_dacapgcn_tongiao,
            'caodai_dacapgcn_khac' => $caodai_dacapgcn_khac,
            'caodai_chuacapgcn' => $caodai_chuacapgcn,
            //TĐCSPHVN
            'tdcsphvn_tongdt' => $tdcsphvn_tongdt,
            'tdcsphvn_dacapgcn_tongiao' => $tdcsphvn_dacapgcn_tongiao,
            'tdcsphvn_dacapgcn_khac' => $tdcsphvn_dacapgcn_khac,
            'tdcsphvn_chuacapgcn' => $tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'hoigiao_tongdt' => $hoigiao_tongdt,
            'hoigiao_dacapgcn_tongiao' => $hoigiao_dacapgcn_tongiao,
            'hoigiao_dacapgcn_khac' => $hoigiao_dacapgcn_khac,
            'hoigiao_chuacapgcn' => $hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'phatgiaohoahao_tongdt' => 0,//$phatgiaohoahao_tongdt,
            'phatgiaohoahao_dacapgcn_tongiao' => 0,//$phatgiaohoahao_dacapgcn_tongiao,
            'phatgiaohoahao_dacapgcn_khac' => 0,//$phatgiaohoahao_dacapgcn_khac,
            'phatgiaohoahao_chuacapgcn' => 0,//$phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'tinnguong_tongdt' => $tinnguong_tongdt,
            'tinnguong_dacapgcn_tongiao' => $tinnguong_dacapgcn_tongiao,
            'tinnguong_dacapgcn_khac' => $tinnguong_dacapgcn_khac,
            'tinnguong_chuacapgcn' => $tinnguong_chuacapgcn,
        );

        return $data;
    }

    public function formatData()
    {
        /**
         * Exports/formatData/Giaoxu
         *
         * Cosotinnguong            OK
         * Diemnhomtinlanh          OK
         * Cosohoigiaoislam         OK
         * Hodaocaodai              OK
         * Chihoitinhdocusiphatgiaovietnam
         * Chihoitinlanh            OK
         * Dongtuconggiao           OK
         * Giaoxu                   OK
         * Tuvienphatgiao           OK
         */
        $request = $this->request;
        $pass = $request->params['pass'];
        $modelName = $pass[0];
        $array = array(
            $modelName
        );
        App::import('Model', $array);
        //init model
        foreach ($array as $element) {
            $this->$element = new $element();
        }

        $fields = array();
        $conditions = array(
            'is_add' => 1
        );

        //Cosotinnguong
        if ($modelName == 'Cosotinnguong') {
            $fields = array(
                'id', 'datdai_tongdientich',
                'tongiao_dientich', 'tongiao_chuacap_dientich', 'tongiao_dacap_dientich',
                //tongiao_dacap_gcn_quyensudungdat
                'tongiao_dacap_gcn_quyensudungdat',
                'nnlnntts_dientich', 'nnlnntts_chuacap_dientich', 'nnlnntts_dacap_dientich',
                //nnlnntts_dacap_gcn_quyensudungdat
                'nnlnntts_dacap_gcn_quyensudungdat',
                'gdyt_dientich', 'gdyt_chuacap_dientich', 'gdyt_dacap_dientich',
                //gdyt_dacap_gcn_quyensudungdat
                'gdyt_dacap_gcn_quyensudungdat',
                'dsdmdk_dientich', 'dsdmdk_chuacap_dientich', 'dsdmdk_dacap_dientich',
                //dsdmdk_dacap_gcn_quyensudungdat
                'dsdmdk_dacap_gcn_quyensudungdat'
            );
        }
        //Diemnhomtinlanh
        if ($modelName == 'Diemnhomtinlanh') {
            $fields = array(
                'id', 'tongdientichdat',
                'tongiao_dientich', 'tongiao_chuacap_dientich', 'tongiao_dacap_dientich',
                //tongiao_dacap_gcn_quyensudungdat
                'tongiao_dacap_gcn_quyensudungdat',
                'nnlnntts_dientich', 'nnlnntts_chuacap_dientich', 'nnlnntts_dacap_dientich',
                //nnlnntts_dacap_gcn_quyensudungdat
                'nnlnntts_dacap_gcn_quyensudungdat',
                'gdyt_dientich', 'gdyt_chuacap_dientich', 'gdyt_dacap_dientich',
                //gdyt_dacap_gcn_quyensudungdat
                'gdyt_dacap_gcn_quyensudungdat',
                'dsdmdk_dientich', 'dsdmdk_chuacap_dientich', 'dsdmdk_dacap_dientich',
                //dsdmdk_dacap_gcn_quyensudungdat
                'dsdmdk_dacap_gcn_quyensudungdat'
            );
        }
        //Cosohoigiaoislam
        //Hodaocaodai
        //Chihoitinhdocusiphatgiaovietnam
        //Chihoitinlanh
        //Dongtuconggiao
        //Giaoxu
        //Tuvienphatgiao
        if (in_array(
            $modelName,
            array('Cosohoigiaoislam', 'Hodaocaodai', 'Chihoitinhdocusiphatgiaovietnam', 'Chihoitinlanh', 'Dongtuconggiao', 'Giaoxu', 'Tuvienphatgiao')
        )) {
            $fields = array(
                'id',
                /*dattrongkhuonvien*/
                'dattrongkhuonvien', 'datdai_tongdientich',
                //Tôn giáo
                'dattrongkhuonvien_tongiao_dientich',
                'dattrongkhuonvien_tongiao_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'dattrongkhuonvien_tongiao_chuacap_dientich',
                //Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'dattrongkhuonvien_nnlnntts_dientich',
                'dattrongkhuonvien_nnlnntts_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_nnlnntts_dacap_dientich',
                'dattrongkhuonvien_nnlnntts_chuacap_dientich',
                //Giáo dục, y tế
                'dattrongkhuonvien_gdyt_dientich',
                'dattrongkhuonvien_gdyt_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_gdyt_dacap_dientich',
                'dattrongkhuonvien_gdyt_chuacap_dientich',
                //Đất sử dụng mục đích khác
                'dattrongkhuonvien_dsdmdk_dientich',
                'dattrongkhuonvien_dsdmdk_dacap_gcn_quyensudungdat',
                'dattrongkhuonvien_dsdmdk_dacap_dientich',
                'dattrongkhuonvien_dsdmdk_chuacap_dientich',

                /*datngoaikhuonvien*/
                'datngoaikhuonvien',
                //(1)Tôn giáo
                'datngoaikhuonvien_tongiao_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_chuacap_dientich_1',
                //(1)Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'datngoaikhuonvien_nnlnntts_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_1',
                //(1)Giáo dục, y tế
                'datngoaikhuonvien_gdyt_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_chuacap_dientich_1',
                //(1)Đất sử dụng mục đích khác
                'datngoaikhuonvien_dsdmdk_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_1',

                //(2)Tôn giáo
                'datngoaikhuonvien_tongiao_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_chuacap_dientich_2',
                //(2)Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'datngoaikhuonvien_nnlnntts_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_2',
                //(2)Giáo dục, y tế
                'datngoaikhuonvien_gdyt_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_chuacap_dientich_2',
                //(2)Đất sử dụng mục đích khác
                'datngoaikhuonvien_dsdmdk_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_2',

                //(3)Tôn giáo
                'datngoaikhuonvien_tongiao_dientich_3',
                'datngoaikhuonvien_tongiao_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_tongiao_chuacap_dientich_3',
                //(3)Nông nghiệp, lâm nghiệp, nuôi trồng thủy sản
                'datngoaikhuonvien_nnlnntts_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_chuacap_dientich_3',
                //(3)Giáo dục, y tế
                'datngoaikhuonvien_gdyt_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_chuacap_dientich_3',
                //(3)Đất sử dụng mục đích khác
                'datngoaikhuonvien_dsdmdk_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_gcn_quyensudungdat_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_chuacap_dientich_3'
            );
        }

        $data = $this->$modelName->find('all', array(
            'fields' => $fields,
            'conditions' => $conditions
        ));

        print '<pre>';
        print_r($data);
        print '</pre>';
        exit;
    }









    private function calculate_conggiao()
    {
        $dtcg = $this->calculate_dongtuconggiao('Dongtuconggiao');
        $gx = $this->calculate_giaoxu('Giaoxu');

        foreach ($dtcg as $province_code => &$item) {
            if (isset($gx[$province_code])) {
                $item['total'] = $gx[$province_code]['total'];
                $item['licensed_main'] = $gx[$province_code]['licensed_main'];
                $item['licensed_other'] = $gx[$province_code]['licensed_other'];
                $item['unlicense'] = $gx[$province_code]['unlicense'];
                unset($gx[$province_code]);
            }
        }

        if ($gx) {
            $dtcg = array_merge($dtcg, $gx);
        }

        return $dtcg;
    }

    public function test2()
    {
        $list = [
            'Conggiao',
             'Cosotinnguong', // ok
             'Cosohoigiaoislam', // ok
             'Hodaocaodai', // ok
             'Chihoitinhdocusiphatgiaovietnam', // ok
             'Dongtuconggiao', // ok
             'Giaoxu', // ok
             'Tuvienphatgiao' // ok
        ];

        $statictis = [];

        $export = [];
        $province = $this->getProvince();

        $index = 1;
        foreach ($province as $code => $name) {
            $export[$code] = [
                $index++,
                $name,
                0,
                0,
                0,
                0,
                0,
                0
            ];
            $statictis[$code] = [
                'final_total' => 0,
                'total' => 0,
                'licensed_main' => 0,
                'licensed_other' => 0,
                'unlicense' => 0,
            ];
        }

        foreach ($list as $model) {
            $func = 'calculate_' . mb_strtolower($model);
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                if (!empty($tmp[$provice_code])) {
                    $partial = array_values($tmp[$provice_code]);
                    $statictis[$provice_code]['total'] += $tmp[$provice_code]['total'];
                    $statictis[$provice_code]['licensed_main'] += $tmp[$provice_code]['licensed_main'];
                    $statictis[$provice_code]['licensed_other'] += $tmp[$provice_code]['licensed_other'];
                    $statictis[$provice_code]['unlicense'] += $tmp[$provice_code]['unlicense'];

                    $statictis[$provice_code]['final_total'] += $tmp[$provice_code]['total'] +
                                                                $tmp[$provice_code]['licensed_main'] +
                                                                $tmp[$provice_code]['licensed_other'] +
                                                                $tmp[$provice_code]['unlicense'];
                } else {
                    $partial = [0, 0, 0, 0];
                }

                $export[$provice_code] = array_merge($export[$provice_code], $partial);
            }
        }

        foreach ($export as &$item) {
            $item[2] = $statictis[$provice_code]['total'];
            $item[3] = $statictis[$provice_code]['licensed_main'];
            $item[4] = $statictis[$provice_code]['licensed_other'];
            $item[5] = $statictis[$provice_code]['unlicense'];
            $item[6] = $statictis[$provice_code]['final_total'];
        }
        print '<pre>';
        print_r($export);
        print '</pre>';
        exit;
        //return $export;
    }

    private function calculate_cosotinnguong($model)
    {
        $field = [
            'id',
            'diachi_huyen',
            'datdai_tongdientich',
            'tongiao_dacap_dientich',
            'nnlnntts_dacap_dientich',
            'gdyt_dacap_dientich',
            'dsdmdk_dacap_dientich',
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'tongiao_dacap_dientich',
            ],
            'sum' => [
                'tongiao_dacap_dientich',
                'nnlnntts_dacap_dientich',
                'gdyt_dacap_dientich',
                'dsdmdk_dacap_dientich'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'diachi_huyen');
    }

    private function calculate_cosohoigiaoislam($model)
    {
        $field = [
            'id',
            'tenthanhduong_diachi_huyen',
            'datdai_tongdientich',

            'dattrongkhuonvien',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_dientich',

            'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

            'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

            'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
            ],
            'sum' => [
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'tenthanhduong_diachi_huyen');
    }

    private function calculate_chihoitinhdocusiphatgiaovietnam($model)
    {
        $field = [
            'id',
            'tenchihoi_diachi_huyen',
            'datdai_tongdientich',

            'dattrongkhuonvien',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_dientich',

            'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

            'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

            'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
            ],
            'sum' => [
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'tenchihoi_diachi_huyen');
    }

    private function calculate_hodaocaodai($model)
    {
        $field = [
            'id',
            'tenhodao_diachi_huyen',
            'datdai_tongdientich',

            'dattrongkhuonvien',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_dientich',

            'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

            'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

            'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
            ],
            'sum' => [
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'tenhodao_diachi_huyen');
    }

    private function calculate_tuvienphatgiao($model)
    {
        $field = [
            'id',
            'diachi_huyen',
            'datdai_tongdientich',

            'dattrongkhuonvien',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_dientich',

            'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

            'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

            'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
            ],
            'sum' => [
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'diachi_huyen');
    }

    private function calculate_dongtuconggiao($model)
    {
        $field = [
            'id',
            'diachi_huyen',
            'datdai_tongdientich',

            'dattrongkhuonvien',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_dientich',

            'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

            'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

            'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
            ],
            'sum' => [
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'diachi_huyen');
    }

    private function calculate_giaoxu($model)
    {
        $field = [
            'id',
            'diachi_huyen',
            'datdai_tongdientich',

            'dattrongkhuonvien',
            'dattrongkhuonvien_tongiao_dientich',
            'dattrongkhuonvien_tongiao_dacap_dientich',
            'dattrongkhuonvien_nnlnntts_dacap_dientich',
            'dattrongkhuonvien_gdyt_dacap_dientich',
            'dattrongkhuonvien_dsdmdk_dacap_dientich',

            'datngoaikhuonvien_tongiao_dacap_dientich_1',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
            'datngoaikhuonvien_gdyt_dacap_dientich_1',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

            'datngoaikhuonvien_tongiao_dacap_dientich_2',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
            'datngoaikhuonvien_gdyt_dacap_dientich_2',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

            'datngoaikhuonvien_tongiao_dacap_dientich_3',
            'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
            'datngoaikhuonvien_gdyt_dacap_dientich_3',
            'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
        ];

        $formular = [
            'total' => 'datdai_tongdientich',
            'main' => [
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',
            ],
            'sum' => [
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',

                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',

                'datngoaikhuonvien_tongiao_dacap_dientich_3',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3'
            ]
        ];
        $data = $this->getData($model, $field);

        return $this->calculate($data, $formular, 'diachi_huyen');
    }

    private function calculate($data, $formular, $province_field)
    {
        $result = [];

        foreach ($data as $id => $item) {
            $provice_code = $this->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $total = $item[$formular['total']];
            $licensed_total = 0;
            foreach ($formular['sum'] as $field) {
                if (!empty($item[$field])) {
                    $licensed_total += $item[$field];
                }
            }

            $licensed_main = 0;
            foreach ($formular['main'] as $field) {
                if (!empty($item[$field])) {
                    $licensed_main += $item[$field];
                }
            }
            $licensed_other = $licensed_total - $licensed_main;
            $unlicense = $total - $licensed_total;

            if (!isset($result[$provice_code])) {
                $result[$provice_code] = [
                    'total' => [],
                    'licensed_main' => [],
                    'licensed_other' => [],
                    'unlicense' => []
                ];
            }

            if ($total) {
                array_push($result[$provice_code]['total'], $total);
            }
            if ($licensed_main) {
                array_push($result[$provice_code]['licensed_main'], $licensed_main);
            }
            if ($licensed_other) {
                array_push($result[$provice_code]['licensed_other'], $licensed_other);
            }
            if ($unlicense) {
                array_push($result[$provice_code]['unlicense'], $unlicense);
            }
        }

        foreach ($result as $provice_code => $list) {
            $sum = $result[$provice_code]['total'] ? array_sum($result[$provice_code]['total']) : 0;
            $result[$provice_code]['total'] = $sum;

            $sum = $result[$provice_code]['licensed_main'] ? array_sum($result[$provice_code]['licensed_main']) : 0;
            $result[$provice_code]['licensed_main'] = $sum;

            $sum = $result[$provice_code]['licensed_other'] ? array_sum($result[$provice_code]['licensed_other']) : 0;
            $result[$provice_code]['licensed_other'] = $sum;

            $sum = $result[$provice_code]['unlicense'] ? array_sum($result[$provice_code]['unlicense']) : 0;
            $result[$provice_code]['unlicense'] = $sum;
        }

        return $result;
    }

    private function getData($model, $data_field)
    {
        $obj = ClassRegistry::init($model);
        $conditions = [
            'is_add' => 1,
        ];
        $data = $obj->find('all', array(
            'fields' => $data_field,
            'conditions' => $conditions,
            'limit' => 10
        ));

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function retrieveProvinceCode($string = '')
    {
        $list = $this->getProvince();

        $string = $this->Utility->slug($string);

        foreach ($list as $code => $name) {
            if (mb_strpos($string, $code) !== false) {
                return $code;
            }
        }
        // $test = rand(0, 10);
        // $key = array_keys($list);
        // return $key = $key[$test];

        return '';
    }

    private function getProvince()
    {
        return [
            'bien-hoa' => 'BIÊN HÒA',
            'cam-my' => 'CẨM MỸ',
            'dinh-quan' => 'ĐỊNH QUÁN',
            'long-khanh' => 'LONG KHÁNH',
            'long-thanh' => 'LONG THÀNH',
            'nhon-trach' => 'NHƠN TRẠCH',
            'thong-nhat' => 'THỐNG NHẤT',
            'trang-bom' => 'TRẢNG BOM',
            'tan-phu' => 'TÂN PHÚ',
            'vinh-cuu' => 'VĨNH CỬU',
            'xuan-loc' => 'XUÂN LỘC',
        ];
    }

    private function getProvinceName($code)
    {
        $provine = $this->getProvince();

        return isset($province[$code]) ? $province[$code] : '';
    }
}
