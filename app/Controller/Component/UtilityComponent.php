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
}
