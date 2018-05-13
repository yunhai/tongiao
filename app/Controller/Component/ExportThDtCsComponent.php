<?php

class ExportThDtCsComponent extends Component
{
    public function __construct()
    {
        App::uses('ProvinceComponent', 'Controller/Component');
        $this->Province = new ProvinceComponent(new ComponentCollection());

        App::uses('UtilityComponent', 'Controller/Component');
        $this->Utility = new UtilityComponent(new ComponentCollection());
    }

    public function export()
    {
        $export_fields = [
			[
				'Chucsacnhatuhanhconggiaotrieu',
				'Chucsacnhatuhanhcongiaodongtu'
			],
			['Chucsacnhatuhanhphatgiao'],
			['Chucsactinlanh'],
			['Chucsaccaodai'],
			['Chucviechoigiao'],
			['Chucviectinhdocusiphathoivietnam'],
			['Nguoihoatdongtinnguongchuyennghiep']
        ];

        $province = $this->Province->getProvince();

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $list) {
			$tmp = $this->__calculate($list);
            foreach ($province as $provice_code => $name) {
				$partial = $tmp[$provice_code];
				foreach($partial as $key => $val) {
					$export[$provice_code]['total_' . $key] += $val;
				}
				$export[$provice_code] = array_merge($export[$provice_code], $partial);
            }
        }

        return $export;
    }

	private function __calculate($list = []) {
		$tmp = [];
		foreach($list as $model) {
			$func = '__getDataRange';
			array_push($tmp, $this->$func($model));
		}

		$final = [];
		foreach($tmp as $element) {
			foreach($element as $province => $statis) {
				foreach($statis as $range => $count) {
					if (!isset($final[$province][$range])) {
						$final[$province][$range] = 0;
					}

					$final[$province][$range] += $count;
				}
			}
		}

		return $final;
	}

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                'index' => $index++,
                'province' => $name,
				'total_1' => 0,
				'total_2' => 0,
				'total_3' => 0,
				'total_4' => 0,
            ];
        }

        return $export;
    }

	private function __getDataRange($model)
	{
		$fields = [
			'id',
			'noiohiennay_huyen'
		];
		$conditions = [
			'noiohiennay_huyen <>' => '',
			'noiohiennay_huyen is not null',
			'ngaythangnamsinh <>' => '',
			'ngaythangnamsinh is not null',
		];
		$column = [
			'ngaythangnamsinh'
		];
		$province_field = 'noiohiennay_huyen';

		$fields = array_merge($fields, $column);

		$data = $this->__getData($model, compact('fields', 'conditions'));

		return $this->__groupData($data, $column, $province_field);
	}

    private function __getData($model, $option = [])
    {
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function __groupData($data, $column, $province_field)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array(
				1 => 0,
				2 => 0,
				3 => 0,
				4 => 0
			);
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }
			$ageRange = $this->__calculateAgeRange($item['ngaythangnamsinh']);

			if (isset($result[$provice_code][$ageRange])) {
				$result[$provice_code][$ageRange]++;
			}
        }

        return $result;
    }

	private function __calculateAgeRange($dob) {
		if ($dob) {
			$tmp = explode('/', $dob);
			$year = end($tmp);
			$age = date('Y') - $year;
			if ($age < 21) {
				return 1;
			}
			if ($age < 41) {
				return 2;
			}
			if ($age < 62) {
				return 3;
			}
			return 4;
		}
		return 0;
	}
}

/**
 * DO TUOI CUA CHAC SAC
 * BẢNG TỔNG HỢP LỨA TUỔI CỦA CHỨC SẮC CÁC TÔN GIÁO, TÍN NGƯỠNG TRÊN ĐỊA BÀN TỈNH
 *
 * I. CÔNG GIÁO
 * 1. Bảng chucsacnhatuhanhconggiaotrieu + chucsacnhatuhanhcongiaodongtu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * II. PHẬT GIÁO
 * 2. Bảng chucsacnhatuhanhphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * III. TIN LÀNH
 * 3. Bảng chucsactinlanh
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * IV. CAO ĐÀI
 * 4. Bảng chucsaccaodai
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * V. HỒI GIÁO
 * 5. Bảng chucviechoigiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * VI. TĐCSPHVN
 * 6. Bảng chucviectinhdocusiphathoivietnam
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * VII. TÍN NGƯỠNG
 * 7. Bảng nguoihoatdongtinnguongchuyennghiep
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * noiohiennay_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * Dưới 20
 * 21 đến 40
 * 41 đến 61
 * Trên 61
 * => Lấy năm hiện tại trừ đi cho dữ liệu trong cột ngaythangnamsinh để biết được nằm ở mốc tuổi nào
 *
 * cột ngaythangnamsinh có thể lưu dữ liệu kiểu ngày/tháng/năm hoặc tháng/năm hoặc năm, nên tìm cách tính theo định dạnh trên
 *
 */
