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
            // TONG_HOP_DAT_DAI => 'TONG HOP DAT DAI',
            TH_TON_GIAO_CO_SO => 'TH TON GIAO CO SO',
            // TH_CO_SO_TON_GIAO => 'TH CO SO TON GIAO',
            TONG_HOP_DI_TICH => 'TONG HOP DI TICH',
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

    public function download($type = null)
    {
        $this->autoLayout = false;
        $this->autoRender = false;

        $conditions = array();

        if ($this->request->is('post')) {
            $request = $this->request->data;
            $type = $request['type'];
            if (array_key_exists('prefecture_'.$type, $request)) {
                $conditions['prefecture'] = $request['prefecture_'.$type];
            }
            if (array_key_exists('ton_giao_'.$type, $request)) {
                $conditions['ton_giao'] = $request['ton_giao_'.$type];
            }
        }

        return $this->export($type, $conditions);
    }

    public function export($type, $conditions)
    {
        $config = Configure::read('export.excel.' . $type);

        extract($config);
        $component = $this->Components->load($component);

        $this->excelTemplate($type);

        $config = $component->layout($conditions['ton_giao']);
        $this->excelLayout($config);

        $data = $component->export($conditions);
        $this->excelData($data, $config);

        $this->excelRendered($component, $data, $config);
        $this->Excel->save($filename);
    }

    private function excelRendered($component, $data, $config)
    {
        $rendered = $component->rendered($data, $config);
        extract($rendered);
        if (!empty($merge)) {
            foreach ($merge as $range) {
                $this->Excel->ActiveSheet->mergeCells($range);
            }
        }
    }

    private function excelTemplate($type)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . "template{$type}.xls";

        $this->Excel->load($source);
    }

    private function excelLayout($config)
    {
        extract($config);

        $buffer_text = [];
        if (!empty($buffer)) {
            foreach ($buffer as $row => $list) {
                $tmp = $column_begin;
                foreach ($list as $i => $item) {
                    $low = $this->getColumnAddress($tmp) . $row;

                    $tmp += $item['size'][1];
                    $high = $this->getColumnAddress($tmp - 1) . ($row + $item['size'][0] - 1);
                    $range = $low . ':' . $high;

                    $buffer_text["{$row}.{$i}"] = $this->Excel->ActiveSheet->getCell($low)->getValue();
                    $this->Excel->ActiveSheet->unmergeCells($range);

                    if (!empty($item['merge'])) {
                        foreach ($item['merge'] as $range) {
                            $this->Excel->ActiveSheet->mergeCells($range);
                        }
                    }
                }
            }
        }

        $tmp = $column_begin;
        foreach ($column_structure as $col => $step) {
            if (in_array($col, $column_remove)) {
                $begin = $this->getColumnAddress($tmp);
                $end = $this->getColumnAddress($tmp + $step - 1);

                if ($begin != $end) {
                    $this->Excel->ActiveSheet->unmergeCells("{$begin}{$row_header_index}:{$end}{$row_header_index}");
                }

                $this->Excel->ActiveSheet->removeColumn($begin, $step);
            } else {
                $tmp += $step;
            }
        }

        if ($buffer) {
            foreach ($buffer as $row => $list) {
                $tmp = $column_begin;
                foreach ($list as $i => $item) {
                    $low = $this->getColumnAddress($tmp) . $row;

                    foreach ($item['group'] as $j => $value) {
                        if (in_array($value, $column_remove)) {
                            unset($item['group'][$j]);
                            continue;
                        }
                        $tmp += $column_structure[$value];
                    }

                    if (!$item['group']) {
                        continue;
                    }

                    $high = $this->getColumnAddress($tmp - 1) . ($row + $item['size'][0] - 1);
                    $range = $low . ':' . $high;

                    $this->Excel->ActiveSheet->mergeCells($range);
                    $this->Excel->ActiveSheet
                            ->getCell($low)
                            ->setValue($buffer_text["{$row}.{$i}"]);

                    $alignment = $this->Excel->ActiveSheet
                            ->getStyle($range)
                            ->getAlignment();
                    $alignment->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $alignment->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                }
            }
        }
    }

    private function excelData($data, $config)
    {
        extract($config);
        $count = count($data);

        foreach ($data as $index => $row_data) {
            $column_index = 1;

            foreach ($row_data as $cell_data) {
                $cell_index = $this->getColumnAddress($column_index) . $row_data_index;

                $this->Excel->ActiveSheet->getCell($cell_index)->setValue($cell_data);
                $this->setExcelCellStyle($cell_index, $row_data_index);
                if ($count === 1) {
                    $fonts = array('font' => array('bold' => true, 'name' => 'Times New Roman'));
                    $this->Excel->ActiveSheet->getStyle($cell_index)->applyFromArray($fonts);
                }
                $column_index++;
            }

            $count--;
            $row_data_index++;
        }

        if ($data && $cell_total_count) {
            $row_data_index = $row_data_index - 1;

            $address = $this->getColumnAddress($cell_total_count);
            $begin = "A{$row_data_index}";
            $range = "{$begin}:{$address}{$row_data_index}";
            $this->Excel->ActiveSheet->mergeCells($range);
            $this->Excel->ActiveSheet->getCell($begin)->setValue('TỔNG');
        }
    }

    private function getColumnAddress($index)
    {
        $map = [
            'A', 'B', 'C', 'D', 'E', 'F',
            'G', 'H', 'I', 'J', 'K', 'L',
            'M', 'N', 'O', 'P', 'Q', 'R',
            'S', 'T', 'U', 'V', 'W', 'X',
            'Y', 'Z'
        ];

        $index = $index - 1;
        $div = intval($index / 26) - 1;
        $mod = ($index % 26);

        $result = '';
        if ($div >= 0) {
            $result = $map[$div];
        }
        $result .= $map[$mod];

        return $result;
    }

    public function setExcelCellStyle($cell_index, $row_data_index)
    {
        $borders = array(
          'borders' => array(
              'allborders' => array(
                  'style' => PHPExcel_Style_Border::BORDER_THIN
              )
          )
        );

        $this->Excel->ActiveSheet->getRowDimension($row_data_index)->setRowHeight(25);

        $style = $this->Excel->ActiveSheet->getStyle($cell_index);
        $style->getFont()->setSize(8);
        $style->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $style->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $style->applyFromArray($borders);
        return true;
    }

    /**
     * TỔNG HỢP CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG ĐÃ ĐƯỢC TRÙNG TU, TÔN TẠO
     */
    protected function __getType6Data($conditions)
    {
        $component = $this->Components->load('Cstgtrungtu');
        $data = $component->export($conditions);

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

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template6.xls';
        $filename = "{$this->_type_text[6]}";
        $this->Excel->load($source);

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
     * DANH SÁCH CƠ SỞ THỜ TỰ TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
     */
    protected function __getType8Data()
    {
        $component = $this->Components->load('ExportThCsTtTg');
        $data = $component->export();

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template8.xls';
        $filename = "{$this->_type_text[8]}";
        $this->Excel->load($source);

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

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template9.xls';
        $filename = "{$this->_type_text[9]}";
        $this->Excel->load($source);

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
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template11.xls';
        $filename = "{$this->_type_text[11]}";
        $this->Excel->load($source);

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
        $this->__createTemplate12($data);
    }

    public function __createTemplate12($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template12.xls';
        $filename = "{$this->_type_text[12]}";
        $this->Excel->load($source);

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
        $this->__createTemplate13($data);
    }

    public function __createTemplate13($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template13.xls';
        $filename = "{$this->_type_text[13]}";
        $this->Excel->load($source);

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
        $this->__createTemplate17($data);
    }

    public function __createTemplate17($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template17.xls';
        $filename = "{$this->_type_text[17]}";
        $this->Excel->load($source);

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
        $this->__createTemplate19($data);
    }

    public function __createTemplate19($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template19.xls';
        $filename = "{$this->_type_text[19]}";
        $this->Excel->load($source);

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
    protected function __getType20Data($conditions)
    {
        $component = $this->Components->load('ExportThCsPc');
        $data = $component->export($conditions);

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template20.xls';
        $filename = "{$this->_type_text[20]}";
        $this->Excel->load($source);

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
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_linhmuc']);
                        break;
                    case 'G'://PHẬT GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_total']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_hoathuong']);
                        break;
                    case 'I':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_thuongtoa']);
                        break;
                    case 'J':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_nitruong']);
                        break;
                    case 'K':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsacnhatuhanhphatgiao_nisu']);
                        break;
                    case 'L'://TIN LÀNH
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_total']);
                        break;
                    case 'M':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsu']);
                        break;
                    case 'N':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsunc']);
                        break;
                    case 'O':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_truyendao']);
                        break;
                    case 'P'://CAO ĐÀI
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_total']);
                        break;
                    case 'Q':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_phosu']);
                        break;
                    case 'R':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_giaosu']);
                        break;
                    case 'S':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauthang_giaohuu']);
                        break;
                    case 'T':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucsaccaodai_phamsac_ntn_cauphong_lesanh']);
                        break;
                    case 'U'://HỒI GIÁO
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_total']);
                        break;
                    case 'V':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_hakim']);
                        break;
                    case 'W':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_naep']);
                        break;
                    case 'X':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_ahly']);
                        break;
                    case 'Y':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_khotip']);
                        break;
                    case 'Z':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_imam']);
                        break;
                    case 'AA'://TĐCSPHVN
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_tuon']);
                        break;
                    case 'AB':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_total']);
                        break;
                    case 'AC':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_phogiangsu']);
                        break;
                    case 'AD':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien']);
                        break;
                    case 'AE':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_ysi']);
                        break;
                    case 'AF':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Chucviectinhdocusiphathoivietnam_ysinh']);
                        break;
                    default:
                        echo 'TH CHUC SAC PCPP';
                }
            }
            $this->Excel->ActiveSheet->getCell('C19')->setValue($tong3 += $result['total']);
            $this->Excel->ActiveSheet->getCell('D19')->setValue($tong4 += $result['Chucsacnhatuhanhconggiaotrieu_total']);
            $this->Excel->ActiveSheet->getCell('E19')->setValue($tong5 += $result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_giammuc']);
            $this->Excel->ActiveSheet->getCell('F19')->setValue($tong6 += $result['Chucsacnhatuhanhconggiaotrieu_phamsactrongtongiao_namphong_linhmuc']);
            $this->Excel->ActiveSheet->getCell('G19')->setValue($tong7 += $result['Chucsacnhatuhanhphatgiao_total']);
            $this->Excel->ActiveSheet->getCell('H19')->setValue($tong8 += $result['Chucsacnhatuhanhphatgiao_hoathuong']);
            $this->Excel->ActiveSheet->getCell('I19')->setValue($tong9 += $result['Chucsacnhatuhanhphatgiao_thuongtoa']);
            $this->Excel->ActiveSheet->getCell('J19')->setValue($tong10 += $result['Chucsacnhatuhanhphatgiao_nitruong']);
            $this->Excel->ActiveSheet->getCell('K19')->setValue($tong11 += $result['Chucsacnhatuhanhphatgiao_nisu']);
            $this->Excel->ActiveSheet->getCell('L19')->setValue($tong12 += $result['Chucsactinlanh_total']);
            $this->Excel->ActiveSheet->getCell('M19')->setValue($tong13 += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsu']);
            $this->Excel->ActiveSheet->getCell('N19')->setValue($tong14 += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_mucsunc']);
            $this->Excel->ActiveSheet->getCell('O19')->setValue($tong15 += $result['Chucsactinlanh_phamsactrongtongiao_ntn_duocphong_truyendao']);
            $this->Excel->ActiveSheet->getCell('P19')->setValue($tong16 += $result['Chucsaccaodai_total']);
            $this->Excel->ActiveSheet->getCell('Q19')->setValue($tong17 += $result['Chucsaccaodai_phamsac_ntn_cauthang_phosu']);
            $this->Excel->ActiveSheet->getCell('R19')->setValue($tong18 += $result['Chucsaccaodai_phamsac_ntn_cauthang_giaosu']);
            $this->Excel->ActiveSheet->getCell('S19')->setValue($tong19 += $result['Chucsaccaodai_phamsac_ntn_cauthang_giaohuu']);
            $this->Excel->ActiveSheet->getCell('T19')->setValue($tong20 += $result['Chucsaccaodai_phamsac_ntn_cauphong_lesanh']);
            $this->Excel->ActiveSheet->getCell('U19')->setValue($tong21 += $result['Chucviechoigiao_total']);
            $this->Excel->ActiveSheet->getCell('V19')->setValue($tong22 += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_hakim']);
            $this->Excel->ActiveSheet->getCell('W19')->setValue($tong23 += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_naep']);
            $this->Excel->ActiveSheet->getCell('X19')->setValue($tong24 += $result['Chucviechoigiao_ahly']);
            $this->Excel->ActiveSheet->getCell('Y19')->setValue($tong25 += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_khotip']);
            $this->Excel->ActiveSheet->getCell('Z19')->setValue($tong26 += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_imam']);
            $this->Excel->ActiveSheet->getCell('AA19')->setValue($tong27 += $result['Chucviechoigiao_phamsactrongtongiao_ntn_bonhiem_tuon']);
            $this->Excel->ActiveSheet->getCell('AB19')->setValue($tong28 += $result['Chucviectinhdocusiphathoivietnam_total']);
            $this->Excel->ActiveSheet->getCell('AC19')->setValue($tong29 += $result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_phogiangsu']);
            $this->Excel->ActiveSheet->getCell('AD19')->setValue($tong30 += $result['Chucviectinhdocusiphathoivietnam_phamsactrongtongiao_ntn_bonhiem_thuyettrinhvien']);
            $this->Excel->ActiveSheet->getCell('AE19')->setValue($tong31 += $result['Chucviectinhdocusiphathoivietnam_ysi']);
            $this->Excel->ActiveSheet->getCell('AF19')->setValue($tong32 += $result['Chucviectinhdocusiphathoivietnam_ysinh']);

            $r++;
        }

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
        $this->__createTemplate23($data);
    }

    public function __createTemplate23($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template23.xls';
        $filename = "{$this->_type_text[23]}";
        $this->Excel->load($source);

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
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue('');
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
        $this->__createTemplate24($data);
    }

    public function __createTemplate24($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template24.xls';
        $filename = "{$this->_type_text[24]}";
        $this->Excel->load($source);

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
        $this->__createTemplate25($data);
    }

    public function __createTemplate25($data)
    {
        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template25.xls';
        $filename = "{$this->_type_text[25]}";
        $this->Excel->load($source);

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
     * TONG HOP CHUC VIEC
     * BẢNG TỔNG HỢP CHỨC VIỆC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
     **/
    protected function __getType26Data($conditions)
    {
        $component = $this->Components->load('ExportThCvTinh');
        $data = $component->export($conditions);

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template26.xls';
        $filename = "{$this->_type_text[26]}";
        $this->Excel->load($source);

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
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_banhanhgiao']);
                        break;
                    case 'F':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_thuongvubhg']);
                        break;
                    case 'G':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_lanhdaocachoidoantucapgxtrolen']);
                        break;
                    case 'H':
                        $this->Excel->ActiveSheet->getCell("{$c}{$r}")->setValue($result['Giaoxu_khac']);
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
            $tong_conggiao_banhanhgiao += $result['Giaoxu_banhanhgiao'];
            $tong_conggiao_thuongvubhg += $result['Giaoxu_thuongvubhg'];
            $tong_conggiao_lanhdaocachoidoantucapgiaoxutrolen += $result['Giaoxu_lanhdaocachoidoantucapgxtrolen'];
            $tong_conggiao_khac += $result['Giaoxu_khac'];

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
    protected function __getType27Data($conditions)
    {
        $component = $this->Components->load('ExportThTs');
        $data = $component->export($conditions);

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template27.xls';
        $filename = "{$this->_type_text[27]}";
        $this->Excel->load($source);

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
    protected function __getType28Data($conditions)
    {
        $component = $this->Components->load('ExportThCskcv');
        $data = $component->export($conditions);

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template28.xls';
        $filename = "{$this->_type_text[28]}";
        $this->Excel->load($source);

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
    protected function __getType29Data($conditions)
    {
        $component = $this->Components->load('ExportThCscv');
        $data = $component->export($conditions);

        $source = WWW_ROOT . 'files' . DS . 'templates' . DS . 'template29.xls';
        $filename = "{$this->_type_text[29]}";
        $this->Excel->load($source);

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
}
