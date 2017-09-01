<?php

class TableHelperComponent extends Component {

    function table($name, $ar, $limit = 255) {
        APP::import("Model", array("Admin"));
        $this->Admin = new Admin();
        $drop = "DROP TABLE IF EXISTS {$name} ; ";
        $start = "CREATE TABLE {$name} (`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,";
        $fiedl = $this->genarateTable($ar, $limit);
        $end = "`is_add` INT(10) DEFAULT 0, `created_user` INT(10) DEFAULT 0,`created` DATETIME DEFAULT NULL,`modified` DATETIME DEFAULT NULL,PRIMARY KEY (`id`)) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;";
        $sql = $drop . $start . $fiedl . $end;
        $this->Admin->query($sql);
    }

    function DecodeStringAuto($ar) {
        $list_key = array();
        $count = 0;
        foreach ($ar as $key => $val) {
            $list_key[$key] = $key;
            $list_key[$key] = $key;
            $count = MAX($count, count($val));
        }
        $str = "";
        for ($i = 0; $i < $count; $i++) {
            $is_null = 1;
            foreach ($list_key as $key) {
                if (!empty($ar[$key][$i]))
                    $is_null = 0;
            }
            if ($is_null == 0) {
                $value = "";
                // pr($ar[$key][$i]);
                foreach ($list_key as $key) {
                    if (!empty($ar[$key][$i]))
                        $string = $key . MODE_1 . $ar[$key][$i];
                    else
                        $string = "";
                    if (!empty($string))
                        $value .= empty($value) ? $string : MODE_2 . $string;
                }
                if (!empty($value))
                    $str .= empty($str) ? $value : MODE_3 . $value;
            }
        }
        return $str;
    }

    function decodeDataSave($ar, $fiedlAuto) {
        foreach ($ar as $key => $val) {
            foreach ($fiedlAuto as $value) {
                if ($key == $value) {
                    $data = $this->DecodeStringAuto($val);
                    $ar[$key] = $data;
                }
            }
        }
        return $ar;
    }

    function splitStr($str) {
        $result = array();
        if (!empty($str)) {
            $ar_1 = split(MODE_3, $str);
            foreach ($ar_1 as $val) {
                $ar = array();
                $v = explode(MODE_2, $val);
                foreach ($v as $value) {
                    $ex = explode(MODE_1, $value);
                    if (count($ex) >= 2) {
                        $ar[$ex[0]] = $ex[1];
                    }
                }
                $result[] = $ar;
            }
        }
        return $result;
    }

    function encodeDataSave($ar, $fiedlAuto) {
        foreach ($ar as $key => $val) {
            foreach ($fiedlAuto as $value) {
                if ($key == $value) {
                    if (!empty($val)) {
                        $data = $this->splitStr($val);
                        $ar[$key] = $data;
                    }
                }
            }
        }
        return $ar;
    }

    function genarateTable($ar, $limit) {
        $str = "";
        foreach ($ar as $key => $val) {
            $value = "";
            $val = strtolower($val);
            $key = strtolower($key);
            if ($val == "radio" || $val == "checkbox") {
                $value = "`{$key}`  int(11) DEFAULT '0'";
            } else if ($val == "datetime") {
                $value = "`{$key}`  date ";
            } else if ($val == "date") {
                $value = "`{$key}`  date ";
            } else if ($val == "string") {
                //$value = "`{$key}`  varchar({$limit}) COLLATE utf8_unicode_ci NOT NULL DEFAULT ''";
                $value = "`{$key}`  text COLLATE utf8_unicode_ci NOT NULL ";
            } else if ($val == "textarea") {
                $value = "`{$key}`  text COLLATE utf8_unicode_ci NOT NULL ";
            } else if ($val == "year") {
                $value = "`{$key}`  int(11) DEFAULT '0'";
            }
            if (!empty($value))
                $str .= empty($str) ? $value : "," . $value;
        }
        if (!empty($str))
            $str .=",";
        return $str;
    }

}
