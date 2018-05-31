<?php
App::uses('Component', 'Controller');
App::import('Vendor', 'PHPExcel', array('file' => 'Excel/PHPExcel.php'));

/**
 * For exporting excel using template
 *
 * @package ExcelComponent
 * @extend Component
 * @author Mai Nhut Tan
 * @since 2013.07.01
 */
class ExcelComponent extends Component
{
    public $defaultPlaceHolder = null;

    protected $filter = '/[\\\$\{]+([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)[\\\$\}]+/u';
    protected $controller;
    protected $Reader = null;
    protected $Writer = null;
    public $Handler = null;
    protected $_variables = array();
    public $ActiveSheet = null;
    protected $_properties = null;

    /**
     * Override constructor
     *
     * @method initialize
     * @param Controller $controller
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function initialize(Controller $controller)
    {
        ini_set('zlib.output_compression', 'Off');
        ob_start();

        // $this->controller = $controller;
        $this->Reader = new PHPExcel_Reader_Excel5();
    }


    /**
     * Load template from XLS file
     *
     * @method load
     * @param string $path
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function load($path)
    {
        if (!file_exists($path)) {
            throw new Exception(__('COMMON_ERR_MSG001'), 1);
            return false;
        }

        if (!$this->Reader->canRead($path)) {
            throw new Exception(__('COMMON_ERR_MSG002'), 1);
            return false;
        }

        $this->Handler = $this->Reader->load($path);
        $this->Writer = new PHPExcel_Writer_Excel5($this->Handler);
        $this->Writer->setTempDir(TMP);

        $this->setActiveSheet(0);
    }


    /**
     * Set author for XLS
     *
     * @method setAuthor
     * @param string $name
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setAuthor($name)
    {
        $this->_properties->setCreator($name);
    }


    /**
     * Set title for XLS
     *
     * @method setTitle
     * @param string $title
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setTitle($title)
    {
        $this->_properties->setTitle($title);
    }


    /**
     * Set subject for XLS
     *
     * @method setSubject
     * @param string $subject
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setSubject($subject)
    {
        $this->_properties->setSubject($subject);
    }

    /**
     * Set active sheet
     *
     * @method setActiveSheet
     * @param int $num
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setActiveSheet($num)
    {
        $this->Handler->setActiveSheetIndex($num);
        $this->ActiveSheet = $this->Handler->getActiveSheet();
        $this->_properties = $this->Handler->getProperties();
    }

    /**
     * Get max column index
     *
     * @method getMaxCols
     * @param
     * @return char
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function getMaxCols()
    {
        return $this->ActiveSheet->getHighestColumn();
    }

    /**
     * Get max row index
     *
     * @method getMaxRows
     * @param
     * @return uint
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function getMaxRows()
    {
        return $this->ActiveSheet->getHighestRow();
    }

    /**
     * Reset variable list
     *
     * @method resetVariables
     * @param
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function resetVariables()
    {
        $this->_variables = array();
    }

    /**
     * Get current variables
     *
     * @method getVariables
     * @param string $name
     * @return mixed
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function getVariables($name = null)
    {
        return $name === null ? $this->_variables : $this->_variables[$name];
    }

    /**
     * Set variable value
     *
     * @method setVariable
     * @param string $name, string $value
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setVariable($name, $value)
    {
        $this->_variables[$name] = $value;
    }

    /**
     * Set variable list
     *
     * @method setVariableArray
     * @param array $arr
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setVariableArray($arr)
    {
        $this->_variables = $arr;
    }

    /**
     * Set size = -1 for a row
     *
     * @method setAutosize
     * @param int $row
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setAutosize($row = null)
    {
        $this->setRowSize($row, -1);
    }

    /**
     * Set size = -1 for a row
     *
     * @method setAutosizeByContents
     * @param string $cell, int $line_max_char, float $row_size
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setAutosizeByContents($cell = null, $line_max_char = 75, $row_size = 12.85)
    {
        $cell = $this->ActiveSheet->getCell($cell);
        if (!$cell) {
            return;
        }

        $current_row = $cell->getRow();
        $content = $cell->getValue();

        //emulating wrapping long text
        $after_wrap = $this->__wrap($content, $line_max_char, "\n", true);
        $lines = preg_split('/(\r\n|\n)/', $after_wrap);
        $num_line = count($lines);

        //original row height
        $original_row_size = $this->ActiveSheet->getRowDimension($cell->getRow())->getRowHeight();

        //calculated row height
        $row_size = $num_line * $row_size;

        //get row range if it is merged cell
        $row_range = $this->__getCellRowIndexes($cell);
        $from_row = $row_range[0];
        $to_row = $row_range[1];

        //exclude other row heights
        for ($i = $from_row; $i <= $to_row; $i++) {
            if ($i == $current_row) {
                continue;
            }
            $row_size -= $this->ActiveSheet->getRowDimension($i)->getRowHeight();
        }

        $this->setWordWrap($cell->getCoordinate(), true);

        //set extended row height
        if ($row_size > $original_row_size) {
            $this->ActiveSheet->getRowDimension($from_row)->setRowHeight($row_size);
        }
    }

    /**
     * Set size = -1 for a row
     *
     * @method setRowSize
     * @param int $row, $int size
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.12
     */
    public function setRowSize($row = null, $size = -1)
    {
        if ($row === null) {
            $max = $this->getMaxRows();
            for ($i = 1; $i <= $max; $i++) {
                $this->setRowSize($i, $size);
            }

            return;
        }

        $row = intval($row);
        if (empty($row)) {
            return;
        } else {
            $this->ActiveSheet->getRowDimension($row)->setRowHeight($size);
        }
    }

