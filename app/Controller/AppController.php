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
class AppController extends Controller {

    public $components = array(
        'Session',
        'CustomPaginator',
        "TableHelper",
    );
    public $resultModel = array();
    public $fiedlAuto = array();

    public function beforeFilter() {
        $session_data = $this->Session->read('admin');
        $controller = strtolower($this->params["controller"]);
        if (empty($session_data) && $controller != "admin") {
            $this->redirect("/Admin");
        }
    }

    function convertAr($ar) {
        foreach ($ar as $key => $val) {
            foreach ($this->fiedlAuto as $value) {
                if ($key == $value) {
                    $ar[$key] = "";
                    break;
                }
            }
        }
        return $ar;
    }

    function getLast($ar = array()) {
       
        foreach ($ar as $key => $val) {
            $is_check = 0;
            foreach ($this->fiedlAuto as $k => $v) {
                if ($k == $key) {
                    $this->resultModel[$v] = "textarea";
                    $is_check = 1;
                    break;
                }
            }
            if ($is_check)
                continue;
            if (!empty($val["value"])) {
                $this->resultModel[$val["value"]] = $val["key"];
            } else {
                $this->getLast($val);
            }
        }
    }

    function convertPhone($phone) {
        $phone = trim($phone);
        if (strpos($phone, '+') === false) {
            $phone = "+" . $phone;
        }
        return $phone;
    }

    function getShortText($str, $max_cut = 160) {
//        $str = $this->supertrim((($str)));
        $length = mb_strlen($str, 'utf-8');
        if ($length > $max_cut) {
            return mb_substr($str, 0, $max_cut, 'utf-8') . '・・・';
        }
        return $str;
    }

    function supertrim($str) {
        return trim(preg_replace('/\s+/', ' ', $str));
    }

}
