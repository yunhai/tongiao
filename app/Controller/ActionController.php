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
            //TONG_HOP_CHUC_SAC => 'TONG HOP CHUC SAC',
            TONG_HOP_DAT_DAI => 'TONG HOP DAT DAI',
            TH_TON_GIAO_CO_SO => 'TH TON GIAO CO SO',
            TH_CO_SO_TON_GIAO => 'TH CO SO TON GIAO',
            TONG_HOP_DI_TICH => 'TONG HOP DI TICH',
            TONG_HOP_CSTT_XAY_DUNG => 'TONG HOP CSTT XAY DUNG',
            TONG_HOP_CSTG_TRUNG_TU => 'TONG HOP CSTG TRUNG TU',
            BANG_TONG_HOP_TIN_DO => 'BANG TONG HOP TIN DO',
            DS_CSTT => 'ds cstt',
            DSCS_BAO_TRO_XA_HOI => 'DSCS BAO TRO XA HOI'
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
                    "LOWER({$model}.{$value}) LIKE" => '%' . strtolower($search) . '%'
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

    public function template($type)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . "template{$type}.xls";
        $filename = "template{$type}";
        $this->Excel->load($source);
        $this->{"__createTemplate{$type}"}();
        $this->Excel->save($filename);
    }

    /**
     * Tạo template
     */
    public function __createTemplate0()
    {
        $maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 2;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }

        $arrays = array(
            9 => 'bien_hoa',
            10 => 'cam_my',
            11 => 'dinh_quan',
            12 => 'long_khanh',
            13 => 'long_thanh',
            14 => 'nhon_trach',
            15 => 'thong_nhat',
            16 => 'trang_bom',
            17 => 'tan_phu',
            18 => 'vinh_cuu',
            19 => 'xuan_loc',
            20 => 'tong'
        );

        foreach ($arrays as $key => $value) {
            for ($r = 3; $r <= $maxRows; $r++) {
                foreach ($colIndexes as $k => $c) {
                    $this->Excel->ActiveSheet->getCell("{$c}{$key}")->setValue('{$'.$value.$k.'}');
                }
            }
        }
        //exit;
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
        $result = $this->getExcelData();

        $tongdt = $result['bien-hoa']['2'] + $result['long-khanh']['2'] + $result['xuan-loc']['2'] + $result['cam-my']['2'] + $result['tan-phu']['2'] + $result['dinh-quan']['2'] + $result['thong-nhat']['2'] + $result['trang-bom']['2'] + $result['vinh-cuu']['2'] + $result['nhon-trach']['2'] + $result['long-thanh']['2'];
        $sodientichdat_dacapgcn_tong = $result['bien-hoa']['3'] + $result['long-khanh']['3'] + $result['xuan-loc']['3'] + $result['cam-my']['3'] + $result['tan-phu']['3'] + $result['dinh-quan']['3'] + $result['thong-nhat']['3'] + $result['trang-bom']['3'] + $result['vinh-cuu']['3'] + $result['nhon-trach']['3'] + $result['long-thanh']['3'];
        $sodientichdat_dacapgcn_tongiao = $result['bien-hoa']['4'] + $result['long-khanh']['4'] + $result['xuan-loc']['4'] + $result['cam-my']['4'] + $result['tan-phu']['4'] + $result['dinh-quan']['4'] + $result['thong-nhat']['4'] + $result['trang-bom']['4'] + $result['vinh-cuu']['4'] + $result['nhon-trach']['4'] + $result['long-thanh']['4'];
        $sodientichdat_dacapgcn_khac = $result['bien-hoa']['5'] + $result['long-khanh']['5'] + $result['xuan-loc']['5'] + $result['cam-my']['5'] + $result['tan-phu']['5'] + $result['dinh-quan']['5'] + $result['thong-nhat']['5'] + $result['trang-bom']['5'] + $result['vinh-cuu']['5'] + $result['nhon-trach']['5'] + $result['long-thanh']['5'];
        $sodientichdat_chuacapgcn = $result['bien-hoa']['6'] + $result['long-khanh']['6'] + $result['xuan-loc']['6'] + $result['cam-my']['6'] + $result['tan-phu']['6'] + $result['dinh-quan']['6'] + $result['thong-nhat']['6'] + $result['trang-bom']['6'] + $result['vinh-cuu']['6'] + $result['nhon-trach']['6'] + $result['long-thanh']['6'];
        $congiao_tongdt = $result['bien-hoa']['7'] + $result['long-khanh']['7'] + $result['xuan-loc']['7'] + $result['cam-my']['7'] + $result['tan-phu']['7'] + $result['dinh-quan']['7'] + $result['thong-nhat']['7'] + $result['trang-bom']['7'] + $result['vinh-cuu']['7'] + $result['nhon-trach']['7'] + $result['long-thanh']['7'];
        $congiao_dacapgcn_tongiao = $result['bien-hoa']['8'] + $result['long-khanh']['8'] + $result['xuan-loc']['8'] + $result['cam-my']['8'] + $result['tan-phu']['8'] + $result['dinh-quan']['8'] + $result['thong-nhat']['8'] + $result['trang-bom']['8'] + $result['vinh-cuu']['8'] + $result['nhon-trach']['8'] + $result['long-thanh']['8'];
        $congiao_dacapgcn_khac = $result['bien-hoa']['9'] + $result['long-khanh']['9'] + $result['xuan-loc']['9'] + $result['cam-my']['9'] + $result['tan-phu']['9'] + $result['dinh-quan']['9'] + $result['thong-nhat']['9'] + $result['trang-bom']['9'] + $result['vinh-cuu']['9'] + $result['nhon-trach']['9'] + $result['long-thanh']['9'];
        $congiao_chuacapgcn = $result['bien-hoa']['10'] + $result['long-khanh']['10'] + $result['xuan-loc']['10'] + $result['cam-my']['10'] + $result['tan-phu']['10'] + $result['dinh-quan']['10'] + $result['thong-nhat']['10'] + $result['trang-bom']['10'] + $result['vinh-cuu']['10'] + $result['nhon-trach']['10'] + $result['long-thanh']['10'];
        $phatgiao_tongdt = $result['bien-hoa']['11'] + $result['long-khanh']['11'] + $result['xuan-loc']['11'] + $result['cam-my']['11'] + $result['tan-phu']['11'] + $result['dinh-quan']['11'] + $result['thong-nhat']['11'] + $result['trang-bom']['11'] + $result['vinh-cuu']['11'] + $result['nhon-trach']['11'] + $result['long-thanh']['11'];
        $phatgiao_dacapgcn_tongiao = $result['bien-hoa']['12'] + $result['long-khanh']['12'] + $result['xuan-loc']['12'] + $result['cam-my']['12'] + $result['tan-phu']['12'] + $result['dinh-quan']['12'] + $result['thong-nhat']['12'] + $result['trang-bom']['12'] + $result['vinh-cuu']['12'] + $result['nhon-trach']['12'] + $result['long-thanh']['12'];
        $phatgiao_dacapgcn_khac = $result['bien-hoa']['13'] + $result['long-khanh']['13'] + $result['xuan-loc']['13'] + $result['cam-my']['13'] + $result['tan-phu']['13'] + $result['dinh-quan']['13'] + $result['thong-nhat']['13'] + $result['trang-bom']['13'] + $result['vinh-cuu']['13'] + $result['nhon-trach']['13'] + $result['long-thanh']['13'];
        $phatgiao_chuacapgcn = $result['bien-hoa']['14'] + $result['long-khanh']['14'] + $result['xuan-loc']['14'] + $result['cam-my']['14'] + $result['tan-phu']['14'] + $result['dinh-quan']['14'] + $result['thong-nhat']['14'] + $result['trang-bom']['14'] + $result['vinh-cuu']['14'] + $result['nhon-trach']['14'] + $result['long-thanh']['14'];
        $caodai_tongdt = $result['bien-hoa']['15'] + $result['long-khanh']['15'] + $result['xuan-loc']['15'] + $result['cam-my']['15'] + $result['tan-phu']['15'] + $result['dinh-quan']['15'] + $result['thong-nhat']['15'] + $result['trang-bom']['15'] + $result['vinh-cuu']['15'] + $result['nhon-trach']['15'] + $result['long-thanh']['15'];
        $caodai_dacapgcn_tongiao = $result['bien-hoa']['16'] + $result['long-khanh']['16'] + $result['xuan-loc']['16'] + $result['cam-my']['16'] + $result['tan-phu']['16'] + $result['dinh-quan']['16'] + $result['thong-nhat']['16'] + $result['trang-bom']['16'] + $result['vinh-cuu']['16'] + $result['nhon-trach']['16'] + $result['long-thanh']['16'];
        $caodai_dacapgcn_khac = $result['bien-hoa']['17'] + $result['long-khanh']['17'] + $result['xuan-loc']['17'] + $result['cam-my']['17'] + $result['tan-phu']['17'] + $result['dinh-quan']['17'] + $result['thong-nhat']['17'] + $result['trang-bom']['17'] + $result['vinh-cuu']['17'] + $result['nhon-trach']['17'] + $result['long-thanh']['17'];
        $caodai_chuacapgcn = $result['bien-hoa']['18'] + $result['long-khanh']['18'] + $result['xuan-loc']['18'] + $result['cam-my']['18'] + $result['tan-phu']['18'] + $result['dinh-quan']['18'] + $result['thong-nhat']['18'] + $result['trang-bom']['18'] + $result['vinh-cuu']['18'] + $result['nhon-trach']['18'] + $result['long-thanh']['18'];
        $tdcsphvn_tongdt = $result['bien-hoa']['19'] + $result['long-khanh']['19'] + $result['xuan-loc']['19'] + $result['cam-my']['19'] + $result['tan-phu']['19'] + $result['dinh-quan']['19'] + $result['thong-nhat']['19'] + $result['trang-bom']['19'] + $result['vinh-cuu']['19'] + $result['nhon-trach']['19'] + $result['long-thanh']['19'];
        $tdcsphvn_dacapgcn_tongiao = $result['bien-hoa']['20'] + $result['long-khanh']['20'] + $result['xuan-loc']['20'] + $result['cam-my']['20'] + $result['tan-phu']['20'] + $result['dinh-quan']['20'] + $result['thong-nhat']['20'] + $result['trang-bom']['20'] + $result['vinh-cuu']['20'] + $result['nhon-trach']['20'] + $result['long-thanh']['20'];
        $tdcsphvn_dacapgcn_khac = $result['bien-hoa']['21'] + $result['long-khanh']['21'] + $result['xuan-loc']['21'] + $result['cam-my']['21'] + $result['tan-phu']['21'] + $result['dinh-quan']['21'] + $result['thong-nhat']['21'] + $result['trang-bom']['21'] + $result['vinh-cuu']['21'] + $result['nhon-trach']['21'] + $result['long-thanh']['21'];
        $tdcsphvn_chuacapgcn = $result['bien-hoa']['22'] + $result['long-khanh']['22'] + $result['xuan-loc']['22'] + $result['cam-my']['22'] + $result['tan-phu']['22'] + $result['dinh-quan']['22'] + $result['thong-nhat']['22'] + $result['trang-bom']['22'] + $result['vinh-cuu']['22'] + $result['nhon-trach']['22'] + $result['long-thanh']['22'];
        $hoigiao_tongdt = $result['bien-hoa']['23'] + $result['long-khanh']['23'] + $result['xuan-loc']['23'] + $result['cam-my']['23'] + $result['tan-phu']['23'] + $result['dinh-quan']['23'] + $result['thong-nhat']['23'] + $result['trang-bom']['23'] + $result['vinh-cuu']['23'] + $result['nhon-trach']['23'] + $result['long-thanh']['23'];
        $hoigiao_dacapgcn_tongiao = $result['bien-hoa']['24'] + $result['long-khanh']['24'] + $result['xuan-loc']['24'] + $result['cam-my']['24'] + $result['tan-phu']['24'] + $result['dinh-quan']['24'] + $result['thong-nhat']['24'] + $result['trang-bom']['24'] + $result['vinh-cuu']['24'] + $result['nhon-trach']['24'] + $result['long-thanh']['24'];
        $hoigiao_dacapgcn_khac = $result['bien-hoa']['25'] + $result['long-khanh']['25'] + $result['xuan-loc']['25'] + $result['cam-my']['25'] + $result['tan-phu']['25'] + $result['dinh-quan']['25'] + $result['thong-nhat']['25'] + $result['trang-bom']['25'] + $result['vinh-cuu']['25'] + $result['nhon-trach']['25'] + $result['long-thanh']['25'];
        $hoigiao_chuacapgcn = $result['bien-hoa']['26'] + $result['long-khanh']['26'] + $result['xuan-loc']['26'] + $result['cam-my']['26'] + $result['tan-phu']['26'] + $result['dinh-quan']['26'] + $result['thong-nhat']['26'] + $result['trang-bom']['26'] + $result['vinh-cuu']['26'] + $result['nhon-trach']['26'] + $result['long-thanh']['26'];
        $tinnguong_tongdt = $result['bien-hoa']['31'] + $result['long-khanh']['31'] + $result['xuan-loc']['31'] + $result['cam-my']['31'] + $result['tan-phu']['31'] + $result['dinh-quan']['31'] + $result['thong-nhat']['31'] + $result['trang-bom']['31'] + $result['vinh-cuu']['31'] + $result['nhon-trach']['31'] + $result['long-thanh']['31'];
        $tinnguong_dacapgcn_tongiao = $result['bien-hoa']['32'] + $result['long-khanh']['32'] + $result['xuan-loc']['32'] + $result['cam-my']['32'] + $result['tan-phu']['32'] + $result['dinh-quan']['32'] + $result['thong-nhat']['32'] + $result['trang-bom']['32'] + $result['vinh-cuu']['32'] + $result['nhon-trach']['32'] + $result['long-thanh']['32'];
        $tinnguong_dacapgcn_khac = $result['bien-hoa']['33'] + $result['long-khanh']['33'] + $result['xuan-loc']['33'] + $result['cam-my']['33'] + $result['tan-phu']['33'] + $result['dinh-quan']['33'] + $result['thong-nhat']['33'] + $result['trang-bom']['33'] + $result['vinh-cuu']['33'] + $result['nhon-trach']['33'] + $result['long-thanh']['33'];
        $tinnguong_chuacapgcn = $result['bien-hoa']['34'] + $result['long-khanh']['34'] + $result['xuan-loc']['34'] + $result['cam-my']['34'] + $result['tan-phu']['34'] + $result['dinh-quan']['34'] + $result['thong-nhat']['34'] + $result['trang-bom']['34'] + $result['vinh-cuu']['34'] + $result['nhon-trach']['34'] + $result['long-thanh']['34'];

        $data = array(
            /*BIÊN HÒA*/
            //SỐ DIỆN TÍCH ĐẤT
            'bienhoa_tongdt' => $result['bien-hoa']['2'],//$bienhoa_tongdt,
            'bienhoa_sodientichdat_dacapgcn_tong' => $result['bien-hoa']['3'],//$bienhoa_sodientichdat_dacapgcn_tong,
            'bienhoa_sodientichdat_dacapgcn_tongiao' => $result['bien-hoa']['4'],//$bienhoa_sodientichdat_dacapgcn_tongiao,
            'bienhoa_sodientichdat_dacapgcn_khac' => $result['bien-hoa']['5'],//$bienhoa_sodientichdat_dacapgcn_khac,
            'bienhoa_sodientichdat_chuacapgcn' => $result['bien-hoa']['6'],//$bienhoa_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'bienhoa_congiao_tongdt' => $result['bien-hoa']['7'],//$bienhoa_congiao_tongdt,
            'bienhoa_congiao_dacapgcn_tongiao' => $result['bien-hoa']['8'],//$bienhoa_congiao_dacapgcn_tongiao,
            'bienhoa_congiao_dacapgcn_khac' => $result['bien-hoa']['9'],//$bienhoa_congiao_dacapgcn_khac,
            'bienhoa_congiao_chuacapgcn' => $result['bien-hoa']['10'],//$bienhoa_congiao_chuacapgcn,
            //PHẬT GIÁO
            'bienhoa_phatgiao_tongdt' => $result['bien-hoa']['11'],//$bienhoa_phatgiao_tongdt,
            'bienhoa_phatgiao_dacapgcn_tongiao' => $result['bien-hoa']['12'],//$bienhoa_phatgiao_dacapgcn_tongiao,
            'bienhoa_phatgiao_dacapgcn_khac' => $result['bien-hoa']['13'],//$bienhoa_phatgiao_dacapgcn_khac,
            'bienhoa_phatgiao_chuacapgcn' => $result['bien-hoa']['14'],//$bienhoa_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'bienhoa_caodai_tongdt' => $result['bien-hoa']['15'],//$bienhoa_caodai_tongdt,
            'bienhoa_caodai_dacapgcn_tongiao' => $result['bien-hoa']['16'],//$bienhoa_caodai_dacapgcn_tongiao,
            'bienhoa_caodai_dacapgcn_khac' => $result['bien-hoa']['17'],//$bienhoa_caodai_dacapgcn_khac,
            'bienhoa_caodai_chuacapgcn' => $result['bien-hoa']['18'],//$bienhoa_caodai_chuacapgcn,
            //TĐCSPHVN
            'bienhoa_tdcsphvn_tongdt' => $result['bien-hoa']['19'],//$bienhoa_tdcsphvn_tongdt,
            'bienhoa_tdcsphvn_dacapgcn_tongiao' => $result['bien-hoa']['20'],//$bienhoa_tdcsphvn_dacapgcn_tongiao,
            'bienhoa_tdcsphvn_dacapgcn_khac' => $result['bien-hoa']['21'],//$bienhoa_tdcsphvn_dacapgcn_khac,
            'bienhoa_tdcsphvn_chuacapgcn' => $result['bien-hoa']['22'],//$bienhoa_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'bienhoa_hoigiao_tongdt' => $result['bien-hoa']['23'],//$bienhoa_hoigiao_tongdt,
            'bienhoa_hoigiao_dacapgcn_tongiao' => $result['bien-hoa']['24'],//$bienhoa_hoigiao_dacapgcn_tongiao,
            'bienhoa_hoigiao_dacapgcn_khac' => $result['bien-hoa']['25'],//$bienhoa_hoigiao_dacapgcn_khac,
            'bienhoa_hoigiao_chuacapgcn' => $result['bien-hoa']['26'],//$bienhoa_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'bienhoa_phatgiaohoahao_tongdt' => 0, //$bienhoa_phatgiaohoahao_tongdt,
            'bienhoa_phatgiaohoahao_dacapgcn_tongiao' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_tongiao,
            'bienhoa_phatgiaohoahao_dacapgcn_khac' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_khac,
            'bienhoa_phatgiaohoahao_chuacapgcn' => 0, //$bienhoa_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'bienhoa_tinnguong_tongdt' => $result['bien-hoa']['31'],//$bienhoa_tinnguong_tongdt,
            'bienhoa_tinnguong_dacapgcn_tongiao' => $result['bien-hoa']['32'],//$bienhoa_tinnguong_dacapgcn_tongiao,
            'bienhoa_tinnguong_dacapgcn_khac' => $result['bien-hoa']['33'],//$bienhoa_tinnguong_dacapgcn_khac,
            'bienhoa_tinnguong_chuacapgcn' => $result['bien-hoa']['34'],//$bienhoa_tinnguong_chuacapgcn,

            /*LONG KHÁNH*/
            'longkhanh_tongdt' => $result['long-khanh']['2'],//$longkhanh_tongdt,
            'longkhanh_sodientichdat_dacapgcn_tong' => $result['long-khanh']['3'],//$longkhanh_sodientichdat_dacapgcn_tong,
            'longkhanh_sodientichdat_dacapgcn_tongiao' => $result['long-khanh']['4'],//$longkhanh_sodientichdat_dacapgcn_tongiao,
            'longkhanh_sodientichdat_dacapgcn_khac' => $result['long-khanh']['5'],//$longkhanh_sodientichdat_dacapgcn_khac,
            'longkhanh_sodientichdat_chuacapgcn' => $result['long-khanh']['6'],//$longkhanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longkhanh_congiao_tongdt' => $result['long-khanh']['7'],//$longkhanh_congiao_tongdt,
            'longkhanh_congiao_dacapgcn_tongiao' => $result['long-khanh']['8'],//$longkhanh_congiao_dacapgcn_tongiao,
            'longkhanh_congiao_dacapgcn_khac' => $result['long-khanh']['9'],//$longkhanh_congiao_dacapgcn_khac,
            'longkhanh_congiao_chuacapgcn' => $result['long-khanh']['10'],//$longkhanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longkhanh_phatgiao_tongdt' => $result['long-khanh']['11'],//$longkhanh_phatgiao_tongdt,
            'longkhanh_phatgiao_dacapgcn_tongiao' => $result['long-khanh']['12'],//$longkhanh_phatgiao_dacapgcn_tongiao,
            'longkhanh_phatgiao_dacapgcn_khac' => $result['long-khanh']['13'],//$longkhanh_phatgiao_dacapgcn_khac,
            'longkhanh_phatgiao_chuacapgcn' => $result['long-khanh']['14'],//$longkhanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longkhanh_caodai_tongdt' => $result['long-khanh']['15'],//$longkhanh_caodai_tongdt,
            'longkhanh_caodai_dacapgcn_tongiao' => $result['long-khanh']['16'],//$longkhanh_caodai_dacapgcn_tongiao,
            'longkhanh_caodai_dacapgcn_khac' => $result['long-khanh']['17'],//$longkhanh_caodai_dacapgcn_khac,
            'longkhanh_caodai_chuacapgcn' => $result['long-khanh']['18'],//$longkhanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longkhanh_tdcsphvn_tongdt' => $result['long-khanh']['19'],//$longkhanh_tdcsphvn_tongdt,
            'longkhanh_tdcsphvn_dacapgcn_tongiao' => $result['long-khanh']['20'],//$longkhanh_tdcsphvn_dacapgcn_tongiao,
            'longkhanh_tdcsphvn_dacapgcn_khac' => $result['long-khanh']['21'],//$longkhanh_tdcsphvn_dacapgcn_khac,
            'longkhanh_tdcsphvn_chuacapgcn' => $result['long-khanh']['22'],//$longkhanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longkhanh_hoigiao_tongdt' => $result['long-khanh']['23'],//$longkhanh_hoigiao_tongdt,
            'longkhanh_hoigiao_dacapgcn_tongiao' => $result['long-khanh']['24'],//$longkhanh_hoigiao_dacapgcn_tongiao,
            'longkhanh_hoigiao_dacapgcn_khac' => $result['long-khanh']['25'],//$longkhanh_hoigiao_dacapgcn_khac,
            'longkhanh_hoigiao_chuacapgcn' => $result['long-khanh']['26'],//$longkhanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longkhanh_phatgiaohoahao_tongdt' => 0, //$longkhanh_phatgiaohoahao_tongdt,
            'longkhanh_phatgiaohoahao_dacapgcn_tongiao' => 0, //$longkhanh_phatgiaohoahao_dacapgcn_tongiao,
            'longkhanh_phatgiaohoahao_dacapgcn_khac' => 0, //$longkhanh_phatgiaohoahao_dacapgcn_khac,
            'longkhanh_phatgiaohoahao_chuacapgcn' => 0, //$longkhanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longkhanh_tinnguong_tongdt' => $result['long-khanh']['31'],//$longkhanh_tinnguong_tongdt,
            'longkhanh_tinnguong_dacapgcn_tongiao' => $result['long-khanh']['32'],//$longkhanh_tinnguong_dacapgcn_tongiao,
            'longkhanh_tinnguong_dacapgcn_khac' => $result['long-khanh']['33'],//$longkhanh_tinnguong_dacapgcn_khac,
            'longkhanh_tinnguong_chuacapgcn' => $result['long-khanh']['34'],//$longkhanh_tinnguong_chuacapgcn,

            /*XUÂN LỘC*/
            'xuanloc_tongdt' => $result['xuan-loc']['2'],//$xuanloc_tongdt,
            'xuanloc_sodientichdat_dacapgcn_tong' => $result['xuan-loc']['3'],//$xuanloc_sodientichdat_dacapgcn_tong,
            'xuanloc_sodientichdat_dacapgcn_tongiao' => $result['xuan-loc']['4'],//$xuanloc_sodientichdat_dacapgcn_tongiao,
            'xuanloc_sodientichdat_dacapgcn_khac' => $result['xuan-loc']['5'],//$xuanloc_sodientichdat_dacapgcn_khac,
            'xuanloc_sodientichdat_chuacapgcn' => $result['xuan-loc']['6'],//$xuanloc_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'xuanloc_congiao_tongdt' => $result['xuan-loc']['7'],//$xuanloc_congiao_tongdt,
            'xuanloc_congiao_dacapgcn_tongiao' => $result['xuan-loc']['8'],//$xuanloc_congiao_dacapgcn_tongiao,
            'xuanloc_congiao_dacapgcn_khac' => $result['xuan-loc']['9'],//$xuanloc_congiao_dacapgcn_khac,
            'xuanloc_congiao_chuacapgcn' => $result['xuan-loc']['10'],//$xuanloc_congiao_chuacapgcn,
            //PHẬT GIÁO
            'xuanloc_phatgiao_tongdt' => $result['xuan-loc']['11'],//$xuanloc_phatgiao_tongdt,
            'xuanloc_phatgiao_dacapgcn_tongiao' => $result['xuan-loc']['12'],//$xuanloc_phatgiao_dacapgcn_tongiao,
            'xuanloc_phatgiao_dacapgcn_khac' => $result['xuan-loc']['13'],//$xuanloc_phatgiao_dacapgcn_khac,
            'xuanloc_phatgiao_chuacapgcn' => $result['xuan-loc']['14'],//$xuanloc_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'xuanloc_caodai_tongdt' => $result['xuan-loc']['15'],//$xuanloc_caodai_tongdt,
            'xuanloc_caodai_dacapgcn_tongiao' => $result['xuan-loc']['16'],//$xuanloc_caodai_dacapgcn_tongiao,
            'xuanloc_caodai_dacapgcn_khac' => $result['xuan-loc']['17'],//$xuanloc_caodai_dacapgcn_khac,
            'xuanloc_caodai_chuacapgcn' => $result['xuan-loc']['18'],//$xuanloc_caodai_chuacapgcn,
            //TĐCSPHVN
            'xuanloc_tdcsphvn_tongdt' => $result['xuan-loc']['19'],//$xuanloc_tdcsphvn_tongdt,
            'xuanloc_tdcsphvn_dacapgcn_tongiao' => $result['xuan-loc']['20'],//$xuanloc_tdcsphvn_dacapgcn_tongiao,
            'xuanloc_tdcsphvn_dacapgcn_khac' => $result['xuan-loc']['21'],//$xuanloc_tdcsphvn_dacapgcn_khac,
            'xuanloc_tdcsphvn_chuacapgcn' => $result['xuan-loc']['22'],//$xuanloc_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'xuanloc_hoigiao_tongdt' => $result['xuan-loc']['23'],//$xuanloc_hoigiao_tongdt,
            'xuanloc_hoigiao_dacapgcn_tongiao' => $result['xuan-loc']['24'],//$xuanloc_hoigiao_dacapgcn_tongiao,
            'xuanloc_hoigiao_dacapgcn_khac' => $result['xuan-loc']['25'],//$xuanloc_hoigiao_dacapgcn_khac,
            'xuanloc_hoigiao_chuacapgcn' => $result['xuan-loc']['26'],//$xuanloc_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'xuanloc_phatgiaohoahao_tongdt' => 0, //$xuanloc_phatgiaohoahao_tongdt,
            'xuanloc_phatgiaohoahao_dacapgcn_tongiao' => 0, //$xuanloc_phatgiaohoahao_dacapgcn_tongiao,
            'xuanloc_phatgiaohoahao_dacapgcn_khac' => 0, //$xuanloc_phatgiaohoahao_dacapgcn_khac,
            'xuanloc_phatgiaohoahao_chuacapgcn' => 0, //$xuanloc_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'xuanloc_tinnguong_tongdt' => $result['xuan-loc']['31'],//$xuanloc_tinnguong_tongdt,
            'xuanloc_tinnguong_dacapgcn_tongiao' => $result['xuan-loc']['32'],//$xuanloc_tinnguong_dacapgcn_tongiao,
            'xuanloc_tinnguong_dacapgcn_khac' => $result['xuan-loc']['33'],//$xuanloc_tinnguong_dacapgcn_khac,
            'xuanloc_tinnguong_chuacapgcn' => $result['xuan-loc']['34'],//$xuanloc_tinnguong_chuacapgcn,

            /*CẨM MỸ*/
            'cammy_tongdt' => $result['cam-my']['2'],//$cammy_tongdt,
            'cammy_sodientichdat_dacapgcn_tong' => $result['cam-my']['3'],//$cammy_sodientichdat_dacapgcn_tong,
            'cammy_sodientichdat_dacapgcn_tongiao' => $result['cam-my']['4'],//$cammy_sodientichdat_dacapgcn_tongiao,
            'cammy_sodientichdat_dacapgcn_khac' => $result['cam-my']['5'],//$cammy_sodientichdat_dacapgcn_khac,
            'cammy_sodientichdat_chuacapgcn' => $result['cam-my']['6'],//$cammy_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'cammy_congiao_tongdt' => $result['cam-my']['7'],//$cammy_congiao_tongdt,
            'cammy_congiao_dacapgcn_tongiao' => $result['cam-my']['8'],//$cammy_congiao_dacapgcn_tongiao,
            'cammy_congiao_dacapgcn_khac' => $result['cam-my']['9'],//$cammy_congiao_dacapgcn_khac,
            'cammy_congiao_chuacapgcn' => $result['cam-my']['10'],//$cammy_congiao_chuacapgcn,
            //PHẬT GIÁO
            'cammy_phatgiao_tongdt' => $result['cam-my']['11'],//$cammy_phatgiao_tongdt,
            'cammy_phatgiao_dacapgcn_tongiao' => $result['cam-my']['12'],//$cammy_phatgiao_dacapgcn_tongiao,
            'cammy_phatgiao_dacapgcn_khac' => $result['cam-my']['13'],//$cammy_phatgiao_dacapgcn_khac,
            'cammy_phatgiao_chuacapgcn' => $result['cam-my']['14'],//$cammy_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'cammy_caodai_tongdt' => $result['cam-my']['15'],//$cammy_caodai_tongdt,
            'cammy_caodai_dacapgcn_tongiao' => $result['cam-my']['16'],//$cammy_caodai_dacapgcn_tongiao,
            'cammy_caodai_dacapgcn_khac' => $result['cam-my']['17'],//$cammy_caodai_dacapgcn_khac,
            'cammy_caodai_chuacapgcn' => $result['cam-my']['18'],//$cammy_caodai_chuacapgcn,
            //TĐCSPHVN
            'cammy_tdcsphvn_tongdt' => $result['cam-my']['19'],//$cammy_tdcsphvn_tongdt,
            'cammy_tdcsphvn_dacapgcn_tongiao' => $result['cam-my']['20'],//$cammy_tdcsphvn_dacapgcn_tongiao,
            'cammy_tdcsphvn_dacapgcn_khac' => $result['cam-my']['21'],//$cammy_tdcsphvn_dacapgcn_khac,
            'cammy_tdcsphvn_chuacapgcn' => $result['cam-my']['22'],//$cammy_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'cammy_hoigiao_tongdt' => $result['cam-my']['23'],//$cammy_hoigiao_tongdt,
            'cammy_hoigiao_dacapgcn_tongiao' => $result['cam-my']['24'],//$cammy_hoigiao_dacapgcn_tongiao,
            'cammy_hoigiao_dacapgcn_khac' => $result['cam-my']['25'],//$cammy_hoigiao_dacapgcn_khac,
            'cammy_hoigiao_chuacapgcn' => $result['cam-my']['26'],//$cammy_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'cammy_phatgiaohoahao_tongdt' => 0, //$cammy_phatgiaohoahao_tongdt,
            'cammy_phatgiaohoahao_dacapgcn_tongiao' => 0, //$cammy_phatgiaohoahao_dacapgcn_tongiao,
            'cammy_phatgiaohoahao_dacapgcn_khac' => 0, //$cammy_phatgiaohoahao_dacapgcn_khac,
            'cammy_phatgiaohoahao_chuacapgcn' => 0, //$cammy_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'cammy_tinnguong_tongdt' => $result['cam-my']['31'],//$cammy_tinnguong_tongdt,
            'cammy_tinnguong_dacapgcn_tongiao' => $result['cam-my']['32'],//$cammy_tinnguong_dacapgcn_tongiao,
            'cammy_tinnguong_dacapgcn_khac' => $result['cam-my']['33'],//$cammy_tinnguong_dacapgcn_khac,
            'cammy_tinnguong_chuacapgcn' => $result['cam-my']['34'],//$cammy_tinnguong_chuacapgcn,

            /*TÂN PHÚ*/
            'tanphu_tongdt' => $result['tan-phu']['2'],//$tanphu_tongdt,
            'tanphu_sodientichdat_dacapgcn_tong' => $result['tan-phu']['3'],//$tanphu_sodientichdat_dacapgcn_tong,
            'tanphu_sodientichdat_dacapgcn_tongiao' => $result['tan-phu']['4'],//$tanphu_sodientichdat_dacapgcn_tongiao,
            'tanphu_sodientichdat_dacapgcn_khac' => $result['tan-phu']['5'],//$tanphu_sodientichdat_dacapgcn_khac,
            'tanphu_sodientichdat_chuacapgcn' => $result['tan-phu']['6'],//$tanphu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'tanphu_congiao_tongdt' => $result['tan-phu']['7'],//$tanphu_congiao_tongdt,
            'tanphu_congiao_dacapgcn_tongiao' => $result['tan-phu']['8'],//$tanphu_congiao_dacapgcn_tongiao,
            'tanphu_congiao_dacapgcn_khac' => $result['tan-phu']['9'],//$tanphu_congiao_dacapgcn_khac,
            'tanphu_congiao_chuacapgcn' => $result['tan-phu']['10'],//$tanphu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'tanphu_phatgiao_tongdt' => $result['tan-phu']['11'],//$tanphu_phatgiao_tongdt,
            'tanphu_phatgiao_dacapgcn_tongiao' => $result['tan-phu']['12'],//$tanphu_phatgiao_dacapgcn_tongiao,
            'tanphu_phatgiao_dacapgcn_khac' => $result['tan-phu']['13'],//$tanphu_phatgiao_dacapgcn_khac,
            'tanphu_phatgiao_chuacapgcn' => $result['tan-phu']['14'],//$tanphu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'tanphu_caodai_tongdt' => $result['tan-phu']['15'],//$tanphu_caodai_tongdt,
            'tanphu_caodai_dacapgcn_tongiao' => $result['tan-phu']['16'],//$tanphu_caodai_dacapgcn_tongiao,
            'tanphu_caodai_dacapgcn_khac' => $result['tan-phu']['17'],//$tanphu_caodai_dacapgcn_khac,
            'tanphu_caodai_chuacapgcn' => $result['tan-phu']['18'],//$tanphu_caodai_chuacapgcn,
            //TĐCSPHVN
            'tanphu_tdcsphvn_tongdt' => $result['tan-phu']['19'],//$tanphu_tdcsphvn_tongdt,
            'tanphu_tdcsphvn_dacapgcn_tongiao' => $result['tan-phu']['20'],//$tanphu_tdcsphvn_dacapgcn_tongiao,
            'tanphu_tdcsphvn_dacapgcn_khac' => $result['tan-phu']['21'],//$tanphu_tdcsphvn_dacapgcn_khac,
            'tanphu_tdcsphvn_chuacapgcn' => $result['tan-phu']['22'],//$tanphu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'tanphu_hoigiao_tongdt' => $result['tan-phu']['23'],//$tanphu_hoigiao_tongdt,
            'tanphu_hoigiao_dacapgcn_tongiao' => $result['tan-phu']['24'],//$tanphu_hoigiao_dacapgcn_tongiao,
            'tanphu_hoigiao_dacapgcn_khac' => $result['tan-phu']['25'],//$tanphu_hoigiao_dacapgcn_khac,
            'tanphu_hoigiao_chuacapgcn' => $result['tan-phu']['26'],//$tanphu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'tanphu_phatgiaohoahao_tongdt' => 0, //$tanphu_phatgiaohoahao_tongdt,
            'tanphu_phatgiaohoahao_dacapgcn_tongiao' => 0, //$tanphu_phatgiaohoahao_dacapgcn_tongiao,
            'tanphu_phatgiaohoahao_dacapgcn_khac' => 0, //$tanphu_phatgiaohoahao_dacapgcn_khac,
            'tanphu_phatgiaohoahao_chuacapgcn' => 0, //$tanphu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'tanphu_tinnguong_tongdt' => $result['tan-phu']['31'],//$tanphu_tinnguong_tongdt,
            'tanphu_tinnguong_dacapgcn_tongiao' => $result['tan-phu']['32'],//$tanphu_tinnguong_dacapgcn_tongiao,
            'tanphu_tinnguong_dacapgcn_khac' => $result['tan-phu']['33'],//$tanphu_tinnguong_dacapgcn_khac,
            'tanphu_tinnguong_chuacapgcn' => $result['tan-phu']['34'],//$tanphu_tinnguong_chuacapgcn,

            /*ĐỊNH QUÁN*/
            'dinhquan_tongdt' => $result['dinh-quan']['2'],//$dinhquan_tongdt,
            'dinhquan_sodientichdat_dacapgcn_tong' => $result['dinh-quan']['3'],//$dinhquan_sodientichdat_dacapgcn_tong,
            'dinhquan_sodientichdat_dacapgcn_tongiao' => $result['dinh-quan']['4'],//$dinhquan_sodientichdat_dacapgcn_tongiao,
            'dinhquan_sodientichdat_dacapgcn_khac' => $result['dinh-quan']['5'],//$dinhquan_sodientichdat_dacapgcn_khac,
            'dinhquan_sodientichdat_chuacapgcn' => $result['dinh-quan']['6'],//$dinhquan_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'dinhquan_congiao_tongdt' => $result['dinh-quan']['7'],//$dinhquan_congiao_tongdt,
            'dinhquan_congiao_dacapgcn_tongiao' => $result['dinh-quan']['8'],//$dinhquan_congiao_dacapgcn_tongiao,
            'dinhquan_congiao_dacapgcn_khac' => $result['dinh-quan']['9'],//$dinhquan_congiao_dacapgcn_khac,
            'dinhquan_congiao_chuacapgcn' => $result['dinh-quan']['10'],//$dinhquan_congiao_chuacapgcn,
            //PHẬT GIÁO
            'dinhquan_phatgiao_tongdt' => $result['dinh-quan']['11'],//$dinhquan_phatgiao_tongdt,
            'dinhquan_phatgiao_dacapgcn_tongiao' => $result['dinh-quan']['12'],//$dinhquan_phatgiao_dacapgcn_tongiao,
            'dinhquan_phatgiao_dacapgcn_khac' => $result['dinh-quan']['13'],//$dinhquan_phatgiao_dacapgcn_khac,
            'dinhquan_phatgiao_chuacapgcn' => $result['dinh-quan']['14'],//$dinhquan_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'dinhquan_caodai_tongdt' => $result['dinh-quan']['15'],//$dinhquan_caodai_tongdt,
            'dinhquan_caodai_dacapgcn_tongiao' => $result['dinh-quan']['16'],//$dinhquan_caodai_dacapgcn_tongiao,
            'dinhquan_caodai_dacapgcn_khac' => $result['dinh-quan']['17'],//$dinhquan_caodai_dacapgcn_khac,
            'dinhquan_caodai_chuacapgcn' => $result['dinh-quan']['18'],//$dinhquan_caodai_chuacapgcn,
            //TĐCSPHVN
            'dinhquan_tdcsphvn_tongdt' => $result['dinh-quan']['19'],//$dinhquan_tdcsphvn_tongdt,
            'dinhquan_tdcsphvn_dacapgcn_tongiao' => $result['dinh-quan']['20'],//$dinhquan_tdcsphvn_dacapgcn_tongiao,
            'dinhquan_tdcsphvn_dacapgcn_khac' => $result['dinh-quan']['21'],//$dinhquan_tdcsphvn_dacapgcn_khac,
            'dinhquan_tdcsphvn_chuacapgcn' => $result['dinh-quan']['22'],//$dinhquan_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'dinhquan_hoigiao_tongdt' => $result['dinh-quan']['23'],//$dinhquan_hoigiao_tongdt,
            'dinhquan_hoigiao_dacapgcn_tongiao' => $result['dinh-quan']['24'],//$dinhquan_hoigiao_dacapgcn_tongiao,
            'dinhquan_hoigiao_dacapgcn_khac' => $result['dinh-quan']['25'],//$dinhquan_hoigiao_dacapgcn_khac,
            'dinhquan_hoigiao_chuacapgcn' => $result['dinh-quan']['26'],//$dinhquan_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'dinhquan_phatgiaohoahao_tongdt' => 0, //$dinhquan_phatgiaohoahao_tongdt,
            'dinhquan_phatgiaohoahao_dacapgcn_tongiao' => 0, //$dinhquan_phatgiaohoahao_dacapgcn_tongiao,
            'dinhquan_phatgiaohoahao_dacapgcn_khac' => 0, //$dinhquan_phatgiaohoahao_dacapgcn_khac,
            'dinhquan_phatgiaohoahao_chuacapgcn' => 0, //$dinhquan_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'dinhquan_tinnguong_tongdt' => $result['dinh-quan']['31'],//$dinhquan_tinnguong_tongdt,
            'dinhquan_tinnguong_dacapgcn_tongiao' => $result['dinh-quan']['32'],//$dinhquan_tinnguong_dacapgcn_tongiao,
            'dinhquan_tinnguong_dacapgcn_khac' => $result['dinh-quan']['33'],//$dinhquan_tinnguong_dacapgcn_khac,
            'dinhquan_tinnguong_chuacapgcn' => $result['dinh-quan']['34'],//$dinhquan_tinnguong_chuacapgcn,

            /*THỐNG NHẤT*/
            'thongnhat_tongdt' => $result['thong-nhat']['2'],//$thongnhat_tongdt,
            'thongnhat_sodientichdat_dacapgcn_tong' => $result['thong-nhat']['3'],//$thongnhat_sodientichdat_dacapgcn_tong,
            'thongnhat_sodientichdat_dacapgcn_tongiao' => $result['thong-nhat']['4'],//$thongnhat_sodientichdat_dacapgcn_tongiao,
            'thongnhat_sodientichdat_dacapgcn_khac' => $result['thong-nhat']['5'],//$thongnhat_sodientichdat_dacapgcn_khac,
            'thongnhat_sodientichdat_chuacapgcn' => $result['thong-nhat']['6'],//$thongnhat_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'thongnhat_congiao_tongdt' => $result['thong-nhat']['7'],//$thongnhat_congiao_tongdt,
            'thongnhat_congiao_dacapgcn_tongiao' => $result['thong-nhat']['8'],//$thongnhat_congiao_dacapgcn_tongiao,
            'thongnhat_congiao_dacapgcn_khac' => $result['thong-nhat']['9'],//$thongnhat_congiao_dacapgcn_khac,
            'thongnhat_congiao_chuacapgcn' => $result['thong-nhat']['10'],//$thongnhat_congiao_chuacapgcn,
            //PHẬT GIÁO
            'thongnhat_phatgiao_tongdt' => $result['thong-nhat']['11'],//$thongnhat_phatgiao_tongdt,
            'thongnhat_phatgiao_dacapgcn_tongiao' => $result['thong-nhat']['12'],//$thongnhat_phatgiao_dacapgcn_tongiao,
            'thongnhat_phatgiao_dacapgcn_khac' => $result['thong-nhat']['13'],//$thongnhat_phatgiao_dacapgcn_khac,
            'thongnhat_phatgiao_chuacapgcn' => $result['thong-nhat']['14'],//$thongnhat_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'thongnhat_caodai_tongdt' => $result['thong-nhat']['15'],//$thongnhat_caodai_tongdt,
            'thongnhat_caodai_dacapgcn_tongiao' => $result['thong-nhat']['16'],//$thongnhat_caodai_dacapgcn_tongiao,
            'thongnhat_caodai_dacapgcn_khac' => $result['thong-nhat']['17'],//$thongnhat_caodai_dacapgcn_khac,
            'thongnhat_caodai_chuacapgcn' => $result['thong-nhat']['18'],//$thongnhat_caodai_chuacapgcn,
            //TĐCSPHVN
            'thongnhat_tdcsphvn_tongdt' => $result['thong-nhat']['19'],//$thongnhat_tdcsphvn_tongdt,
            'thongnhat_tdcsphvn_dacapgcn_tongiao' => $result['thong-nhat']['20'],//$thongnhat_tdcsphvn_dacapgcn_tongiao,
            'thongnhat_tdcsphvn_dacapgcn_khac' => $result['thong-nhat']['21'],//$thongnhat_tdcsphvn_dacapgcn_khac,
            'thongnhat_tdcsphvn_chuacapgcn' => $result['thong-nhat']['22'],//$thongnhat_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'thongnhat_hoigiao_tongdt' => $result['thong-nhat']['23'],//$thongnhat_hoigiao_tongdt,
            'thongnhat_hoigiao_dacapgcn_tongiao' => $result['thong-nhat']['24'],//$thongnhat_hoigiao_dacapgcn_tongiao,
            'thongnhat_hoigiao_dacapgcn_khac' => $result['thong-nhat']['25'],//$thongnhat_hoigiao_dacapgcn_khac,
            'thongnhat_hoigiao_chuacapgcn' => $result['thong-nhat']['26'],//$thongnhat_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'thongnhat_phatgiaohoahao_tongdt' => 0, //$thongnhat_phatgiaohoahao_tongdt,
            'thongnhat_phatgiaohoahao_dacapgcn_tongiao' => 0, // $thongnhat_phatgiaohoahao_dacapgcn_tongiao,
            'thongnhat_phatgiaohoahao_dacapgcn_khac' => 0, //$thongnhat_phatgiaohoahao_dacapgcn_khac,
            'thongnhat_phatgiaohoahao_chuacapgcn' => 0, //$thongnhat_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'thongnhat_tinnguong_tongdt' => $result['thong-nhat']['31'],//$thongnhat_tinnguong_tongdt,
            'thongnhat_tinnguong_dacapgcn_tongiao' => $result['thong-nhat']['32'],//$thongnhat_tinnguong_dacapgcn_tongiao,
            'thongnhat_tinnguong_dacapgcn_khac' => $result['thong-nhat']['33'],//$thongnhat_tinnguong_dacapgcn_khac,
            'thongnhat_tinnguong_chuacapgcn' => $result['thong-nhat']['34'],//$thongnhat_tinnguong_chuacapgcn,

            /*TRẢNG BOM*/
            'trangbom_tongdt' => $result['trang-bom']['2'],//$trangbom_tongdt,
            'trangbom_sodientichdat_dacapgcn_tong' => $result['trang-bom']['3'],//$trangbom_sodientichdat_dacapgcn_tong,
            'trangbom_sodientichdat_dacapgcn_tongiao' => $result['trang-bom']['4'],//$trangbom_sodientichdat_dacapgcn_tongiao,
            'trangbom_sodientichdat_dacapgcn_khac' => $result['trang-bom']['5'],//$trangbom_sodientichdat_dacapgcn_khac,
            'trangbom_sodientichdat_chuacapgcn' => $result['trang-bom']['6'],//$trangbom_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'trangbom_congiao_tongdt' => $result['trang-bom']['7'],//$trangbom_congiao_tongdt,
            'trangbom_congiao_dacapgcn_tongiao' => $result['trang-bom']['8'],//$trangbom_congiao_dacapgcn_tongiao,
            'trangbom_congiao_dacapgcn_khac' => $result['trang-bom']['9'],//$trangbom_congiao_dacapgcn_khac,
            'trangbom_congiao_chuacapgcn' => $result['trang-bom']['10'],//$trangbom_congiao_chuacapgcn,
            //PHẬT GIÁO
            'trangbom_phatgiao_tongdt' => $result['trang-bom']['11'],//$trangbom_phatgiao_tongdt,
            'trangbom_phatgiao_dacapgcn_tongiao' => $result['trang-bom']['12'],//$trangbom_phatgiao_dacapgcn_tongiao,
            'trangbom_phatgiao_dacapgcn_khac' => $result['trang-bom']['13'],//$trangbom_phatgiao_dacapgcn_khac,
            'trangbom_phatgiao_chuacapgcn' => $result['trang-bom']['14'],//$trangbom_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'trangbom_caodai_tongdt' => $result['trang-bom']['15'],//$trangbom_caodai_tongdt,
            'trangbom_caodai_dacapgcn_tongiao' => $result['trang-bom']['16'],//$trangbom_caodai_dacapgcn_tongiao,
            'trangbom_caodai_dacapgcn_khac' => $result['trang-bom']['17'],//$trangbom_caodai_dacapgcn_khac,
            'trangbom_caodai_chuacapgcn' => $result['trang-bom']['18'],//$trangbom_caodai_chuacapgcn,
            //TĐCSPHVN
            'trangbom_tdcsphvn_tongdt' => $result['trang-bom']['19'],//$trangbom_tdcsphvn_tongdt,
            'trangbom_tdcsphvn_dacapgcn_tongiao' => $result['trang-bom']['20'],//$trangbom_tdcsphvn_dacapgcn_tongiao,
            'trangbom_tdcsphvn_dacapgcn_khac' => $result['trang-bom']['21'],//$trangbom_tdcsphvn_dacapgcn_khac,
            'trangbom_tdcsphvn_chuacapgcn' => $result['trang-bom']['22'],//$trangbom_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'trangbom_hoigiao_tongdt' => $result['trang-bom']['23'],//$trangbom_hoigiao_tongdt,
            'trangbom_hoigiao_dacapgcn_tongiao' => $result['trang-bom']['24'],//$trangbom_hoigiao_dacapgcn_tongiao,
            'trangbom_hoigiao_dacapgcn_khac' => $result['trang-bom']['25'],//$trangbom_hoigiao_dacapgcn_khac,
            'trangbom_hoigiao_chuacapgcn' => $result['trang-bom']['26'],//$trangbom_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'trangbom_phatgiaohoahao_tongdt' => 0, //$trangbom_phatgiaohoahao_tongdt,
            'trangbom_phatgiaohoahao_dacapgcn_tongiao' => 0, //$trangbom_phatgiaohoahao_dacapgcn_tongiao,
            'trangbom_phatgiaohoahao_dacapgcn_khac' => 0, //$trangbom_phatgiaohoahao_dacapgcn_khac,
            'trangbom_phatgiaohoahao_chuacapgcn' => 0, //$trangbom_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'trangbom_tinnguong_tongdt' => $result['trang-bom']['31'],//$trangbom_tinnguong_tongdt,
            'trangbom_tinnguong_dacapgcn_tongiao' => $result['trang-bom']['32'],//$trangbom_tinnguong_dacapgcn_tongiao,
            'trangbom_tinnguong_dacapgcn_khac' => $result['trang-bom']['33'],//$trangbom_tinnguong_dacapgcn_khac,
            'trangbom_tinnguong_chuacapgcn' => $result['trang-bom']['34'],//$trangbom_tinnguong_chuacapgcn,

            /*VĨNH CỬU*/
            'vinhcuu_tongdt' => $result['vinh-cuu']['2'],//$vinhcuu_tongdt,
            'vinhcuu_sodientichdat_dacapgcn_tong' => $result['vinh-cuu']['3'],//$vinhcuu_sodientichdat_dacapgcn_tong,
            'vinhcuu_sodientichdat_dacapgcn_tongiao' => $result['vinh-cuu']['4'],//$vinhcuu_sodientichdat_dacapgcn_tongiao,
            'vinhcuu_sodientichdat_dacapgcn_khac' => $result['vinh-cuu']['5'],//$vinhcuu_sodientichdat_dacapgcn_khac,
            'vinhcuu_sodientichdat_chuacapgcn' => $result['vinh-cuu']['6'],//$vinhcuu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'vinhcuu_congiao_tongdt' => $result['vinh-cuu']['7'],//$vinhcuu_congiao_tongdt,
            'vinhcuu_congiao_dacapgcn_tongiao' => $result['vinh-cuu']['8'],//$vinhcuu_congiao_dacapgcn_tongiao,
            'vinhcuu_congiao_dacapgcn_khac' => $result['vinh-cuu']['9'],//$vinhcuu_congiao_dacapgcn_khac,
            'vinhcuu_congiao_chuacapgcn' => $result['vinh-cuu']['10'],//$vinhcuu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'vinhcuu_phatgiao_tongdt' => $result['vinh-cuu']['11'],//$vinhcuu_phatgiao_tongdt,
            'vinhcuu_phatgiao_dacapgcn_tongiao' => $result['vinh-cuu']['12'],//$vinhcuu_phatgiao_dacapgcn_tongiao,
            'vinhcuu_phatgiao_dacapgcn_khac' => $result['vinh-cuu']['13'],//$vinhcuu_phatgiao_dacapgcn_khac,
            'vinhcuu_phatgiao_chuacapgcn' => $result['vinh-cuu']['14'],//$vinhcuu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'vinhcuu_caodai_tongdt' => $result['vinh-cuu']['15'],//$vinhcuu_caodai_tongdt,
            'vinhcuu_caodai_dacapgcn_tongiao' => $result['vinh-cuu']['16'],//$vinhcuu_caodai_dacapgcn_tongiao,
            'vinhcuu_caodai_dacapgcn_khac' => $result['vinh-cuu']['17'],//$vinhcuu_caodai_dacapgcn_khac,
            'vinhcuu_caodai_chuacapgcn' => $result['vinh-cuu']['18'],//$vinhcuu_caodai_chuacapgcn,
            //TĐCSPHVN
            'vinhcuu_tdcsphvn_tongdt' => $result['vinh-cuu']['19'],//$vinhcuu_tdcsphvn_tongdt,
            'vinhcuu_tdcsphvn_dacapgcn_tongiao' => $result['vinh-cuu']['20'],//$vinhcuu_tdcsphvn_dacapgcn_tongiao,
            'vinhcuu_tdcsphvn_dacapgcn_khac' => $result['vinh-cuu']['21'],//$vinhcuu_tdcsphvn_dacapgcn_khac,
            'vinhcuu_tdcsphvn_chuacapgcn' => $result['vinh-cuu']['22'],//$vinhcuu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'vinhcuu_hoigiao_tongdt' => $result['vinh-cuu']['23'],//$vinhcuu_hoigiao_tongdt,
            'vinhcuu_hoigiao_dacapgcn_tongiao' => $result['vinh-cuu']['24'],//$vinhcuu_hoigiao_dacapgcn_tongiao,
            'vinhcuu_hoigiao_dacapgcn_khac' => $result['vinh-cuu']['25'],//$vinhcuu_hoigiao_dacapgcn_khac,
            'vinhcuu_hoigiao_chuacapgcn' => $result['vinh-cuu']['26'],//$vinhcuu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'vinhcuu_phatgiaohoahao_tongdt' => 0, //$vinhcuu_phatgiaohoahao_tongdt,
            'vinhcuu_phatgiaohoahao_dacapgcn_tongiao' => 0, //$vinhcuu_phatgiaohoahao_dacapgcn_tongiao,
            'vinhcuu_phatgiaohoahao_dacapgcn_khac' => 0, //$vinhcuu_phatgiaohoahao_dacapgcn_khac,
            'vinhcuu_phatgiaohoahao_chuacapgcn' => 0, //$vinhcuu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'vinhcuu_tinnguong_tongdt' => $result['vinh-cuu']['31'],//$vinhcuu_tinnguong_tongdt,
            'vinhcuu_tinnguong_dacapgcn_tongiao' => $result['vinh-cuu']['32'],//$vinhcuu_tinnguong_dacapgcn_tongiao,
            'vinhcuu_tinnguong_dacapgcn_khac' => $result['vinh-cuu']['33'],//$vinhcuu_tinnguong_dacapgcn_khac,
            'vinhcuu_tinnguong_chuacapgcn' => $result['vinh-cuu']['34'],//$vinhcuu_tinnguong_chuacapgcn,

            /*NHƠN TRẠCH*/
            'nhontrach_tongdt' => $result['nhon-trach']['2'],//$nhontrach_tongdt,
            'nhontrach_sodientichdat_dacapgcn_tong' => $result['nhon-trach']['3'],//$nhontrach_sodientichdat_dacapgcn_tong,
            'nhontrach_sodientichdat_dacapgcn_tongiao' => $result['nhon-trach']['4'],//$nhontrach_sodientichdat_dacapgcn_tongiao,
            'nhontrach_sodientichdat_dacapgcn_khac' => $result['nhon-trach']['5'],//$nhontrach_sodientichdat_dacapgcn_khac,
            'nhontrach_sodientichdat_chuacapgcn' => $result['nhon-trach']['6'],//$nhontrach_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'nhontrach_congiao_tongdt' => $result['nhon-trach']['7'],//$nhontrach_congiao_tongdt,
            'nhontrach_congiao_dacapgcn_tongiao' => $result['nhon-trach']['8'],//$nhontrach_congiao_dacapgcn_tongiao,
            'nhontrach_congiao_dacapgcn_khac' => $result['nhon-trach']['9'],//$nhontrach_congiao_dacapgcn_khac,
            'nhontrach_congiao_chuacapgcn' => $result['nhon-trach']['10'],//$nhontrach_congiao_chuacapgcn,
            //PHẬT GIÁO
            'nhontrach_phatgiao_tongdt' => $result['nhon-trach']['11'],//$nhontrach_phatgiao_tongdt,
            'nhontrach_phatgiao_dacapgcn_tongiao' => $result['nhon-trach']['12'],//$nhontrach_phatgiao_dacapgcn_tongiao,
            'nhontrach_phatgiao_dacapgcn_khac' => $result['nhon-trach']['13'],//$nhontrach_phatgiao_dacapgcn_khac,
            'nhontrach_phatgiao_chuacapgcn' => $result['nhon-trach']['14'],//$nhontrach_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'nhontrach_caodai_tongdt' => $result['nhon-trach']['15'],//$nhontrach_caodai_tongdt,
            'nhontrach_caodai_dacapgcn_tongiao' => $result['nhon-trach']['16'],//$nhontrach_caodai_dacapgcn_tongiao,
            'nhontrach_caodai_dacapgcn_khac' => $result['nhon-trach']['17'],//$nhontrach_caodai_dacapgcn_khac,
            'nhontrach_caodai_chuacapgcn' => $result['nhon-trach']['18'],//$nhontrach_caodai_chuacapgcn,
            //TĐCSPHVN
            'nhontrach_tdcsphvn_tongdt' => $result['nhon-trach']['19'],//$nhontrach_tdcsphvn_tongdt,
            'nhontrach_tdcsphvn_dacapgcn_tongiao' => $result['nhon-trach']['20'],//$nhontrach_tdcsphvn_dacapgcn_tongiao,
            'nhontrach_tdcsphvn_dacapgcn_khac' => $result['nhon-trach']['21'],//$nhontrach_tdcsphvn_dacapgcn_khac,
            'nhontrach_tdcsphvn_chuacapgcn' => $result['nhon-trach']['22'],//$nhontrach_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'nhontrach_hoigiao_tongdt' => $result['nhon-trach']['23'],//$nhontrach_hoigiao_tongdt,
            'nhontrach_hoigiao_dacapgcn_tongiao' => $result['nhon-trach']['24'],//$nhontrach_hoigiao_dacapgcn_tongiao,
            'nhontrach_hoigiao_dacapgcn_khac' => $result['nhon-trach']['25'],//$nhontrach_hoigiao_dacapgcn_khac,
            'nhontrach_hoigiao_chuacapgcn' => $result['nhon-trach']['26'],//$nhontrach_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'nhontrach_phatgiaohoahao_tongdt' => 0, //$nhontrach_phatgiaohoahao_tongdt,
            'nhontrach_phatgiaohoahao_dacapgcn_tongiao' => 0, //$nhontrach_phatgiaohoahao_dacapgcn_tongiao,
            'nhontrach_phatgiaohoahao_dacapgcn_khac' => 0, //$nhontrach_phatgiaohoahao_dacapgcn_khac,
            'nhontrach_phatgiaohoahao_chuacapgcn' => 0, //$nhontrach_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'nhontrach_tinnguong_tongdt' => $result['nhon-trach']['31'],//$nhontrach_tinnguong_tongdt,
            'nhontrach_tinnguong_dacapgcn_tongiao' => $result['nhon-trach']['32'],//$nhontrach_tinnguong_dacapgcn_tongiao,
            'nhontrach_tinnguong_dacapgcn_khac' => $result['nhon-trach']['33'],//$nhontrach_tinnguong_dacapgcn_khac,
            'nhontrach_tinnguong_chuacapgcn' => $result['nhon-trach']['34'],//$nhontrach_tinnguong_chuacapgcn,

            /*LONG THÀNH*/
            'longthanh_tongdt' => $result['long-thanh']['2'],//$longthanh_tongdt,
            'longthanh_sodientichdat_dacapgcn_tong' => $result['long-thanh']['3'],//$longthanh_sodientichdat_dacapgcn_tong,
            'longthanh_sodientichdat_dacapgcn_tongiao' => $result['long-thanh']['4'],//$longthanh_sodientichdat_dacapgcn_tongiao,
            'longthanh_sodientichdat_dacapgcn_khac' => $result['long-thanh']['5'],//$longthanh_sodientichdat_dacapgcn_khac,
            'longthanh_sodientichdat_chuacapgcn' => $result['long-thanh']['6'],//$longthanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longthanh_congiao_tongdt' => $result['long-thanh']['7'],//$longthanh_congiao_tongdt,
            'longthanh_congiao_dacapgcn_tongiao' => $result['long-thanh']['8'],//$longthanh_congiao_dacapgcn_tongiao,
            'longthanh_congiao_dacapgcn_khac' => $result['long-thanh']['9'],//$longthanh_congiao_dacapgcn_khac,
            'longthanh_congiao_chuacapgcn' => $result['long-thanh']['10'],//$longthanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longthanh_phatgiao_tongdt' => $result['long-thanh']['11'],//$longthanh_phatgiao_tongdt,
            'longthanh_phatgiao_dacapgcn_tongiao' => $result['long-thanh']['12'],//$longthanh_phatgiao_dacapgcn_tongiao,
            'longthanh_phatgiao_dacapgcn_khac' => $result['long-thanh']['13'],//$longthanh_phatgiao_dacapgcn_khac,
            'longthanh_phatgiao_chuacapgcn' => $result['long-thanh']['14'],//$longthanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longthanh_caodai_tongdt' => $result['long-thanh']['15'],//$longthanh_caodai_tongdt,
            'longthanh_caodai_dacapgcn_tongiao' => $result['long-thanh']['16'],//$longthanh_caodai_dacapgcn_tongiao,
            'longthanh_caodai_dacapgcn_khac' => $result['long-thanh']['17'],//$longthanh_caodai_dacapgcn_khac,
            'longthanh_caodai_chuacapgcn' => $result['long-thanh']['18'],//$longthanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longthanh_tdcsphvn_tongdt' => $result['long-thanh']['19'],//$longthanh_tdcsphvn_tongdt,
            'longthanh_tdcsphvn_dacapgcn_tongiao' => $result['long-thanh']['20'],//$longthanh_tdcsphvn_dacapgcn_tongiao,
            'longthanh_tdcsphvn_dacapgcn_khac' => $result['long-thanh']['21'],//$longthanh_tdcsphvn_dacapgcn_khac,
            'longthanh_tdcsphvn_chuacapgcn' => $result['long-thanh']['22'],//$longthanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longthanh_hoigiao_tongdt' => $result['long-thanh']['23'],//$longthanh_hoigiao_tongdt,
            'longthanh_hoigiao_dacapgcn_tongiao' => $result['long-thanh']['24'],//$longthanh_hoigiao_dacapgcn_tongiao,
            'longthanh_hoigiao_dacapgcn_khac' => $result['long-thanh']['25'],//$longthanh_hoigiao_dacapgcn_khac,
            'longthanh_hoigiao_chuacapgcn' => $result['long-thanh']['26'],//$longthanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longthanh_phatgiaohoahao_tongdt' => 0, //$longthanh_phatgiaohoahao_tongdt,
            'longthanh_phatgiaohoahao_dacapgcn_tongiao' => 0, //$longthanh_phatgiaohoahao_dacapgcn_tongiao,
            'longthanh_phatgiaohoahao_dacapgcn_khac' => 0, //$longthanh_phatgiaohoahao_dacapgcn_khac,
            'longthanh_phatgiaohoahao_chuacapgcn' => 0, //$longthanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longthanh_tinnguong_tongdt' => $result['long-thanh']['31'],//$longthanh_tinnguong_tongdt,
            'longthanh_tinnguong_dacapgcn_tongiao' => $result['long-thanh']['32'],//$longthanh_tinnguong_dacapgcn_tongiao,
            'longthanh_tinnguong_dacapgcn_khac' => $result['long-thanh']['33'],//$longthanh_tinnguong_dacapgcn_khac,
            'longthanh_tinnguong_chuacapgcn' => $result['long-thanh']['34'],//$longthanh_tinnguong_chuacapgcn,

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

    /**
     * TH TON GIAO CO SO
     */
    protected function __getType2Data()
    {
        $component = $this->Components->load('Tongiaocoso');
        $result = $component->export();

        $data = array();
        foreach ($result as $key => $value) {
            foreach ($value as $k => $v) {
                if ($k >= 2) {
                    $key = str_replace('-', '_', $key);
                    $data[$key.$k] = $v;
                }
            }
        }
        $i = 2;
        while ($i <= 19) {
            $sum = 0;
            foreach ($result as $key => $value) {
                $sum += $value[$i];
            }
            $data["tong{$i}"] = $sum;
            $i++;
        }

        return $data;
    }

    /**
     * TH CO SO TON GIAO
     * sheet 3/9
     */
    protected function __getType3Data()
    {
        $component = $this->Components->load('Cosotongiao');
        $data = $component->export();

        // begin tinh toan dong cuoi cung
        $result = $data;
        $total = [];
        $i = 2;
        while ($i <= 29) {
            $sum = 0;
            foreach ($result as $key => $value) {
                $sum += $value[$i];
            }
            $total["tong{$i}"] = $sum;
            $i++;
        }
        print_r('<pre>');
        print_r($total);
        print_r('</pre>');
        exit;
    }

    /**
     * TONG HOP CSTG TRUNG TU
     * Sheet 6/9
     */
    protected function __getType6Data()
    {
        $component = $this->Components->load('Cstgtrungtu');
        $data = $component->export();

        $result = $data;

        $total = [];
        $i = 2;
        while ($i <= 19) {
            $sum = 0;
            foreach ($result as $key => $value) {
                $sum += $value[$i];
            }
            $total["tong{$i}"] = $sum;
            $i++;
        }
        print_r('<pre>');
        print_r($result);
        print_r('</pre>');
        exit;
    }

    public function pandog()
    {
        $component = $this->Components->load('Cosotongiao');
        $data = $component->export();

        $result = $data;
        $total = [];
        $i = 2;
        while ($i <= 29) {
            $sum = 0;
            foreach ($result as $key => $value) {
                $sum += $value[$i];
            }
            $total["tong{$i}"] = $sum;
            $i++;
        }
        print_r('<pre>');
        print_r($total);
        print_r('</pre>');
        exit;
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

    //////////////////////////////////////////////////////////////////////////////

    public function getExcelData()
    {
        // ini_set('memory_limit', '-1');
        $list = [
            'Conggiao', // gom Dongtuconggiao & Giaoxu
            'Cosotinnguong', // ok
            'Hodaocaodai', // ok
            'Chihoitinhdocusiphatgiaovietnam', // ok
            'Tuvienphatgiao', // ok
            'Phatgiaohoahoa', // ok
            'Cosohoigiaoislam', // ok
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
                0
            ];
            $statictis[$code] = [
                'total' => 0,
                'licensed_main' => 0,
                'licensed_other' => 0,
                'licensed_total' => 0,
                'unlicense' => 0,
            ];
        }

        foreach ($list as $model) {
            $func = 'cal_' . mb_strtolower($model);
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                if (!empty($tmp[$provice_code])) {
                    $partial = array_values($tmp[$provice_code]);
                    $statictis[$provice_code]['total'] += $tmp[$provice_code]['total'];

                    $statictis[$provice_code]['licensed_main'] += $tmp[$provice_code]['licensed_main'];
                    $statictis[$provice_code]['licensed_other'] += $tmp[$provice_code]['licensed_other'];

                    $statictis[$provice_code]['licensed_total'] = ($statictis[$provice_code]['licensed_main'] + $statictis[$provice_code]['licensed_other']);
                    $statictis[$provice_code]['unlicense'] += $tmp[$provice_code]['unlicense'];
                } else {
                    $partial = [0, 0, 0, 0];
                }

                $export[$provice_code] = array_merge($export[$provice_code], $partial);
            }
        }

        foreach ($export as $provice_code => &$item) {
            $item[2] = $statictis[$provice_code]['total'];
            $item[3] = $statictis[$provice_code]['licensed_total'];
            $item[4] = $statictis[$provice_code]['licensed_main'];
            $item[5] = $statictis[$provice_code]['licensed_other'];
            $item[6] = $statictis[$provice_code]['unlicense'];
        }

        return $export;
    }

    private function cal_conggiao()
    {
        $dtcg = $this->cal_dongtuconggiao('Dongtuconggiao');
        $gx = $this->cal_giaoxu('Giaoxu');

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

    private function cal_dongtuconggiao($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_giaoxu($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_cosotinnguong($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_hodaocaodai($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_chihoitinhdocusiphatgiaovietnam($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_tuvienphatgiao($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function cal_phatgiaohoahoa($model)
    {
        $province = $this->getProvince();
        $result = [];
        foreach ($province as $code => $name) {
            $result[$code] = [
                'total' => 0,
                'licensed_main' => 0,
                'licensed_other' => 0,
                'unlicense' => 0,
            ];
        }

        return $result;
    }

    private function cal_cosohoigiaoislam($model)
    {
        $option = $this->calculateMapping($model);
        extract($option);

        $data = $this->getData($model, $data_field);

        return $this->calculate($data, $formular, $model);
    }

    private function calculateMapping($model)
    {
        $model = mb_strtolower($model);

        if ($model == 'cosotinnguong') {
            $data_field = [
                'id',

                // cot 1
                'datdai_tongdientich',

                // cot 2
                'tongiao_dacap_dientich',

                // cot 3
                'nnlnntts_dacap_dientich',
                'gdyt_dacap_dientich',
                'dsdmdk_dacap_dientich',
            ];
            $formular = [
                'total' => ['datdai_tongdientich'],
                'licensed_main' => [
                    'tongiao_dacap_dientich',
                ],
                'licensed_other' => [
                    'nnlnntts_dacap_dientich',
                    'gdyt_dacap_dientich',
                    'dsdmdk_dacap_dientich',
                ]
            ];
        }

        $list = [
            'cosohoigiaoislam',
            'hodaocaodai',
            'chihoitinhdocusiphatgiaovietnam',
            'dongtuconggiao',
            'giaoxu',
            'tuvienphatgiao'
        ];

        if (in_array($model, $list)) {
            $data_field = [
                'id',
                // cot 1
                'datdai_tongdientich',

                // cot 2
                'dattrongkhuonvien_tongiao_dacap_dientich',
                'datngoaikhuonvien_tongiao_dacap_dientich_1',
                'datngoaikhuonvien_tongiao_dacap_dientich_2',
                'datngoaikhuonvien_tongiao_dacap_dientich_3',

                // cot 3
                'dattrongkhuonvien_nnlnntts_dacap_dientich',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                'dattrongkhuonvien_gdyt_dacap_dientich',
                'datngoaikhuonvien_gdyt_dacap_dientich_1',
                'datngoaikhuonvien_gdyt_dacap_dientich_2',
                'datngoaikhuonvien_gdyt_dacap_dientich_3',
                'dattrongkhuonvien_dsdmdk_dacap_dientich',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
            ];
            $formular = [
                'total' => ['datdai_tongdientich'],
                'licensed_main' => [
                    'dattrongkhuonvien_tongiao_dacap_dientich',
                    'datngoaikhuonvien_tongiao_dacap_dientich_1',
                    'datngoaikhuonvien_tongiao_dacap_dientich_2',
                    'datngoaikhuonvien_tongiao_dacap_dientich_3',
                ],
                'licensed_other' => [
                    'dattrongkhuonvien_nnlnntts_dacap_dientich',
                    'datngoaikhuonvien_nnlnntts_dacap_dientich_1',
                    'datngoaikhuonvien_nnlnntts_dacap_dientich_2',
                    'datngoaikhuonvien_nnlnntts_dacap_dientich_3',
                    'dattrongkhuonvien_gdyt_dacap_dientich',
                    'datngoaikhuonvien_gdyt_dacap_dientich_1',
                    'datngoaikhuonvien_gdyt_dacap_dientich_2',
                    'datngoaikhuonvien_gdyt_dacap_dientich_3',
                    'dattrongkhuonvien_dsdmdk_dacap_dientich',
                    'datngoaikhuonvien_dsdmdk_dacap_dientich_1',
                    'datngoaikhuonvien_dsdmdk_dacap_dientich_2',
                    'datngoaikhuonvien_dsdmdk_dacap_dientich_3',
                ]
            ];
        }

        array_push($data_field, $this->getLocationFieldName($model));

        return compact('data_field', 'formular');
    }

    private function getLocationFieldName($model = '')
    {
        $model = mb_strtolower($model);
        $location = [
            'giaoxu' => 'diachi_huyen',
            'dongtuconggiao' => 'diachi_huyen',
            'cosotinnguong' => 'diachi_huyen',
            'hodaocaodai' => 'tenhodao_diachi_huyen',
            'chihoitinhdocusiphatgiaovietnam' => 'tenchihoi_diachi_huyen',
            'tuvienphatgiao' => 'diachi_huyen',
            'cosohoigiaoislam' => 'tenthanhduong_diachi_huyen'
        ];

        return $location[$model];
    }

    private function calculate($data, $formular, $model)
    {
        $result = [];

        $province_field = $this->getLocationFieldName($model);
        foreach ($data as $id => $item) {
            $provice_code = $this->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            $total = 0;
            foreach ($formular['total'] as $field) {
                if (!empty($item[$field])) {
                    $total += $item[$field];
                }
            }

            $licensed_main = 0;
            foreach ($formular['licensed_main'] as $field) {
                if (!empty($item[$field])) {
                    $licensed_main += $item[$field];
                }
            }

            $licensed_other = 0;
            foreach ($formular['licensed_other'] as $field) {
                if (!empty($item[$field])) {
                    $licensed_other += $item[$field];
                }
            }

            $unlicense = round($total - ($licensed_main + $licensed_other), 2);

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
            unset($data[$id]);
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
        ));

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function retrieveProvinceCode($string = '')
    {
        $list = $this->getProvince();

        $string = $this->Utility->slug($string);

        foreach ($list as $code => $name) {
            if (strpos($string, $code) !== false) {
                return $code;
            }
        }

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
