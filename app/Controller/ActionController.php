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
        $data = array(
            /*BIÊN HÒA*/
            //SỐ DIỆN TÍCH ĐẤT
            'bienhoa_tongdt' => 900,
            'bienhoa_sodientichdat_dacapgcn_tong' => $bienhoa_sodientichdat_dacapgcn_tong,
            'bienhoa_sodientichdat_dacapgcn_tongiao' => $bienhoa_sodientichdat_dacapgcn_tongiao,
            'bienhoa_sodientichdat_dacapgcn_khac' => $bienhoa_sodientichdat_dacapgcn_khac,
            'bienhoa_sodientichdat_chuacapgcn' => $bienhoa_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'bienhoa_congiao_tongdt' => $bienhoa_congiao_tongdt,
            'bienhoa_congiao_dacapgcn_tongiao' => $bienhoa_congiao_dacapgcn_tongiao,
            'bienhoa_congiao_dacapgcn_khac' => $bienhoa_congiao_dacapgcn_khac,
            'bienhoa_congiao_chuacapgcn' => $bienhoa_congiao_chuacapgcn,
            //PHẬT GIÁO
            'bienhoa_phatgiao_tongdt' => $bienhoa_phatgiao_tongdt,
            'bienhoa_phatgiao_dacapgcn_tongiao' => $bienhoa_phatgiao_dacapgcn_tongiao,
            'bienhoa_phatgiao_dacapgcn_khac' => $bienhoa_phatgiao_dacapgcn_khac,
            'bienhoa_phatgiao_chuacapgcn' => $bienhoa_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'bienhoa_caodai_tongdt' => $bienhoa_caodai_tongdt,
            'bienhoa_caodai_dacapgcn_tongiao' => $bienhoa_caodai_dacapgcn_tongiao,
            'bienhoa_caodai_dacapgcn_khac' => $bienhoa_caodai_dacapgcn_khac,
            'bienhoa_caodai_chuacapgcn' => $bienhoa_caodai_chuacapgcn,
            //TĐCSPHVN
            'bienhoa_tdcsphvn_tongdt' => $bienhoa_tdcsphvn_tongdt,
            'bienhoa_tdcsphvn_dacapgcn_tongiao' => $bienhoa_tdcsphvn_dacapgcn_tongiao,
            'bienhoa_tdcsphvn_dacapgcn_khac' => $bienhoa_tdcsphvn_dacapgcn_khac,
            'bienhoa_tdcsphvn_chuacapgcn' => $bienhoa_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'bienhoa_hoigiao_tongdt' => $bienhoa_hoigiao_tongdt,
            'bienhoa_hoigiao_dacapgcn_tongiao' => $bienhoa_hoigiao_dacapgcn_tongiao,
            'bienhoa_hoigiao_dacapgcn_khac' => $bienhoa_hoigiao_dacapgcn_khac,
            'bienhoa_hoigiao_chuacapgcn' => $bienhoa_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'bienhoa_phatgiaohoahao_tongdt' => 0, //$bienhoa_phatgiaohoahao_tongdt,
            'bienhoa_phatgiaohoahao_dacapgcn_tongiao' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_tongiao,
            'bienhoa_phatgiaohoahao_dacapgcn_khac' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_khac,
            'bienhoa_phatgiaohoahao_chuacapgcn' => 0, //$bienhoa_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'bienhoa_tinnguong_tongdt' => $bienhoa_tinnguong_tongdt,
            'bienhoa_tinnguong_dacapgcn_tongiao' => $bienhoa_tinnguong_dacapgcn_tongiao,
            'bienhoa_tinnguong_dacapgcn_khac' => $bienhoa_tinnguong_dacapgcn_khac,
            'bienhoa_tinnguong_chuacapgcn' => $bienhoa_tinnguong_chuacapgcn,

            /*LONG KHÁNH*/
            'longkhanh_tongdt' => $longkhanh_tongdt,
            'longkhanh_sodientichdat_dacapgcn_tong' => $longkhanh_sodientichdat_dacapgcn_tong,
            'longkhanh_sodientichdat_dacapgcn_tongiao' => $longkhanh_sodientichdat_dacapgcn_tongiao,
            'longkhanh_sodientichdat_dacapgcn_khac' => $longkhanh_sodientichdat_dacapgcn_khac,
            'longkhanh_sodientichdat_chuacapgcn' => $longkhanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longkhanh_congiao_tongdt' => $longkhanh_congiao_tongdt,
            'longkhanh_congiao_dacapgcn_tongiao' => $longkhanh_congiao_dacapgcn_tongiao,
            'longkhanh_congiao_dacapgcn_khac' => $longkhanh_congiao_dacapgcn_khac,
            'longkhanh_congiao_chuacapgcn' => $longkhanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longkhanh_phatgiao_tongdt' => $longkhanh_phatgiao_tongdt,
            'longkhanh_phatgiao_dacapgcn_tongiao' => $longkhanh_phatgiao_dacapgcn_tongiao,
            'longkhanh_phatgiao_dacapgcn_khac' => $longkhanh_phatgiao_dacapgcn_khac,
            'longkhanh_phatgiao_chuacapgcn' => $longkhanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longkhanh_caodai_tongdt' => $longkhanh_caodai_tongdt,
            'longkhanh_caodai_dacapgcn_tongiao' => $longkhanh_caodai_dacapgcn_tongiao,
            'longkhanh_caodai_dacapgcn_khac' => $longkhanh_caodai_dacapgcn_khac,
            'longkhanh_caodai_chuacapgcn' => $longkhanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longkhanh_tdcsphvn_tongdt' => $longkhanh_tdcsphvn_tongdt,
            'longkhanh_tdcsphvn_dacapgcn_tongiao' => $longkhanh_tdcsphvn_dacapgcn_tongiao,
            'longkhanh_tdcsphvn_dacapgcn_khac' => $longkhanh_tdcsphvn_dacapgcn_khac,
            'longkhanh_tdcsphvn_chuacapgcn' => $longkhanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longkhanh_hoigiao_tongdt' => $longkhanh_hoigiao_tongdt,
            'longkhanh_hoigiao_dacapgcn_tongiao' => $longkhanh_hoigiao_dacapgcn_tongiao,
            'longkhanh_hoigiao_dacapgcn_khac' => $longkhanh_hoigiao_dacapgcn_khac,
            'longkhanh_hoigiao_chuacapgcn' => $longkhanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longkhanh_phatgiaohoahao_tongdt' => 0, //$longkhanh_phatgiaohoahao_tongdt,
            'longkhanh_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$longkhanh_phatgiaohoahao_dacapgcn_tongiao,
            'longkhanh_phatgiaohoahao_dacapgcn_khac' =>  0, //$longkhanh_phatgiaohoahao_dacapgcn_khac,
            'longkhanh_phatgiaohoahao_chuacapgcn' =>  0, //$longkhanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longkhanh_tinnguong_tongdt' => $longkhanh_tinnguong_tongdt,
            'longkhanh_tinnguong_dacapgcn_tongiao' => $longkhanh_tinnguong_dacapgcn_tongiao,
            'longkhanh_tinnguong_dacapgcn_khac' => $longkhanh_tinnguong_dacapgcn_khac,
            'longkhanh_tinnguong_chuacapgcn' => $longkhanh_tinnguong_chuacapgcn,

            /*XUÂN LỘC*/
            'xuanloc_tongdt' => $xuanloc_tongdt,
            'xuanloc_sodientichdat_dacapgcn_tong' => $xuanloc_sodientichdat_dacapgcn_tong,
            'xuanloc_sodientichdat_dacapgcn_tongiao' => $xuanloc_sodientichdat_dacapgcn_tongiao,
            'xuanloc_sodientichdat_dacapgcn_khac' => $xuanloc_sodientichdat_dacapgcn_khac,
            'xuanloc_sodientichdat_chuacapgcn' => $xuanloc_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'xuanloc_congiao_tongdt' => $xuanloc_congiao_tongdt,
            'xuanloc_congiao_dacapgcn_tongiao' => $xuanloc_congiao_dacapgcn_tongiao,
            'xuanloc_congiao_dacapgcn_khac' => $xuanloc_congiao_dacapgcn_khac,
            'xuanloc_congiao_chuacapgcn' => $xuanloc_congiao_chuacapgcn,
            //PHẬT GIÁO
            'xuanloc_phatgiao_tongdt' => $xuanloc_phatgiao_tongdt,
            'xuanloc_phatgiao_dacapgcn_tongiao' => $xuanloc_phatgiao_dacapgcn_tongiao,
            'xuanloc_phatgiao_dacapgcn_khac' => $xuanloc_phatgiao_dacapgcn_khac,
            'xuanloc_phatgiao_chuacapgcn' => $xuanloc_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'xuanloc_caodai_tongdt' => $xuanloc_caodai_tongdt,
            'xuanloc_caodai_dacapgcn_tongiao' => $xuanloc_caodai_dacapgcn_tongiao,
            'xuanloc_caodai_dacapgcn_khac' => $xuanloc_caodai_dacapgcn_khac,
            'xuanloc_caodai_chuacapgcn' => $xuanloc_caodai_chuacapgcn,
            //TĐCSPHVN
            'xuanloc_tdcsphvn_tongdt' => $xuanloc_tdcsphvn_tongdt,
            'xuanloc_tdcsphvn_dacapgcn_tongiao' => $xuanloc_tdcsphvn_dacapgcn_tongiao,
            'xuanloc_tdcsphvn_dacapgcn_khac' => $xuanloc_tdcsphvn_dacapgcn_khac,
            'xuanloc_tdcsphvn_chuacapgcn' => $xuanloc_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'xuanloc_hoigiao_tongdt' => $xuanloc_hoigiao_tongdt,
            'xuanloc_hoigiao_dacapgcn_tongiao' => $xuanloc_hoigiao_dacapgcn_tongiao,
            'xuanloc_hoigiao_dacapgcn_khac' => $xuanloc_hoigiao_dacapgcn_khac,
            'xuanloc_hoigiao_chuacapgcn' => $xuanloc_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'xuanloc_phatgiaohoahao_tongdt' =>  0, //$xuanloc_phatgiaohoahao_tongdt,
            'xuanloc_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$xuanloc_phatgiaohoahao_dacapgcn_tongiao,
            'xuanloc_phatgiaohoahao_dacapgcn_khac' =>  0, //$xuanloc_phatgiaohoahao_dacapgcn_khac,
            'xuanloc_phatgiaohoahao_chuacapgcn' =>  0, //$xuanloc_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'xuanloc_tinnguong_tongdt' => $xuanloc_tinnguong_tongdt,
            'xuanloc_tinnguong_dacapgcn_tongiao' => $xuanloc_tinnguong_dacapgcn_tongiao,
            'xuanloc_tinnguong_dacapgcn_khac' => $xuanloc_tinnguong_dacapgcn_khac,
            'xuanloc_tinnguong_chuacapgcn' => $xuanloc_tinnguong_chuacapgcn,

            /*CẨM MỸ*/
            'cammy_tongdt' => $cammy_tongdt,
            'cammy_sodientichdat_dacapgcn_tong' => $cammy_sodientichdat_dacapgcn_tong,
            'cammy_sodientichdat_dacapgcn_tongiao' => $cammy_sodientichdat_dacapgcn_tongiao,
            'cammy_sodientichdat_dacapgcn_khac' => $cammy_sodientichdat_dacapgcn_khac,
            'cammy_sodientichdat_chuacapgcn' => $cammy_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'cammy_congiao_tongdt' => $cammy_congiao_tongdt,
            'cammy_congiao_dacapgcn_tongiao' => $cammy_congiao_dacapgcn_tongiao,
            'cammy_congiao_dacapgcn_khac' => $cammy_congiao_dacapgcn_khac,
            'cammy_congiao_chuacapgcn' => $cammy_congiao_chuacapgcn,
            //PHẬT GIÁO
            'cammy_phatgiao_tongdt' => $cammy_phatgiao_tongdt,
            'cammy_phatgiao_dacapgcn_tongiao' => $cammy_phatgiao_dacapgcn_tongiao,
            'cammy_phatgiao_dacapgcn_khac' => $cammy_phatgiao_dacapgcn_khac,
            'cammy_phatgiao_chuacapgcn' => $cammy_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'cammy_caodai_tongdt' => $cammy_caodai_tongdt,
            'cammy_caodai_dacapgcn_tongiao' => $cammy_caodai_dacapgcn_tongiao,
            'cammy_caodai_dacapgcn_khac' => $cammy_caodai_dacapgcn_khac,
            'cammy_caodai_chuacapgcn' => $cammy_caodai_chuacapgcn,
            //TĐCSPHVN
            'cammy_tdcsphvn_tongdt' => $cammy_tdcsphvn_tongdt,
            'cammy_tdcsphvn_dacapgcn_tongiao' => $cammy_tdcsphvn_dacapgcn_tongiao,
            'cammy_tdcsphvn_dacapgcn_khac' => $cammy_tdcsphvn_dacapgcn_khac,
            'cammy_tdcsphvn_chuacapgcn' => $cammy_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'cammy_hoigiao_tongdt' => $cammy_hoigiao_tongdt,
            'cammy_hoigiao_dacapgcn_tongiao' => $cammy_hoigiao_dacapgcn_tongiao,
            'cammy_hoigiao_dacapgcn_khac' => $cammy_hoigiao_dacapgcn_khac,
            'cammy_hoigiao_chuacapgcn' => $cammy_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'cammy_phatgiaohoahao_tongdt' =>  0, //$cammy_phatgiaohoahao_tongdt,
            'cammy_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$cammy_phatgiaohoahao_dacapgcn_tongiao,
            'cammy_phatgiaohoahao_dacapgcn_khac' =>  0, //$cammy_phatgiaohoahao_dacapgcn_khac,
            'cammy_phatgiaohoahao_chuacapgcn' =>  0, //$cammy_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'cammy_tinnguong_tongdt' => $cammy_tinnguong_tongdt,
            'cammy_tinnguong_dacapgcn_tongiao' => $cammy_tinnguong_dacapgcn_tongiao,
            'cammy_tinnguong_dacapgcn_khac' => $cammy_tinnguong_dacapgcn_khac,
            'cammy_tinnguong_chuacapgcn' => $cammy_tinnguong_chuacapgcn,

            /*TÂN PHÚ*/
            'tanphu_tongdt' => $tanphu_tongdt,
            'tanphu_sodientichdat_dacapgcn_tong' => $tanphu_sodientichdat_dacapgcn_tong,
            'tanphu_sodientichdat_dacapgcn_tongiao' => $tanphu_sodientichdat_dacapgcn_tongiao,
            'tanphu_sodientichdat_dacapgcn_khac' => $tanphu_sodientichdat_dacapgcn_khac,
            'tanphu_sodientichdat_chuacapgcn' => $tanphu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'tanphu_congiao_tongdt' => $tanphu_congiao_tongdt,
            'tanphu_congiao_dacapgcn_tongiao' => $tanphu_congiao_dacapgcn_tongiao,
            'tanphu_congiao_dacapgcn_khac' => $tanphu_congiao_dacapgcn_khac,
            'tanphu_congiao_chuacapgcn' => $tanphu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'tanphu_phatgiao_tongdt' => $tanphu_phatgiao_tongdt,
            'tanphu_phatgiao_dacapgcn_tongiao' => $tanphu_phatgiao_dacapgcn_tongiao,
            'tanphu_phatgiao_dacapgcn_khac' => $tanphu_phatgiao_dacapgcn_khac,
            'tanphu_phatgiao_chuacapgcn' => $tanphu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'tanphu_caodai_tongdt' => $tanphu_caodai_tongdt,
            'tanphu_caodai_dacapgcn_tongiao' => $tanphu_caodai_dacapgcn_tongiao,
            'tanphu_caodai_dacapgcn_khac' => $tanphu_caodai_dacapgcn_khac,
            'tanphu_caodai_chuacapgcn' => $tanphu_caodai_chuacapgcn,
            //TĐCSPHVN
            'tanphu_tdcsphvn_tongdt' => $tanphu_tdcsphvn_tongdt,
            'tanphu_tdcsphvn_dacapgcn_tongiao' => $tanphu_tdcsphvn_dacapgcn_tongiao,
            'tanphu_tdcsphvn_dacapgcn_khac' => $tanphu_tdcsphvn_dacapgcn_khac,
            'tanphu_tdcsphvn_chuacapgcn' => $tanphu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'tanphu_hoigiao_tongdt' => $tanphu_hoigiao_tongdt,
            'tanphu_hoigiao_dacapgcn_tongiao' => $tanphu_hoigiao_dacapgcn_tongiao,
            'tanphu_hoigiao_dacapgcn_khac' => $tanphu_hoigiao_dacapgcn_khac,
            'tanphu_hoigiao_chuacapgcn' => $tanphu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'tanphu_phatgiaohoahao_tongdt' =>  0, //$tanphu_phatgiaohoahao_tongdt,
            'tanphu_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$tanphu_phatgiaohoahao_dacapgcn_tongiao,
            'tanphu_phatgiaohoahao_dacapgcn_khac' =>  0, //$tanphu_phatgiaohoahao_dacapgcn_khac,
            'tanphu_phatgiaohoahao_chuacapgcn' =>  0, //$tanphu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'tanphu_tinnguong_tongdt' => $tanphu_tinnguong_tongdt,
            'tanphu_tinnguong_dacapgcn_tongiao' => $tanphu_tinnguong_dacapgcn_tongiao,
            'tanphu_tinnguong_dacapgcn_khac' => $tanphu_tinnguong_dacapgcn_khac,
            'tanphu_tinnguong_chuacapgcn' => $tanphu_tinnguong_chuacapgcn,

            /*ĐỊNH QUÁN*/
            'dinhquan_tongdt' => $dinhquan_tongdt,
            'dinhquan_sodientichdat_dacapgcn_tong' => $dinhquan_sodientichdat_dacapgcn_tong,
            'dinhquan_sodientichdat_dacapgcn_tongiao' => $dinhquan_sodientichdat_dacapgcn_tongiao,
            'dinhquan_sodientichdat_dacapgcn_khac' => $dinhquan_sodientichdat_dacapgcn_khac,
            'dinhquan_sodientichdat_chuacapgcn' => $dinhquan_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'dinhquan_congiao_tongdt' => $dinhquan_congiao_tongdt,
            'dinhquan_congiao_dacapgcn_tongiao' => $dinhquan_congiao_dacapgcn_tongiao,
            'dinhquan_congiao_dacapgcn_khac' => $dinhquan_congiao_dacapgcn_khac,
            'dinhquan_congiao_chuacapgcn' => $dinhquan_congiao_chuacapgcn,
            //PHẬT GIÁO
            'dinhquan_phatgiao_tongdt' => $dinhquan_phatgiao_tongdt,
            'dinhquan_phatgiao_dacapgcn_tongiao' => $dinhquan_phatgiao_dacapgcn_tongiao,
            'dinhquan_phatgiao_dacapgcn_khac' => $dinhquan_phatgiao_dacapgcn_khac,
            'dinhquan_phatgiao_chuacapgcn' => $dinhquan_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'dinhquan_caodai_tongdt' => $dinhquan_caodai_tongdt,
            'dinhquan_caodai_dacapgcn_tongiao' => $dinhquan_caodai_dacapgcn_tongiao,
            'dinhquan_caodai_dacapgcn_khac' => $dinhquan_caodai_dacapgcn_khac,
            'dinhquan_caodai_chuacapgcn' => $dinhquan_caodai_chuacapgcn,
            //TĐCSPHVN
            'dinhquan_tdcsphvn_tongdt' => $dinhquan_tdcsphvn_tongdt,
            'dinhquan_tdcsphvn_dacapgcn_tongiao' => $dinhquan_tdcsphvn_dacapgcn_tongiao,
            'dinhquan_tdcsphvn_dacapgcn_khac' => $dinhquan_tdcsphvn_dacapgcn_khac,
            'dinhquan_tdcsphvn_chuacapgcn' => $dinhquan_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'dinhquan_hoigiao_tongdt' => $dinhquan_hoigiao_tongdt,
            'dinhquan_hoigiao_dacapgcn_tongiao' => $dinhquan_hoigiao_dacapgcn_tongiao,
            'dinhquan_hoigiao_dacapgcn_khac' => $dinhquan_hoigiao_dacapgcn_khac,
            'dinhquan_hoigiao_chuacapgcn' => $dinhquan_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'dinhquan_phatgiaohoahao_tongdt' =>  0, //$dinhquan_phatgiaohoahao_tongdt,
            'dinhquan_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$dinhquan_phatgiaohoahao_dacapgcn_tongiao,
            'dinhquan_phatgiaohoahao_dacapgcn_khac' =>  0, //$dinhquan_phatgiaohoahao_dacapgcn_khac,
            'dinhquan_phatgiaohoahao_chuacapgcn' =>  0, //$dinhquan_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'dinhquan_tinnguong_tongdt' => $dinhquan_tinnguong_tongdt,
            'dinhquan_tinnguong_dacapgcn_tongiao' => $dinhquan_tinnguong_dacapgcn_tongiao,
            'dinhquan_tinnguong_dacapgcn_khac' => $dinhquan_tinnguong_dacapgcn_khac,
            'dinhquan_tinnguong_chuacapgcn' => $dinhquan_tinnguong_chuacapgcn,

            /*THỐNG NHẤT*/
            'thongnhat_tongdt' => $thongnhat_tongdt,
            'thongnhat_sodientichdat_dacapgcn_tong' => $thongnhat_sodientichdat_dacapgcn_tong,
            'thongnhat_sodientichdat_dacapgcn_tongiao' => $thongnhat_sodientichdat_dacapgcn_tongiao,
            'thongnhat_sodientichdat_dacapgcn_khac' => $thongnhat_sodientichdat_dacapgcn_khac,
            'thongnhat_sodientichdat_chuacapgcn' => $thongnhat_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'thongnhat_congiao_tongdt' => $thongnhat_congiao_tongdt,
            'thongnhat_congiao_dacapgcn_tongiao' => $thongnhat_congiao_dacapgcn_tongiao,
            'thongnhat_congiao_dacapgcn_khac' => $thongnhat_congiao_dacapgcn_khac,
            'thongnhat_congiao_chuacapgcn' => $thongnhat_congiao_chuacapgcn,
            //PHẬT GIÁO
            'thongnhat_phatgiao_tongdt' => $thongnhat_phatgiao_tongdt,
            'thongnhat_phatgiao_dacapgcn_tongiao' => $thongnhat_phatgiao_dacapgcn_tongiao,
            'thongnhat_phatgiao_dacapgcn_khac' => $thongnhat_phatgiao_dacapgcn_khac,
            'thongnhat_phatgiao_chuacapgcn' => $thongnhat_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'thongnhat_caodai_tongdt' => $thongnhat_caodai_tongdt,
            'thongnhat_caodai_dacapgcn_tongiao' => $thongnhat_caodai_dacapgcn_tongiao,
            'thongnhat_caodai_dacapgcn_khac' => $thongnhat_caodai_dacapgcn_khac,
            'thongnhat_caodai_chuacapgcn' => $thongnhat_caodai_chuacapgcn,
            //TĐCSPHVN
            'thongnhat_tdcsphvn_tongdt' => $thongnhat_tdcsphvn_tongdt,
            'thongnhat_tdcsphvn_dacapgcn_tongiao' => $thongnhat_tdcsphvn_dacapgcn_tongiao,
            'thongnhat_tdcsphvn_dacapgcn_khac' => $thongnhat_tdcsphvn_dacapgcn_khac,
            'thongnhat_tdcsphvn_chuacapgcn' => $thongnhat_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'thongnhat_hoigiao_tongdt' => $thongnhat_hoigiao_tongdt,
            'thongnhat_hoigiao_dacapgcn_tongiao' => $thongnhat_hoigiao_dacapgcn_tongiao,
            'thongnhat_hoigiao_dacapgcn_khac' => $thongnhat_hoigiao_dacapgcn_khac,
            'thongnhat_hoigiao_chuacapgcn' => $thongnhat_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'thongnhat_phatgiaohoahao_tongdt' =>  0, //$thongnhat_phatgiaohoahao_tongdt,
            'thongnhat_phatgiaohoahao_dacapgcn_tongiao' => 0, // $thongnhat_phatgiaohoahao_dacapgcn_tongiao,
            'thongnhat_phatgiaohoahao_dacapgcn_khac' =>  0, //$thongnhat_phatgiaohoahao_dacapgcn_khac,
            'thongnhat_phatgiaohoahao_chuacapgcn' =>  0, //$thongnhat_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'thongnhat_tinnguong_tongdt' => $thongnhat_tinnguong_tongdt,
            'thongnhat_tinnguong_dacapgcn_tongiao' => $thongnhat_tinnguong_dacapgcn_tongiao,
            'thongnhat_tinnguong_dacapgcn_khac' => $thongnhat_tinnguong_dacapgcn_khac,
            'thongnhat_tinnguong_chuacapgcn' => $thongnhat_tinnguong_chuacapgcn,

            /*TRẢNG BOM*/
            'trangbom_tongdt' => $trangbom_tongdt,
            'trangbom_sodientichdat_dacapgcn_tong' => $trangbom_sodientichdat_dacapgcn_tong,
            'trangbom_sodientichdat_dacapgcn_tongiao' => $trangbom_sodientichdat_dacapgcn_tongiao,
            'trangbom_sodientichdat_dacapgcn_khac' => $trangbom_sodientichdat_dacapgcn_khac,
            'trangbom_sodientichdat_chuacapgcn' => $trangbom_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'trangbom_congiao_tongdt' => $trangbom_congiao_tongdt,
            'trangbom_congiao_dacapgcn_tongiao' => $trangbom_congiao_dacapgcn_tongiao,
            'trangbom_congiao_dacapgcn_khac' => $trangbom_congiao_dacapgcn_khac,
            'trangbom_congiao_chuacapgcn' => $trangbom_congiao_chuacapgcn,
            //PHẬT GIÁO
            'trangbom_phatgiao_tongdt' => $trangbom_phatgiao_tongdt,
            'trangbom_phatgiao_dacapgcn_tongiao' => $trangbom_phatgiao_dacapgcn_tongiao,
            'trangbom_phatgiao_dacapgcn_khac' => $trangbom_phatgiao_dacapgcn_khac,
            'trangbom_phatgiao_chuacapgcn' => $trangbom_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'trangbom_caodai_tongdt' => $trangbom_caodai_tongdt,
            'trangbom_caodai_dacapgcn_tongiao' => $trangbom_caodai_dacapgcn_tongiao,
            'trangbom_caodai_dacapgcn_khac' => $trangbom_caodai_dacapgcn_khac,
            'trangbom_caodai_chuacapgcn' => $trangbom_caodai_chuacapgcn,
            //TĐCSPHVN
            'trangbom_tdcsphvn_tongdt' => $trangbom_tdcsphvn_tongdt,
            'trangbom_tdcsphvn_dacapgcn_tongiao' => $trangbom_tdcsphvn_dacapgcn_tongiao,
            'trangbom_tdcsphvn_dacapgcn_khac' => $trangbom_tdcsphvn_dacapgcn_khac,
            'trangbom_tdcsphvn_chuacapgcn' => $trangbom_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'trangbom_hoigiao_tongdt' => $trangbom_hoigiao_tongdt,
            'trangbom_hoigiao_dacapgcn_tongiao' => $trangbom_hoigiao_dacapgcn_tongiao,
            'trangbom_hoigiao_dacapgcn_khac' => $trangbom_hoigiao_dacapgcn_khac,
            'trangbom_hoigiao_chuacapgcn' => $trangbom_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'trangbom_phatgiaohoahao_tongdt' =>  0, //$trangbom_phatgiaohoahao_tongdt,
            'trangbom_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$trangbom_phatgiaohoahao_dacapgcn_tongiao,
            'trangbom_phatgiaohoahao_dacapgcn_khac' =>  0, //$trangbom_phatgiaohoahao_dacapgcn_khac,
            'trangbom_phatgiaohoahao_chuacapgcn' =>  0, //$trangbom_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'trangbom_tinnguong_tongdt' => $trangbom_tinnguong_tongdt,
            'trangbom_tinnguong_dacapgcn_tongiao' => $trangbom_tinnguong_dacapgcn_tongiao,
            'trangbom_tinnguong_dacapgcn_khac' => $trangbom_tinnguong_dacapgcn_khac,
            'trangbom_tinnguong_chuacapgcn' => $trangbom_tinnguong_chuacapgcn,

            /*VĨNH CỬU*/
            'vinhcuu_tongdt' => $vinhcuu_tongdt,
            'vinhcuu_sodientichdat_dacapgcn_tong' => $vinhcuu_sodientichdat_dacapgcn_tong,
            'vinhcuu_sodientichdat_dacapgcn_tongiao' => $vinhcuu_sodientichdat_dacapgcn_tongiao,
            'vinhcuu_sodientichdat_dacapgcn_khac' => $vinhcuu_sodientichdat_dacapgcn_khac,
            'vinhcuu_sodientichdat_chuacapgcn' => $vinhcuu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'vinhcuu_congiao_tongdt' => $vinhcuu_congiao_tongdt,
            'vinhcuu_congiao_dacapgcn_tongiao' => $vinhcuu_congiao_dacapgcn_tongiao,
            'vinhcuu_congiao_dacapgcn_khac' => $vinhcuu_congiao_dacapgcn_khac,
            'vinhcuu_congiao_chuacapgcn' => $vinhcuu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'vinhcuu_phatgiao_tongdt' => $vinhcuu_phatgiao_tongdt,
            'vinhcuu_phatgiao_dacapgcn_tongiao' => $vinhcuu_phatgiao_dacapgcn_tongiao,
            'vinhcuu_phatgiao_dacapgcn_khac' => $vinhcuu_phatgiao_dacapgcn_khac,
            'vinhcuu_phatgiao_chuacapgcn' => $vinhcuu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'vinhcuu_caodai_tongdt' => $vinhcuu_caodai_tongdt,
            'vinhcuu_caodai_dacapgcn_tongiao' => $vinhcuu_caodai_dacapgcn_tongiao,
            'vinhcuu_caodai_dacapgcn_khac' => $vinhcuu_caodai_dacapgcn_khac,
            'vinhcuu_caodai_chuacapgcn' => $vinhcuu_caodai_chuacapgcn,
            //TĐCSPHVN
            'vinhcuu_tdcsphvn_tongdt' => $vinhcuu_tdcsphvn_tongdt,
            'vinhcuu_tdcsphvn_dacapgcn_tongiao' => $vinhcuu_tdcsphvn_dacapgcn_tongiao,
            'vinhcuu_tdcsphvn_dacapgcn_khac' => $vinhcuu_tdcsphvn_dacapgcn_khac,
            'vinhcuu_tdcsphvn_chuacapgcn' => $vinhcuu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'vinhcuu_hoigiao_tongdt' => $vinhcuu_hoigiao_tongdt,
            'vinhcuu_hoigiao_dacapgcn_tongiao' => $vinhcuu_hoigiao_dacapgcn_tongiao,
            'vinhcuu_hoigiao_dacapgcn_khac' => $vinhcuu_hoigiao_dacapgcn_khac,
            'vinhcuu_hoigiao_chuacapgcn' => $vinhcuu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'vinhcuu_phatgiaohoahao_tongdt' =>  0, //$vinhcuu_phatgiaohoahao_tongdt,
            'vinhcuu_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$vinhcuu_phatgiaohoahao_dacapgcn_tongiao,
            'vinhcuu_phatgiaohoahao_dacapgcn_khac' =>  0, //$vinhcuu_phatgiaohoahao_dacapgcn_khac,
            'vinhcuu_phatgiaohoahao_chuacapgcn' =>  0, //$vinhcuu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'vinhcuu_tinnguong_tongdt' => $vinhcuu_tinnguong_tongdt,
            'vinhcuu_tinnguong_dacapgcn_tongiao' => $vinhcuu_tinnguong_dacapgcn_tongiao,
            'vinhcuu_tinnguong_dacapgcn_khac' => $vinhcuu_tinnguong_dacapgcn_khac,
            'vinhcuu_tinnguong_chuacapgcn' => $vinhcuu_tinnguong_chuacapgcn,

            /*NHƠN TRẠCH*/
            'nhontrach_tongdt' => $nhontrach_tongdt,
            'nhontrach_sodientichdat_dacapgcn_tong' => $nhontrach_sodientichdat_dacapgcn_tong,
            'nhontrach_sodientichdat_dacapgcn_tongiao' => $nhontrach_sodientichdat_dacapgcn_tongiao,
            'nhontrach_sodientichdat_dacapgcn_khac' => $nhontrach_sodientichdat_dacapgcn_khac,
            'nhontrach_sodientichdat_chuacapgcn' => $nhontrach_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'nhontrach_congiao_tongdt' => $nhontrach_congiao_tongdt,
            'nhontrach_congiao_dacapgcn_tongiao' => $nhontrach_congiao_dacapgcn_tongiao,
            'nhontrach_congiao_dacapgcn_khac' => $nhontrach_congiao_dacapgcn_khac,
            'nhontrach_congiao_chuacapgcn' => $nhontrach_congiao_chuacapgcn,
            //PHẬT GIÁO
            'nhontrach_phatgiao_tongdt' => $nhontrach_phatgiao_tongdt,
            'nhontrach_phatgiao_dacapgcn_tongiao' => $nhontrach_phatgiao_dacapgcn_tongiao,
            'nhontrach_phatgiao_dacapgcn_khac' => $nhontrach_phatgiao_dacapgcn_khac,
            'nhontrach_phatgiao_chuacapgcn' => $nhontrach_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'nhontrach_caodai_tongdt' => $nhontrach_caodai_tongdt,
            'nhontrach_caodai_dacapgcn_tongiao' => $nhontrach_caodai_dacapgcn_tongiao,
            'nhontrach_caodai_dacapgcn_khac' => $nhontrach_caodai_dacapgcn_khac,
            'nhontrach_caodai_chuacapgcn' => $nhontrach_caodai_chuacapgcn,
            //TĐCSPHVN
            'nhontrach_tdcsphvn_tongdt' => $nhontrach_tdcsphvn_tongdt,
            'nhontrach_tdcsphvn_dacapgcn_tongiao' => $nhontrach_tdcsphvn_dacapgcn_tongiao,
            'nhontrach_tdcsphvn_dacapgcn_khac' => $nhontrach_tdcsphvn_dacapgcn_khac,
            'nhontrach_tdcsphvn_chuacapgcn' => $nhontrach_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'nhontrach_hoigiao_tongdt' => $nhontrach_hoigiao_tongdt,
            'nhontrach_hoigiao_dacapgcn_tongiao' => $nhontrach_hoigiao_dacapgcn_tongiao,
            'nhontrach_hoigiao_dacapgcn_khac' => $nhontrach_hoigiao_dacapgcn_khac,
            'nhontrach_hoigiao_chuacapgcn' => $nhontrach_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'nhontrach_phatgiaohoahao_tongdt' =>  0, //$nhontrach_phatgiaohoahao_tongdt,
            'nhontrach_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$nhontrach_phatgiaohoahao_dacapgcn_tongiao,
            'nhontrach_phatgiaohoahao_dacapgcn_khac' =>  0, //$nhontrach_phatgiaohoahao_dacapgcn_khac,
            'nhontrach_phatgiaohoahao_chuacapgcn' =>  0, //$nhontrach_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'nhontrach_tinnguong_tongdt' => $nhontrach_tinnguong_tongdt,
            'nhontrach_tinnguong_dacapgcn_tongiao' => $nhontrach_tinnguong_dacapgcn_tongiao,
            'nhontrach_tinnguong_dacapgcn_khac' => $nhontrach_tinnguong_dacapgcn_khac,
            'nhontrach_tinnguong_chuacapgcn' => $nhontrach_tinnguong_chuacapgcn,

            /*LONG THÀNH*/
            'longthanh_tongdt' => $longthanh_tongdt,
            'longthanh_sodientichdat_dacapgcn_tong' => $longthanh_sodientichdat_dacapgcn_tong,
            'longthanh_sodientichdat_dacapgcn_tongiao' => $longthanh_sodientichdat_dacapgcn_tongiao,
            'longthanh_sodientichdat_dacapgcn_khac' => $longthanh_sodientichdat_dacapgcn_khac,
            'longthanh_sodientichdat_chuacapgcn' => $longthanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longthanh_congiao_tongdt' => $longthanh_congiao_tongdt,
            'longthanh_congiao_dacapgcn_tongiao' => $longthanh_congiao_dacapgcn_tongiao,
            'longthanh_congiao_dacapgcn_khac' => $longthanh_congiao_dacapgcn_khac,
            'longthanh_congiao_chuacapgcn' => $longthanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longthanh_phatgiao_tongdt' => $longthanh_phatgiao_tongdt,
            'longthanh_phatgiao_dacapgcn_tongiao' => $longthanh_phatgiao_dacapgcn_tongiao,
            'longthanh_phatgiao_dacapgcn_khac' => $longthanh_phatgiao_dacapgcn_khac,
            'longthanh_phatgiao_chuacapgcn' => $longthanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longthanh_caodai_tongdt' => $longthanh_caodai_tongdt,
            'longthanh_caodai_dacapgcn_tongiao' => $longthanh_caodai_dacapgcn_tongiao,
            'longthanh_caodai_dacapgcn_khac' => $longthanh_caodai_dacapgcn_khac,
            'longthanh_caodai_chuacapgcn' => $longthanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longthanh_tdcsphvn_tongdt' => $longthanh_tdcsphvn_tongdt,
            'longthanh_tdcsphvn_dacapgcn_tongiao' => $longthanh_tdcsphvn_dacapgcn_tongiao,
            'longthanh_tdcsphvn_dacapgcn_khac' => $longthanh_tdcsphvn_dacapgcn_khac,
            'longthanh_tdcsphvn_chuacapgcn' => $longthanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longthanh_hoigiao_tongdt' => $longthanh_hoigiao_tongdt,
            'longthanh_hoigiao_dacapgcn_tongiao' => $longthanh_hoigiao_dacapgcn_tongiao,
            'longthanh_hoigiao_dacapgcn_khac' => $longthanh_hoigiao_dacapgcn_khac,
            'longthanh_hoigiao_chuacapgcn' => $longthanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longthanh_phatgiaohoahao_tongdt' =>  0, //$longthanh_phatgiaohoahao_tongdt,
            'longthanh_phatgiaohoahao_dacapgcn_tongiao' =>  0, //$longthanh_phatgiaohoahao_dacapgcn_tongiao,
            'longthanh_phatgiaohoahao_dacapgcn_khac' =>  0, //$longthanh_phatgiaohoahao_dacapgcn_khac,
            'longthanh_phatgiaohoahao_chuacapgcn' =>  0, //$longthanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longthanh_tinnguong_tongdt' => $longthanh_tinnguong_tongdt,
            'longthanh_tinnguong_dacapgcn_tongiao' => $longthanh_tinnguong_dacapgcn_tongiao,
            'longthanh_tinnguong_dacapgcn_khac' => $longthanh_tinnguong_dacapgcn_khac,
            'longthanh_tinnguong_chuacapgcn' => $longthanh_tinnguong_chuacapgcn,

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
            'phatgiaohoahao_tongdt' => $phatgiaohoahao_tongdt,
            'phatgiaohoahao_dacapgcn_tongiao' => $phatgiaohoahao_dacapgcn_tongiao,
            'phatgiaohoahao_dacapgcn_khac' => $phatgiaohoahao_dacapgcn_khac,
            'phatgiaohoahao_chuacapgcn' => $phatgiaohoahao_chuacapgcn,
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
        
        print "<pre>";
        print_r($data);
        print "</pre>";
        exit;
    }
}
