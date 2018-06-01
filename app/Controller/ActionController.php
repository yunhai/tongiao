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
        $this->_type_text = array(
            TONG_HOP_CSTG_TRUNG_TU => 'TONG HOP CSTG TRUNG TU',
            DS_CSTT => 'ds cstt',
            DSCS_BAO_TRO_XA_HOI => 'DSCS BAO TRO XA HOI',
            DS_CS_THAM_GIA_CT_XH_CAP_XA => 'DS CS THAM GIA CT-XH CAP XA',
            DS_CS_THAM_GIA_CT_XH_CAP_HUYEN => 'DS CS THAM GIA CT-XH CAP HUYEN',
            DS_CS_THAM_GIA_CT_XH_CAP_TINH => 'DS CS THAM GIA CT-XH CAP TINH',
            DS_CS_DT_BD => 'DS CS ĐT-BD',
            DS_CHUC_SAC_PCPP => 'DS CHUC SAC PCPP',
            DANH_SACH_TU_SI => 'DANH SACH TU SI',
            DS_CHUC_SAC_KO_CO_CHUC_VU => 'DS CHUC SAC KO CO CHUC VU',
            DS_CHUC_SAC_CO_CHUC_VU => 'DS CHUC SAC CO CHUC VU',
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
}
