<?php

class ExportThTsComponent extends Component
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
			'Giaoxu',
            'Tuvienphatgiao',
        ];

        $province = $this->Province->getProvince();

        $export = $this->init($province);

        foreach ($export_fields as $field_index => $model) {
			$func = '__get' . $model;
            $tmp = $this->$func($model);

            foreach ($province as $provice_code => $name) {
                $partial = $tmp[$provice_code];


				foreach($partial as $field => $value) {
					if ($field === 'total') {
						$export[$provice_code]['total'] += $value;
					}
					$export[$provice_code][$model . '_' . $field] = $value;
				}
            }
        }

        return $export;
    }

    private function init($province)
    {
        $index = 1;
        $export = [];

        foreach ($province as $code => $name) {
            $export[$code] = [
                    'index' => $index++,
                    'province' => $name,
                    'total' => 0,
                ];
        }

        return $export;
    }

	private function __getTuvienphatgiao($model)
	{
		$fields = [
			'id',
			'diachi_huyen'
		];
		$conditions = [];
		$column = [
			'sotusi',
			'nam_tykheo',
			'nam_sadi',
			'nu_tykheoni',
			'nu_thucxoamana',
			'nu_sadini',
		];
		$province_field = 'diachi_huyen';

		$fields = array_merge($fields, $column);

		$data = $this->__getData($model, compact('fields', 'conditions'));

		$result = $this->__groupData($data, $column, $province_field);

		foreach($result as &$item) {
			$item = array(
				'total' => $item['sotusi'],
				'nam_tykheo' => $item['nam_tykheo'],
				'nam_sadi' => $item['nam_sadi'],
				'nam_tinhnhon_dieu' => 0,
				'nu_tykheoni' => $item['nu_tykheoni'],
				'nu_thucxoamana' => $item['nu_thucxoamana'],
				'nu_sadini' => $item['nu_sadini'],
				'tinhnhon_dieu' => 0
			);
		}

		return $result;
	}

    private function __getGiaoxu($model)
    {
        $fields = [
            'id',
            'diachi_huyen'
        ];
        $conditions = [];
        $column = [
			'sotusi_nam',
			'sotusi_nu',
        ];
        $province_field = 'diachi_huyen';

        $fields = array_merge($fields, $column);
        $data = $this->__getData($model, compact('fields', 'conditions'));

		$result = $this->__groupData($data, $column, $province_field);

		foreach($result as &$item) {
			$total = array_sum($item);
			$item = [
				'total' => $total,
				'sotusi_nam' => $item['sotusi_nam'],
				'chungsinh' => 0,
				'sotusi_nu' => $item['sotusi_nu'],
			];
		}

		return $result;
    }

    private function __getData($model, $option = [])
    {
        $obj = ClassRegistry::init($model);
        $data = $obj->find('all', $option);

        return Hash::combine($data, '{n}.' . $model . '.id', '{n}.' . $model);
    }

    private function __groupData($data, $column, $province_field, $countFlag = false)
    {
        $result = [];
        $province = $this->Province->getProvince();

        foreach ($province as $provice_code => $name) {
            $result[$provice_code] = array();
			foreach ($column as $col) {
                $result[$provice_code][$col] = 0;
            }
        }

        foreach ($data as $id => $item) {
            $provice_code = $this->Province->retrieveProvinceCode($item[$province_field]);
            if (!$provice_code) {
                continue;
            }

            foreach ($result[$provice_code] as $key => &$count) {
                if ($item[$key]) {
					if ($countFlag) {
						$count++;
					} else {
						$count += $item[$key];
					}
                }
            }
        }

        return $result;
    }
}

/**
 * TONG HOP TU SI
 * BẢNG TỔNG HỢP TU SĨ CÁC TÔN GIÁO TRÊN ĐỊA BÀN TỈNH
 *
 * 1. Bảng giaoxu
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG (CỘT D8 TRONG FILE EXCEL) : sotusi
 * TU SĨ DÒNG (CỘT E8 TRONG FILE EXCEL) : sotusi_nam
 * CHỦNG SINH (CỘT F8 TRONG FILE EXCEL) : Để mặc định bằng 0
 * TU SĨ DÒNG (CỘT G8 TRONG FILE EXCEL) : sotusi_nu
 *
 * 1. Bảng tuvienphatgiao
 * Tương ứng với từng huyện: BIÊN HÒA/LONG KHÁNH/XUÂN LỘC/CẨM MỸ/TÂN PHÚ/ĐỊNH QUÁN/THỐNG NHẤT/TRẢNG BOM/VĨNH CỬU/NHƠN TRẠCH/LONG THÀNH
 * diachi_huyen = Tương ứng với từng huyện ở trên và điều kiện
 * TỔNG (CỘT H8 TRONG FILE EXCEL) : sotusi
 * ĐẠI ĐỨC (CỘT I8 TRONG FILE EXCEL) : nam_tykheo
 * SA DI (CỘT J8 TRONG FILE EXCEL) : nam_sadi
 * TỊNH NHƠN, ĐIỆU (CỘT K8 TRONG FILE EXCEL) : Để mặc định bằng 0
 * TỲ KHEO NI (CỘT L8 TRONG FILE EXCEL) : nu_tykheoni
 * THỨC XOA MA NA (CỘT M8 TRONG FILE EXCEL) : nu_thucxoamana
 * SA DI NI (CỘT N8 TRONG FILE EXCEL) : nu_sadini
 * TỊNH NHƠN, ĐIỆU (CỘT 08 TRONG FILE EXCEL) : Để mặc định bằng 0
 *
 */
