<?php

class UtilityComponent extends Component
{
    public function retrieveNumberFromString($string)
    {
        $matches = [];
        preg_match_all('/[\s][0-9\.\,]*/', ' ' . $string, $matches);
        $matches = array_filter($matches);
        $number = isset($matches[0]) ? $matches[0] : 0;

        if ($number) {
            $number = array_filter($number, function ($target) {
                return !empty(trim($target));
            });

            $number = current($number);
            $number = str_replace(',', '.', trim($number));

            $decimal = '';
            $tmp = explode('.', $number);
            if (count($tmp) > 1) {
                $check = end($tmp);
                if (mb_strlen($check) < 3) {
                    $decimal = '.' . $check;
                    array_pop($tmp);
                }
            }

            $number = implode('', $tmp) . $decimal;
        }

        return $number;
    }

    public function seperateNumberFromString($string, $token = ';')
    {
        $string = explode($token, $string);

        $result = [];
        foreach ($string as $str) {
            $result[] = self::retrieveNumberFromString($str);
        }

        return $result;
    }

    public function sumList($list)
    {
        return array_sum($list);
    }

    public function slug($strAccent = '', $sepchar = '-')
    {
        $strfrom = ' Á À Ả Ã Ạ Â Ấ Ầ Ẩ Ẫ Ậ Ă Ắ Ằ Ẳ Ẵ Ặ Đ É È Ẻ Ẽ Ẹ Ê Ế Ề Ể Ễ Ệ Í Ì Ỉ Ĩ Ị Ó Ò Ỏ Õ Ọ Ơ Ớ Ờ Ở Ỡ Ợ Ô Ố Ồ Ổ Õ Ộ Ú Ù Ủ Ũ Ụ Ư Ứ Ừ Ử Ữ Ự Ý Ỳ Ỷ Ỹ Ỵ';
        $strto = ' A A A A A A A A A A A A A A A A A D E E E E E E E E E E E I I I I I O O O O O O O O O O O O O O O O O U U U U U U U U U U U Y Y Y Y Y';

        $strfrom .= ' á à ả ã ạ â ấ ầ ẩ ẫ ậ ă ắ ằ ẳ ẵ ặ đ é è ẻ ẽ ẹ ê ế ề ể ễ ệ í ì ỉ ĩ ị ó ò ỏ õ ọ ơ ớ ờ ở ỡ ợ ô ố ồ ổ ỗ ộ ú ù ủ ũ ụ ư ứ ừ ử ữ ự ý ỳ ỷ ỹ ỵ';
        $strto .= ' a a a a a a a a a a a a a a a a a d e e e e e e e e e e e i i i i i o o o o o o o o o o o o o o o o o u u u u u u u u u u u y y y y y';

        $fromarr = explode(' ', $strfrom);
        $toarr = explode(' ', $strto);

        $dicarr = [];
        for ($i = 1; $i < count($fromarr); $i++) {
            $dicarr[$fromarr[$i]] = $toarr[$i];
        }


        $strNoAccent = strtr($strAccent, $dicarr);

        if (isset($sepchar)) {
            $strNoAccent = str_replace(' ', $sepchar, $strNoAccent);
            $strNoAccent = str_replace($sepchar.$sepchar, $sepchar, $strNoAccent);
        }

        return mb_strtolower($strNoAccent);
    }

    private function slug2($string)
    {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

        return strtolower(str_replace(' ', '-', trim($string)));
    }
}
