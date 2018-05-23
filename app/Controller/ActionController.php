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
 * @package        app.Controller
 * @link        http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
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
            //TONG_HOP_CSTT_XAY_DUNG => 'TONG HOP CSTT XAY DUNG',
            TONG_HOP_CSTG_TRUNG_TU => 'TONG HOP CSTG TRUNG TU',
            BANG_TONG_HOP_TIN_DO => 'BANG TONG HOP TIN DO',
            DS_CSTT => 'ds cstt',
            DSCS_BAO_TRO_XA_HOI => 'DSCS BAO TRO XA HOI',

            DS_CS_THAM_GIA_CT_XH_CAP_XA => 'DS CS THAM GIA CT-XH CAP XA',
            DS_CS_THAM_GIA_CT_XH_CAP_HUYEN => 'DS CS THAM GIA CT-XH CAP HUYEN',
            DS_CS_THAM_GIA_CT_XH_CAP_TINH => 'DS CS THAM GIA CT-XH CAP TINH',
            TH_CS_THAM_GIA_CT_XH_CAP_XA => 'TH CS THAM GIA CT-XH CAP XA',
            TH_CS_THAM_GIA_CT_XH_CAP_HUYEN => 'TH CS THAM GIA CT-XH CAP HUYEN',
            TH_CS_THAM_GIA_CT_XH_CAP_TINH => 'TH CS THAM GIA CT-XHCAP TINH',
            DS_CS_DT_BD => 'DS CS ĐT-BD',
            THBNCS => 'THBNCS',
            DS_CHUC_SAC_PCPP => 'DS CHUC SAC PCPP',
            TH_CHUC_SAC_PCPP => 'TH CHUC SAC PCPP',
            TH_TRINH_DO_TON_GIAO => 'TH TRINH DO TON GIAO',
            TH_TRINH_DO_VH => 'TH TRINH DO VH',
            DANH_SACH_TU_SI => 'DANH SACH TU SI',
            DS_CHUC_SAC_KO_CO_CHUC_VU => 'DS CHUC SAC KO CO CHUC VU',
            DS_CHUC_SAC_CO_CHUC_VU => 'DS CHUC SAC CO CHUC VU',
            TONG_HOP_CHUC_VIEC => 'TONG HOP CHUC VIEC',
            TONG_HOP_TU_SI => 'TONG HOP TU SI',
            TONG_HOP_CHUC_SAC_KO_CHUC_VU => 'TONG HOP CHUC SAC KO CHUC VU',
            TONG_HOP_CHUC_SAC_CO_CHUC_VU => 'TONG HOP CHUC SAC CO CHUC VU',
            DO_TUOI_CUA_CHAC_SAC => 'DO TUOI CUA CHAC SAC',
            //DO_TUOI_CUA_TU_SI => 'DO TUOI CUA TU SĨ'
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

    /**
     * BẢNG TỔNG HỢP THỐNG KÊ ĐẤT CÁC TỔ CHỨC TÔN GIÁO VÀ CƠ SỞ TÍN NGƯỠNG ĐANG QUẢN LÝ VÀ SỬ DỤNG
     */
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
            'bienhoa_tongdt' => $result['bien-hoa']['2'], //$bienhoa_tongdt,
            'bienhoa_sodientichdat_dacapgcn_tong' => $result['bien-hoa']['3'], //$bienhoa_sodientichdat_dacapgcn_tong,
            'bienhoa_sodientichdat_dacapgcn_tongiao' => $result['bien-hoa']['4'], //$bienhoa_sodientichdat_dacapgcn_tongiao,
            'bienhoa_sodientichdat_dacapgcn_khac' => $result['bien-hoa']['5'], //$bienhoa_sodientichdat_dacapgcn_khac,
            'bienhoa_sodientichdat_chuacapgcn' => $result['bien-hoa']['6'], //$bienhoa_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'bienhoa_congiao_tongdt' => $result['bien-hoa']['7'], //$bienhoa_congiao_tongdt,
            'bienhoa_congiao_dacapgcn_tongiao' => $result['bien-hoa']['8'], //$bienhoa_congiao_dacapgcn_tongiao,
            'bienhoa_congiao_dacapgcn_khac' => $result['bien-hoa']['9'], //$bienhoa_congiao_dacapgcn_khac,
            'bienhoa_congiao_chuacapgcn' => $result['bien-hoa']['10'], //$bienhoa_congiao_chuacapgcn,
            //PHẬT GIÁO
            'bienhoa_phatgiao_tongdt' => $result['bien-hoa']['11'], //$bienhoa_phatgiao_tongdt,
            'bienhoa_phatgiao_dacapgcn_tongiao' => $result['bien-hoa']['12'], //$bienhoa_phatgiao_dacapgcn_tongiao,
            'bienhoa_phatgiao_dacapgcn_khac' => $result['bien-hoa']['13'], //$bienhoa_phatgiao_dacapgcn_khac,
            'bienhoa_phatgiao_chuacapgcn' => $result['bien-hoa']['14'], //$bienhoa_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'bienhoa_caodai_tongdt' => $result['bien-hoa']['15'], //$bienhoa_caodai_tongdt,
            'bienhoa_caodai_dacapgcn_tongiao' => $result['bien-hoa']['16'], //$bienhoa_caodai_dacapgcn_tongiao,
            'bienhoa_caodai_dacapgcn_khac' => $result['bien-hoa']['17'], //$bienhoa_caodai_dacapgcn_khac,
            'bienhoa_caodai_chuacapgcn' => $result['bien-hoa']['18'], //$bienhoa_caodai_chuacapgcn,
            //TĐCSPHVN
            'bienhoa_tdcsphvn_tongdt' => $result['bien-hoa']['19'], //$bienhoa_tdcsphvn_tongdt,
            'bienhoa_tdcsphvn_dacapgcn_tongiao' => $result['bien-hoa']['20'], //$bienhoa_tdcsphvn_dacapgcn_tongiao,
            'bienhoa_tdcsphvn_dacapgcn_khac' => $result['bien-hoa']['21'], //$bienhoa_tdcsphvn_dacapgcn_khac,
            'bienhoa_tdcsphvn_chuacapgcn' => $result['bien-hoa']['22'], //$bienhoa_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'bienhoa_hoigiao_tongdt' => $result['bien-hoa']['23'], //$bienhoa_hoigiao_tongdt,
            'bienhoa_hoigiao_dacapgcn_tongiao' => $result['bien-hoa']['24'], //$bienhoa_hoigiao_dacapgcn_tongiao,
            'bienhoa_hoigiao_dacapgcn_khac' => $result['bien-hoa']['25'], //$bienhoa_hoigiao_dacapgcn_khac,
            'bienhoa_hoigiao_chuacapgcn' => $result['bien-hoa']['26'], //$bienhoa_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'bienhoa_phatgiaohoahao_tongdt' => 0, //$bienhoa_phatgiaohoahao_tongdt,
            'bienhoa_phatgiaohoahao_dacapgcn_tongiao' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_tongiao,
            'bienhoa_phatgiaohoahao_dacapgcn_khac' => 0, //$bienhoa_phatgiaohoahao_dacapgcn_khac,
            'bienhoa_phatgiaohoahao_chuacapgcn' => 0, //$bienhoa_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'bienhoa_tinnguong_tongdt' => $result['bien-hoa']['31'], //$bienhoa_tinnguong_tongdt,
            'bienhoa_tinnguong_dacapgcn_tongiao' => $result['bien-hoa']['32'], //$bienhoa_tinnguong_dacapgcn_tongiao,
            'bienhoa_tinnguong_dacapgcn_khac' => $result['bien-hoa']['33'], //$bienhoa_tinnguong_dacapgcn_khac,
            'bienhoa_tinnguong_chuacapgcn' => $result['bien-hoa']['34'], //$bienhoa_tinnguong_chuacapgcn,

            /*LONG KHÁNH*/
            'longkhanh_tongdt' => $result['long-khanh']['2'], //$longkhanh_tongdt,
            'longkhanh_sodientichdat_dacapgcn_tong' => $result['long-khanh']['3'], //$longkhanh_sodientichdat_dacapgcn_tong,
            'longkhanh_sodientichdat_dacapgcn_tongiao' => $result['long-khanh']['4'], //$longkhanh_sodientichdat_dacapgcn_tongiao,
            'longkhanh_sodientichdat_dacapgcn_khac' => $result['long-khanh']['5'], //$longkhanh_sodientichdat_dacapgcn_khac,
            'longkhanh_sodientichdat_chuacapgcn' => $result['long-khanh']['6'], //$longkhanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longkhanh_congiao_tongdt' => $result['long-khanh']['7'], //$longkhanh_congiao_tongdt,
            'longkhanh_congiao_dacapgcn_tongiao' => $result['long-khanh']['8'], //$longkhanh_congiao_dacapgcn_tongiao,
            'longkhanh_congiao_dacapgcn_khac' => $result['long-khanh']['9'], //$longkhanh_congiao_dacapgcn_khac,
            'longkhanh_congiao_chuacapgcn' => $result['long-khanh']['10'], //$longkhanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longkhanh_phatgiao_tongdt' => $result['long-khanh']['11'], //$longkhanh_phatgiao_tongdt,
            'longkhanh_phatgiao_dacapgcn_tongiao' => $result['long-khanh']['12'], //$longkhanh_phatgiao_dacapgcn_tongiao,
            'longkhanh_phatgiao_dacapgcn_khac' => $result['long-khanh']['13'], //$longkhanh_phatgiao_dacapgcn_khac,
            'longkhanh_phatgiao_chuacapgcn' => $result['long-khanh']['14'], //$longkhanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longkhanh_caodai_tongdt' => $result['long-khanh']['15'], //$longkhanh_caodai_tongdt,
            'longkhanh_caodai_dacapgcn_tongiao' => $result['long-khanh']['16'], //$longkhanh_caodai_dacapgcn_tongiao,
            'longkhanh_caodai_dacapgcn_khac' => $result['long-khanh']['17'], //$longkhanh_caodai_dacapgcn_khac,
            'longkhanh_caodai_chuacapgcn' => $result['long-khanh']['18'], //$longkhanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longkhanh_tdcsphvn_tongdt' => $result['long-khanh']['19'], //$longkhanh_tdcsphvn_tongdt,
            'longkhanh_tdcsphvn_dacapgcn_tongiao' => $result['long-khanh']['20'], //$longkhanh_tdcsphvn_dacapgcn_tongiao,
            'longkhanh_tdcsphvn_dacapgcn_khac' => $result['long-khanh']['21'], //$longkhanh_tdcsphvn_dacapgcn_khac,
            'longkhanh_tdcsphvn_chuacapgcn' => $result['long-khanh']['22'], //$longkhanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longkhanh_hoigiao_tongdt' => $result['long-khanh']['23'], //$longkhanh_hoigiao_tongdt,
            'longkhanh_hoigiao_dacapgcn_tongiao' => $result['long-khanh']['24'], //$longkhanh_hoigiao_dacapgcn_tongiao,
            'longkhanh_hoigiao_dacapgcn_khac' => $result['long-khanh']['25'], //$longkhanh_hoigiao_dacapgcn_khac,
            'longkhanh_hoigiao_chuacapgcn' => $result['long-khanh']['26'], //$longkhanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longkhanh_phatgiaohoahao_tongdt' => 0, //$longkhanh_phatgiaohoahao_tongdt,
            'longkhanh_phatgiaohoahao_dacapgcn_tongiao' => 0, //$longkhanh_phatgiaohoahao_dacapgcn_tongiao,
            'longkhanh_phatgiaohoahao_dacapgcn_khac' => 0, //$longkhanh_phatgiaohoahao_dacapgcn_khac,
            'longkhanh_phatgiaohoahao_chuacapgcn' => 0, //$longkhanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longkhanh_tinnguong_tongdt' => $result['long-khanh']['31'], //$longkhanh_tinnguong_tongdt,
            'longkhanh_tinnguong_dacapgcn_tongiao' => $result['long-khanh']['32'], //$longkhanh_tinnguong_dacapgcn_tongiao,
            'longkhanh_tinnguong_dacapgcn_khac' => $result['long-khanh']['33'], //$longkhanh_tinnguong_dacapgcn_khac,
            'longkhanh_tinnguong_chuacapgcn' => $result['long-khanh']['34'], //$longkhanh_tinnguong_chuacapgcn,

            /*XUÂN LỘC*/
            'xuanloc_tongdt' => $result['xuan-loc']['2'], //$xuanloc_tongdt,
            'xuanloc_sodientichdat_dacapgcn_tong' => $result['xuan-loc']['3'], //$xuanloc_sodientichdat_dacapgcn_tong,
            'xuanloc_sodientichdat_dacapgcn_tongiao' => $result['xuan-loc']['4'], //$xuanloc_sodientichdat_dacapgcn_tongiao,
            'xuanloc_sodientichdat_dacapgcn_khac' => $result['xuan-loc']['5'], //$xuanloc_sodientichdat_dacapgcn_khac,
            'xuanloc_sodientichdat_chuacapgcn' => $result['xuan-loc']['6'], //$xuanloc_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'xuanloc_congiao_tongdt' => $result['xuan-loc']['7'], //$xuanloc_congiao_tongdt,
            'xuanloc_congiao_dacapgcn_tongiao' => $result['xuan-loc']['8'], //$xuanloc_congiao_dacapgcn_tongiao,
            'xuanloc_congiao_dacapgcn_khac' => $result['xuan-loc']['9'], //$xuanloc_congiao_dacapgcn_khac,
            'xuanloc_congiao_chuacapgcn' => $result['xuan-loc']['10'], //$xuanloc_congiao_chuacapgcn,
            //PHẬT GIÁO
            'xuanloc_phatgiao_tongdt' => $result['xuan-loc']['11'], //$xuanloc_phatgiao_tongdt,
            'xuanloc_phatgiao_dacapgcn_tongiao' => $result['xuan-loc']['12'], //$xuanloc_phatgiao_dacapgcn_tongiao,
            'xuanloc_phatgiao_dacapgcn_khac' => $result['xuan-loc']['13'], //$xuanloc_phatgiao_dacapgcn_khac,
            'xuanloc_phatgiao_chuacapgcn' => $result['xuan-loc']['14'], //$xuanloc_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'xuanloc_caodai_tongdt' => $result['xuan-loc']['15'], //$xuanloc_caodai_tongdt,
            'xuanloc_caodai_dacapgcn_tongiao' => $result['xuan-loc']['16'], //$xuanloc_caodai_dacapgcn_tongiao,
            'xuanloc_caodai_dacapgcn_khac' => $result['xuan-loc']['17'], //$xuanloc_caodai_dacapgcn_khac,
            'xuanloc_caodai_chuacapgcn' => $result['xuan-loc']['18'], //$xuanloc_caodai_chuacapgcn,
            //TĐCSPHVN
            'xuanloc_tdcsphvn_tongdt' => $result['xuan-loc']['19'], //$xuanloc_tdcsphvn_tongdt,
            'xuanloc_tdcsphvn_dacapgcn_tongiao' => $result['xuan-loc']['20'], //$xuanloc_tdcsphvn_dacapgcn_tongiao,
            'xuanloc_tdcsphvn_dacapgcn_khac' => $result['xuan-loc']['21'], //$xuanloc_tdcsphvn_dacapgcn_khac,
            'xuanloc_tdcsphvn_chuacapgcn' => $result['xuan-loc']['22'], //$xuanloc_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'xuanloc_hoigiao_tongdt' => $result['xuan-loc']['23'], //$xuanloc_hoigiao_tongdt,
            'xuanloc_hoigiao_dacapgcn_tongiao' => $result['xuan-loc']['24'], //$xuanloc_hoigiao_dacapgcn_tongiao,
            'xuanloc_hoigiao_dacapgcn_khac' => $result['xuan-loc']['25'], //$xuanloc_hoigiao_dacapgcn_khac,
            'xuanloc_hoigiao_chuacapgcn' => $result['xuan-loc']['26'], //$xuanloc_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'xuanloc_phatgiaohoahao_tongdt' => 0, //$xuanloc_phatgiaohoahao_tongdt,
            'xuanloc_phatgiaohoahao_dacapgcn_tongiao' => 0, //$xuanloc_phatgiaohoahao_dacapgcn_tongiao,
            'xuanloc_phatgiaohoahao_dacapgcn_khac' => 0, //$xuanloc_phatgiaohoahao_dacapgcn_khac,
            'xuanloc_phatgiaohoahao_chuacapgcn' => 0, //$xuanloc_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'xuanloc_tinnguong_tongdt' => $result['xuan-loc']['31'], //$xuanloc_tinnguong_tongdt,
            'xuanloc_tinnguong_dacapgcn_tongiao' => $result['xuan-loc']['32'], //$xuanloc_tinnguong_dacapgcn_tongiao,
            'xuanloc_tinnguong_dacapgcn_khac' => $result['xuan-loc']['33'], //$xuanloc_tinnguong_dacapgcn_khac,
            'xuanloc_tinnguong_chuacapgcn' => $result['xuan-loc']['34'], //$xuanloc_tinnguong_chuacapgcn,

            /*CẨM MỸ*/
            'cammy_tongdt' => $result['cam-my']['2'], //$cammy_tongdt,
            'cammy_sodientichdat_dacapgcn_tong' => $result['cam-my']['3'], //$cammy_sodientichdat_dacapgcn_tong,
            'cammy_sodientichdat_dacapgcn_tongiao' => $result['cam-my']['4'], //$cammy_sodientichdat_dacapgcn_tongiao,
            'cammy_sodientichdat_dacapgcn_khac' => $result['cam-my']['5'], //$cammy_sodientichdat_dacapgcn_khac,
            'cammy_sodientichdat_chuacapgcn' => $result['cam-my']['6'], //$cammy_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'cammy_congiao_tongdt' => $result['cam-my']['7'], //$cammy_congiao_tongdt,
            'cammy_congiao_dacapgcn_tongiao' => $result['cam-my']['8'], //$cammy_congiao_dacapgcn_tongiao,
            'cammy_congiao_dacapgcn_khac' => $result['cam-my']['9'], //$cammy_congiao_dacapgcn_khac,
            'cammy_congiao_chuacapgcn' => $result['cam-my']['10'], //$cammy_congiao_chuacapgcn,
            //PHẬT GIÁO
            'cammy_phatgiao_tongdt' => $result['cam-my']['11'], //$cammy_phatgiao_tongdt,
            'cammy_phatgiao_dacapgcn_tongiao' => $result['cam-my']['12'], //$cammy_phatgiao_dacapgcn_tongiao,
            'cammy_phatgiao_dacapgcn_khac' => $result['cam-my']['13'], //$cammy_phatgiao_dacapgcn_khac,
            'cammy_phatgiao_chuacapgcn' => $result['cam-my']['14'], //$cammy_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'cammy_caodai_tongdt' => $result['cam-my']['15'], //$cammy_caodai_tongdt,
            'cammy_caodai_dacapgcn_tongiao' => $result['cam-my']['16'], //$cammy_caodai_dacapgcn_tongiao,
            'cammy_caodai_dacapgcn_khac' => $result['cam-my']['17'], //$cammy_caodai_dacapgcn_khac,
            'cammy_caodai_chuacapgcn' => $result['cam-my']['18'], //$cammy_caodai_chuacapgcn,
            //TĐCSPHVN
            'cammy_tdcsphvn_tongdt' => $result['cam-my']['19'], //$cammy_tdcsphvn_tongdt,
            'cammy_tdcsphvn_dacapgcn_tongiao' => $result['cam-my']['20'], //$cammy_tdcsphvn_dacapgcn_tongiao,
            'cammy_tdcsphvn_dacapgcn_khac' => $result['cam-my']['21'], //$cammy_tdcsphvn_dacapgcn_khac,
            'cammy_tdcsphvn_chuacapgcn' => $result['cam-my']['22'], //$cammy_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'cammy_hoigiao_tongdt' => $result['cam-my']['23'], //$cammy_hoigiao_tongdt,
            'cammy_hoigiao_dacapgcn_tongiao' => $result['cam-my']['24'], //$cammy_hoigiao_dacapgcn_tongiao,
            'cammy_hoigiao_dacapgcn_khac' => $result['cam-my']['25'], //$cammy_hoigiao_dacapgcn_khac,
            'cammy_hoigiao_chuacapgcn' => $result['cam-my']['26'], //$cammy_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'cammy_phatgiaohoahao_tongdt' => 0, //$cammy_phatgiaohoahao_tongdt,
            'cammy_phatgiaohoahao_dacapgcn_tongiao' => 0, //$cammy_phatgiaohoahao_dacapgcn_tongiao,
            'cammy_phatgiaohoahao_dacapgcn_khac' => 0, //$cammy_phatgiaohoahao_dacapgcn_khac,
            'cammy_phatgiaohoahao_chuacapgcn' => 0, //$cammy_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'cammy_tinnguong_tongdt' => $result['cam-my']['31'], //$cammy_tinnguong_tongdt,
            'cammy_tinnguong_dacapgcn_tongiao' => $result['cam-my']['32'], //$cammy_tinnguong_dacapgcn_tongiao,
            'cammy_tinnguong_dacapgcn_khac' => $result['cam-my']['33'], //$cammy_tinnguong_dacapgcn_khac,
            'cammy_tinnguong_chuacapgcn' => $result['cam-my']['34'], //$cammy_tinnguong_chuacapgcn,

            /*TÂN PHÚ*/
            'tanphu_tongdt' => $result['tan-phu']['2'], //$tanphu_tongdt,
            'tanphu_sodientichdat_dacapgcn_tong' => $result['tan-phu']['3'], //$tanphu_sodientichdat_dacapgcn_tong,
            'tanphu_sodientichdat_dacapgcn_tongiao' => $result['tan-phu']['4'], //$tanphu_sodientichdat_dacapgcn_tongiao,
            'tanphu_sodientichdat_dacapgcn_khac' => $result['tan-phu']['5'], //$tanphu_sodientichdat_dacapgcn_khac,
            'tanphu_sodientichdat_chuacapgcn' => $result['tan-phu']['6'], //$tanphu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'tanphu_congiao_tongdt' => $result['tan-phu']['7'], //$tanphu_congiao_tongdt,
            'tanphu_congiao_dacapgcn_tongiao' => $result['tan-phu']['8'], //$tanphu_congiao_dacapgcn_tongiao,
            'tanphu_congiao_dacapgcn_khac' => $result['tan-phu']['9'], //$tanphu_congiao_dacapgcn_khac,
            'tanphu_congiao_chuacapgcn' => $result['tan-phu']['10'], //$tanphu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'tanphu_phatgiao_tongdt' => $result['tan-phu']['11'], //$tanphu_phatgiao_tongdt,
            'tanphu_phatgiao_dacapgcn_tongiao' => $result['tan-phu']['12'], //$tanphu_phatgiao_dacapgcn_tongiao,
            'tanphu_phatgiao_dacapgcn_khac' => $result['tan-phu']['13'], //$tanphu_phatgiao_dacapgcn_khac,
            'tanphu_phatgiao_chuacapgcn' => $result['tan-phu']['14'], //$tanphu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'tanphu_caodai_tongdt' => $result['tan-phu']['15'], //$tanphu_caodai_tongdt,
            'tanphu_caodai_dacapgcn_tongiao' => $result['tan-phu']['16'], //$tanphu_caodai_dacapgcn_tongiao,
            'tanphu_caodai_dacapgcn_khac' => $result['tan-phu']['17'], //$tanphu_caodai_dacapgcn_khac,
            'tanphu_caodai_chuacapgcn' => $result['tan-phu']['18'], //$tanphu_caodai_chuacapgcn,
            //TĐCSPHVN
            'tanphu_tdcsphvn_tongdt' => $result['tan-phu']['19'], //$tanphu_tdcsphvn_tongdt,
            'tanphu_tdcsphvn_dacapgcn_tongiao' => $result['tan-phu']['20'], //$tanphu_tdcsphvn_dacapgcn_tongiao,
            'tanphu_tdcsphvn_dacapgcn_khac' => $result['tan-phu']['21'], //$tanphu_tdcsphvn_dacapgcn_khac,
            'tanphu_tdcsphvn_chuacapgcn' => $result['tan-phu']['22'], //$tanphu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'tanphu_hoigiao_tongdt' => $result['tan-phu']['23'], //$tanphu_hoigiao_tongdt,
            'tanphu_hoigiao_dacapgcn_tongiao' => $result['tan-phu']['24'], //$tanphu_hoigiao_dacapgcn_tongiao,
            'tanphu_hoigiao_dacapgcn_khac' => $result['tan-phu']['25'], //$tanphu_hoigiao_dacapgcn_khac,
            'tanphu_hoigiao_chuacapgcn' => $result['tan-phu']['26'], //$tanphu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'tanphu_phatgiaohoahao_tongdt' => 0, //$tanphu_phatgiaohoahao_tongdt,
            'tanphu_phatgiaohoahao_dacapgcn_tongiao' => 0, //$tanphu_phatgiaohoahao_dacapgcn_tongiao,
            'tanphu_phatgiaohoahao_dacapgcn_khac' => 0, //$tanphu_phatgiaohoahao_dacapgcn_khac,
            'tanphu_phatgiaohoahao_chuacapgcn' => 0, //$tanphu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'tanphu_tinnguong_tongdt' => $result['tan-phu']['31'], //$tanphu_tinnguong_tongdt,
            'tanphu_tinnguong_dacapgcn_tongiao' => $result['tan-phu']['32'], //$tanphu_tinnguong_dacapgcn_tongiao,
            'tanphu_tinnguong_dacapgcn_khac' => $result['tan-phu']['33'], //$tanphu_tinnguong_dacapgcn_khac,
            'tanphu_tinnguong_chuacapgcn' => $result['tan-phu']['34'], //$tanphu_tinnguong_chuacapgcn,

            /*ĐỊNH QUÁN*/
            'dinhquan_tongdt' => $result['dinh-quan']['2'], //$dinhquan_tongdt,
            'dinhquan_sodientichdat_dacapgcn_tong' => $result['dinh-quan']['3'], //$dinhquan_sodientichdat_dacapgcn_tong,
            'dinhquan_sodientichdat_dacapgcn_tongiao' => $result['dinh-quan']['4'], //$dinhquan_sodientichdat_dacapgcn_tongiao,
            'dinhquan_sodientichdat_dacapgcn_khac' => $result['dinh-quan']['5'], //$dinhquan_sodientichdat_dacapgcn_khac,
            'dinhquan_sodientichdat_chuacapgcn' => $result['dinh-quan']['6'], //$dinhquan_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'dinhquan_congiao_tongdt' => $result['dinh-quan']['7'], //$dinhquan_congiao_tongdt,
            'dinhquan_congiao_dacapgcn_tongiao' => $result['dinh-quan']['8'], //$dinhquan_congiao_dacapgcn_tongiao,
            'dinhquan_congiao_dacapgcn_khac' => $result['dinh-quan']['9'], //$dinhquan_congiao_dacapgcn_khac,
            'dinhquan_congiao_chuacapgcn' => $result['dinh-quan']['10'], //$dinhquan_congiao_chuacapgcn,
            //PHẬT GIÁO
            'dinhquan_phatgiao_tongdt' => $result['dinh-quan']['11'], //$dinhquan_phatgiao_tongdt,
            'dinhquan_phatgiao_dacapgcn_tongiao' => $result['dinh-quan']['12'], //$dinhquan_phatgiao_dacapgcn_tongiao,
            'dinhquan_phatgiao_dacapgcn_khac' => $result['dinh-quan']['13'], //$dinhquan_phatgiao_dacapgcn_khac,
            'dinhquan_phatgiao_chuacapgcn' => $result['dinh-quan']['14'], //$dinhquan_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'dinhquan_caodai_tongdt' => $result['dinh-quan']['15'], //$dinhquan_caodai_tongdt,
            'dinhquan_caodai_dacapgcn_tongiao' => $result['dinh-quan']['16'], //$dinhquan_caodai_dacapgcn_tongiao,
            'dinhquan_caodai_dacapgcn_khac' => $result['dinh-quan']['17'], //$dinhquan_caodai_dacapgcn_khac,
            'dinhquan_caodai_chuacapgcn' => $result['dinh-quan']['18'], //$dinhquan_caodai_chuacapgcn,
            //TĐCSPHVN
            'dinhquan_tdcsphvn_tongdt' => $result['dinh-quan']['19'], //$dinhquan_tdcsphvn_tongdt,
            'dinhquan_tdcsphvn_dacapgcn_tongiao' => $result['dinh-quan']['20'], //$dinhquan_tdcsphvn_dacapgcn_tongiao,
            'dinhquan_tdcsphvn_dacapgcn_khac' => $result['dinh-quan']['21'], //$dinhquan_tdcsphvn_dacapgcn_khac,
            'dinhquan_tdcsphvn_chuacapgcn' => $result['dinh-quan']['22'], //$dinhquan_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'dinhquan_hoigiao_tongdt' => $result['dinh-quan']['23'], //$dinhquan_hoigiao_tongdt,
            'dinhquan_hoigiao_dacapgcn_tongiao' => $result['dinh-quan']['24'], //$dinhquan_hoigiao_dacapgcn_tongiao,
            'dinhquan_hoigiao_dacapgcn_khac' => $result['dinh-quan']['25'], //$dinhquan_hoigiao_dacapgcn_khac,
            'dinhquan_hoigiao_chuacapgcn' => $result['dinh-quan']['26'], //$dinhquan_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'dinhquan_phatgiaohoahao_tongdt' => 0, //$dinhquan_phatgiaohoahao_tongdt,
            'dinhquan_phatgiaohoahao_dacapgcn_tongiao' => 0, //$dinhquan_phatgiaohoahao_dacapgcn_tongiao,
            'dinhquan_phatgiaohoahao_dacapgcn_khac' => 0, //$dinhquan_phatgiaohoahao_dacapgcn_khac,
            'dinhquan_phatgiaohoahao_chuacapgcn' => 0, //$dinhquan_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'dinhquan_tinnguong_tongdt' => $result['dinh-quan']['31'], //$dinhquan_tinnguong_tongdt,
            'dinhquan_tinnguong_dacapgcn_tongiao' => $result['dinh-quan']['32'], //$dinhquan_tinnguong_dacapgcn_tongiao,
            'dinhquan_tinnguong_dacapgcn_khac' => $result['dinh-quan']['33'], //$dinhquan_tinnguong_dacapgcn_khac,
            'dinhquan_tinnguong_chuacapgcn' => $result['dinh-quan']['34'], //$dinhquan_tinnguong_chuacapgcn,

            /*THỐNG NHẤT*/
            'thongnhat_tongdt' => $result['thong-nhat']['2'], //$thongnhat_tongdt,
            'thongnhat_sodientichdat_dacapgcn_tong' => $result['thong-nhat']['3'], //$thongnhat_sodientichdat_dacapgcn_tong,
            'thongnhat_sodientichdat_dacapgcn_tongiao' => $result['thong-nhat']['4'], //$thongnhat_sodientichdat_dacapgcn_tongiao,
            'thongnhat_sodientichdat_dacapgcn_khac' => $result['thong-nhat']['5'], //$thongnhat_sodientichdat_dacapgcn_khac,
            'thongnhat_sodientichdat_chuacapgcn' => $result['thong-nhat']['6'], //$thongnhat_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'thongnhat_congiao_tongdt' => $result['thong-nhat']['7'], //$thongnhat_congiao_tongdt,
            'thongnhat_congiao_dacapgcn_tongiao' => $result['thong-nhat']['8'], //$thongnhat_congiao_dacapgcn_tongiao,
            'thongnhat_congiao_dacapgcn_khac' => $result['thong-nhat']['9'], //$thongnhat_congiao_dacapgcn_khac,
            'thongnhat_congiao_chuacapgcn' => $result['thong-nhat']['10'], //$thongnhat_congiao_chuacapgcn,
            //PHẬT GIÁO
            'thongnhat_phatgiao_tongdt' => $result['thong-nhat']['11'], //$thongnhat_phatgiao_tongdt,
            'thongnhat_phatgiao_dacapgcn_tongiao' => $result['thong-nhat']['12'], //$thongnhat_phatgiao_dacapgcn_tongiao,
            'thongnhat_phatgiao_dacapgcn_khac' => $result['thong-nhat']['13'], //$thongnhat_phatgiao_dacapgcn_khac,
            'thongnhat_phatgiao_chuacapgcn' => $result['thong-nhat']['14'], //$thongnhat_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'thongnhat_caodai_tongdt' => $result['thong-nhat']['15'], //$thongnhat_caodai_tongdt,
            'thongnhat_caodai_dacapgcn_tongiao' => $result['thong-nhat']['16'], //$thongnhat_caodai_dacapgcn_tongiao,
            'thongnhat_caodai_dacapgcn_khac' => $result['thong-nhat']['17'], //$thongnhat_caodai_dacapgcn_khac,
            'thongnhat_caodai_chuacapgcn' => $result['thong-nhat']['18'], //$thongnhat_caodai_chuacapgcn,
            //TĐCSPHVN
            'thongnhat_tdcsphvn_tongdt' => $result['thong-nhat']['19'], //$thongnhat_tdcsphvn_tongdt,
            'thongnhat_tdcsphvn_dacapgcn_tongiao' => $result['thong-nhat']['20'], //$thongnhat_tdcsphvn_dacapgcn_tongiao,
            'thongnhat_tdcsphvn_dacapgcn_khac' => $result['thong-nhat']['21'], //$thongnhat_tdcsphvn_dacapgcn_khac,
            'thongnhat_tdcsphvn_chuacapgcn' => $result['thong-nhat']['22'], //$thongnhat_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'thongnhat_hoigiao_tongdt' => $result['thong-nhat']['23'], //$thongnhat_hoigiao_tongdt,
            'thongnhat_hoigiao_dacapgcn_tongiao' => $result['thong-nhat']['24'], //$thongnhat_hoigiao_dacapgcn_tongiao,
            'thongnhat_hoigiao_dacapgcn_khac' => $result['thong-nhat']['25'], //$thongnhat_hoigiao_dacapgcn_khac,
            'thongnhat_hoigiao_chuacapgcn' => $result['thong-nhat']['26'], //$thongnhat_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'thongnhat_phatgiaohoahao_tongdt' => 0, //$thongnhat_phatgiaohoahao_tongdt,
            'thongnhat_phatgiaohoahao_dacapgcn_tongiao' => 0, // $thongnhat_phatgiaohoahao_dacapgcn_tongiao,
            'thongnhat_phatgiaohoahao_dacapgcn_khac' => 0, //$thongnhat_phatgiaohoahao_dacapgcn_khac,
            'thongnhat_phatgiaohoahao_chuacapgcn' => 0, //$thongnhat_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'thongnhat_tinnguong_tongdt' => $result['thong-nhat']['31'], //$thongnhat_tinnguong_tongdt,
            'thongnhat_tinnguong_dacapgcn_tongiao' => $result['thong-nhat']['32'], //$thongnhat_tinnguong_dacapgcn_tongiao,
            'thongnhat_tinnguong_dacapgcn_khac' => $result['thong-nhat']['33'], //$thongnhat_tinnguong_dacapgcn_khac,
            'thongnhat_tinnguong_chuacapgcn' => $result['thong-nhat']['34'], //$thongnhat_tinnguong_chuacapgcn,

            /*TRẢNG BOM*/
            'trangbom_tongdt' => $result['trang-bom']['2'], //$trangbom_tongdt,
            'trangbom_sodientichdat_dacapgcn_tong' => $result['trang-bom']['3'], //$trangbom_sodientichdat_dacapgcn_tong,
            'trangbom_sodientichdat_dacapgcn_tongiao' => $result['trang-bom']['4'], //$trangbom_sodientichdat_dacapgcn_tongiao,
            'trangbom_sodientichdat_dacapgcn_khac' => $result['trang-bom']['5'], //$trangbom_sodientichdat_dacapgcn_khac,
            'trangbom_sodientichdat_chuacapgcn' => $result['trang-bom']['6'], //$trangbom_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'trangbom_congiao_tongdt' => $result['trang-bom']['7'], //$trangbom_congiao_tongdt,
            'trangbom_congiao_dacapgcn_tongiao' => $result['trang-bom']['8'], //$trangbom_congiao_dacapgcn_tongiao,
            'trangbom_congiao_dacapgcn_khac' => $result['trang-bom']['9'], //$trangbom_congiao_dacapgcn_khac,
            'trangbom_congiao_chuacapgcn' => $result['trang-bom']['10'], //$trangbom_congiao_chuacapgcn,
            //PHẬT GIÁO
            'trangbom_phatgiao_tongdt' => $result['trang-bom']['11'], //$trangbom_phatgiao_tongdt,
            'trangbom_phatgiao_dacapgcn_tongiao' => $result['trang-bom']['12'], //$trangbom_phatgiao_dacapgcn_tongiao,
            'trangbom_phatgiao_dacapgcn_khac' => $result['trang-bom']['13'], //$trangbom_phatgiao_dacapgcn_khac,
            'trangbom_phatgiao_chuacapgcn' => $result['trang-bom']['14'], //$trangbom_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'trangbom_caodai_tongdt' => $result['trang-bom']['15'], //$trangbom_caodai_tongdt,
            'trangbom_caodai_dacapgcn_tongiao' => $result['trang-bom']['16'], //$trangbom_caodai_dacapgcn_tongiao,
            'trangbom_caodai_dacapgcn_khac' => $result['trang-bom']['17'], //$trangbom_caodai_dacapgcn_khac,
            'trangbom_caodai_chuacapgcn' => $result['trang-bom']['18'], //$trangbom_caodai_chuacapgcn,
            //TĐCSPHVN
            'trangbom_tdcsphvn_tongdt' => $result['trang-bom']['19'], //$trangbom_tdcsphvn_tongdt,
            'trangbom_tdcsphvn_dacapgcn_tongiao' => $result['trang-bom']['20'], //$trangbom_tdcsphvn_dacapgcn_tongiao,
            'trangbom_tdcsphvn_dacapgcn_khac' => $result['trang-bom']['21'], //$trangbom_tdcsphvn_dacapgcn_khac,
            'trangbom_tdcsphvn_chuacapgcn' => $result['trang-bom']['22'], //$trangbom_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'trangbom_hoigiao_tongdt' => $result['trang-bom']['23'], //$trangbom_hoigiao_tongdt,
            'trangbom_hoigiao_dacapgcn_tongiao' => $result['trang-bom']['24'], //$trangbom_hoigiao_dacapgcn_tongiao,
            'trangbom_hoigiao_dacapgcn_khac' => $result['trang-bom']['25'], //$trangbom_hoigiao_dacapgcn_khac,
            'trangbom_hoigiao_chuacapgcn' => $result['trang-bom']['26'], //$trangbom_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'trangbom_phatgiaohoahao_tongdt' => 0, //$trangbom_phatgiaohoahao_tongdt,
            'trangbom_phatgiaohoahao_dacapgcn_tongiao' => 0, //$trangbom_phatgiaohoahao_dacapgcn_tongiao,
            'trangbom_phatgiaohoahao_dacapgcn_khac' => 0, //$trangbom_phatgiaohoahao_dacapgcn_khac,
            'trangbom_phatgiaohoahao_chuacapgcn' => 0, //$trangbom_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'trangbom_tinnguong_tongdt' => $result['trang-bom']['31'], //$trangbom_tinnguong_tongdt,
            'trangbom_tinnguong_dacapgcn_tongiao' => $result['trang-bom']['32'], //$trangbom_tinnguong_dacapgcn_tongiao,
            'trangbom_tinnguong_dacapgcn_khac' => $result['trang-bom']['33'], //$trangbom_tinnguong_dacapgcn_khac,
            'trangbom_tinnguong_chuacapgcn' => $result['trang-bom']['34'], //$trangbom_tinnguong_chuacapgcn,

            /*VĨNH CỬU*/
            'vinhcuu_tongdt' => $result['vinh-cuu']['2'], //$vinhcuu_tongdt,
            'vinhcuu_sodientichdat_dacapgcn_tong' => $result['vinh-cuu']['3'], //$vinhcuu_sodientichdat_dacapgcn_tong,
            'vinhcuu_sodientichdat_dacapgcn_tongiao' => $result['vinh-cuu']['4'], //$vinhcuu_sodientichdat_dacapgcn_tongiao,
            'vinhcuu_sodientichdat_dacapgcn_khac' => $result['vinh-cuu']['5'], //$vinhcuu_sodientichdat_dacapgcn_khac,
            'vinhcuu_sodientichdat_chuacapgcn' => $result['vinh-cuu']['6'], //$vinhcuu_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'vinhcuu_congiao_tongdt' => $result['vinh-cuu']['7'], //$vinhcuu_congiao_tongdt,
            'vinhcuu_congiao_dacapgcn_tongiao' => $result['vinh-cuu']['8'], //$vinhcuu_congiao_dacapgcn_tongiao,
            'vinhcuu_congiao_dacapgcn_khac' => $result['vinh-cuu']['9'], //$vinhcuu_congiao_dacapgcn_khac,
            'vinhcuu_congiao_chuacapgcn' => $result['vinh-cuu']['10'], //$vinhcuu_congiao_chuacapgcn,
            //PHẬT GIÁO
            'vinhcuu_phatgiao_tongdt' => $result['vinh-cuu']['11'], //$vinhcuu_phatgiao_tongdt,
            'vinhcuu_phatgiao_dacapgcn_tongiao' => $result['vinh-cuu']['12'], //$vinhcuu_phatgiao_dacapgcn_tongiao,
            'vinhcuu_phatgiao_dacapgcn_khac' => $result['vinh-cuu']['13'], //$vinhcuu_phatgiao_dacapgcn_khac,
            'vinhcuu_phatgiao_chuacapgcn' => $result['vinh-cuu']['14'], //$vinhcuu_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'vinhcuu_caodai_tongdt' => $result['vinh-cuu']['15'], //$vinhcuu_caodai_tongdt,
            'vinhcuu_caodai_dacapgcn_tongiao' => $result['vinh-cuu']['16'], //$vinhcuu_caodai_dacapgcn_tongiao,
            'vinhcuu_caodai_dacapgcn_khac' => $result['vinh-cuu']['17'], //$vinhcuu_caodai_dacapgcn_khac,
            'vinhcuu_caodai_chuacapgcn' => $result['vinh-cuu']['18'], //$vinhcuu_caodai_chuacapgcn,
            //TĐCSPHVN
            'vinhcuu_tdcsphvn_tongdt' => $result['vinh-cuu']['19'], //$vinhcuu_tdcsphvn_tongdt,
            'vinhcuu_tdcsphvn_dacapgcn_tongiao' => $result['vinh-cuu']['20'], //$vinhcuu_tdcsphvn_dacapgcn_tongiao,
            'vinhcuu_tdcsphvn_dacapgcn_khac' => $result['vinh-cuu']['21'], //$vinhcuu_tdcsphvn_dacapgcn_khac,
            'vinhcuu_tdcsphvn_chuacapgcn' => $result['vinh-cuu']['22'], //$vinhcuu_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'vinhcuu_hoigiao_tongdt' => $result['vinh-cuu']['23'], //$vinhcuu_hoigiao_tongdt,
            'vinhcuu_hoigiao_dacapgcn_tongiao' => $result['vinh-cuu']['24'], //$vinhcuu_hoigiao_dacapgcn_tongiao,
            'vinhcuu_hoigiao_dacapgcn_khac' => $result['vinh-cuu']['25'], //$vinhcuu_hoigiao_dacapgcn_khac,
            'vinhcuu_hoigiao_chuacapgcn' => $result['vinh-cuu']['26'], //$vinhcuu_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'vinhcuu_phatgiaohoahao_tongdt' => 0, //$vinhcuu_phatgiaohoahao_tongdt,
            'vinhcuu_phatgiaohoahao_dacapgcn_tongiao' => 0, //$vinhcuu_phatgiaohoahao_dacapgcn_tongiao,
            'vinhcuu_phatgiaohoahao_dacapgcn_khac' => 0, //$vinhcuu_phatgiaohoahao_dacapgcn_khac,
            'vinhcuu_phatgiaohoahao_chuacapgcn' => 0, //$vinhcuu_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'vinhcuu_tinnguong_tongdt' => $result['vinh-cuu']['31'], //$vinhcuu_tinnguong_tongdt,
            'vinhcuu_tinnguong_dacapgcn_tongiao' => $result['vinh-cuu']['32'], //$vinhcuu_tinnguong_dacapgcn_tongiao,
            'vinhcuu_tinnguong_dacapgcn_khac' => $result['vinh-cuu']['33'], //$vinhcuu_tinnguong_dacapgcn_khac,
            'vinhcuu_tinnguong_chuacapgcn' => $result['vinh-cuu']['34'], //$vinhcuu_tinnguong_chuacapgcn,

            /*NHƠN TRẠCH*/
            'nhontrach_tongdt' => $result['nhon-trach']['2'], //$nhontrach_tongdt,
            'nhontrach_sodientichdat_dacapgcn_tong' => $result['nhon-trach']['3'], //$nhontrach_sodientichdat_dacapgcn_tong,
            'nhontrach_sodientichdat_dacapgcn_tongiao' => $result['nhon-trach']['4'], //$nhontrach_sodientichdat_dacapgcn_tongiao,
            'nhontrach_sodientichdat_dacapgcn_khac' => $result['nhon-trach']['5'], //$nhontrach_sodientichdat_dacapgcn_khac,
            'nhontrach_sodientichdat_chuacapgcn' => $result['nhon-trach']['6'], //$nhontrach_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'nhontrach_congiao_tongdt' => $result['nhon-trach']['7'], //$nhontrach_congiao_tongdt,
            'nhontrach_congiao_dacapgcn_tongiao' => $result['nhon-trach']['8'], //$nhontrach_congiao_dacapgcn_tongiao,
            'nhontrach_congiao_dacapgcn_khac' => $result['nhon-trach']['9'], //$nhontrach_congiao_dacapgcn_khac,
            'nhontrach_congiao_chuacapgcn' => $result['nhon-trach']['10'], //$nhontrach_congiao_chuacapgcn,
            //PHẬT GIÁO
            'nhontrach_phatgiao_tongdt' => $result['nhon-trach']['11'], //$nhontrach_phatgiao_tongdt,
            'nhontrach_phatgiao_dacapgcn_tongiao' => $result['nhon-trach']['12'], //$nhontrach_phatgiao_dacapgcn_tongiao,
            'nhontrach_phatgiao_dacapgcn_khac' => $result['nhon-trach']['13'], //$nhontrach_phatgiao_dacapgcn_khac,
            'nhontrach_phatgiao_chuacapgcn' => $result['nhon-trach']['14'], //$nhontrach_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'nhontrach_caodai_tongdt' => $result['nhon-trach']['15'], //$nhontrach_caodai_tongdt,
            'nhontrach_caodai_dacapgcn_tongiao' => $result['nhon-trach']['16'], //$nhontrach_caodai_dacapgcn_tongiao,
            'nhontrach_caodai_dacapgcn_khac' => $result['nhon-trach']['17'], //$nhontrach_caodai_dacapgcn_khac,
            'nhontrach_caodai_chuacapgcn' => $result['nhon-trach']['18'], //$nhontrach_caodai_chuacapgcn,
            //TĐCSPHVN
            'nhontrach_tdcsphvn_tongdt' => $result['nhon-trach']['19'], //$nhontrach_tdcsphvn_tongdt,
            'nhontrach_tdcsphvn_dacapgcn_tongiao' => $result['nhon-trach']['20'], //$nhontrach_tdcsphvn_dacapgcn_tongiao,
            'nhontrach_tdcsphvn_dacapgcn_khac' => $result['nhon-trach']['21'], //$nhontrach_tdcsphvn_dacapgcn_khac,
            'nhontrach_tdcsphvn_chuacapgcn' => $result['nhon-trach']['22'], //$nhontrach_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'nhontrach_hoigiao_tongdt' => $result['nhon-trach']['23'], //$nhontrach_hoigiao_tongdt,
            'nhontrach_hoigiao_dacapgcn_tongiao' => $result['nhon-trach']['24'], //$nhontrach_hoigiao_dacapgcn_tongiao,
            'nhontrach_hoigiao_dacapgcn_khac' => $result['nhon-trach']['25'], //$nhontrach_hoigiao_dacapgcn_khac,
            'nhontrach_hoigiao_chuacapgcn' => $result['nhon-trach']['26'], //$nhontrach_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'nhontrach_phatgiaohoahao_tongdt' => 0, //$nhontrach_phatgiaohoahao_tongdt,
            'nhontrach_phatgiaohoahao_dacapgcn_tongiao' => 0, //$nhontrach_phatgiaohoahao_dacapgcn_tongiao,
            'nhontrach_phatgiaohoahao_dacapgcn_khac' => 0, //$nhontrach_phatgiaohoahao_dacapgcn_khac,
            'nhontrach_phatgiaohoahao_chuacapgcn' => 0, //$nhontrach_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'nhontrach_tinnguong_tongdt' => $result['nhon-trach']['31'], //$nhontrach_tinnguong_tongdt,
            'nhontrach_tinnguong_dacapgcn_tongiao' => $result['nhon-trach']['32'], //$nhontrach_tinnguong_dacapgcn_tongiao,
            'nhontrach_tinnguong_dacapgcn_khac' => $result['nhon-trach']['33'], //$nhontrach_tinnguong_dacapgcn_khac,
            'nhontrach_tinnguong_chuacapgcn' => $result['nhon-trach']['34'], //$nhontrach_tinnguong_chuacapgcn,

            /*LONG THÀNH*/
            'longthanh_tongdt' => $result['long-thanh']['2'], //$longthanh_tongdt,
            'longthanh_sodientichdat_dacapgcn_tong' => $result['long-thanh']['3'], //$longthanh_sodientichdat_dacapgcn_tong,
            'longthanh_sodientichdat_dacapgcn_tongiao' => $result['long-thanh']['4'], //$longthanh_sodientichdat_dacapgcn_tongiao,
            'longthanh_sodientichdat_dacapgcn_khac' => $result['long-thanh']['5'], //$longthanh_sodientichdat_dacapgcn_khac,
            'longthanh_sodientichdat_chuacapgcn' => $result['long-thanh']['6'], //$longthanh_sodientichdat_chuacapgcn,
            //CÔNG GIÁO
            'longthanh_congiao_tongdt' => $result['long-thanh']['7'], //$longthanh_congiao_tongdt,
            'longthanh_congiao_dacapgcn_tongiao' => $result['long-thanh']['8'], //$longthanh_congiao_dacapgcn_tongiao,
            'longthanh_congiao_dacapgcn_khac' => $result['long-thanh']['9'], //$longthanh_congiao_dacapgcn_khac,
            'longthanh_congiao_chuacapgcn' => $result['long-thanh']['10'], //$longthanh_congiao_chuacapgcn,
            //PHẬT GIÁO
            'longthanh_phatgiao_tongdt' => $result['long-thanh']['11'], //$longthanh_phatgiao_tongdt,
            'longthanh_phatgiao_dacapgcn_tongiao' => $result['long-thanh']['12'], //$longthanh_phatgiao_dacapgcn_tongiao,
            'longthanh_phatgiao_dacapgcn_khac' => $result['long-thanh']['13'], //$longthanh_phatgiao_dacapgcn_khac,
            'longthanh_phatgiao_chuacapgcn' => $result['long-thanh']['14'], //$longthanh_phatgiao_chuacapgcn,
            //CAO ĐÀI
            'longthanh_caodai_tongdt' => $result['long-thanh']['15'], //$longthanh_caodai_tongdt,
            'longthanh_caodai_dacapgcn_tongiao' => $result['long-thanh']['16'], //$longthanh_caodai_dacapgcn_tongiao,
            'longthanh_caodai_dacapgcn_khac' => $result['long-thanh']['17'], //$longthanh_caodai_dacapgcn_khac,
            'longthanh_caodai_chuacapgcn' => $result['long-thanh']['18'], //$longthanh_caodai_chuacapgcn,
            //TĐCSPHVN
            'longthanh_tdcsphvn_tongdt' => $result['long-thanh']['19'], //$longthanh_tdcsphvn_tongdt,
            'longthanh_tdcsphvn_dacapgcn_tongiao' => $result['long-thanh']['20'], //$longthanh_tdcsphvn_dacapgcn_tongiao,
            'longthanh_tdcsphvn_dacapgcn_khac' => $result['long-thanh']['21'], //$longthanh_tdcsphvn_dacapgcn_khac,
            'longthanh_tdcsphvn_chuacapgcn' => $result['long-thanh']['22'], //$longthanh_tdcsphvn_chuacapgcn,
            //HỒI GIÁO
            'longthanh_hoigiao_tongdt' => $result['long-thanh']['23'], //$longthanh_hoigiao_tongdt,
            'longthanh_hoigiao_dacapgcn_tongiao' => $result['long-thanh']['24'], //$longthanh_hoigiao_dacapgcn_tongiao,
            'longthanh_hoigiao_dacapgcn_khac' => $result['long-thanh']['25'], //$longthanh_hoigiao_dacapgcn_khac,
            'longthanh_hoigiao_chuacapgcn' => $result['long-thanh']['26'], //$longthanh_hoigiao_chuacapgcn,
            //PHẬT GIÁO HÒA HẢO
            'longthanh_phatgiaohoahao_tongdt' => 0, //$longthanh_phatgiaohoahao_tongdt,
            'longthanh_phatgiaohoahao_dacapgcn_tongiao' => 0, //$longthanh_phatgiaohoahao_dacapgcn_tongiao,
            'longthanh_phatgiaohoahao_dacapgcn_khac' => 0, //$longthanh_phatgiaohoahao_dacapgcn_khac,
            'longthanh_phatgiaohoahao_chuacapgcn' => 0, //$longthanh_phatgiaohoahao_chuacapgcn,
            //TÍN NGƯỠNG
            'longthanh_tinnguong_tongdt' => $result['long-thanh']['31'], //$longthanh_tinnguong_tongdt,
            'longthanh_tinnguong_dacapgcn_tongiao' => $result['long-thanh']['32'], //$longthanh_tinnguong_dacapgcn_tongiao,
            'longthanh_tinnguong_dacapgcn_khac' => $result['long-thanh']['33'], //$longthanh_tinnguong_dacapgcn_khac,
            'longthanh_tinnguong_chuacapgcn' => $result['long-thanh']['34'], //$longthanh_tinnguong_chuacapgcn,

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
            'phatgiaohoahao_tongdt' => 0, //$phatgiaohoahao_tongdt,
            'phatgiaohoahao_dacapgcn_tongiao' => 0, //$phatgiaohoahao_dacapgcn_tongiao,
            'phatgiaohoahao_dacapgcn_khac' => 0, //$phatgiaohoahao_dacapgcn_khac,
            'phatgiaohoahao_chuacapgcn' => 0, //$phatgiaohoahao_chuacapgcn,
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
     * TỔNG HỢP CƠ SỞ TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
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

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template3.xls';
        //$filename = "template3";
        $filename = "{$this->_type_text[3]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        $r = 9;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong2']);
                        break;
                    case 'D'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong3']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong4']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong5']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong6']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['7']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong7']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['8']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong8']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['9']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong9']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['10']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong10']);
                        break;
                    case 'L'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['11']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong11']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['12']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong12']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['13']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong13']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['14']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong14']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['15']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong15']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['16']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong16']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['17']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong17']);
                        break;
                    case 'S'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['18']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong18']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['19']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong19']);
                        break;
                    case 'U'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['20']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong20']);
                        break;
                    case 'V'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['21']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong21']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['22']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong22']);
                        break;
                    case 'X'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['23']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong23']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['24']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong24']);
                        break;
                    case 'Z'://TÍN NGƯỠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['25']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong25']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['26']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong26']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['27']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong27']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['28']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong28']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['29']);
                        $this->Excel->ActiveSheet->getCell("{$c}20")->setValue($total['tong29']);
                        break;
                    default:
                        echo 'TH CO SO TON GIAO';
                }
            }

            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * TONG HOP DI TICH
     * TỔNG HỢP CƠ SỞ TÔN GIÁO, TÍN NGƯỠNG ĐƯỢC XẾP HẠNG DI TÍCH TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType4Data()
    {
        $component = $this->Components->load('ExportThDt');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template4.xls';
        //$filename = "template7";
        $filename = "{$this->_type_text[4]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'D'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 10;
        foreach ($data as $result) {
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_total_tw']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_total_tinh']);
                        break;
                    case 'F'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Giaoxu_tw']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Giaoxu_tinh']);
                        break;
                    case 'H'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Tuvienphatgiao_tw']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Tuvienphatgiao_tinh']);
                        break;
                    case 'J'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Chihoitinlanh_tw']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Chihoitinlanh_tinh']);
                        break;
                    case 'L'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Hodaocaodai_tw']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Hodaocaodai_tinh']);
                        break;
                    case 'N'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Chihoitinhdocusiphatgiaovietnam_tw']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Chihoitinhdocusiphatgiaovietnam_tinh']);
                        break;
                    case 'P'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hoahao_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Hoahao_tw']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hoahao_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Hoahao_tinh']);
                        break;
                    case 'R'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Cosohoigiaoislam_tw']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Cosohoigiaoislam_tw']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Cosohoigiaoislam_tinh']);
                        $this->Excel->ActiveSheet->getCell("{$c}65")->setValue($result['total_Cosohoigiaoislam_tinh']);
                        break;
                    default:
                        echo 'TONG HOP DI TICH';
                }
            }

            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * TỔNG HỢP CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG ĐÃ ĐƯỢC TRÙNG TU, TÔN TẠO
     */
    protected function __getType6Data()
    {
        $component = $this->Components->load('Cstgtrungtu');
        $data = $component->export();

        $result = $data;
        $total = [];
        $i = 2;
        while ($i <= 27) {
            $sum = 0;
            foreach ($result as $key => $value) {
                $sum += $value[$i];
            }
            $total["tong{$i}"] = $sum;
            $i++;
        }

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template6.xls';
        //$filename = "template6";
        $filename = "{$this->_type_text[6]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        $r = 6;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://Tổng
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong2']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong3']);
                        break;
                    case 'E'://Công giáo
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong4']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong5']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong6']);
                        break;
                    case 'H'://Phật giáo
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['7']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong7']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['8']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong8']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['9']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong9']);
                        break;
                    case 'K'://Tin lành
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['10']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong10']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['11']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong11']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['12']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong12']);
                        break;
                    case 'N'://Cao đài
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['13']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong13']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['14']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong14']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['15']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong15']);
                        break;
                    case 'Q'://Tịnh độ Cư sĩ Phật hội VN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['16']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong16']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['17']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong17']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['18']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong18']);
                        break;
                    case 'T'://Phật giáo Hòa Hảo
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['19']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong19']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['20']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong20']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['21']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong21']);
                        break;
                    case 'W'://Hồi giáo
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['22']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong22']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['23']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong23']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['24']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong24']);
                        break;
                    case 'Z'://Tín ngưỡng
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['25']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong25']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['26']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong26']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['27']);
                        $this->Excel->ActiveSheet->getCell("{$c}17")->setValue($total['tong27']);
                        break;
                    default:
                        echo 'TONG HOP CSTG TRUNG TU';
                }
            }

            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * BẢNG TỔNG HỢP TÍN ĐỒ CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType7Data()
    {
        $component = $this->Components->load('ExportThTdTg');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template7.xls';
        //$filename = "template7";
        $filename = "{$this->_type_text[7]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 12;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_total']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_dathuchiennghiletongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_chuathuchiennghiletongiao']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_dantocthieuso']);
                        break;
                    case 'G'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_total']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_dathuchiennghiletongiao']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_chuathuchiennghiletongiao']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_dantocthieuso']);
                        break;
                    case 'K'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_total']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_dathuchiennghiletongiao']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_chuathuchiennghiletongiao']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_dantocthieuso']);
                        break;
                    case 'O'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_total']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_dathuchiennghiletongiao']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_chuathuchiennghiletongiao']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_dantocthieuso']);
                        break;
                    case 'S'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_total']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_dathuchiennghiletongiao']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_chuathuchiennghiletongiao']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_dantocthieuso']);
                        break;
                    case 'W'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_total']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_dathuchiennghiletongiao']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_chuathuchiennghiletongiao']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_dantocthieuso']);
                        break;
                    case 'AA'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hoahao_total']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hoahao_dathuchiennghiletongiao']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hoahao_chuathuchiennghiletongiao']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hoahao_dantocthieuso']);
                        break;
                    case 'AE'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Cosohoigiaoislam_total']);
                        break;
                    case 'AF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Cosohoigiaoislam_dathuchiennghiletongiao']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Cosohoigiaoislam_chuathuchiennghiletongiao']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Cosohoigiaoislam_dantocthieuso']);
                        break;
                    case 'AI'://CÁC TÔN GIÁO KHÁC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tongiaokhac_total']);
                        break;
                    case 'AJ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tongiaokhac_dathuchiennghiletongiao']);
                        break;
                    case 'AK':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tongiaokhac_chuathuchiennghiletongiao']);
                        break;
                    case 'AL':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tongiaokhac_dantocthieuso']);
                        break;
                    default:
                        echo 'BANG TONG HOP TIN DO';
                }
            }

            $this->Excel->ActiveSheet->getCell('C23')->setValue($tong3 += $result['total_total']);
            $this->Excel->ActiveSheet->getCell('D23')->setValue($tong4 += $result['total_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('E23')->setValue($tong5 += $result['total_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('F23')->setValue($tong6 += $result['total_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('G17')->setValue($tong7 += $result['Giaoxu_total']);
            $this->Excel->ActiveSheet->getCell('H17')->setValue($tong8 += $result['Giaoxu_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('I17')->setValue($tong9 += $result['Giaoxu_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('J17')->setValue($tong10 += $result['Giaoxu_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('K17')->setValue($tong11 += $result['Tuvienphatgiao_total']);
            $this->Excel->ActiveSheet->getCell('L17')->setValue($tong12 += $result['Tuvienphatgiao_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('M17')->setValue($tong13 += $result['Tuvienphatgiao_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('N17')->setValue($tong14 += $result['Tuvienphatgiao_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('O17')->setValue($tong15 += $result['Chihoitinlanh_total']);
            $this->Excel->ActiveSheet->getCell('P17')->setValue($tong16 += $result['Chihoitinlanh_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('Q17')->setValue($tong17 += $result['Chihoitinlanh_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('R17')->setValue($tong18 += $result['Chihoitinlanh_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('S17')->setValue($tong19 += $result['Hodaocaodai_total']);
            $this->Excel->ActiveSheet->getCell('T17')->setValue($tong20 += $result['Hodaocaodai_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('U17')->setValue($tong21 += $result['Hodaocaodai_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('V17')->setValue($tong22 += $result['Hodaocaodai_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('W17')->setValue($tong23 += $result['Chihoitinhdocusiphatgiaovietnam_total']);
            $this->Excel->ActiveSheet->getCell('X17')->setValue($tong24 += $result['Chihoitinhdocusiphatgiaovietnam_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('Y17')->setValue($tong25 += $result['Chihoitinhdocusiphatgiaovietnam_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('Z17')->setValue($tong26 += $result['Chihoitinhdocusiphatgiaovietnam_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('AA17')->setValue($tong27 += $result['Hoahao_total']);
            $this->Excel->ActiveSheet->getCell('AB17')->setValue($tong28 += $result['Hoahao_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('AC17')->setValue($tong29 += $result['Hoahao_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('AD17')->setValue($tong30 += $result['Hoahao_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('AE17')->setValue($tong31 += $result['Cosohoigiaoislam_total']);
            $this->Excel->ActiveSheet->getCell('AF17')->setValue($tong32 += $result['Cosohoigiaoislam_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('AG17')->setValue($tong33 += $result['Cosohoigiaoislam_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('AH17')->setValue($tong34 += $result['Cosohoigiaoislam_dantocthieuso']);
            $this->Excel->ActiveSheet->getCell('AI17')->setValue($tong35 += $result['Tongiaokhac_total']);
            $this->Excel->ActiveSheet->getCell('AJ17')->setValue($tong36 += $result['Tongiaokhac_dathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('AK17')->setValue($tong37 += $result['Tongiaokhac_chuathuchiennghiletongiao']);
            $this->Excel->ActiveSheet->getCell('AL17')->setValue($tong38 += $result['Tongiaokhac_dantocthieuso']);

            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DANH SÁCH CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType8Data()
    {
        $component = $this->Components->load('ExportThCsTtTg');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template8.xls';
        //$filename = "template8";
        $filename = "{$this->_type_text[8]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }

        $r = 8;
        foreach ($data as $result) {
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['stt']);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tencosothotu']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['diachi']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tindodathuchiennghiletongiao']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tindochuathuchiennghiletongiao']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tindoladantocthieuso']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['chucsac']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tusi']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['chucsacladantocthieuso']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['chucviec']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['chucviecladantocthieuso']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['namthanhlap']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['namxaydung']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['sotien']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['solan']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['sotienlancuoi']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['dacapgcnqsddat_tongiao']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['dacapgcnqsddat_khac']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['chuacapgcnqsddat']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['kientruc']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['xephangditich']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['capcongnhan']);
                        break;
                    default:
                        echo 'ds cstt';
                }
            }
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DANH SÁCH CƠ SỞ HOẠT ĐỘNG XÃ HỘI CỦA CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType9Data()
    {
        $component = $this->Components->load('ExportThCsHdXh');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template9.xls';
        //$filename = "template9";
        $filename = "{$this->_type_text[9]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 8;
        foreach ($data as $result) {
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['stt']);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tencosothotu']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['diachi']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['thuoctochuctongiaocoso']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['thuoclinhvuc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['cosohopphapchuahopphap']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['coquancongnhan']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['giaychungnhan']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['ghichu']);
                        break;
                    default:
                        echo 'DSCS BAO TRO XA HOI';
                }
            }
            $r++;
        }

        return $this->Excel->save($filename);
    }

    public function formatData()
    {
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

        return $this->$modelName->find('all', array(
            'fields' => $fields,
            'conditions' => $conditions
        ));
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

    /*====================CHỨC SẮC TÔN GIÁO====================*/

    /**
     * DS CS THAM GIA CT-XH CAP XA
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ
     *
     * + Cách lấy dữ liệu
     * 1. Bảng chucsactinlanh
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_capxa = true hoặc
     * cột uybanmttqvn_capxa = true hoặc
     * cột hoichuthapdo_capxa = true hoặc
     * cột hoinongdan_capxa = true hoặc
     * cột hoilienhiepthanhnien_capxa = true hoặc
     * cột hoilienhiepphunu_capxa = true hoặc
     * cột cactochuckhac_capxa = true
     *
     * 2. Bảng chucsacnhatuhanhconggiaotrieu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_capxa = true
     *
     * 3. Bảng chucsacnhatuhanhcongiaodongtu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_ubbdkcg_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_capxa = true
     *
     * 4. Bảng chucviecphathoahao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_capxa = true hoặc
     * cột uybanmttqvn_capxa = true hoặc
     * cột hoichuthapdo_capxa = true hoặc
     * cột hoinongdan_capxa = true hoặc
     * cột hoilienhiepphunu_capxa = true hoặc
     * cột doanthanhnien_capxa = true hoặc
     * cột tochuckhac_capxa = true
     *
     * 5. Bảng chucviectinhdocusiphathoivietnam
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_capxa = true hoặc
     * cột ubmttqvn_capxa = true hoặc
     * cột hoichuthapdo_capxa = true hoặc
     * cột hoinongdan_capxa = true hoặc
     * cột hoilienhiepphunu_capxa = true hoặc
     * cột doanthanhnien_capxa = true hoặc
     * cột tochuckhac_capxa = true
     *
     * 6. Bảng chucsaccaodai
     * - lấy dữ liệu thõa điều kiện sau:
     * cột thamgiacactcctxh_hoidongnhandan_capxa = true hoặc
     * cột thamgiacactcctxh_uybanmttqvn_capxa = true hoặc
     * cột thamgiacactcctxh_hoichuthapdo_capxa = true hoặc
     * cột thamgiacactcctxh_hoinongdan_capxa = true hoặc
     * cột thamgiacactcctxh_hoilienhiepphunu_capxa = true hoặc
     * cột thamgiacactcctxh_doanthanhnien_capxa = true hoặc
     * cột thamgiacactcctxh_tochuckhac_capxa = true
     *
     * 7. Bảng chucsacnhatuhanhphatgiao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_capxa = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_capxa = true
     *
     * 8. Bảng huynhtruonggiadinhphattu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột thamgia_hoidongnhandan_capxa = true hoặc
     * cột thamgia_ubmttqvn_capxa = true hoặc
     * cột thamgia_hoinongdan_capxa = true hoặc
     * cột thamgia_hoichuthapdo_capxa = true hoặc
     * cột thamgia_hoilienhiepthanhnien_capxa = true hoặc
     * cột thamgia_hoilienhiepphunu_capxa = true hoặc
     * cột thamgia_cactochuckhac_capxa = true
     *
     * 9. Bảng nguoihoatdongtinnguongchuyennghiep
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_capxa = true hoặc
     * cột ubmttqvn_capxa = true hoặc
     * cột hoinongdan_capxa = true hoặc
     * cột hoichuthapdo_capxa = true hoặc
     * cột hoilienhiepthanhnien_capxa = true hoặc
     * cột hoilienhiepphunu_capxa = true hoặc
     * cột cactochuckhac_capxa = true
     *
     * 10. Bảng chucviechoigiao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_capxa = true hoặc
     * cột ubmttqvn_capxa = true hoặc
     * cột hoichuthapdo_capxa = true hoặc
     * cột hoinongdan_capxa = true hoặc
     * cột hoilienhiepphunu_capxa = true hoặc
     * cột doanthanhnien_capxa = true hoặc
     * cột tochuckhac_capxa = true
     */
    protected function __getType11Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Huynhtruonggiadinhphattu',
            'Nguoihoatdongtinnguongchuyennghiep', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelDSCSTHAMGIACTXHCAPXA();
        //$huynh_truong_gia_dinh_phat_tu = $this->Huynhtruonggiadinhphattu->getDataExcelDSCSTHAMGIACTXHCAPXA();
        //$nguoi_hoat_dong_tin_nguong_chuyen_nghiep = $this->Nguoihoatdongtinnguongchuyennghiep->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelDSCSTHAMGIACTXHCAPXA();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            //$huynh_truong_gia_dinh_phat_tu,
            //$nguoi_hoat_dong_tin_nguong_chuyen_nghiep,
            $chuc_viec_hoi_giao
        );

        $this->__createTemplate11($data);
    }

    public function __createTemplate11($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template11.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[11]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'S'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }

        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['dantoc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamtrat']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongpham']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thamgiatochucchinhtrixahoi']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
                        break;
                    default:
                        echo 'DS CS THAM GIA CT-XH CAP XA';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DS CS THAM GIA CT-XH CAP HUYEN
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP HUYỆN
     *
     * 1. Bảng chucsactinlanh
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_caphuyen = true hoặc
     * cột uybanmttqvn_caphuyen = true hoặc
     * cột hoichuthapdo_caphuyen = true hoặc
     * cột hoinongdan_caphuyen = true hoặc
     * cột hoilienhiepthanhnien_caphuyen = true hoặc
     * cột hoilienhiepphunu_caphuyen = true hoặc
     * cột cactochuckhac_caphuyen = true
     *
     * 2. Bảng chucsacnhatuhanhconggiaotrieu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_caphuyen = true
     *
     * 3. Bảng chucsacnhatuhanhcongiaodongtu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_caphuyen = true
     *
     * 4. Bảng chucviecphathoahao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_caphuyen = true hoặc
     * cột uybanmttqvn_caphuyen = true hoặc
     * cột hoichuthapdo_caphuyen = true hoặc
     * cột hoinongdan_caphuyen = true hoặc
     * cột hoilienhiepphunu_caphuyen = true hoặc
     * cột doanthanhnien_caphuyen = true hoặc
     * cột tochuckhac_caphuyen = true
     *
     * 5. Bảng chucviectinhdocusiphathoivietnam
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_caphuyen = true hoặc
     * cột ubmttqvn_caphuyen = true hoặc
     * cột hoichuthapdo_caphuyen = true hoặc
     * cột hoinongdan_caphuyen = true hoặc
     * cột hoilienhiepphunu_caphuyen = true hoặc
     * cột doanthanhnien_caphuyen = true hoặc
     * cột tochuckhac_caphuyen = true
     *
     * 6. Bảng chucsaccaodai
     * - lấy dữ liệu thõa điều kiện sau:
     * cột thamgiacactcctxh_hoidongnhandan_caphuyen = true hoặc
     * cột thamgiacactcctxh_uybanmttqvn_caphuyen = true hoặc
     * cột thamgiacactcctxh_hoichuthapdo_caphuyen = true hoặc
     * cột thamgiacactcctxh_hoinongdan_caphuyen = true hoặc
     * cột thamgiacactcctxh_hoilienhiepphunu_caphuyen = true hoặc
     * cột thamgiacactcctxh_doanthanhnien_caphuyen = true hoặc
     * cột thamgiacactcctxh_tochuckhac_caphuyen = true
     *
     * 7. Bảng chucsacnhatuhanhphatgiao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_caphuyen = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_caphuyen = true
     *
     * 8. Bảng huynhtruonggiadinhphattu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột thamgia_hoidongnhandan_caphuyen = true hoặc
     * cột thamgia_ubmttqvn_caphuyen = true hoặc
     * cột thamgia_hoinongdan_caphuyen = true hoặc
     * cột thamgia_hoichuthapdo_caphuyen = true hoặc
     * cột thamgia_hoilienhiepthanhnien_caphuyen = true hoặc
     * cột thamgia_hoilienhiepphunu_caphuyen = true hoặc
     * cột thamgia_cactochuckhac_caphuyen = true
     *
     * 9. Bảng nguoihoatdongtinnguongchuyennghiep
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_caphuyen = true hoặc
     * cột ubmttqvn_caphuyen = true hoặc
     * cột hoinongdan_caphuyen = true hoặc
     * cột hoichuthapdo_caphuyen = true hoặc
     * cột hoilienhiepthanhnien_caphuyen = true hoặc
     * cột hoilienhiepphunu_caphuyen = true hoặc
     * cột cactochuckhac_caphuyen = true
     *
     * 10. Bảng chucviechoigiao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_caphuyen = true hoặc
     * cột ubmttqvn_caphuyen = true hoặc
     * cột hoichuthapdo_caphuyen = true hoặc
     * cột hoinongdan_caphuyen = true hoặc
     * cột hoilienhiepphunu_caphuyen = true hoặc
     * cột doanthanhnien_caphuyen = true hoặc
     * cột tochuckhac_caphuyen = true
     */
    protected function __getType12Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Huynhtruonggiadinhphattu',
            'Nguoihoatdongtinnguongchuyennghiep', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $huynh_truong_gia_dinh_phat_tu = $this->Huynhtruonggiadinhphattu->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $nguoi_hoat_dong_tin_nguong_chuyen_nghiep = $this->Nguoihoatdongtinnguongchuyennghiep->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelDSCSTHAMGIACTXHCAPHUYEN();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            $huynh_truong_gia_dinh_phat_tu,
            $nguoi_hoat_dong_tin_nguong_chuyen_nghiep,
            $chuc_viec_hoi_giao
        );
        //exit;
        $this->__createTemplate12($data);
    }

    public function __createTemplate12($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template12.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[12]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'S'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }

        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['dantoc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamtrat']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongpham']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thamgiatochucchinhtrixahoi']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
                        break;
                    default:
                        echo 'DS CS THAM GIA CT-XH CAP HUYEN';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DS CS THAM GIA CT-XH CAP TINH
     * DANH SÁCH CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP TỈNH
     *
     * 1. Bảng chucsactinlanh
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_captinh = true hoặc
     * cột uybanmttqvn_captinh = true hoặc
     * cột hoichuthapdo_captinh = true hoặc
     * cột hoinongdan_captinh = true hoặc
     * cột hoilienhiepthanhnien_captinh = true hoặc
     * cột hoilienhiepphunu_captinh = true hoặc
     * cột cactochuckhac_captinh = true
     *
     * 2. Bảng chucsacnhatuhanhconggiaotrieu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_captinh = true
     *
     * 3. Bảng chucsacnhatuhanhcongiaodongtu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_captinh = true
     *
     * 4. Bảng chucviecphathoahao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_captinh = true hoặc
     * cột uybanmttqvn_captinh = true hoặc
     * cột hoichuthapdo_captinh = true hoặc
     * cột hoinongdan_captinh = true hoặc
     * cột hoilienhiepphunu_captinh = true hoặc
     * cột doanthanhnien_captinh = true hoặc
     * cột tochuckhac_captinh = true
     *
     * 5. Bảng chucviectinhdocusiphathoivietnam
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_captinh = true hoặc
     * cột ubmttqvn_captinh = true hoặc
     * cột hoichuthapdo_captinh = true hoặc
     * cột hoinongdan_captinh = true hoặc
     * cột hoilienhiepphunu_captinh = true hoặc
     * cột doanthanhnien_captinh = true hoặc
     * cột tochuckhac_captinh = true
     *
     * 6. Bảng chucsaccaodai
     * - lấy dữ liệu thõa điều kiện sau:
     * cột thamgiacactcctxh_hoidongnhandan_captinh = true hoặc
     * cột thamgiacactcctxh_uybanmttqvn_captinh = true hoặc
     * cột thamgiacactcctxh_hoichuthapdo_captinh = true hoặc
     * cột thamgiacactcctxh_hoinongdan_captinh = true hoặc
     * cột thamgiacactcctxh_hoilienhiepphunu_captinh = true hoặc
     * cột thamgiacactcctxh_doanthanhnien_captinh = true hoặc
     * cột thamgiacactcctxh_tochuckhac_captinh = true
     *
     * 7. Bảng chucsacnhatuhanhphatgiao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoatdongtongiao_thamgia_hoidongnhandan_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_ubmttqvn_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoichuthapdo_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoinongdan_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepthanhnien_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_hoilienhiepphunu_captinh = true hoặc
     * cột hoatdongtongiao_thamgia_cactochuckhac_captinh = true
     *
     * 8. Bảng huynhtruonggiadinhphattu
     * - lấy dữ liệu thõa điều kiện sau:
     * cột thamgia_hoidongnhandan_captinh = true hoặc
     * cột thamgia_ubmttqvn_captinh = true hoặc
     * cột thamgia_hoinongdan_captinh = true hoặc
     * cột thamgia_hoichuthapdo_captinh = true hoặc
     * cột thamgia_hoilienhiepthanhnien_captinh = true hoặc
     * cột thamgia_hoilienhiepphunu_captinh = true hoặc
     * cột thamgia_cactochuckhac_captinh = true
     *
     * 9. Bảng nguoihoatdongtinnguongchuyennghiep
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_captinh = true hoặc
     * cột ubmttqvn_captinh = true hoặc
     * cột hoinongdan_captinh = true hoặc
     * cột hoichuthapdo_captinh = true hoặc
     * cột hoilienhiepthanhnien_captinh = true hoặc
     * cột hoilienhiepphunu_captinh = true hoặc
     * cột cactochuckhac_captinh = true
     *
     * 10. Bảng chucviechoigiao
     * - lấy dữ liệu thõa điều kiện sau:
     * cột hoidongnhandan_captinh = true hoặc
     * cột ubmttqvn_captinh = true hoặc
     * cột hoichuthapdo_captinh = true hoặc
     * cột hoinongdan_captinh = true hoặc
     * cột hoilienhiepphunu_captinh = true hoặc
     * cột doanthanhnien_captinh = true hoặc
     * cột tochuckhac_captinh = true
     */
    protected function __getType13Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Huynhtruonggiadinhphattu',
            'Nguoihoatdongtinnguongchuyennghiep', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $huynh_truong_gia_dinh_phat_tu = $this->Huynhtruonggiadinhphattu->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $nguoi_hoat_dong_tin_nguong_chuyen_nghiep = $this->Nguoihoatdongtinnguongchuyennghiep->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelDSCSTHAMGIACTXHCAPTINH();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            $huynh_truong_gia_dinh_phat_tu,
            $nguoi_hoat_dong_tin_nguong_chuyen_nghiep,
            $chuc_viec_hoi_giao
        );
        //exit;
        $this->__createTemplate13($data);
    }

    public function __createTemplate13($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template13.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[13]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'S'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['dantoc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamtrat']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongpham']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thamgiatochucchinhtrixahoi']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
                        break;
                    default:
                        echo 'DS CS THAM GIA CT-XH CAP HUYEN';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * TH CS THAM GIA CT-XH CAP XA
     * TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP XÃ
     */
    protected function __getType14Data()
    {
        $component = $this->Components->load('ExportThCtxhXa');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template14.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[14]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 6;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        $tong = $tong_hoidongnhandan_capxa = $tong_uybanmttqvn_capxa =
        $tong_hoinongdan_capxa = $tong_hoilienhiepphunu_capxa =
        $tong_hoilienhiepthanhnien_capxa = $tong_hoichuthapdo_capxa =
        $tong_cactochuckhac_capxa =
        $tong_1_hoidongnhandan_capxa =
        $tong_1_uybanmttqvn_capxa =
        $tong_1_hoinongdan_capxa =
        $tong_1_hoilienhiepphunu_capxa =
        $tong_1_hoilienhiepthanhnien_capxa =
        $tong_1_hoichuthapdo_capxa =
        $tong_1_cactochuckhac_capxa =

        $tong_2_hoidongnhandan_capxa =
        $tong_2_uybanmttqvn_capxa =
        $tong_2_hoinongdan_capxa =
        $tong_2_hoilienhiepphunu_capxa =
        $tong_2_hoilienhiepthanhnien_capxa =
        $tong_2_hoichuthapdo_capxa =
        $tong_2_cactochuckhac_capxa =

        $tong_3_hoidongnhandan_capxa =
        $tong_3_uybanmttqvn_capxa =
        $tong_3_hoinongdan_capxa =
        $tong_3_hoilienhiepphunu_capxa =
        $tong_3_hoilienhiepthanhnien_capxa =
        $tong_3_hoichuthapdo_capxa =
        $tong_3_cactochuckhac_capxa =

        $tong_4_hoidongnhandan_capxa =
        $tong_4_uybanmttqvn_capxa =
        $tong_4_hoinongdan_capxa =
        $tong_4_hoilienhiepphunu_capxa =
        $tong_4_hoilienhiepthanhnien_capxa =
        $tong_4_hoichuthapdo_capxa =
        $tong_4_cactochuckhac_capxa =

        $tong_5_hoidongnhandan_capxa =
        $tong_5_uybanmttqvn_capxa =
        $tong_5_hoinongdan_capxa =
        $tong_5_hoilienhiepphunu_capxa =
        $tong_5_hoilienhiepthanhnien_capxa =
        $tong_5_hoichuthapdo_capxa =
        $tong_5_cactochuckhac_capxa =

        $tong_6_hoidongnhandan_capxa =
        $tong_6_uybanmttqvn_capxa =
        $tong_6_hoinongdan_capxa =
        $tong_6_hoilienhiepphunu_capxa =
        $tong_6_hoilienhiepthanhnien_capxa =
        $tong_6_hoichuthapdo_capxa = 0;
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoidongnhandan_capxa']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['uybanmttqvn_capxa']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoinongdan_capxa']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoilienhiepphunu_capxa']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoilienhiepthanhnien_capxa']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoichuthapdo_capxa']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['cactochuckhac_capxa']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoidongnhandan_capxa']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_uybanmttqvn_capxa']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoinongdan_capxa']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoilienhiepphunu_capxa']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoichuthapdo_capxa']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_cactochuckhac_capxa']);
                        break;
                    case 'R'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoidongnhandan_capxa']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_uybanmttqvn_capxa']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoinongdan_capxa']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoilienhiepphunu_capxa']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoichuthapdo_capxa']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_cactochuckhac_capxa']);
                        break;
                    case 'Y'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoidongnhandan_capxa']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_uybanmttqvn_capxa']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoinongdan_capxa']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoilienhiepphunu_capxa']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoichuthapdo_capxa']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_cactochuckhac_capxa']);
                        break;
                    case 'AF'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoidongnhandan_capxa']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_uybanmttqvn_capxa']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoinongdan_capxa']);
                        break;
                    case 'AI':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoilienhiepphunu_capxa']);
                        break;
                    case 'AJ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'AK':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoichuthapdo_capxa']);
                        break;
                    case 'AL':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_cactochuckhac_capxa']);
                        break;
                    case 'AM'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoidongnhandan_capxa']);
                        break;
                    case 'AN':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_uybanmttqvn_capxa']);
                        break;
                    case 'AO':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoinongdan_capxa']);
                        break;
                    case 'AP':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoilienhiepphunu_capxa']);
                        break;
                    case 'AQ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'AR':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoichuthapdo_capxa']);
                        break;
                    case 'AS':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_cactochuckhac_capxa']);
                        break;
                    case 'AT'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoidongnhandan_capxa']);
                        break;
                    case 'AU':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_uybanmttqvn_capxa']);
                        break;
                    case 'AV':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoinongdan_capxa']);
                        break;
                    case 'AW':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoilienhiepphunu_capxa']);
                        break;
                    case 'AX':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'AY':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoichuthapdo_capxa']);
                        break;
                    case 'AZ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_cactochuckhac_capxa']);
                        break;
                    case 'BA'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoidongnhandan_capxa']);
                        break;
                    case 'BB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_uybanmttqvn_capxa']);
                        break;
                    case 'BC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoinongdan_capxa']);
                        break;
                    case 'BD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoilienhiepphunu_capxa']);
                        break;
                    case 'BE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoilienhiepthanhnien_capxa']);
                        break;
                    case 'BF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoichuthapdo_capxa']);
                        break;
                    default:
                        echo 'TH CS THAM GIA CT-XH CAP XA';
                }
            }
            $tong += $result['total'];
            $tong_hoidongnhandan_capxa += $result['hoidongnhandan_capxa'];
            $tong_uybanmttqvn_capxa += $result['uybanmttqvn_capxa'];
            $tong_hoinongdan_capxa += $result['hoinongdan_capxa'];
            $tong_hoilienhiepphunu_capxa += $result['hoilienhiepphunu_capxa'];
            $tong_hoilienhiepthanhnien_capxa += $result['hoilienhiepthanhnien_capxa'];
            $tong_hoichuthapdo_capxa += $result['hoichuthapdo_capxa'];
            $tong_cactochuckhac_capxa += $result['cactochuckhac_capxa'];

            $tong_0_hoidongnhandan_capxa += $result['0_hoidongnhandan_capxa'];
            $tong_0_uybanmttqvn_capxa += $result['0_uybanmttqvn_capxa'];
            $tong_0_hoinongdan_capxa += $result['0_hoinongdan_capxa'];
            $tong_0_hoilienhiepphunu_capxa += $result['0_hoilienhiepphunu_capxa'];
            $tong_0_hoilienhiepthanhnien_capxa += $result['0_hoilienhiepthanhnien_capxa'];
            $tong_0_hoichuthapdo_capxa += $result['0_hoichuthapdo_capxa'];
            $tong_0_cactochuckhac_capxa += $result['0_cactochuckhac_capxa'];

            $tong_1_hoidongnhandan_capxa += $result['1_hoidongnhandan_capxa'];
            $tong_1_uybanmttqvn_capxa += $result['1_uybanmttqvn_capxa'];
            $tong_1_hoinongdan_capxa += $result['1_hoinongdan_capxa'];
            $tong_1_hoilienhiepphunu_capxa += $result['1_hoilienhiepphunu_capxa'];
            $tong_1_hoilienhiepthanhnien_capxa += $result['1_hoilienhiepthanhnien_capxa'];
            $tong_1_hoichuthapdo_capxa += $result['1_hoichuthapdo_capxa'];
            $tong_1_cactochuckhac_capxa += $result['1_cactochuckhac_capxa'];

            $tong_2_hoidongnhandan_capxa += $result['2_hoidongnhandan_capxa'];
            $tong_2_uybanmttqvn_capxa += $result['2_uybanmttqvn_capxa'];
            $tong_2_hoinongdan_capxa += $result['2_hoinongdan_capxa'];
            $tong_2_hoilienhiepphunu_capxa += $result['2_hoilienhiepphunu_capxa'];
            $tong_2_hoilienhiepthanhnien_capxa += $result['2_hoilienhiepthanhnien_capxa'];
            $tong_2_hoichuthapdo_capxa += $result['2_hoichuthapdo_capxa'];
            $tong_2_cactochuckhac_capxa += $result['2_cactochuckhac_capxa'];

            $tong_3_hoidongnhandan_capxa += $result['3_hoidongnhandan_capxa'];
            $tong_3_uybanmttqvn_capxa += $result['3_uybanmttqvn_capxa'];
            $tong_3_hoinongdan_capxa += $result['3_hoinongdan_capxa'];
            $tong_3_hoilienhiepphunu_capxa += $result['3_hoilienhiepphunu_capxa'];
            $tong_3_hoilienhiepthanhnien_capxa += $result['3_hoilienhiepthanhnien_capxa'];
            $tong_3_hoichuthapdo_capxa += $result['3_hoichuthapdo_capxa'];
            $tong_3_cactochuckhac_capxa += $result['3_cactochuckhac_capxa'];

            $tong_4_hoidongnhandan_capxa += $result['4_hoidongnhandan_capxa'];
            $tong_4_uybanmttqvn_capxa += $result['4_uybanmttqvn_capxa'];
            $tong_4_hoinongdan_capxa += $result['4_hoinongdan_capxa'];
            $tong_4_hoilienhiepphunu_capxa += $result['4_hoilienhiepphunu_capxa'];
            $tong_4_hoilienhiepthanhnien_capxa += $result['4_hoilienhiepthanhnien_capxa'];
            $tong_4_hoichuthapdo_capxa += $result['4_hoichuthapdo_capxa'];
            $tong_4_cactochuckhac_capxa += $result['4_cactochuckhac_capxa'];

            $tong_5_hoidongnhandan_capxa += $result['5_hoidongnhandan_capxa'];
            $tong_5_uybanmttqvn_capxa += $result['5_uybanmttqvn_capxa'];
            $tong_5_hoinongdan_capxa += $result['5_hoinongdan_capxa'];
            $tong_5_hoilienhiepphunu_capxa += $result['5_hoilienhiepphunu_capxa'];
            $tong_5_hoilienhiepthanhnien_capxa += $result['5_hoilienhiepthanhnien_capxa'];
            $tong_5_hoichuthapdo_capxa += $result['5_hoichuthapdo_capxa'];
            $tong_5_cactochuckhac_capxa += $result['5_cactochuckhac_capxa'];

            $tong_6_hoidongnhandan_capxa += $result['6_hoidongnhandan_capxa'];
            $tong_6_uybanmttqvn_capxa += $result['6_uybanmttqvn_capxa'];
            $tong_6_hoinongdan_capxa += $result['6_hoinongdan_capxa'];
            $tong_6_hoilienhiepphunu_capxa += $result['6_hoilienhiepphunu_capxa'];
            $tong_6_hoilienhiepthanhnien_capxa += $result['6_hoilienhiepthanhnien_capxa'];
            $tong_6_hoichuthapdo_capxa += $result['6_hoichuthapdo_capxa'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C17')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D17')->setValue($tong_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('E17')->setValue($tong_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('F17')->setValue($tong_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('G17')->setValue($tong_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('H17')->setValue($tong_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('I17')->setValue($tong_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('J17')->setValue($tong_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('K17')->setValue($tong_0_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('L17')->setValue($tong_0_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('M17')->setValue($tong_0_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('N17')->setValue($tong_0_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('O17')->setValue($tong_0_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('P17')->setValue($tong_0_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('Q17')->setValue($tong_0_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('R17')->setValue($tong_1_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('S17')->setValue($tong_1_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('T17')->setValue($tong_1_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('U17')->setValue($tong_1_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('V17')->setValue($tong_1_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('W17')->setValue($tong_1_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('X17')->setValue($tong_1_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('Y17')->setValue($tong_2_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('Z17')->setValue($tong_2_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('AA17')->setValue($tong_2_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('AB17')->setValue($tong_2_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('AC17')->setValue($tong_2_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('AD17')->setValue($tong_2_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('AE17')->setValue($tong_2_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('AF17')->setValue($tong_3_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('AG17')->setValue($tong_3_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('AH17')->setValue($tong_3_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('AI17')->setValue($tong_3_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('AJ17')->setValue($tong_3_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('AK17')->setValue($tong_3_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('AL17')->setValue($tong_3_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('AM17')->setValue($tong_4_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('AN17')->setValue($tong_4_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('AO17')->setValue($tong_4_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('AP17')->setValue($tong_4_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('AQ17')->setValue($tong_4_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('AR17')->setValue($tong_4_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('AS17')->setValue($tong_4_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('AT17')->setValue($tong_5_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('AU17')->setValue($tong_5_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('AV17')->setValue($tong_5_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('AW17')->setValue($tong_5_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('AX17')->setValue($tong_5_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('AY17')->setValue($tong_5_hoichuthapdo_capxa);
        $this->Excel->ActiveSheet->getCell('AZ17')->setValue($tong_5_cactochuckhac_capxa);

        $this->Excel->ActiveSheet->getCell('BA17')->setValue($tong_6_hoidongnhandan_capxa);
        $this->Excel->ActiveSheet->getCell('BB17')->setValue($tong_6_uybanmttqvn_capxa);
        $this->Excel->ActiveSheet->getCell('BC17')->setValue($tong_6_hoinongdan_capxa);
        $this->Excel->ActiveSheet->getCell('BD17')->setValue($tong_6_hoilienhiepphunu_capxa);
        $this->Excel->ActiveSheet->getCell('BE17')->setValue($tong_6_hoilienhiepthanhnien_capxa);
        $this->Excel->ActiveSheet->getCell('BF17')->setValue($tong_6_hoichuthapdo_capxa);

        return $this->Excel->save($filename);
    }

    /**
     * TH CS THAM GIA CT-XH CAP HUYEN
     * TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP HUYỆN
     */
    protected function __getType15Data()
    {
        $component = $this->Components->load('ExportThCtxhHuyen');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template15.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[15]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 6;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        $tong = $tong_hoidongnhandan_caphuyen = $tong_uybanmttqvn_caphuyen =
        $tong_hoinongdan_caphuyen = $tong_hoilienhiepphunu_caphuyen =
        $tong_hoilienhiepthanhnien_caphuyen = $tong_hoichuthapdo_caphuyen =
        $tong_cactochuckhac_caphuyen =
        $tong_1_hoidongnhandan_caphuyen =
        $tong_1_uybanmttqvn_caphuyen =
        $tong_1_hoinongdan_caphuyen =
        $tong_1_hoilienhiepphunu_caphuyen =
        $tong_1_hoilienhiepthanhnien_caphuyen =
        $tong_1_hoichuthapdo_caphuyen =
        $tong_1_cactochuckhac_caphuyen =

        $tong_2_hoidongnhandan_caphuyen =
        $tong_2_uybanmttqvn_caphuyen =
        $tong_2_hoinongdan_caphuyen =
        $tong_2_hoilienhiepphunu_caphuyen =
        $tong_2_hoilienhiepthanhnien_caphuyen =
        $tong_2_hoichuthapdo_caphuyen =
        $tong_2_cactochuckhac_caphuyen =

        $tong_3_hoidongnhandan_caphuyen =
        $tong_3_uybanmttqvn_caphuyen =
        $tong_3_hoinongdan_caphuyen =
        $tong_3_hoilienhiepphunu_caphuyen =
        $tong_3_hoilienhiepthanhnien_caphuyen =
        $tong_3_hoichuthapdo_caphuyen =
        $tong_3_cactochuckhac_caphuyen =

        $tong_4_hoidongnhandan_caphuyen =
        $tong_4_uybanmttqvn_caphuyen =
        $tong_4_hoinongdan_caphuyen =
        $tong_4_hoilienhiepphunu_caphuyen =
        $tong_4_hoilienhiepthanhnien_caphuyen =
        $tong_4_hoichuthapdo_caphuyen =
        $tong_4_cactochuckhac_caphuyen =

        $tong_5_hoidongnhandan_caphuyen =
        $tong_5_uybanmttqvn_caphuyen =
        $tong_5_hoinongdan_caphuyen =
        $tong_5_hoilienhiepphunu_caphuyen =
        $tong_5_hoilienhiepthanhnien_caphuyen =
        $tong_5_hoichuthapdo_caphuyen =
        $tong_5_cactochuckhac_caphuyen =

        $tong_6_hoidongnhandan_caphuyen =
        $tong_6_uybanmttqvn_caphuyen =
        $tong_6_hoinongdan_caphuyen =
        $tong_6_hoilienhiepphunu_caphuyen =
        $tong_6_hoilienhiepthanhnien_caphuyen =
        $tong_6_hoichuthapdo_caphuyen = 0;
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoidongnhandan_caphuyen']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['uybanmttqvn_caphuyen']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoinongdan_caphuyen']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoilienhiepphunu_caphuyen']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoichuthapdo_caphuyen']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['cactochuckhac_caphuyen']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoidongnhandan_caphuyen']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_uybanmttqvn_caphuyen']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoinongdan_caphuyen']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoichuthapdo_caphuyen']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_cactochuckhac_caphuyen']);
                        break;
                    case 'R'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoidongnhandan_caphuyen']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_uybanmttqvn_caphuyen']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoinongdan_caphuyen']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoichuthapdo_caphuyen']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_cactochuckhac_caphuyen']);
                        break;
                    case 'Y'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoidongnhandan_caphuyen']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_uybanmttqvn_caphuyen']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoinongdan_caphuyen']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoichuthapdo_caphuyen']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_cactochuckhac_caphuyen']);
                        break;
                    case 'AF'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoidongnhandan_caphuyen']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_uybanmttqvn_caphuyen']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoinongdan_caphuyen']);
                        break;
                    case 'AI':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'AJ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'AK':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoichuthapdo_caphuyen']);
                        break;
                    case 'AL':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_cactochuckhac_caphuyen']);
                        break;
                    case 'AM'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoidongnhandan_caphuyen']);
                        break;
                    case 'AN':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_uybanmttqvn_caphuyen']);
                        break;
                    case 'AO':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoinongdan_caphuyen']);
                        break;
                    case 'AP':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'AQ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'AR':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoichuthapdo_caphuyen']);
                        break;
                    case 'AS':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_cactochuckhac_caphuyen']);
                        break;
                    case 'AT'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoidongnhandan_caphuyen']);
                        break;
                    case 'AU':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_uybanmttqvn_caphuyen']);
                        break;
                    case 'AV':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoinongdan_caphuyen']);
                        break;
                    case 'AW':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'AX':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'AY':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoichuthapdo_caphuyen']);
                        break;
                    case 'AZ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_cactochuckhac_caphuyen']);
                        break;
                    case 'BA'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoidongnhandan_caphuyen']);
                        break;
                    case 'BB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_uybanmttqvn_caphuyen']);
                        break;
                    case 'BC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoinongdan_caphuyen']);
                        break;
                    case 'BD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoilienhiepphunu_caphuyen']);
                        break;
                    case 'BE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoilienhiepthanhnien_caphuyen']);
                        break;
                    case 'BF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoichuthapdo_caphuyen']);
                        break;
                    default:
                        echo 'TH CS THAM GIA CT-XH CAP HUYỆN';
                }
            }
            $tong += $result['total'];
            $tong_hoidongnhandan_caphuyen += $result['hoidongnhandan_caphuyen'];
            $tong_uybanmttqvn_caphuyen += $result['uybanmttqvn_caphuyen'];
            $tong_hoinongdan_caphuyen += $result['hoinongdan_caphuyen'];
            $tong_hoilienhiepphunu_caphuyen += $result['hoilienhiepphunu_caphuyen'];
            $tong_hoilienhiepthanhnien_caphuyen += $result['hoilienhiepthanhnien_caphuyen'];
            $tong_hoichuthapdo_caphuyen += $result['hoichuthapdo_caphuyen'];
            $tong_cactochuckhac_caphuyen += $result['cactochuckhac_caphuyen'];

            $tong_0_hoidongnhandan_caphuyen += $result['0_hoidongnhandan_caphuyen'];
            $tong_0_uybanmttqvn_caphuyen += $result['0_uybanmttqvn_caphuyen'];
            $tong_0_hoinongdan_caphuyen += $result['0_hoinongdan_caphuyen'];
            $tong_0_hoilienhiepphunu_caphuyen += $result['0_hoilienhiepphunu_caphuyen'];
            $tong_0_hoilienhiepthanhnien_caphuyen += $result['0_hoilienhiepthanhnien_caphuyen'];
            $tong_0_hoichuthapdo_caphuyen += $result['0_hoichuthapdo_caphuyen'];
            $tong_0_cactochuckhac_caphuyen += $result['0_cactochuckhac_caphuyen'];

            $tong_1_hoidongnhandan_caphuyen += $result['1_hoidongnhandan_caphuyen'];
            $tong_1_uybanmttqvn_caphuyen += $result['1_uybanmttqvn_caphuyen'];
            $tong_1_hoinongdan_caphuyen += $result['1_hoinongdan_caphuyen'];
            $tong_1_hoilienhiepphunu_caphuyen += $result['1_hoilienhiepphunu_caphuyen'];
            $tong_1_hoilienhiepthanhnien_caphuyen += $result['1_hoilienhiepthanhnien_caphuyen'];
            $tong_1_hoichuthapdo_caphuyen += $result['1_hoichuthapdo_caphuyen'];
            $tong_1_cactochuckhac_caphuyen += $result['1_cactochuckhac_caphuyen'];

            $tong_2_hoidongnhandan_caphuyen += $result['2_hoidongnhandan_caphuyen'];
            $tong_2_uybanmttqvn_caphuyen += $result['2_uybanmttqvn_caphuyen'];
            $tong_2_hoinongdan_caphuyen += $result['2_hoinongdan_caphuyen'];
            $tong_2_hoilienhiepphunu_caphuyen += $result['2_hoilienhiepphunu_caphuyen'];
            $tong_2_hoilienhiepthanhnien_caphuyen += $result['2_hoilienhiepthanhnien_caphuyen'];
            $tong_2_hoichuthapdo_caphuyen += $result['2_hoichuthapdo_caphuyen'];
            $tong_2_cactochuckhac_caphuyen += $result['2_cactochuckhac_caphuyen'];

            $tong_3_hoidongnhandan_caphuyen += $result['3_hoidongnhandan_caphuyen'];
            $tong_3_uybanmttqvn_caphuyen += $result['3_uybanmttqvn_caphuyen'];
            $tong_3_hoinongdan_caphuyen += $result['3_hoinongdan_caphuyen'];
            $tong_3_hoilienhiepphunu_caphuyen += $result['3_hoilienhiepphunu_caphuyen'];
            $tong_3_hoilienhiepthanhnien_caphuyen += $result['3_hoilienhiepthanhnien_caphuyen'];
            $tong_3_hoichuthapdo_caphuyen += $result['3_hoichuthapdo_caphuyen'];
            $tong_3_cactochuckhac_caphuyen += $result['3_cactochuckhac_caphuyen'];

            $tong_4_hoidongnhandan_caphuyen += $result['4_hoidongnhandan_caphuyen'];
            $tong_4_uybanmttqvn_caphuyen += $result['4_uybanmttqvn_caphuyen'];
            $tong_4_hoinongdan_caphuyen += $result['4_hoinongdan_caphuyen'];
            $tong_4_hoilienhiepphunu_caphuyen += $result['4_hoilienhiepphunu_caphuyen'];
            $tong_4_hoilienhiepthanhnien_caphuyen += $result['4_hoilienhiepthanhnien_caphuyen'];
            $tong_4_hoichuthapdo_caphuyen += $result['4_hoichuthapdo_caphuyen'];
            $tong_4_cactochuckhac_caphuyen += $result['4_cactochuckhac_caphuyen'];

            $tong_5_hoidongnhandan_caphuyen += $result['5_hoidongnhandan_caphuyen'];
            $tong_5_uybanmttqvn_caphuyen += $result['5_uybanmttqvn_caphuyen'];
            $tong_5_hoinongdan_caphuyen += $result['5_hoinongdan_caphuyen'];
            $tong_5_hoilienhiepphunu_caphuyen += $result['5_hoilienhiepphunu_caphuyen'];
            $tong_5_hoilienhiepthanhnien_caphuyen += $result['5_hoilienhiepthanhnien_caphuyen'];
            $tong_5_hoichuthapdo_caphuyen += $result['5_hoichuthapdo_caphuyen'];
            $tong_5_cactochuckhac_caphuyen += $result['5_cactochuckhac_caphuyen'];

            $tong_6_hoidongnhandan_caphuyen += $result['6_hoidongnhandan_caphuyen'];
            $tong_6_uybanmttqvn_caphuyen += $result['6_uybanmttqvn_caphuyen'];
            $tong_6_hoinongdan_caphuyen += $result['6_hoinongdan_caphuyen'];
            $tong_6_hoilienhiepphunu_caphuyen += $result['6_hoilienhiepphunu_caphuyen'];
            $tong_6_hoilienhiepthanhnien_caphuyen += $result['6_hoilienhiepthanhnien_caphuyen'];
            $tong_6_hoichuthapdo_caphuyen += $result['6_hoichuthapdo_caphuyen'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C17')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D17')->setValue($tong_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('E17')->setValue($tong_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('F17')->setValue($tong_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('G17')->setValue($tong_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('H17')->setValue($tong_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('I17')->setValue($tong_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('J17')->setValue($tong_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('K17')->setValue($tong_0_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('L17')->setValue($tong_0_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('M17')->setValue($tong_0_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('N17')->setValue($tong_0_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('O17')->setValue($tong_0_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('P17')->setValue($tong_0_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('Q17')->setValue($tong_0_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('R17')->setValue($tong_1_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('S17')->setValue($tong_1_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('T17')->setValue($tong_1_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('U17')->setValue($tong_1_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('V17')->setValue($tong_1_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('W17')->setValue($tong_1_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('X17')->setValue($tong_1_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('Y17')->setValue($tong_2_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('Z17')->setValue($tong_2_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('AA17')->setValue($tong_2_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AB17')->setValue($tong_2_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('AC17')->setValue($tong_2_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('AD17')->setValue($tong_2_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('AE17')->setValue($tong_2_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('AF17')->setValue($tong_3_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AG17')->setValue($tong_3_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('AH17')->setValue($tong_3_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AI17')->setValue($tong_3_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('AJ17')->setValue($tong_3_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('AK17')->setValue($tong_3_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('AL17')->setValue($tong_3_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('AM17')->setValue($tong_4_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AN17')->setValue($tong_4_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('AO17')->setValue($tong_4_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AP17')->setValue($tong_4_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('AQ17')->setValue($tong_4_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('AR17')->setValue($tong_4_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('AS17')->setValue($tong_4_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('AT17')->setValue($tong_5_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AU17')->setValue($tong_5_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('AV17')->setValue($tong_5_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('AW17')->setValue($tong_5_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('AX17')->setValue($tong_5_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('AY17')->setValue($tong_5_hoichuthapdo_caphuyen);
        $this->Excel->ActiveSheet->getCell('AZ17')->setValue($tong_5_cactochuckhac_caphuyen);

        $this->Excel->ActiveSheet->getCell('BA17')->setValue($tong_6_hoidongnhandan_caphuyen);
        $this->Excel->ActiveSheet->getCell('BB17')->setValue($tong_6_uybanmttqvn_caphuyen);
        $this->Excel->ActiveSheet->getCell('BC17')->setValue($tong_6_hoinongdan_caphuyen);
        $this->Excel->ActiveSheet->getCell('BD17')->setValue($tong_6_hoilienhiepphunu_caphuyen);
        $this->Excel->ActiveSheet->getCell('BE17')->setValue($tong_6_hoilienhiepthanhnien_caphuyen);
        $this->Excel->ActiveSheet->getCell('BF17')->setValue($tong_6_hoichuthapdo_caphuyen);

        return $this->Excel->save($filename);
    }

    /**
     * TH CS THAM GIA CT-XHCAP TINH
     * TỔNG HỢP CHỨC SẮC TÔN GIÁO THAM GIA CÁC TỔ CHỨC CHÍNH TRỊ - XÃ HỘI CẤP TỈNH
     */
    protected function __getType16Data()
    {
        $component = $this->Components->load('ExportThCtxhTinh');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template15.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[15]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 6;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        $tong = $tong_hoidongnhandan_captinh = $tong_uybanmttqvn_captinh =
        $tong_hoinongdan_captinh = $tong_hoilienhiepphunu_captinh =
        $tong_hoilienhiepthanhnien_captinh = $tong_hoichuthapdo_captinh =
        $tong_cactochuckhac_captinh =
        $tong_1_hoidongnhandan_captinh =
        $tong_1_uybanmttqvn_captinh =
        $tong_1_hoinongdan_captinh =
        $tong_1_hoilienhiepphunu_captinh =
        $tong_1_hoilienhiepthanhnien_captinh =
        $tong_1_hoichuthapdo_captinh =
        $tong_1_cactochuckhac_captinh =

        $tong_2_hoidongnhandan_captinh =
        $tong_2_uybanmttqvn_captinh =
        $tong_2_hoinongdan_captinh =
        $tong_2_hoilienhiepphunu_captinh =
        $tong_2_hoilienhiepthanhnien_captinh =
        $tong_2_hoichuthapdo_captinh =
        $tong_2_cactochuckhac_captinh =

        $tong_3_hoidongnhandan_captinh =
        $tong_3_uybanmttqvn_captinh =
        $tong_3_hoinongdan_captinh =
        $tong_3_hoilienhiepphunu_captinh =
        $tong_3_hoilienhiepthanhnien_captinh =
        $tong_3_hoichuthapdo_captinh =
        $tong_3_cactochuckhac_captinh =

        $tong_4_hoidongnhandan_captinh =
        $tong_4_uybanmttqvn_captinh =
        $tong_4_hoinongdan_captinh =
        $tong_4_hoilienhiepphunu_captinh =
        $tong_4_hoilienhiepthanhnien_captinh =
        $tong_4_hoichuthapdo_captinh =
        $tong_4_cactochuckhac_captinh =

        $tong_5_hoidongnhandan_captinh =
        $tong_5_uybanmttqvn_captinh =
        $tong_5_hoinongdan_captinh =
        $tong_5_hoilienhiepphunu_captinh =
        $tong_5_hoilienhiepthanhnien_captinh =
        $tong_5_hoichuthapdo_captinh =
        $tong_5_cactochuckhac_captinh =

        $tong_6_hoidongnhandan_captinh =
        $tong_6_uybanmttqvn_captinh =
        $tong_6_hoinongdan_captinh =
        $tong_6_hoilienhiepphunu_captinh =
        $tong_6_hoilienhiepthanhnien_captinh =
        $tong_6_hoichuthapdo_captinh = 0;
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoidongnhandan_captinh']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['uybanmttqvn_captinh']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoinongdan_captinh']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoilienhiepphunu_captinh']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoilienhiepthanhnien_captinh']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['hoichuthapdo_captinh']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['cactochuckhac_captinh']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoidongnhandan_captinh']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_uybanmttqvn_captinh']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoinongdan_captinh']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoilienhiepphunu_captinh']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_hoichuthapdo_captinh']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_cactochuckhac_captinh']);
                        break;
                    case 'R'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoidongnhandan_captinh']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_uybanmttqvn_captinh']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoinongdan_captinh']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoilienhiepphunu_captinh']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_hoichuthapdo_captinh']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_cactochuckhac_captinh']);
                        break;
                    case 'Y'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoidongnhandan_captinh']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_uybanmttqvn_captinh']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoinongdan_captinh']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoilienhiepphunu_captinh']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_hoichuthapdo_captinh']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_cactochuckhac_captinh']);
                        break;
                    case 'AF'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoidongnhandan_captinh']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_uybanmttqvn_captinh']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoinongdan_captinh']);
                        break;
                    case 'AI':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoilienhiepphunu_captinh']);
                        break;
                    case 'AJ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'AK':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_hoichuthapdo_captinh']);
                        break;
                    case 'AL':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_cactochuckhac_captinh']);
                        break;
                    case 'AM'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoidongnhandan_captinh']);
                        break;
                    case 'AN':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_uybanmttqvn_captinh']);
                        break;
                    case 'AO':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoinongdan_captinh']);
                        break;
                    case 'AP':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoilienhiepphunu_captinh']);
                        break;
                    case 'AQ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'AR':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_hoichuthapdo_captinh']);
                        break;
                    case 'AS':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_cactochuckhac_captinh']);
                        break;
                    case 'AT'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoidongnhandan_captinh']);
                        break;
                    case 'AU':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_uybanmttqvn_captinh']);
                        break;
                    case 'AV':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoinongdan_captinh']);
                        break;
                    case 'AW':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoilienhiepphunu_captinh']);
                        break;
                    case 'AX':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'AY':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_hoichuthapdo_captinh']);
                        break;
                    case 'AZ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_cactochuckhac_captinh']);
                        break;
                    case 'BA'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoidongnhandan_captinh']);
                        break;
                    case 'BB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_uybanmttqvn_captinh']);
                        break;
                    case 'BC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoinongdan_captinh']);
                        break;
                    case 'BD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoilienhiepphunu_captinh']);
                        break;
                    case 'BE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoilienhiepthanhnien_captinh']);
                        break;
                    case 'BF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6_hoichuthapdo_captinh']);
                        break;
                    default:
                        echo 'TH CS THAM GIA CT-XH CAP TINH';
                }
            }
            $tong += $result['total'];
            $tong_hoidongnhandan_captinh += $result['hoidongnhandan_captinh'];
            $tong_uybanmttqvn_captinh += $result['uybanmttqvn_captinh'];
            $tong_hoinongdan_captinh += $result['hoinongdan_captinh'];
            $tong_hoilienhiepphunu_captinh += $result['hoilienhiepphunu_captinh'];
            $tong_hoilienhiepthanhnien_captinh += $result['hoilienhiepthanhnien_captinh'];
            $tong_hoichuthapdo_captinh += $result['hoichuthapdo_captinh'];
            $tong_cactochuckhac_captinh += $result['cactochuckhac_captinh'];

            $tong_0_hoidongnhandan_captinh += $result['0_hoidongnhandan_captinh'];
            $tong_0_uybanmttqvn_captinh += $result['0_uybanmttqvn_captinh'];
            $tong_0_hoinongdan_captinh += $result['0_hoinongdan_captinh'];
            $tong_0_hoilienhiepphunu_captinh += $result['0_hoilienhiepphunu_captinh'];
            $tong_0_hoilienhiepthanhnien_captinh += $result['0_hoilienhiepthanhnien_captinh'];
            $tong_0_hoichuthapdo_captinh += $result['0_hoichuthapdo_captinh'];
            $tong_0_cactochuckhac_captinh += $result['0_cactochuckhac_captinh'];

            $tong_1_hoidongnhandan_captinh += $result['1_hoidongnhandan_captinh'];
            $tong_1_uybanmttqvn_captinh += $result['1_uybanmttqvn_captinh'];
            $tong_1_hoinongdan_captinh += $result['1_hoinongdan_captinh'];
            $tong_1_hoilienhiepphunu_captinh += $result['1_hoilienhiepphunu_captinh'];
            $tong_1_hoilienhiepthanhnien_captinh += $result['1_hoilienhiepthanhnien_captinh'];
            $tong_1_hoichuthapdo_captinh += $result['1_hoichuthapdo_captinh'];
            $tong_1_cactochuckhac_captinh += $result['1_cactochuckhac_captinh'];

            $tong_2_hoidongnhandan_captinh += $result['2_hoidongnhandan_captinh'];
            $tong_2_uybanmttqvn_captinh += $result['2_uybanmttqvn_captinh'];
            $tong_2_hoinongdan_captinh += $result['2_hoinongdan_captinh'];
            $tong_2_hoilienhiepphunu_captinh += $result['2_hoilienhiepphunu_captinh'];
            $tong_2_hoilienhiepthanhnien_captinh += $result['2_hoilienhiepthanhnien_captinh'];
            $tong_2_hoichuthapdo_captinh += $result['2_hoichuthapdo_captinh'];
            $tong_2_cactochuckhac_captinh += $result['2_cactochuckhac_captinh'];

            $tong_3_hoidongnhandan_captinh += $result['3_hoidongnhandan_captinh'];
            $tong_3_uybanmttqvn_captinh += $result['3_uybanmttqvn_captinh'];
            $tong_3_hoinongdan_captinh += $result['3_hoinongdan_captinh'];
            $tong_3_hoilienhiepphunu_captinh += $result['3_hoilienhiepphunu_captinh'];
            $tong_3_hoilienhiepthanhnien_captinh += $result['3_hoilienhiepthanhnien_captinh'];
            $tong_3_hoichuthapdo_captinh += $result['3_hoichuthapdo_captinh'];
            $tong_3_cactochuckhac_captinh += $result['3_cactochuckhac_captinh'];

            $tong_4_hoidongnhandan_captinh += $result['4_hoidongnhandan_captinh'];
            $tong_4_uybanmttqvn_captinh += $result['4_uybanmttqvn_captinh'];
            $tong_4_hoinongdan_captinh += $result['4_hoinongdan_captinh'];
            $tong_4_hoilienhiepphunu_captinh += $result['4_hoilienhiepphunu_captinh'];
            $tong_4_hoilienhiepthanhnien_captinh += $result['4_hoilienhiepthanhnien_captinh'];
            $tong_4_hoichuthapdo_captinh += $result['4_hoichuthapdo_captinh'];
            $tong_4_cactochuckhac_captinh += $result['4_cactochuckhac_captinh'];

            $tong_5_hoidongnhandan_captinh += $result['5_hoidongnhandan_captinh'];
            $tong_5_uybanmttqvn_captinh += $result['5_uybanmttqvn_captinh'];
            $tong_5_hoinongdan_captinh += $result['5_hoinongdan_captinh'];
            $tong_5_hoilienhiepphunu_captinh += $result['5_hoilienhiepphunu_captinh'];
            $tong_5_hoilienhiepthanhnien_captinh += $result['5_hoilienhiepthanhnien_captinh'];
            $tong_5_hoichuthapdo_captinh += $result['5_hoichuthapdo_captinh'];
            $tong_5_cactochuckhac_captinh += $result['5_cactochuckhac_captinh'];

            $tong_6_hoidongnhandan_captinh += $result['6_hoidongnhandan_captinh'];
            $tong_6_uybanmttqvn_captinh += $result['6_uybanmttqvn_captinh'];
            $tong_6_hoinongdan_captinh += $result['6_hoinongdan_captinh'];
            $tong_6_hoilienhiepphunu_captinh += $result['6_hoilienhiepphunu_captinh'];
            $tong_6_hoilienhiepthanhnien_captinh += $result['6_hoilienhiepthanhnien_captinh'];
            $tong_6_hoichuthapdo_captinh += $result['6_hoichuthapdo_captinh'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C17')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D17')->setValue($tong_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('E17')->setValue($tong_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('F17')->setValue($tong_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('G17')->setValue($tong_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('H17')->setValue($tong_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('I17')->setValue($tong_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('J17')->setValue($tong_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('K17')->setValue($tong_0_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('L17')->setValue($tong_0_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('M17')->setValue($tong_0_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('N17')->setValue($tong_0_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('O17')->setValue($tong_0_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('P17')->setValue($tong_0_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('Q17')->setValue($tong_0_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('R17')->setValue($tong_1_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('S17')->setValue($tong_1_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('T17')->setValue($tong_1_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('U17')->setValue($tong_1_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('V17')->setValue($tong_1_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('W17')->setValue($tong_1_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('X17')->setValue($tong_1_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('Y17')->setValue($tong_2_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('Z17')->setValue($tong_2_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('AA17')->setValue($tong_2_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('AB17')->setValue($tong_2_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('AC17')->setValue($tong_2_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('AD17')->setValue($tong_2_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('AE17')->setValue($tong_2_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('AF17')->setValue($tong_3_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('AG17')->setValue($tong_3_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('AH17')->setValue($tong_3_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('AI17')->setValue($tong_3_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('AJ17')->setValue($tong_3_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('AK17')->setValue($tong_3_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('AL17')->setValue($tong_3_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('AM17')->setValue($tong_4_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('AN17')->setValue($tong_4_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('AO17')->setValue($tong_4_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('AP17')->setValue($tong_4_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('AQ17')->setValue($tong_4_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('AR17')->setValue($tong_4_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('AS17')->setValue($tong_4_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('AT17')->setValue($tong_5_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('AU17')->setValue($tong_5_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('AV17')->setValue($tong_5_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('AW17')->setValue($tong_5_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('AX17')->setValue($tong_5_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('AY17')->setValue($tong_5_hoichuthapdo_captinh);
        $this->Excel->ActiveSheet->getCell('AZ17')->setValue($tong_5_cactochuckhac_captinh);

        $this->Excel->ActiveSheet->getCell('BA17')->setValue($tong_6_hoidongnhandan_captinh);
        $this->Excel->ActiveSheet->getCell('BB17')->setValue($tong_6_uybanmttqvn_captinh);
        $this->Excel->ActiveSheet->getCell('BC17')->setValue($tong_6_hoinongdan_captinh);
        $this->Excel->ActiveSheet->getCell('BD17')->setValue($tong_6_hoilienhiepphunu_captinh);
        $this->Excel->ActiveSheet->getCell('BE17')->setValue($tong_6_hoilienhiepthanhnien_captinh);
        $this->Excel->ActiveSheet->getCell('BF17')->setValue($tong_6_hoichuthapdo_captinh);

        return $this->Excel->save($filename);
    }

    /**
     * DS CS ĐT-BD
     * DANH SÁCH CHỨC SẮC ĐÃ THAM GIA CÁC LỚP ĐÀO TẠO, BỒI DƯỠNG TÔN GIÁO
     */
    protected function __getType17Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelDSCSDTBD();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelDSCSDTBD();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelDSCSDTBD();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelDSCSDTBD();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelDSCSDTBD();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelDSCSDTBD();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelDSCSDTBD();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelDSCSDTBD();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            $chuc_viec_hoi_giao
        );
        //exit;
        $this->__createTemplate17($data);
    }

    public function __createTemplate17($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template17.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[17]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'N'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamsac']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['nam_dt_bd']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tenkhoa_dt_bd']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
                        break;
                    default:
                        echo 'DS CS ĐT-BD';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /*
     * TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO ĐƯỢC BỔ NHIỆM, CHUẨN Y
    */
    protected function __getType18Data()
    {
        $component = $this->Components->load('ExportThCsCy');
        $data = $component->export();
        
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template18.xls';
        //$filename = "template18";
        $filename = "{$this->_type_text[18]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        $r = 6;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_total']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_toagiammuc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_daichungvien']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_giaohat']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_chanhxu']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_phoxu']);
                        break;
                    case 'J'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_total']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_tv_bts_tinh']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_ban_bts_tinh']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_truong_daotao_tongiao']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_tv_bts_huyen']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_trutri']);
                        break;
                    case 'P'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_total']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_tvbandaidiencaptinh']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_quannhiem']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phutaquannhiem']);
                        break;
                    case 'T'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_total']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_chucvuhiennay_thanhvienbddct']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_chucvuhiennay_phobancaiquan']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_chucvuhiennay_caiquan']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_chucvuhiennay_thanhvienbddct2']);
                        break;
                    case 'Y'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_chucvuhiennay_thanhvienbangiaoca']);
                        break;
                    case 'Z'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_total']);
                        break;
                    case 'AA'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_thanhvienbantrisucaptinh']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_thanhvienbantrisucaptrunguong']);
                        break;
                    default:
                        echo 'THBNCS';
                }
            }

            $this->Excel->ActiveSheet->getCell('C17')->setValue($tong3 += $result['total']);
            $this->Excel->ActiveSheet->getCell('D17')->setValue($tong4 += $result['Chucsacnhatuhanhconggiaotrieu_total']);
            $this->Excel->ActiveSheet->getCell('E17')->setValue($tong5 += $result['Chucsacnhatuhanhconggiaotrieu_toagiammuc']);
            $this->Excel->ActiveSheet->getCell('F17')->setValue($tong6 += $result['Chucsacnhatuhanhconggiaotrieu_daichungvien']);
            $this->Excel->ActiveSheet->getCell('G17')->setValue($tong7 += $result['Chucsacnhatuhanhconggiaotrieu_giaohat']);
            $this->Excel->ActiveSheet->getCell('H17')->setValue($tong8 += $result['Chucsacnhatuhanhconggiaotrieu_chanhxu']);
            $this->Excel->ActiveSheet->getCell('I17')->setValue($tong9 += $result['Chucsacnhatuhanhconggiaotrieu_phoxu']);
            $this->Excel->ActiveSheet->getCell('J17')->setValue($tong10 += $result['Chucsacnhatuhanhphatgiao_total']);
            $this->Excel->ActiveSheet->getCell('K17')->setValue($tong11 += $result['Chucsacnhatuhanhphatgiao_tv_bts_tinh']);
            $this->Excel->ActiveSheet->getCell('L17')->setValue($tong12 += $result['Chucsacnhatuhanhphatgiao_ban_bts_tinh']);
            $this->Excel->ActiveSheet->getCell('M17')->setValue($tong13 += $result['Chucsacnhatuhanhphatgiao_truong_daotao_tongiao']);
            $this->Excel->ActiveSheet->getCell('N17')->setValue($tong14 += $result['Chucsacnhatuhanhphatgiao_tv_bts_huyen']);
            $this->Excel->ActiveSheet->getCell('O17')->setValue($tong15 += $result['Chucsacnhatuhanhphatgiao_trutri']);
            $this->Excel->ActiveSheet->getCell('P17')->setValue($tong16 += $result['Chucsactinlanh_total']);
            $this->Excel->ActiveSheet->getCell('Q17')->setValue($tong17 += $result['Chucsactinlanh_tvbandaidiencaptinh']);
            $this->Excel->ActiveSheet->getCell('R17')->setValue($tong18 += $result['Chucsactinlanh_quannhiem']);
            $this->Excel->ActiveSheet->getCell('S17')->setValue($tong19 += $result['Chucsactinlanh_phutaquannhiem']);
            $this->Excel->ActiveSheet->getCell('T17')->setValue($tong20 += $result['Chucsaccaodai_total']);
            $this->Excel->ActiveSheet->getCell('U17')->setValue($tong21 += $result['Chucsaccaodai_chucvuhiennay_thanhvienbddct']);
            $this->Excel->ActiveSheet->getCell('V17')->setValue($tong22 += $result['Chucsaccaodai_chucvuhiennay_phobancaiquan']);
            $this->Excel->ActiveSheet->getCell('W17')->setValue($tong23 += $result['Chucsaccaodai_chucvuhiennay_caiquan']);
            $this->Excel->ActiveSheet->getCell('X17')->setValue($tong24 += $result['Chucsaccaodai_chucvuhiennay_thanhvienbddct2']);
            $this->Excel->ActiveSheet->getCell('Y17')->setValue($tong25 += $result['Chucviechoigiao_chucvuhiennay_thanhvienbangiaoca']);
            $this->Excel->ActiveSheet->getCell('Z17')->setValue($tong26 += $result['Chucviectinhdocusiphathoivietnam_total']);
            $this->Excel->ActiveSheet->getCell('AA17')->setValue($tong27 += $result['Chucviectinhdocusiphathoivietnam_thanhvienbantrisucaptinh']);
            $this->Excel->ActiveSheet->getCell('AB17')->setValue($tong28 += $result['Chucviectinhdocusiphathoivietnam_thanhvienbantrisucaptrunguong']);

            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DS CHUC SAC PCPP
     * DANH SÁCH CHỨC SẮC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM
     */
    protected function __getType19Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Huynhtruonggiadinhphattu',
            'Nguoihoatdongtinnguongchuyennghiep', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelDSCHUCSACPCPP();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelDSCHUCSACPCPP();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu
        );
        //exit;
        $this->__createTemplate19($data);
    }

    public function __createTemplate19($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template19.xls';
        //$filename = "template19";
        $filename = "{$this->_type_text[19]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'Q'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamsactruockhiphong']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamsacduocphong']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
                        break;
                    default:
                        echo 'DS CHUC SAC PCPP';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * TH CHUC SAC PCPP
     * TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO ĐƯỢC PHONG CHỨC, PHONG PHẨM
     */
    protected function __getType20Data()
    {
        $component = $this->Components->load('ExportThCsPc');
        $data = $component->export();
    }

    /**
     * TH TRINH DO TON GIAO
     * TỔNG HỢP TRÌNH ĐỘ TÔN GIÁO CỦA CHỨC SẮC CÁC TÔN GIÁO
     */
    protected function __getType21Data()
    {
        /*$component = $this->Components->load('ExportThTdTgCs');
        $data = $component->export();
        print_r('<pre>final');
        print_r($data);
        print_r('</pre>');
        exit;*/
        $component = $this->Components->load('ExportThTdTgCs');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template21.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[21]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 8;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        $tong =
        $tong_so_cap = $tong_trung_cap =
        $tong_cao_dang = $tong_dai_hoc =
        $tong_sau_dai_hoc =
        $tong_cactochuckhac_captinh =

        $tong_0_so_cap =
        $tong_0_trung_cap =
        $tong_0_cao_dang =
        $tong_0_dai_hoc =
        $tong_0_sau_dai_hoc =

        $tong_1_so_cap =
        $tong_1_trung_cap =
        $tong_1_cao_dang =
        $tong_1_dai_hoc =
        $tong_1_sau_dai_hoc =

        $tong_2_so_cap =
        $tong_2_trung_cap =
        $tong_2_cao_dang =
        $tong_2_dai_hoc =
        $tong_2_sau_dai_hoc =

        $tong_3_so_cap =
        $tong_3_trung_cap =
        $tong_3_cao_dang =
        $tong_3_dai_hoc =
        $tong_3_sau_dai_hoc =

        $tong_4_so_cap =
        $tong_4_trung_cap =
        $tong_4_cao_dang =
        $tong_4_dai_hoc =
        $tong_4_sau_dai_hoc =

        $tong_5_so_cap =
        $tong_5_trung_cap =
        $tong_5_cao_dang =
        $tong_5_dai_hoc =
        $tong_5_sau_dai_hoc = 0;
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['so_cap']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['trung_cap']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['cao_dang']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['dai_hoc']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['sau_dai_hoc']);
                        break;
                    case 'I'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_so_cap']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_trung_cap']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_cao_dang']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_dai_hoc']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_sau_dai_hoc']);
                        break;
                    case 'N'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_so_cap']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_trung_cap']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_cao_dang']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_dai_hoc']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_sau_dai_hoc']);
                        break;
                    case 'S'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_so_cap']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_trung_cap']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_cao_dang']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_dai_hoc']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_sau_dai_hoc']);
                        break;
                    case 'X'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_so_cap']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_trung_cap']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_cao_dang']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_dai_hoc']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_sau_dai_hoc']);
                        break;
                    case 'AC'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_so_cap']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_trung_cap']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_cao_dang']);
                        break;
                    case 'AF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_dai_hoc']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_sau_dai_hoc']);
                        break;
                    case 'AH'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_so_cap']);
                        break;
                    case 'AI':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_trung_cap']);
                        break;
                    case 'AJ':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_cao_dang']);
                        break;
                    case 'AK':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_dai_hoc']);
                        break;
                    case 'AL':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_sau_dai_hoc']);
                        break;
                    default:
                        echo 'TH TRINH DO TON GIAO';
                }
            }
            $tong += $result['total'];
            $tong_so_cap += $result['so_cap'];
            $tong_trung_cap += $result['trung_cap'];
            $tong_cao_dang += $result['cao_dang'];
            $tong_dai_hoc += $result['dai_hoc'];
            $tong_sau_dai_hoc += $result['sau_dai_hoc'];

            $tong_0_so_cap += $result['0_so_cap'];
            $tong_0_trung_cap += $result['0_trung_cap'];
            $tong_0_cao_dang += $result['0_cao_dang'];
            $tong_0_dai_hoc += $result['0_dai_hoc'];
            $tong_0_sau_dai_hoc += $result['0_sau_dai_hoc'];

            $tong_1_so_cap += $result['1_so_cap'];
            $tong_1_trung_cap += $result['1_trung_cap'];
            $tong_1_cao_dang += $result['1_cao_dang'];
            $tong_1_dai_hoc += $result['1_dai_hoc'];
            $tong_1_sau_dai_hoc += $result['1_sau_dai_hoc'];

            $tong_2_so_cap += $result['2_so_cap'];
            $tong_2_trung_cap += $result['2_trung_cap'];
            $tong_2_cao_dang += $result['2_cao_dang'];
            $tong_2_dai_hoc += $result['2_dai_hoc'];
            $tong_2_sau_dai_hoc += $result['2_sau_dai_hoc'];

            $tong_3_so_cap += $result['3_so_cap'];
            $tong_3_trung_cap += $result['3_trung_cap'];
            $tong_3_cao_dang += $result['3_cao_dang'];
            $tong_3_dai_hoc += $result['3_dai_hoc'];
            $tong_3_sau_dai_hoc += $result['3_sau_dai_hoc'];

            $tong_4_so_cap += $result['4_so_cap'];
            $tong_4_trung_cap += $result['4_trung_cap'];
            $tong_4_cao_dang += $result['4_cao_dang'];
            $tong_4_dai_hoc += $result['4_dai_hoc'];
            $tong_4_sau_dai_hoc += $result['4_sau_dai_hoc'];

            $tong_5_so_cap += $result['5_so_cap'];
            $tong_5_trung_cap += $result['5_trung_cap'];
            $tong_5_cao_dang += $result['5_cao_dang'];
            $tong_5_dai_hoc += $result['5_dai_hoc'];
            $tong_5_sau_dai_hoc += $result['5_sau_dai_hoc'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C19')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D19')->setValue($tong_so_cap);
        $this->Excel->ActiveSheet->getCell('E19')->setValue($tong_trung_cap);
        $this->Excel->ActiveSheet->getCell('F19')->setValue($tong_cao_dang);
        $this->Excel->ActiveSheet->getCell('G19')->setValue($tong_dai_hoc);
        $this->Excel->ActiveSheet->getCell('H19')->setValue($tong_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('I19')->setValue($tong_0_so_cap);
        $this->Excel->ActiveSheet->getCell('J19')->setValue($tong_0_trung_cap);
        $this->Excel->ActiveSheet->getCell('K19')->setValue($tong_0_cao_dang);
        $this->Excel->ActiveSheet->getCell('L19')->setValue($tong_0_dai_hoc);
        $this->Excel->ActiveSheet->getCell('M19')->setValue($tong_0_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('N19')->setValue($tong_1_so_cap);
        $this->Excel->ActiveSheet->getCell('O19')->setValue($tong_1_trung_cap);
        $this->Excel->ActiveSheet->getCell('P19')->setValue($tong_1_cao_dang);
        $this->Excel->ActiveSheet->getCell('Q19')->setValue($tong_1_dai_hoc);
        $this->Excel->ActiveSheet->getCell('R19')->setValue($tong_1_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('S19')->setValue($tong_2_so_cap);
        $this->Excel->ActiveSheet->getCell('T19')->setValue($tong_2_trung_cap);
        $this->Excel->ActiveSheet->getCell('U19')->setValue($tong_2_cao_dang);
        $this->Excel->ActiveSheet->getCell('V19')->setValue($tong_2_dai_hoc);
        $this->Excel->ActiveSheet->getCell('W19')->setValue($tong_2_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('X19')->setValue($tong_3_so_cap);
        $this->Excel->ActiveSheet->getCell('Y19')->setValue($tong_3_trung_cap);
        $this->Excel->ActiveSheet->getCell('Z19')->setValue($tong_3_cao_dang);
        $this->Excel->ActiveSheet->getCell('AA19')->setValue($tong_3_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AB19')->setValue($tong_3_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('AC19')->setValue($tong_4_so_cap);
        $this->Excel->ActiveSheet->getCell('AD19')->setValue($tong_4_trung_cap);
        $this->Excel->ActiveSheet->getCell('AE19')->setValue($tong_4_cao_dang);
        $this->Excel->ActiveSheet->getCell('AF19')->setValue($tong_4_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AG19')->setValue($tong_4_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('AH19')->setValue($tong_5_so_cap);
        $this->Excel->ActiveSheet->getCell('AI19')->setValue($tong_5_trung_cap);
        $this->Excel->ActiveSheet->getCell('AJ19')->setValue($tong_5_cao_dang);
        $this->Excel->ActiveSheet->getCell('AK19')->setValue($tong_5_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AL19')->setValue($tong_5_sau_dai_hoc);

        return $this->Excel->save($filename);
    }

    /**
     * TH TRINH DO VH
     * TỔNG HỢP TRÌNH ĐỘ VĂN HÓA CỦA CHỨC SẮC CÁC TÔN GIÁO
     */
    protected function __getType22Data()
    {
        $component = $this->Components->load('ExportThTdVhCs');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template22.xls';
        //$filename = "template17";
        $filename = "{$this->_type_text[22]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 10;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        $tong =
        $tong_tieu_hoc =
        $tong_thcs =
        $tong_thpt =
        $tong_so_cap =
        $tong_trung_cap =
        $tong_cao_dang =
        $tong_dai_hoc =
        $tong_sau_dai_hoc =

        $tong_0_tieu_hoc =
        $tong_0_thcs =
        $tong_0_thpt =
        $tong_0_so_cap =
        $tong_0_trung_cap =
        $tong_0_cao_dang =
        $tong_0_dai_hoc =
        $tong_0_sau_dai_hoc =

        $tong_1_tieu_hoc =
        $tong_1_thcs =
        $tong_1_thpt =
        $tong_1_so_cap =
        $tong_1_trung_cap =
        $tong_1_cao_dang =
        $tong_1_dai_hoc =
        $tong_1_sau_dai_hoc =

        $tong_2_tieu_hoc =
        $tong_2_thcs =
        $tong_2_thpt =
        $tong_2_so_cap =
        $tong_2_trung_cap =
        $tong_2_cao_dang =
        $tong_2_dai_hoc =
        $tong_2_sau_dai_hoc =

        $tong_3_tieu_hoc =
        $tong_3_thcs =
        $tong_3_thpt =
        $tong_3_so_cap =
        $tong_3_trung_cap =
        $tong_3_cao_dang =
        $tong_3_dai_hoc =
        $tong_3_sau_dai_hoc =

        $tong_4_tieu_hoc =
        $tong_4_thcs =
        $tong_4_thpt =
        $tong_4_so_cap =
        $tong_4_trung_cap =
        $tong_4_cao_dang =
        $tong_4_dai_hoc =
        $tong_4_sau_dai_hoc =

        $tong_5_tieu_hoc =
        $tong_5_thcs =
        $tong_5_thpt =
        $tong_5_so_cap =
        $tong_5_trung_cap =
        $tong_5_cao_dang =
        $tong_5_dai_hoc =
        $tong_5_sau_dai_hoc = 0;
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D'://TRÌNH ĐỘ - HỌC VẤN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['tieu_hoc']);
                        break;
                    case 'E'://HỌC VẤN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['thcs']);
                        break;
                    case 'F'://HỌC VẤN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['thpt']);
                        break;
                    case 'G'://CHUYÊN MÔN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['so_cap']);
                        break;
                    case 'H'://CHUYÊN MÔN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['trung_cap']);
                        break;
                    case 'I'://CHUYÊN MÔN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['cao_dang']);
                        break;
                    case 'J'://CHUYÊN MÔN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['dai_hoc']);
                        break;
                    case 'K'://CHUYÊN MÔN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['sau_dai_hoc']);
                        break;
                    case 'L'://CÔNG GIÁO - TRÌNH ĐỘ - HỌC VẤN - TIỂU HỌC VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_tieu_hoc']);
                        break;
                    case 'M'://CÔNG GIÁO - TRÌNH ĐỘ - HỌC VẤN - THCS VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_thcs']);
                        break;
                    case 'N'://CÔNG GIÁO - TRÌNH ĐỘ - HỌC VẤN - THPT VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_thpt']);
                        break;
                    case 'O'://CÔNG GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - SƠ CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_so_cap']);
                        break;
                    case 'P'://CÔNG GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - TRUNG CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_trung_cap']);
                        break;
                    case 'Q'://CÔNG GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - CAO ĐẲNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_cao_dang']);
                        break;
                    case 'R'://CÔNG GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_dai_hoc']);
                        break;
                    case 'S'://CÔNG GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - TRÊN ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0_sau_dai_hoc']);
                        break;
                    case 'T'://PHẬT GIÁO - TRÌNH ĐỘ - HỌC VẤN - TIỂU HỌC VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_tieu_hoc']);
                        break;
                    case 'U'://PHẬT GIÁO - TRÌNH ĐỘ - HỌC VẤN - THCS VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_thcs']);
                        break;
                    case 'V'://PHẬT GIÁO - TRÌNH ĐỘ - HỌC VẤN - THPT VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_thpt']);
                        break;
                    case 'W'://PHẬT GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - SƠ CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_so_cap']);
                        break;
                    case 'X'://PHẬT GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - TRUNG CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_trung_cap']);
                        break;
                    case 'Y'://PHẬT GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - CAO ĐẲNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_cao_dang']);
                        break;
                    case 'Z'://PHẬT GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_dai_hoc']);
                        break;
                    case 'AA'://PHẬT GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - TRÊN ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1_sau_dai_hoc']);
                        break;
                    case 'AB'://TIN LÀNH - TRÌNH ĐỘ - HỌC VẤN - TIỂU HỌC VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_tieu_hoc']);
                        break;
                    case 'AC'://TIN LÀNH - TRÌNH ĐỘ - HỌC VẤN - THCS VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_thcs']);
                        break;
                    case 'AD'://TIN LÀNH - TRÌNH ĐỘ - HỌC VẤN - THPT VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_thpt']);
                        break;
                    case 'AE'://TIN LÀNH - TRÌNH ĐỘ - CHUYÊN MÔN - SƠ CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_so_cap']);
                        break;
                    case 'AF'://TIN LÀNH - TRÌNH ĐỘ - CHUYÊN MÔN - TRUNG CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_trung_cap']);
                        break;
                    case 'AG'://TIN LÀNH - TRÌNH ĐỘ - CHUYÊN MÔN - CAO ĐẲNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_cao_dang']);
                        break;
                    case 'AH'://TIN LÀNH - TRÌNH ĐỘ - CHUYÊN MÔN - ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_dai_hoc']);
                        break;
                    case 'AI'://TIN LÀNH - TRÌNH ĐỘ - CHUYÊN MÔN - TRÊN ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2_sau_dai_hoc']);
                        break;
                    case 'AJ'://CAO ĐÀI - TRÌNH ĐỘ - HỌC VẤN - TIỂU HỌC VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_tieu_hoc']);
                        break;
                    case 'AK'://CAO ĐÀI - TRÌNH ĐỘ - HỌC VẤN - THCS VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_thcs']);
                        break;
                    case 'AL'://CAO ĐÀI - TRÌNH ĐỘ - HỌC VẤN - THPT VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_thpt']);
                        break;
                    case 'AM'://CAO ĐÀI - TRÌNH ĐỘ - CHUYÊN MÔN - SƠ CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_so_cap']);
                        break;
                    case 'AN'://CAO ĐÀI - TRÌNH ĐỘ - CHUYÊN MÔN - TRUNG CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_trung_cap']);
                        break;
                    case 'AO'://CAO ĐÀI - TRÌNH ĐỘ - CHUYÊN MÔN - CAO ĐẲNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_cao_dang']);
                        break;
                    case 'AP'://CAO ĐÀI - TRÌNH ĐỘ - CHUYÊN MÔN - ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_dai_hoc']);
                        break;
                    case 'AQ'://CAO ĐÀI - TRÌNH ĐỘ - CHUYÊN MÔN - TRÊN ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3_sau_dai_hoc']);
                        break;
                    case 'AR'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - HỌC VẤN - TIỂU HỌC VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_tieu_hoc']);
                        break;
                    case 'AS'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - HỌC VẤN - THCS VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_thcs']);
                        break;
                    case 'AT'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - HỌC VẤN - THPT VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_thpt']);
                        break;
                    case 'AU'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - CHUYÊN MÔN - SƠ CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_so_cap']);
                        break;
                    case 'AV'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - CHUYÊN MÔN - TRUNG CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_trung_cap']);
                        break;
                    case 'AW'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - CHUYÊN MÔN - CAO ĐẲNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_cao_dang']);
                        break;
                    case 'AX'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - CHUYÊN MÔN - ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_dai_hoc']);
                        break;
                    case 'AY'://TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM - TRÌNH ĐỘ - CHUYÊN MÔN - TRÊN ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4_sau_dai_hoc']);
                        break;
                    case 'AZ'://HỒI GIÁO - TRÌNH ĐỘ - HỌC VẤN - TIỂU HỌC VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_tieu_hoc']);
                        break;
                    case 'BA'://HỒI GIÁO - TRÌNH ĐỘ - HỌC VẤN - THCS VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_thcs']);
                        break;
                    case 'BB'://HỒI GIÁO - TRÌNH ĐỘ - HỌC VẤN - THPT VÀ TƯƠNG ĐƯƠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_thpt']);
                        break;
                    case 'BC'://HỒI GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - SƠ CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_so_cap']);
                        break;
                    case 'BD'://HỒI GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - TRUNG CẤP
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_trung_cap']);
                        break;
                    case 'BE'://HỒI GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - CAO ĐẲNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_cao_dang']);
                        break;
                    case 'BF'://HỒI GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_dai_hoc']);
                        break;
                    case 'BG'://HỒI GIÁO - TRÌNH ĐỘ - CHUYÊN MÔN - TRÊN ĐẠI HỌC
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5_sau_dai_hoc']);
                        break;
                    default:
                        echo 'TH TRINH DO VH';
                }
            }
            $tong += $result['total'];
            $tong_tieu_hoc += $result['tieu_hoc'];
            $tong_thcs += $result['thcs'];
            $tong_thpt += $result['thpt'];
            $tong_so_cap += $result['so_cap'];
            $tong_trung_cap += $result['trung_cap'];
            $tong_cao_dang += $result['cao_dang'];
            $tong_dai_hoc += $result['dai_hoc'];
            $tong_sau_dai_hoc += $result['sau_dai_hoc'];

            $tong_0_tieu_hoc += $result['0_tieu_hoc'];
            $tong_0_thcs += $result['0_thcs'];
            $tong_0_thpt += $result['0_thpt'];
            $tong_0_so_cap += $result['0_so_cap'];
            $tong_0_trung_cap += $result['0_trung_cap'];
            $tong_0_cao_dang += $result['0_cao_dang'];
            $tong_0_dai_hoc += $result['0_dai_hoc'];
            $tong_0_sau_dai_hoc += $result['0_sau_dai_hoc'];

            $tong_1_tieu_hoc += $result['1_tieu_hoc'];
            $tong_1_thcs += $result['1_thcs'];
            $tong_1_thpt += $result['1_thpt'];
            $tong_1_so_cap += $result['1_so_cap'];
            $tong_1_trung_cap += $result['1_trung_cap'];
            $tong_1_cao_dang += $result['1_cao_dang'];
            $tong_1_dai_hoc += $result['1_dai_hoc'];
            $tong_1_sau_dai_hoc += $result['1_sau_dai_hoc'];

            $tong_2_tieu_hoc += $result['2_tieu_hoc'];
            $tong_2_thcs += $result['2_thcs'];
            $tong_2_thpt += $result['2_thpt'];
            $tong_2_so_cap += $result['2_so_cap'];
            $tong_2_trung_cap += $result['2_trung_cap'];
            $tong_2_cao_dang += $result['2_cao_dang'];
            $tong_2_dai_hoc += $result['2_dai_hoc'];
            $tong_2_sau_dai_hoc += $result['2_sau_dai_hoc'];

            $tong_3_tieu_hoc += $result['3_tieu_hoc'];
            $tong_3_thcs += $result['3_thcs'];
            $tong_3_thpt += $result['3_thpt'];
            $tong_3_so_cap += $result['3_so_cap'];
            $tong_3_trung_cap += $result['3_trung_cap'];
            $tong_3_cao_dang += $result['3_cao_dang'];
            $tong_3_dai_hoc += $result['3_dai_hoc'];
            $tong_3_sau_dai_hoc += $result['3_sau_dai_hoc'];

            $tong_4_tieu_hoc += $result['4_tieu_hoc'];
            $tong_4_thcs += $result['4_thcs'];
            $tong_4_thpt += $result['4_thpt'];
            $tong_4_so_cap += $result['4_so_cap'];
            $tong_4_trung_cap += $result['4_trung_cap'];
            $tong_4_cao_dang += $result['4_cao_dang'];
            $tong_4_dai_hoc += $result['4_dai_hoc'];
            $tong_4_sau_dai_hoc += $result['4_sau_dai_hoc'];

            $tong_5_tieu_hoc += $result['5_tieu_hoc'];
            $tong_5_thcs += $result['5_thcs'];
            $tong_5_thpt += $result['5_thpt'];
            $tong_5_so_cap += $result['5_so_cap'];
            $tong_5_trung_cap += $result['5_trung_cap'];
            $tong_5_cao_dang += $result['5_cao_dang'];
            $tong_5_dai_hoc += $result['5_dai_hoc'];
            $tong_5_sau_dai_hoc += $result['5_sau_dai_hoc'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C21')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D21')->setValue($tong_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('E21')->setValue($tong_thcs);
        $this->Excel->ActiveSheet->getCell('F21')->setValue($tong_thpt);
        $this->Excel->ActiveSheet->getCell('G21')->setValue($tong_so_cap);
        $this->Excel->ActiveSheet->getCell('H21')->setValue($tong_trung_cap);
        $this->Excel->ActiveSheet->getCell('I21')->setValue($tong_cao_dang);
        $this->Excel->ActiveSheet->getCell('J21')->setValue($tong_dai_hoc);
        $this->Excel->ActiveSheet->getCell('K21')->setValue($tong_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('L21')->setValue($tong_0_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('M21')->setValue($tong_0_thcs);
        $this->Excel->ActiveSheet->getCell('N21')->setValue($tong_0_thpt);
        $this->Excel->ActiveSheet->getCell('O21')->setValue($tong_0_so_cap);
        $this->Excel->ActiveSheet->getCell('P21')->setValue($tong_0_trung_cap);
        $this->Excel->ActiveSheet->getCell('Q21')->setValue($tong_0_cao_dang);
        $this->Excel->ActiveSheet->getCell('R21')->setValue($tong_0_dai_hoc);
        $this->Excel->ActiveSheet->getCell('S21')->setValue($tong_0_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('T21')->setValue($tong_1_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('U21')->setValue($tong_1_thcs);
        $this->Excel->ActiveSheet->getCell('V21')->setValue($tong_1_thpt);
        $this->Excel->ActiveSheet->getCell('W21')->setValue($tong_1_so_cap);
        $this->Excel->ActiveSheet->getCell('X21')->setValue($tong_1_trung_cap);
        $this->Excel->ActiveSheet->getCell('Y21')->setValue($tong_1_cao_dang);
        $this->Excel->ActiveSheet->getCell('Z21')->setValue($tong_1_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AA21')->setValue($tong_1_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('AB21')->setValue($tong_2_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('AC21')->setValue($tong_2_thcs);
        $this->Excel->ActiveSheet->getCell('AD21')->setValue($tong_2_thpt);
        $this->Excel->ActiveSheet->getCell('AE21')->setValue($tong_2_so_cap);
        $this->Excel->ActiveSheet->getCell('AF21')->setValue($tong_2_trung_cap);
        $this->Excel->ActiveSheet->getCell('AG21')->setValue($tong_2_cao_dang);
        $this->Excel->ActiveSheet->getCell('AH21')->setValue($tong_2_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AI21')->setValue($tong_2_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('AJ21')->setValue($tong_3_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('AK21')->setValue($tong_3_thcs);
        $this->Excel->ActiveSheet->getCell('AL21')->setValue($tong_3_thpt);
        $this->Excel->ActiveSheet->getCell('AM21')->setValue($tong_3_so_cap);
        $this->Excel->ActiveSheet->getCell('AN21')->setValue($tong_3_trung_cap);
        $this->Excel->ActiveSheet->getCell('AO21')->setValue($tong_3_cao_dang);
        $this->Excel->ActiveSheet->getCell('AP21')->setValue($tong_3_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AQ21')->setValue($tong_3_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('AR21')->setValue($tong_4_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('AS21')->setValue($tong_4_thcs);
        $this->Excel->ActiveSheet->getCell('AT21')->setValue($tong_4_thpt);
        $this->Excel->ActiveSheet->getCell('AU21')->setValue($tong_4_so_cap);
        $this->Excel->ActiveSheet->getCell('AV21')->setValue($tong_4_trung_cap);
        $this->Excel->ActiveSheet->getCell('AW21')->setValue($tong_4_cao_dang);
        $this->Excel->ActiveSheet->getCell('AX21')->setValue($tong_4_dai_hoc);
        $this->Excel->ActiveSheet->getCell('AY21')->setValue($tong_4_sau_dai_hoc);

        $this->Excel->ActiveSheet->getCell('AZ21')->setValue($tong_5_tieu_hoc);
        $this->Excel->ActiveSheet->getCell('BA21')->setValue($tong_5_thcs);
        $this->Excel->ActiveSheet->getCell('BB21')->setValue($tong_5_thpt);
        $this->Excel->ActiveSheet->getCell('BC21')->setValue($tong_5_so_cap);
        $this->Excel->ActiveSheet->getCell('BD21')->setValue($tong_5_trung_cap);
        $this->Excel->ActiveSheet->getCell('BE21')->setValue($tong_5_cao_dang);
        $this->Excel->ActiveSheet->getCell('BF21')->setValue($tong_5_dai_hoc);
        $this->Excel->ActiveSheet->getCell('BG21')->setValue($tong_5_sau_dai_hoc);

        return $this->Excel->save($filename);
    }

    /**
     * DANH SACH TU SI
     * DANH SÁCH TU SĨ CÁC TÔN GIÁO
     */
    protected function __getType23Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Huynhtruonggiadinhphattu',
            'Nguoihoatdongtinnguongchuyennghiep', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelDSTSCTG();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelDSTSCTG();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelDSTSCTG();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelDSTSCTG();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelDSTSCTG();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelDSTSCTG();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelDSTSCTG();
        //$huynh_truong_gia_dinh_phat_tu = $this->Huynhtruonggiadinhphattu->getDataExcelDSTSCTG();
        //$nguoi_hoat_dong_tin_nguong_chuyen_nghiep = $this->Nguoihoatdongtinnguongchuyennghiep->getDataExcelDSTSCTG();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelDSTSCTG();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            //$huynh_truong_gia_dinh_phat_tu,
            //$nguoi_hoat_dong_tin_nguong_chuyen_nghiep,
            $chuc_viec_hoi_giao
        );
        //exit;
        $this->__createTemplate23($data);
    }

    public function __createTemplate23($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template23.xls';
        //$filename = "template24";
        $filename = "{$this->_type_text[23]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'Q'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamtrat']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongpham']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['choohiennay']);
                        break;
                    case 'Q':
                        //$this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ghichu']);
                        break;
                    default:
                        echo 'DANH SACH TU SI';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DS CHUC SAC KO CO CHUC VU
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (KHÔNG CÓ CHỨC VỤ)
     */
    protected function __getType24Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelChucSacTinLanhKhongCoChuVu();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelChucSacNhaTuHanhCongGiaoDongTrieuKhongCoChuVu();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelChucSacNhaTuHanhConGiaoDongTuKhongCoChuVu();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelChucViecPhatHoaHaoKhongCoChuVu();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelChucViecTinhDoCuSiPhatHoiVietNamKhongCoChuVu();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelChucSacCaoDaiKhongCoChuVu();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelChucSacNhaTuHanhPhatGiaoKhongCoChuVu();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelChucViecHoiGiaoKhongCoChuVu();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            $chuc_viec_hoi_giao
        );
        //exit;
        $this->__createTemplate24($data);
    }

    public function __createTemplate24($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template24.xls';
        //$filename = "template24";
        $filename = "{$this->_type_text[24]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'P'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamtrat']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongpham']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
                        break;
                    default:
                        echo 'DS CHUC SAC KO CO CHUC VU';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }

    /**
     * DS CHUC SAC CO CHUC VU
     * DANH SÁCH CHỨC SẮC CÁC TÔN GIÁO (CÓ CHỨC VỤ)
     */
    protected function __getType25Data()
    {
        $array = array(
            'Chucsactinlanh', 'Chucsacnhatuhanhconggiaotrieu', 'Chucsacnhatuhanhcongiaodongtu', 'Chucviecphathoahao',
            'Chucviectinhdocusiphathoivietnam', 'Chucsaccaodai', 'Chucsacnhatuhanhphatgiao', 'Chucviechoigiao'
        );
        App::import('Model', $array);
        foreach ($array as $element) {
            $this->$element = new $element();
        }
        $chuc_sac_tin_lanh = $this->Chucsactinlanh->getDataExcelChucSacTinLanhCoChuVu();
        $chuc_sac_nha_tu_hanh_cong_giao_trieu = $this->Chucsacnhatuhanhconggiaotrieu->getDataExcelChucSacNhaTuHanhCongGiaoDongTrieuCoChuVu();
        $chuc_sac_nha_tu_hanh_con_giao_dong_tu = $this->Chucsacnhatuhanhcongiaodongtu->getDataExcelChucSacNhaTuHanhConGiaoDongTuCoChuVu();
        $chuc_viec_phat_hoahao = $this->Chucviecphathoahao->getDataExcelChucViecPhatHoaHaoCoChuVu();
        $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam = $this->Chucviectinhdocusiphathoivietnam->getDataExcelChucViecTinhDoCuSiPhatHoiVietNamCoChuVu();
        $chuc_sac_cao_dai = $this->Chucsaccaodai->getDataExcelChucSacCaoDaiCoChuVu();
        $chuc_sac_nha_tu_hanh_phat_giao = $this->Chucsacnhatuhanhphatgiao->getDataExcelChucSacNhaTuHanhPhatGiaoCoChuVu();
        $chuc_viec_hoi_giao = $this->Chucviechoigiao->getDataExcelChucViecHoiGiaoCoChuVu();
        $data = array_merge(
            $chuc_sac_tin_lanh,
            $chuc_sac_nha_tu_hanh_cong_giao_trieu,
            $chuc_sac_nha_tu_hanh_con_giao_dong_tu,
            $chuc_viec_phat_hoahao,
            $chuc_viec_tinh_do_cu_si_phat_hoi_viet_nam,
            $chuc_sac_cao_dai,
            $chuc_sac_nha_tu_hanh_phat_giao,
            $chuc_viec_hoi_giao
        );
        //exit;
        $this->__createTemplate25($data);
    }

    public function __createTemplate25($data)
    {
        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template25.xls';
        //$filename = "template25";
        $filename = "{$this->_type_text[25]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'A'; $c <= 'Q'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            /*if ($c == $maxCols) {
                break;
            }*/
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $i = 1;
        $r = 7;
        $gioitinh = unserialize(GIOI_TINH);
        foreach ($data as $key => $value) {
            $gioi_tinh = isset($gioitinh[$value['gioitinh']]) ? $gioitinh[$value['gioitinh']] : '';
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'A':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($i);
                        break;
                    case 'B':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['hovaten']);
                        break;
                    case 'C':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['tengoitheotongiao']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['thuoctochuctongiao']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ngaythangnamsinh']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($gioi_tinh);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chungminhnhandan']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['chucvu']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongchuc']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['phamtrat']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['namduocphongpham']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdohocvan']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdochuyenmon']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['trinhdotongiao']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['quequan']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['cosotongiaodanghoatdong']);
                        break;
                    case 'Q':
                        //$this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($value['ghichu']);
                        break;
                    default:
                        echo 'DS CHUC SAC KO CO CHUC VU';
                }
            }
            $i++;
            $r++;
        }

        return $this->Excel->save($filename);
    }


    /**
     * TONG HOP CHUC VIEC
     * BẢNG TỔNG HỢP CHỨC VIỆC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
     **/
    protected function __getType26Data()
    {
        $component = $this->Components->load('ExportThCvTinh');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template26.xls';
        //$filename = "template26";
        $filename = "{$this->_type_text[26]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'W'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 9;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_total']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_0']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_1']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_2']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_3']);
                        break;
                    case 'I'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_total']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_banhotu']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_banhotu_banhoniem_sothanhvien']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_giadinhphattu_sodoanvien']);
                        break;
                    case 'M'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_sothanhvientrongbanchapsu']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinlanh_bantrisu']);
                        break;
                    case 'O'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_total']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_sothanvien_bancaiquan']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Hodaocaodai_bantrisu']);
                        break;
                    case 'R'://PHẬT GIÁO HÒA HẢO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviecphathoahao_total']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviecphathoahao_thanhvienbandaidientinh']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviecphathoahao_phobantrisu']);
                        break;
                    case 'U'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_total']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_sothanhvien_banhodao']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chihoitinhdocusiphatgiaovietnam_sothanhvien_banchaphanhdaoduc']);
                        break;
                    default:
                        echo 'TONG HOP CHUC VIEC';
                }
            }
            $tong += $result['total'];
            $tong_conggiao_tong += $result['Giaoxu_total'];
            $tong_conggiao_banhanhgiao += $result['Giaoxu_0'];
            $tong_conggiao_thuongvubhg += $result['Giaoxu_1'];
            $tong_conggiao_lanhdaocachoidoantucapgiaoxutrolen += $result['Giaoxu_2'];
            $tong_conggiao_khac += $result['Giaoxu_3'];

            $tong_phatgiao_tong += $result['Tuvienphatgiao_total'];
            $tong_phatgiao_banhotu += $result['Tuvienphatgiao_banhotu'];
            $tong_phatgiao_banhoniem += $result['Tuvienphatgiao_banhotu_banhoniem_sothanhvien'];
            $tong_phatgiao_giadinhphattu += $result['Tuvienphatgiao_giadinhphattu_sodoanvien'];

            $tong_tinlanh_banchapsu += $result['Chihoitinlanh_sothanhvientrongbanchapsu'];
            $tong_tinlanh_bantrisu += $result['Chihoitinlanh_bantrisu'];

            $tong_caodai_tong += $result['Hodaocaodai_total'];
            $tong_caodai_bancaiquan += $result['Hodaocaodai_sothanvien_bancaiquan'];
            $tong_caodai_bantrisu += $result['Hodaocaodai_bantrisu'];

            $tong_phatgiaohoahao_tong += $result['Chucviecphathoahao_total'];
            $tong_phatgiaohoahao_bandaidien += $result['Chucviecphathoahao_thanhvienbandaidientinh'];
            $tong_phatgiaohoahao_bantrisuxaphuongthitran += $result['Chucviecphathoahao_phobantrisu'];

            $tong_tdcsphvn_tong += $result['Chihoitinhdocusiphatgiaovietnam_total'];
            $tong_tdcsphvn_banhodao += $result['Chihoitinhdocusiphatgiaovietnam_sothanhvien_banhodao'];
            $tong_tdcsphvn_banchaphanhdaoduc += $result['Chihoitinhdocusiphatgiaovietnam_sothanhvien_banchaphanhdaoduc'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C20')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D20')->setValue($tong_conggiao_tong);
        $this->Excel->ActiveSheet->getCell('E20')->setValue($tong_conggiao_banhanhgiao);
        $this->Excel->ActiveSheet->getCell('F20')->setValue($tong_conggiao_thuongvubhg);
        $this->Excel->ActiveSheet->getCell('G20')->setValue($tong_conggiao_lanhdaocachoidoantucapgiaoxutrolen);
        $this->Excel->ActiveSheet->getCell('H20')->setValue($tong_conggiao_khac);

        $this->Excel->ActiveSheet->getCell('I20')->setValue($tong_phatgiao_tong);
        $this->Excel->ActiveSheet->getCell('J20')->setValue($tong_phatgiao_banhotu);
        $this->Excel->ActiveSheet->getCell('K20')->setValue($tong_phatgiao_banhoniem);
        $this->Excel->ActiveSheet->getCell('L20')->setValue($tong_phatgiao_giadinhphattu);

        $this->Excel->ActiveSheet->getCell('M20')->setValue($tong_tinlanh_banchapsu);
        $this->Excel->ActiveSheet->getCell('N20')->setValue($tong_tinlanh_bantrisu);
        $this->Excel->ActiveSheet->getCell('O20')->setValue($tong_caodai_tong);
        $this->Excel->ActiveSheet->getCell('P20')->setValue($tong_caodai_bancaiquan);
        $this->Excel->ActiveSheet->getCell('Q20')->setValue($tong_caodai_bantrisu);

        $this->Excel->ActiveSheet->getCell('R20')->setValue($tong_phatgiaohoahao_tong);
        $this->Excel->ActiveSheet->getCell('S20')->setValue($tong_phatgiaohoahao_bandaidien);
        $this->Excel->ActiveSheet->getCell('T20')->setValue($tong_phatgiaohoahao_bantrisuxaphuongthitran);

        $this->Excel->ActiveSheet->getCell('U20')->setValue($tong_tdcsphvn_tong);
        $this->Excel->ActiveSheet->getCell('V20')->setValue($tong_tdcsphvn_banhodao);
        $this->Excel->ActiveSheet->getCell('W20')->setValue($tong_tdcsphvn_banchaphanhdaoduc);

        return $this->Excel->save($filename);
    }

    /**
     * TONG HOP TU SI
     * BẢNG TỔNG HỢP TU SĨ CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType27Data()
    {
        $component = $this->Components->load('ExportThTs');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template27.xls';
        //$filename = "template27";
        $filename = "{$this->_type_text[27]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'O'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 10;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_total']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_sotusi_nam']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_chungsinh']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_sotusi_nu']);
                        break;
                    case 'H'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_total']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_nam_tykheo']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_nam_sadi']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_nam_tinhnhon_dieu']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_nu_tykheoni']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_nu_thucxoamana']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_nu_sadini']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Tuvienphatgiao_tinhnhon_dieu']);
                        break;
                    default:
                        echo 'TONG HOP TU SI';
                }
            }
            $tong += $result['total'];
            $tong_conggiao_tong += $result['Giaoxu_total'];
            $tong_conggiao_nam_tusidong += $result['Giaoxu_sotusi_nam'];
            $tong_conggiao_nam_chungsinh += $result['Giaoxu_chungsinh'];
            $tong_conggiao_nu_tusidong += $result['Giaoxu_sotusi_nu'];

            $tong_phatgiao_tong += $result['Tuvienphatgiao_total'];
            $tong_phatgiao_nam_daiduc += $result['Tuvienphatgiao_nam_tykheo'];
            $tong_phatgiao_nam_sadi += $result['Tuvienphatgiao_nam_sadi'];
            $tong_phatgiao_nam_tinhnhondieu += $result['Tuvienphatgiao_nam_tinhnhon_dieu'];
            $tong_phatgiao_nu_tykheoni += $result['Tuvienphatgiao_nu_tykheoni'];
            $tong_phatgiao_nu_thucxoamana += $result['Tuvienphatgiao_nu_thucxoamana'];
            $tong_phatgiao_nu_sadini += $result['Tuvienphatgiao_nu_sadini'];
            $tong_phatgiao_nu_tinhnhon_dieu += $result['Tuvienphatgiao_tinhnhon_dieu'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C20')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D20')->setValue($tong_conggiao_tong);
        $this->Excel->ActiveSheet->getCell('E20')->setValue($tong_conggiao_nam_tusidong);
        $this->Excel->ActiveSheet->getCell('F20')->setValue($tong_conggiao_nam_chungsinh);
        $this->Excel->ActiveSheet->getCell('G20')->setValue($tong_conggiao_nu_tusidong);

        $this->Excel->ActiveSheet->getCell('H20')->setValue($tong_phatgiao_tong);
        $this->Excel->ActiveSheet->getCell('I20')->setValue($tong_phatgiao_nam_daiduc);
        $this->Excel->ActiveSheet->getCell('J20')->setValue($tong_phatgiao_nam_sadi);
        $this->Excel->ActiveSheet->getCell('K20')->setValue($tong_phatgiao_nam_tinhnhondieu);
        $this->Excel->ActiveSheet->getCell('L20')->setValue($tong_phatgiao_nu_tykheoni);
        $this->Excel->ActiveSheet->getCell('M20')->setValue($tong_phatgiao_nu_thucxoamana);
        $this->Excel->ActiveSheet->getCell('N20')->setValue($tong_phatgiao_nu_sadini);
        $this->Excel->ActiveSheet->getCell('O20')->setValue($tong_phatgiao_nu_tinhnhon_dieu);

        return $this->Excel->save($filename);
    }

    /**
     * TONG HOP CHUC SAC KO CHUC VU
     * BẢNG TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH (KHÔNG CÓ CHỨC VỤ)
     */
    protected function __getType28Data()
    {
        $component = $this->Components->load('ExportThCskcv');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template28.xls';
        //$filename = "template28";
        $filename = "{$this->_type_text[28]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 9;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_total']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_giammuc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_betrentongquyen']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_giamtinh']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_linhmuc']);
                        break;
                    case 'I'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_total']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_hoathuong']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_thuongtoa']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_nitruong']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_nisu']);
                        break;
                    case 'N'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_total']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsu']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsunc']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_truyendao']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_total']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_phosu']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_giaosu']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_giaohuu']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauphong_lesanh']);
                        break;
                    case 'W'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_total']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_hakim']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_naep']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_ahly']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_khotip']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_imam']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_tuon']);
                        break;
                    case 'AD'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_total']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_phogiangsu']);
                        break;
                    case 'AF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_ysi']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_ysinh']);
                        break;
                    default:
                        echo 'TONG HOP CHUC SAC KO CHUC VU';
                }
            }
            $tong += $result['total'];
            $tong_conggiao_tong += $result['Chucsacnhatuhanhconggiaotrieu_total'];
            $tong_conggiao_giammuc += $result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_giammuc'];
            $tong_conggiao_betrentongquyen += $result['Chucsacnhatuhanhconggiaotrieu_betrentongquyen'];
            $tong_conggiao_giamtinh += $result['Chucsacnhatuhanhconggiaotrieu_giamtinh'];
            $tong_conggiao_linhmuc += $result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_linhmuc'];

            $tong_phatgiao_tong += $result['Chucsacnhatuhanhphatgiao_total'];
            $tong_phatgiao_hoathuong += $result['Chucsacnhatuhanhphatgiao_hoathuong'];
            $tong_phatgiao_thuongtoa += $result['Chucsacnhatuhanhphatgiao_thuongtoa'];
            $tong_phatgiao_nitruong += $result['Chucsacnhatuhanhphatgiao_nitruong'];
            $tong_phatgiao_nisu += $result['Chucsacnhatuhanhphatgiao_nisu'];

            $tong_tinlanh_tong += $result['Chucsactinlanh_total'];
            $tong_tinlanh_mucsu += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsu'];
            $tong_tinlanh_mucsunhiemchuc += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsunc'];
            $tong_tinlanh_truyendao += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_truyendao'];

            $tong_caodai_tong += $result['Chucsaccaodai_total'];
            $tong_caodai_phoisu += $result['Chucsaccaodai_phamsac_ntn_cauthang_phosu'];
            $tong_caodai_giaosu += $result['Chucsaccaodai_phamsac_ntn_cauthang_giaosu'];
            $tong_caodai_giaohuu += $result['Chucsaccaodai_phamsac_ntn_cauthang_giaohuu'];
            $tong_caodai_lesanh += $result['Chucsaccaodai_phamsac_ntn_cauphong_lesanh'];

            $tong_hoigiao_tong += $result['Chucviechoigiao_total'];
            $tong_hoigiao_hakim += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_hakim'];
            $tong_hoigiao_naep += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_naep'];
            $tong_hoigiao_ahly += $result['Chucviechoigiao_ahly'];
            $tong_hoigiao_khotip += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_khotip'];
            $tong_hoigiao_imam += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_imam'];
            $tong_hoigiao_tuon += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_tuon'];

            $tong_tdcsphvn_tong += $result['Chucviectinhdocusiphathoivietnam_total'];
            $tong_tdcsphvn_giangsu += $result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_phogiangsu'];
            $tong_tdcsphvn_thuyettrinhvien += $result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien'];
            $tong_tdcsphvn_ysi += $result['Chucviectinhdocusiphathoivietnam_ysi'];
            $tong_tdcsphvn_ysinh += $result['Chucviectinhdocusiphathoivietnam_ysinh'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C20')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D20')->setValue($tong_conggiao_tong);
        $this->Excel->ActiveSheet->getCell('E20')->setValue($tong_conggiao_giammuc);
        $this->Excel->ActiveSheet->getCell('F20')->setValue($tong_conggiao_betrentongquyen);
        $this->Excel->ActiveSheet->getCell('G20')->setValue($tong_conggiao_giamtinh);
        $this->Excel->ActiveSheet->getCell('H20')->setValue($tong_conggiao_linhmuc);

        $this->Excel->ActiveSheet->getCell('I20')->setValue($tong_phatgiao_tong);
        $this->Excel->ActiveSheet->getCell('J20')->setValue($tong_phatgiao_hoathuong);
        $this->Excel->ActiveSheet->getCell('K20')->setValue($tong_phatgiao_thuongtoa);
        $this->Excel->ActiveSheet->getCell('L20')->setValue($tong_phatgiao_nitruong);
        $this->Excel->ActiveSheet->getCell('M20')->setValue($tong_phatgiao_nisu);

        $this->Excel->ActiveSheet->getCell('N20')->setValue($tong_tinlanh_tong);
        $this->Excel->ActiveSheet->getCell('O20')->setValue($tong_tinlanh_mucsu);
        $this->Excel->ActiveSheet->getCell('P20')->setValue($tong_tinlanh_mucsunhiemchuc);
        $this->Excel->ActiveSheet->getCell('Q20')->setValue($tong_tinlanh_truyendao);

        $this->Excel->ActiveSheet->getCell('R20')->setValue($tong_caodai_tong);
        $this->Excel->ActiveSheet->getCell('S20')->setValue($tong_caodai_phoisu);
        $this->Excel->ActiveSheet->getCell('T20')->setValue($tong_caodai_giaosu);
        $this->Excel->ActiveSheet->getCell('U20')->setValue($tong_caodai_giaohuu);
        $this->Excel->ActiveSheet->getCell('V20')->setValue($tong_caodai_lesanh);

        $this->Excel->ActiveSheet->getCell('W20')->setValue($tong_hoigiao_tong);
        $this->Excel->ActiveSheet->getCell('X20')->setValue($tong_hoigiao_hakim);
        $this->Excel->ActiveSheet->getCell('Y20')->setValue($tong_hoigiao_naep);
        $this->Excel->ActiveSheet->getCell('Z20')->setValue($tong_hoigiao_ahly);
        $this->Excel->ActiveSheet->getCell('AA20')->setValue($tong_hoigiao_khotip);
        $this->Excel->ActiveSheet->getCell('AB20')->setValue($tong_hoigiao_imam);
        $this->Excel->ActiveSheet->getCell('AC20')->setValue($tong_hoigiao_tuon);

        $this->Excel->ActiveSheet->getCell('AD20')->setValue($tong_tdcsphvn_tong);
        $this->Excel->ActiveSheet->getCell('AE20')->setValue($tong_tdcsphvn_giangsu);
        $this->Excel->ActiveSheet->getCell('AF20')->setValue($tong_tdcsphvn_thuyettrinhvien);
        $this->Excel->ActiveSheet->getCell('AG20')->setValue($tong_tdcsphvn_ysi);
        $this->Excel->ActiveSheet->getCell('AH20')->setValue($tong_tdcsphvn_ysinh);

        return $this->Excel->save($filename);
    }

    /**
     * TONG HOP CHUC SAC CO CHUC VU
     * BẢNG TỔNG HỢP CHỨC SẮC CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH (CÓ CHỨC VỤ)
     *
     */
    protected function __getType29Data()
    {
        $component = $this->Components->load('ExportThCscv');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template29.xls';
        //$filename = "template29";
        $filename = "{$this->_type_text[29]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 9;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total']);
                        break;
                    case 'D'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_total']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_giammuc']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_betrentongquyen']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_giamtinh']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_linhmuc']);
                        break;
                    case 'I'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_total']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_hoathuong']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_thuongtoa']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_nitruong']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_nisu']);
                        break;
                    case 'N'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_total']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsu']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsunc']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_truyendao']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_total']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_phosu']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_giaosu']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_giaohuu']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauphong_lesanh']);
                        break;
                    case 'W'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_total']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_hakim']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_naep']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_ahly']);
                        break;
                    case 'AA':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_khotip']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_imam']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_tuon']);
                        break;
                    case 'AD'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_total']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_phogiangsu']);
                        break;
                    case 'AF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_ysi']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_ysinh']);
                        break;
                    default:
                        echo 'TONG HOP CHUC SAC CO CHUC VU';
                }
            }
            $tong += $result['total'];
            $tong_conggiao_tong += $result['Chucsacnhatuhanhconggiaotrieu_total'];
            $tong_conggiao_giammuc += $result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_giammuc'];
            $tong_conggiao_betrentongquyen += $result['Chucsacnhatuhanhconggiaotrieu_betrentongquyen'];
            $tong_conggiao_giamtinh += $result['Chucsacnhatuhanhconggiaotrieu_giamtinh'];
            $tong_conggiao_linhmuc += $result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_linhmuc'];

            $tong_phatgiao_tong += $result['Chucsacnhatuhanhphatgiao_total'];
            $tong_phatgiao_hoathuong += $result['Chucsacnhatuhanhphatgiao_hoathuong'];
            $tong_phatgiao_thuongtoa += $result['Chucsacnhatuhanhphatgiao_thuongtoa'];
            $tong_phatgiao_nitruong += $result['Chucsacnhatuhanhphatgiao_nitruong'];
            $tong_phatgiao_nisu += $result['Chucsacnhatuhanhphatgiao_nisu'];

            $tong_tinlanh_tong += $result['Chucsactinlanh_total'];
            $tong_tinlanh_mucsu += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsu'];
            $tong_tinlanh_mucsunhiemchuc += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsunc'];
            $tong_tinlanh_truyendao += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_truyendao'];

            $tong_caodai_tong += $result['Chucsaccaodai_total'];
            $tong_caodai_phoisu += $result['Chucsaccaodai_phamsac_ntn_cauthang_phosu'];
            $tong_caodai_giaosu += $result['Chucsaccaodai_phamsac_ntn_cauthang_giaosu'];
            $tong_caodai_giaohuu += $result['Chucsaccaodai_phamsac_ntn_cauthang_giaohuu'];
            $tong_caodai_lesanh += $result['Chucsaccaodai_phamsac_ntn_cauphong_lesanh'];

            $tong_hoigiao_tong += $result['Chucviechoigiao_total'];
            $tong_hoigiao_hakim += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_hakim'];
            $tong_hoigiao_naep += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_naep'];
            $tong_hoigiao_ahly += $result['Chucviechoigiao_ahly'];
            $tong_hoigiao_khotip += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_khotip'];
            $tong_hoigiao_imam += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_imam'];
            $tong_hoigiao_tuon += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_tuon'];

            $tong_tdcsphvn_tong += $result['Chucviectinhdocusiphathoivietnam_total'];
            $tong_tdcsphvn_giangsu += $result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_phogiangsu'];
            $tong_tdcsphvn_thuyettrinhvien += $result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien'];
            $tong_tdcsphvn_ysi += $result['Chucviectinhdocusiphathoivietnam_ysi'];
            $tong_tdcsphvn_ysinh += $result['Chucviectinhdocusiphathoivietnam_ysinh'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C20')->setValue($tong);
        $this->Excel->ActiveSheet->getCell('D20')->setValue($tong_conggiao_tong);
        $this->Excel->ActiveSheet->getCell('E20')->setValue($tong_conggiao_giammuc);
        $this->Excel->ActiveSheet->getCell('F20')->setValue($tong_conggiao_betrentongquyen);
        $this->Excel->ActiveSheet->getCell('G20')->setValue($tong_conggiao_giamtinh);
        $this->Excel->ActiveSheet->getCell('H20')->setValue($tong_conggiao_linhmuc);

        $this->Excel->ActiveSheet->getCell('I20')->setValue($tong_phatgiao_tong);
        $this->Excel->ActiveSheet->getCell('J20')->setValue($tong_phatgiao_hoathuong);
        $this->Excel->ActiveSheet->getCell('K20')->setValue($tong_phatgiao_thuongtoa);
        $this->Excel->ActiveSheet->getCell('L20')->setValue($tong_phatgiao_nitruong);
        $this->Excel->ActiveSheet->getCell('M20')->setValue($tong_phatgiao_nisu);

        $this->Excel->ActiveSheet->getCell('N20')->setValue($tong_tinlanh_tong);
        $this->Excel->ActiveSheet->getCell('O20')->setValue($tong_tinlanh_mucsu);
        $this->Excel->ActiveSheet->getCell('P20')->setValue($tong_tinlanh_mucsunhiemchuc);
        $this->Excel->ActiveSheet->getCell('Q20')->setValue($tong_tinlanh_truyendao);

        $this->Excel->ActiveSheet->getCell('R20')->setValue($tong_caodai_tong);
        $this->Excel->ActiveSheet->getCell('S20')->setValue($tong_caodai_phoisu);
        $this->Excel->ActiveSheet->getCell('T20')->setValue($tong_caodai_giaosu);
        $this->Excel->ActiveSheet->getCell('U20')->setValue($tong_caodai_giaohuu);
        $this->Excel->ActiveSheet->getCell('V20')->setValue($tong_caodai_lesanh);

        $this->Excel->ActiveSheet->getCell('W20')->setValue($tong_hoigiao_tong);
        $this->Excel->ActiveSheet->getCell('X20')->setValue($tong_hoigiao_hakim);
        $this->Excel->ActiveSheet->getCell('Y20')->setValue($tong_hoigiao_naep);
        $this->Excel->ActiveSheet->getCell('Z20')->setValue($tong_hoigiao_ahly);
        $this->Excel->ActiveSheet->getCell('AA20')->setValue($tong_hoigiao_khotip);
        $this->Excel->ActiveSheet->getCell('AB20')->setValue($tong_hoigiao_imam);
        $this->Excel->ActiveSheet->getCell('AC20')->setValue($tong_hoigiao_tuon);

        $this->Excel->ActiveSheet->getCell('AD20')->setValue($tong_tdcsphvn_tong);
        $this->Excel->ActiveSheet->getCell('AE20')->setValue($tong_tdcsphvn_giangsu);
        $this->Excel->ActiveSheet->getCell('AF20')->setValue($tong_tdcsphvn_thuyettrinhvien);
        $this->Excel->ActiveSheet->getCell('AG20')->setValue($tong_tdcsphvn_ysi);
        $this->Excel->ActiveSheet->getCell('AH20')->setValue($tong_tdcsphvn_ysinh);

        return $this->Excel->save($filename);
    }

    /**
     * DO TUOI CUA CHAC SAC
     * BẢNG TỔNG HỢP LỨA TUỔI CỦA CHỨC SẮC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType30Data()
    {
        $component = $this->Components->load('ExportThDtCs');
        $data = $component->export();

        $this->autoLayout = false;
        $this->autoRender = false;
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template30.xls';
        //$filename = "template30";
        $filename = "{$this->_type_text[30]}";
        $this->Excel->load($source);
        //$this->{"__createTemplate{$type}"}();
        //$this->Excel->save($filename);

        //$maxRows = $this->Excel->ActiveSheet->getHighestRow();
        $maxCols = $this->Excel->ActiveSheet->getHighestColumn();
        $colIndexes = array();

        $index = 1;
        for ($c = 'C'; $c <= 'Z'; $c++) {
            $colIndexes[$index] = $c;
            $index ++;
            if ($c == $maxCols) {
                break;
            }
        }
        /*print "<pre>";
        print_r($data);
        print "</pre>";
        print "<pre>";
        print_r($colIndexes);
        print "</pre>";
        exit;*/
        $r = 9;
        $tinhs = array(
            'bien-hoa',
            'long-khanh',
            'xuan-loc',
            'cam-my',
            'tan-phu',
            'dinh-quan',
            'thong-nhat',
            'trang-bom',
            'vinh-cuu',
            'nhon-trach',
            'long-thanh',
        );
        foreach ($tinhs as $tinh) {
            $result = $data[$tinh];
            foreach ($colIndexes as $k => $c) {
                switch ($c) {
                    case 'C'://TỔNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_1']);
                        break;
                    case 'D':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_2']);
                        break;
                    case 'E':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_3']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['total_4']);
                        break;
                    case 'G'://CÔNG GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['0']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['1']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['2']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['3']);
                        break;
                    case 'K'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['4']);
                        break;
                    case 'L':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['5']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['6']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['7']);
                        break;
                    case 'O'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['8']);
                        break;
                    case 'P':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['9']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['10']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['11']);
                        break;
                    case 'S'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['12']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['13']);
                        break;
                    case 'U':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['14']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['15']);
                        break;
                    case 'W'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['16']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['17']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['18']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['19']);
                        break;
                    case 'AA'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['20']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['21']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['22']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['23']);
                        break;
                    case 'AE'://TÍN NGƯỠNG
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['24']);
                        break;
                    case 'AF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['25']);
                        break;
                    case 'AG':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['26']);
                        break;
                    case 'AH':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['27']);
                        break;
                    default:
                        echo 'DO TUOI CUA CHAC SAC';
                }
            }
            $tong_total_1 += $result['total_1'];
            $tong_total_2 += $result['total_2'];
            $tong_total_3 += $result['total_3'];
            $tong_total_4 += $result['total_4'];

            $tong_conggiao_duoi20 += $result['0'];
            $tong_conggiao_21den40 += $result['1'];
            $tong_conggiao_41den61 += $result['2'];
            $tong_conggiao_tren61 += $result['3'];

            $tong_phatgiao_duoi20 += $result['4'];
            $tong_phatgiao_21den40 += $result['5'];
            $tong_phatgiao_41den61 += $result['6'];
            $tong_phatgiao_tren61 += $result['7'];

            $tong_tinlanh_duoi20 += $result['8'];
            $tong_tinlanh_21den40 += $result['9'];
            $tong_tinlanh_41den61 += $result['10'];
            $tong_tinlanh_tren61 += $result['11'];

            $tong_caodai_duoi20 += $result['12'];
            $tong_caodai_21den40 += $result['13'];
            $tong_caodai_41den61 += $result['14'];
            $tong_caodai_tren61 += $result['15'];

            $tong_hoigiao_duoi20 += $result['16'];
            $tong_hoigiao_21den40 += $result['17'];
            $tong_hoigiao_41den61 += $result['18'];
            $tong_hoigiao_tren61 += $result['19'];

            $tong_tdcsphvn_duoi20 += $result['20'];
            $tong_tdcsphvn_21den40 += $result['21'];
            $tong_tdcsphvn_41den61 += $result['22'];
            $tong_tdcsphvn_tren61 += $result['23'];

            $tong_tinnguong_duoi20 += $result['24'];
            $tong_tinnguong_21den40 += $result['25'];
            $tong_tinnguong_41den61 += $result['26'];
            $tong_tinnguong_tren61 += $result['27'];

            $r++;
        }
        $this->Excel->ActiveSheet->getCell('C20')->setValue($tong_total_1);
        $this->Excel->ActiveSheet->getCell('D20')->setValue($tong_total_2);
        $this->Excel->ActiveSheet->getCell('E20')->setValue($tong_total_3);
        $this->Excel->ActiveSheet->getCell('F20')->setValue($tong_total_4);

        $this->Excel->ActiveSheet->getCell('G20')->setValue($tong_conggiao_duoi20);
        $this->Excel->ActiveSheet->getCell('H20')->setValue($tong_conggiao_21den40);
        $this->Excel->ActiveSheet->getCell('I20')->setValue($tong_conggiao_41den61);
        $this->Excel->ActiveSheet->getCell('J20')->setValue($tong_conggiao_tren61);

        $this->Excel->ActiveSheet->getCell('K20')->setValue($tong_phatgiao_duoi20);
        $this->Excel->ActiveSheet->getCell('L20')->setValue($tong_phatgiao_21den40);
        $this->Excel->ActiveSheet->getCell('M20')->setValue($tong_phatgiao_41den61);
        $this->Excel->ActiveSheet->getCell('N20')->setValue($tong_phatgiao_tren61);

        $this->Excel->ActiveSheet->getCell('O20')->setValue($tong_tinlanh_duoi20);
        $this->Excel->ActiveSheet->getCell('P20')->setValue($tong_tinlanh_21den40);
        $this->Excel->ActiveSheet->getCell('Q20')->setValue($tong_tinlanh_41den61);
        $this->Excel->ActiveSheet->getCell('R20')->setValue($tong_tinlanh_tren61);

        $this->Excel->ActiveSheet->getCell('S20')->setValue($tong_caodai_duoi20);
        $this->Excel->ActiveSheet->getCell('T20')->setValue($tong_caodai_21den40);
        $this->Excel->ActiveSheet->getCell('U20')->setValue($tong_caodai_41den61);
        $this->Excel->ActiveSheet->getCell('V20')->setValue($tong_caodai_tren61);

        $this->Excel->ActiveSheet->getCell('W20')->setValue($tong_hoigiao_duoi20);
        $this->Excel->ActiveSheet->getCell('X20')->setValue($tong_hoigiao_21den40);
        $this->Excel->ActiveSheet->getCell('Y20')->setValue($tong_hoigiao_41den61);
        $this->Excel->ActiveSheet->getCell('Z20')->setValue($tong_hoigiao_tren61);

        $this->Excel->ActiveSheet->getCell('AA20')->setValue($tong_tdcsphvn_duoi20);
        $this->Excel->ActiveSheet->getCell('AB20')->setValue($tong_tdcsphvn_21den40);
        $this->Excel->ActiveSheet->getCell('AC20')->setValue($tong_tdcsphvn_41den61);
        $this->Excel->ActiveSheet->getCell('AD20')->setValue($tong_tdcsphvn_tren61);

        $this->Excel->ActiveSheet->getCell('AE20')->setValue($tong_tinnguong_duoi20);
        $this->Excel->ActiveSheet->getCell('AF20')->setValue($tong_tinnguong_21den40);
        $this->Excel->ActiveSheet->getCell('AG20')->setValue($tong_tinnguong_41den61);
        $this->Excel->ActiveSheet->getCell('AH20')->setValue($tong_tinnguong_tren61);

        return $this->Excel->save($filename);
    }
}