    /**
     * Set text wrapping for a cell
     *
     * @method setAutosize
     * @param string $cellName, boolean $bool
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function setWordWrap($cellName = null, $bool = true)
    {
        if ($cellName === null) {
            $maxRows = $this->getMaxRows();
            $maxCols = $this->getMaxCols();
            $colIndexes = array();

            for ($c = 'A'; $c <= 'Z'; $c++) {
                $colIndexes[] = $c;
                if ($c == $maxCols) {
                    break;
                }
            }

            for ($r = 1; $r <= $maxRows; $r++) {
                foreach ($colIndexes as $c) {
                    $this->ActiveSheet->getStyle("{$c}{$r}")->getAlignment()->setWrapText($bool);
                }
            }
        } else {
            $this->ActiveSheet->getStyle($cellName)->getAlignment()->setWrapText($bool);
        }
    }

    /**
     * Compile template with given variables
     *
     * @method compile
     * @param
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function compile()
    {
        $maxRows = $this->getMaxRows();
        $maxCols = $this->getMaxCols();
        $colIndexes = array();

        for ($c = 'A'; $c <= 'Z'; $c++) {
            $colIndexes[] = $c;
            if ($c == $maxCols) {
                break;
            }
        }

        for ($r = 1; $r <= $maxRows; $r++) {
            foreach ($colIndexes as $c) {
                $row = $this->ActiveSheet->getCell("{$c}{$r}");
                $value = $row->getValue();

                $compiled_value = $this->__mergeVariables($value, $this->_variables);
                //if(!empty($value)) pr("{$c}{$r}: {$value} | {$compiled_value}");
                $row->setValue($compiled_value);
            }
        }

        $this->ActiveSheet->setSelectedCells("A1:{$maxCols}{$maxRows}");
    }

    /**
     * Save to file or download
     *
     * @method save
     * @param string $filename, string $path
     * @return mixed
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    public function save($filename, $path = null)
    {
        if ($path === null) {

            //set headers
            header('Cache-Control: cache, must-revalidate');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1'); //IE
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Disposition: inline; filename="'.$filename.'.xls"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Type: application/download');
            header('Content-Type: application/force-download');
            header('Content-Type: application/vnd.ms-excel');
            header('Expires: 0');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
            header('Pragma: public');
            header('Server: Haken Documents');
            header('X-Powered-By: Haken System');

            ob_end_clean();
            $this->Writer->save('php://output');
            exit();
        } else {
            @chmod($path, 0777);
            $file_path = $path . DS . $filename.'.xls';
            $this->Writer->save($file_path);
            return $file_path;
        }
    }

    /**
      * Load text template and merge with given variables
      *
      * @method __mergeVariables
      * @param string $text, array $var_arr
      * @return string
      * @author Mai Nhut Tan
      * @since 2013.07.01
      */
    protected function __mergeVariables($text, $var_arr)
    {
        $used_vars = array();

        //search for used variables
        if (preg_match_all($this->filter, $text, $var_list)) {
            foreach ($var_list[1] as $match) {
                $used_vars[$match] = ($this->defaultPlaceHolder === null ? "#$match#" : $this->defaultPlaceHolder);
            }
        }

        $used_vars = array_merge($used_vars, $var_arr);

        extract($used_vars);
        $this->__parseVariables($text);
        $text = str_replace('"', '\"', $text);

        $result = '';

        try {
            eval('$result = "'.$text.'";');
        } catch (Exception $e) {
        }

        return $result;
    }

    /**
     * Parse variables from text template
     *
     * @method __parseVariables
     * @param string &$text
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.01
     */
    protected function __parseVariables(&$text)
    {
        //escape all dollar signs
        $text = str_replace('$', '\$', $text);
        //parse variables
        $text = preg_replace($this->filter, '{\$$1}$2', $text);

        return $text;
    }

    /**
     * Wrap long unicode text
     *
     * @method __wrap
     * @param string $str, string $width, string $break, boolean $cut, string $charset
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.12
     */
    protected function __wrap($str, $width, $break, $cut = true, $charset = null)
    {
        if ($charset === null) {
            $charset = 'UTF-8';
        }

        $pieces = explode($break, $str);
        $result = array();
        foreach ($pieces as $piece) {
            $current = $piece;
            while ($cut && mb_strlen($current) > $width) {
                $result[] = mb_substr($current, 0, $width, $charset);
                $current = mb_substr($current, $width, 2048, $charset);
            }
            $result[] = $current;
        }
        return implode($break, $result);
    }

    /**
     * Get row range of a merged cell. For example: if merged cell is A3:M6 then returns array(3,6)
     *
     * @method __getCellRowIndexes
     * @param mixed $cell
     * @return void
     * @author Mai Nhut Tan
     * @since 2013.07.12
     */
    protected function __getCellRowIndexes($cell = null)
    {
        if (is_string($cell)) {
            $cell = $this->ActiveSheet->getCell($cell);
        }

        if (!$cell) {
            return null;
        }

        $in_range = null;
        $merged_cells = $this->ActiveSheet->getMergeCells();
        foreach ($merged_cells as $range) {
            if ($cell->isInRange($range)) {
                $in_range = $range;
                break;
            }
        }

        if (!$in_range) {
            return array($cell->getRow(), $cell->getRow());
        }

        $range = explode(':', $in_range);

        return array(
            $this->ActiveSheet->getCell($range[0])->getRow(),
            $this->ActiveSheet->getCell($range[1])->getRow()
        );
    }
}
