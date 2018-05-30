<?php

class ProvinceComponent extends Component
{
    public function retrieveProvinceCode($string = '')
    {
        App::uses('UtilityComponent', 'Controller/Component');
        $component = new UtilityComponent(new ComponentCollection());

        $list = $this->getProvince();

        $string = $component->slug($string);

        foreach ($list as $code => $name) {
            if (strpos($string, $code) !== false) {
                return $code;
            }
        }

        return '';
    }

    public function getProvince($filter = [])
    {
        $result = [
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

        if ($filter) {
            return array_intersect_key($result, array_flip($filter));
        }

        return $result;
    }

    public function getProvinceName($code)
    {
        $provine = $this->getProvince();

        return isset($province[$code]) ? $province[$code] : '';
    }
}
