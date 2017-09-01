<?php

App::uses('AppController', 'Controller');

class TestController extends AppController {

    public $uses = array('ShopFavourite', 'User', 'ShopTagDetail', 'ShopTag', 'Shop', 'MsStation', 'MsPrefecture', 'AlbumShop', 'Admin');

    function abc() {
//        $user = $this->User->getInfoUser("15093088");
//        pr($user["delete_flg"]);
//         pr($user["is_block"]);
//        pr($user);exit;
        //15092963 shop 
        //15093088 user
//        $user = $this->User->getInfoUser("15093088");
//        if ($user["is_type"] == TYPE_USER) {
//            $user["badge"] = intval($user["badge"]) + 1;
//            $this->User->create();
//            $this->User->save($user);
//        } else {
//            $user["badge"] = intval($user["badge"]) + 1;
//            $this->Shop->create();
//            $this->Shop->save($user);
//        }
//        exit;
    }

    function albumUser() {
        exit;
        $data = $this->User->find("list", array(
            "conditions" => array(),
            "recursive" => -1
        ));
        $this->Img = $this->Components->load('Img');
        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');
        $type_album = Configure::read('TYPE_ALBUM');
        foreach ($data as $key => $val) {
            $namePath = sprintf(PATH_USER, $key);
            $realPath = WWW_ROOT . $namePath;
            $folder = new Folder($realPath);
            $files = $folder->find('.*', true);
            $small = $realPath . DS . $type_album["SMALL"];
            $medium = $realPath . DS . $type_album["MEDIUM"];
            $large = $realPath . DS . $type_album["LARGE"];
            $original = $realPath . DS . $type_album["ORIGINAL"];
            $dir_1 = new Folder($small, true, 0777);
            $dir_2 = new Folder($medium, true, 0777);
            $dir_3 = new Folder($large, true, 0777);
            $dir_4 = new Folder($original, true, 0777);
            asort($files);
            foreach ($files as $val) {
                $this->Img->resampleGD($realPath . DS . $val, $small, $val, SIZE_IMG_SMALL, SIZE_IMG_SMALL, false, 0);
                $this->Img->resampleGD($realPath . DS . $val, $medium, $val, SIZE_IMG_MEDIUM, SIZE_IMG_MEDIUM, false, 0);
                $this->Img->resampleGD($realPath . DS . $val, $large, $val, SIZE_IMG_LARGE, SIZE_IMG_LARGE, false, 0);
                $file = new File($realPath . DS . $val);
                $file->copy($original . DS . $val);
                $file->delete();
            }
        }
    }

    function albumShop() {
        exit;
        $data = $this->AlbumShop->find("list", array(
            "conditions" => array(),
            "recursive" => -1
        ));
        $this->Img = $this->Components->load('Img');
        App::uses('Folder', 'Utility');
        App::uses('File', 'Utility');
        $type_album = Configure::read('TYPE_ALBUM');
        foreach ($data as $key => $val) {
            $namePath = sprintf(PATH_ALBUM, $key, "album");
            $realPath = WWW_ROOT . $namePath;
            $folder = new Folder($realPath);
            $files = $folder->find('.*', true);
            $small = $realPath . DS . $type_album["SMALL"];
            $medium = $realPath . DS . $type_album["MEDIUM"];
            $large = $realPath . DS . $type_album["LARGE"];
            $original = $realPath . DS . $type_album["ORIGINAL"];
            $dir_1 = new Folder($small, true, 0777);
            $dir_2 = new Folder($medium, true, 0777);
            $dir_3 = new Folder($large, true, 0777);
            $dir_4 = new Folder($original, true, 0777);
            asort($files);
            foreach ($files as $val) {
                $this->Img->resampleGD($realPath . DS . $val, $small . DS, $val, SIZE_IMG_SMALL, SIZE_IMG_SMALL, false, 0);
                $this->Img->resampleGD($realPath . DS . $val, $medium . DS, $val, SIZE_IMG_MEDIUM, SIZE_IMG_MEDIUM, false, 0);
                $this->Img->resampleGD($realPath . DS . $val, $large . DS, $val, SIZE_IMG_LARGE, SIZE_IMG_LARGE, false, 0);
                $file = new File($realPath . DS . $val);
                $file->copy($original . DS . $val);
                $file->delete();
            }

            $namePath = sprintf(PATH_ALBUM, $key, "user");
            $realPath = WWW_ROOT . $namePath;
            $folder = new Folder($realPath);
            $files = $folder->find('.*', true);
            $small = $realPath . DS . $type_album["SMALL"];
            $medium = $realPath . DS . $type_album["MEDIUM"];
            $large = $realPath . DS . $type_album["LARGE"];
            $original = $realPath . DS . $type_album["ORIGINAL"];
            $dir_1 = new Folder($small, true, 0777);
            $dir_2 = new Folder($medium, true, 0777);
            $dir_3 = new Folder($large, true, 0777);
            $dir_4 = new Folder($original, true, 0777);
            asort($files);
            foreach ($files as $val) {
                $this->Img->resampleGD($realPath . DS . $val, $small . DS, $val, SIZE_IMG_SMALL, SIZE_IMG_SMALL, false, 0);
                $this->Img->resampleGD($realPath . DS . $val, $medium . DS, $val, SIZE_IMG_MEDIUM, SIZE_IMG_MEDIUM, false, 0);
                $this->Img->resampleGD($realPath . DS . $val, $large . DS, $val, SIZE_IMG_LARGE, SIZE_IMG_LARGE, false, 0);
                $file = new File($realPath . DS . $val);
                $file->copy($original . DS . $val);
                $file->delete();
            }
        }
    }

    function test_1() {

//        $result = array();
//        $data = $this->Shop->find("all");
//        foreach ($data as $val) {
//            $name = array(
//                "いちご みるく",
//                "松村美咲",
//                "櫻井叶子",
//                "森村 さき",
//                "谷口鈴夏",
//                "堤亜梨紗",
//                "松本梨花",
//                "伸幸鈴木",
//                "山村江美",
//                "一條 ゆうみ",
//                "小沼竜也",
//                "外田渚",
//                "野口桂哉",
//                "むし ぱん",
//                "都築沙奈",
//                "とむやむ くん",
//                "影山未來",
//                "渕上綾香",
//                "伴宗典",
//                "岡本 ミルク",
//                "한가영",
//                "大石内蔵助",
//                "西野里圭子",
//                "星野恵理香",
//                "河原木聖可",
//                "川村理瑳",
//                "山田祥子",
//                "林裕平",
//                "真由恒本",
//                "颯神崎",
//                "豊田有香",
//            );
//            $i_name = rand(0, count($name) - 1);
//            $i_name_user = rand(0, count($name) - 1);
//            $val["Shop"]["name"] = $name[$i_name];
//            $val["Shop"]["name_user"] = $name[$i_name_user];
//            $result[] = $val["Shop"];
//        }
//        $this->Shop->create();
//        $this->Shop->saveMany($result);
        exit;
        $result = array();
        for ($i = 0; $i < 40; $i++) {
            $ms_precfure = rand(1, 47);
            $shop_tag_id = rand(1, 21);
            // $shop_detail_tag_id = rand(1, 7);
            $name = array(
                "いちご みるく",
                "松村美咲",
                "櫻井叶子",
                "森村 さき",
                "谷口鈴夏",
                "堤亜梨紗",
                "松本梨花",
                "伸幸鈴木",
                "山村江美",
                "一條 ゆうみ",
                "小沼竜也",
                "外田渚",
                "野口桂哉",
                "むし ぱん",
                "都築沙奈",
                "とむやむ くん",
                "影山未來",
                "渕上綾香",
                "伴宗典",
                "岡本 ミルク",
                "한가영",
                "大石内蔵助",
                "西野里圭子",
                "星野恵理香",
                "河原木聖可",
                "川村理瑳",
                "山田祥子",
                "林裕平",
                "真由恒本",
                "颯神崎",
                "豊田有香",
            );
            $i_name = rand(0, count($name) - 1);
            $station = $this->MsStation->find("first", array(
                "conditions" => array("MsStation.ms_prefecture_id" => $ms_precfure),
                "order" => 'rand()',
            ));
            $save = array(
                "name" => $name[$i_name],
                "ms_prefecture_id" => $ms_precfure,
                "ms_station_id" => $station["MsStation"]["id"],
                "shop_tag_id" => $shop_tag_id,
            );
            $result[] = $save;
        }
        $this->Shop->create();
        $this->Shop->saveMany($result);
//        pr($save);
        exit;
    }

    function addAlbum() {
        exit;
        $result = array();
//        for ($i = 1; $i <=40; $i++) {
//            $shop_detail_tag_id = rand(1, 7);
//            $save = array(
//                "shop_id" => $i,
//                "photo" => $i . ".JPG",
//                "rank" => 1,
//                "shop_tag_detail_id" => $shop_detail_tag_id,
//            );
//            $result[] = $save;
//        }

        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 1,
            "photo" => "1_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;

        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 1,
            "photo" => "1_2.JPG",
            "rank" => 3,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 2,
            "photo" => "2_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 3,
            "photo" => "3_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 4,
            "photo" => "4_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 5,
            "photo" => "5_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 5,
            "photo" => "5_2.JPG",
            "rank" => 3,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 5,
            "photo" => "5_3.JPG",
            "rank" => 4,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 6,
            "photo" => "6_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 6,
            "photo" => "6_2.JPG",
            "rank" => 3,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 7,
            "photo" => "7_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 9,
            "photo" => "9_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 10,
            "photo" => "10_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 11,
            "photo" => "11_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;
        $shop_detail_tag_id = rand(1, 7);
        $save = array(
            "shop_id" => 12,
            "photo" => "12_1.JPG",
            "rank" => 2,
            "shop_tag_detail_id" => $shop_detail_tag_id,
        );
        $result[] = $save;



        $this->AlbumShop->create();
        $this->AlbumShop->saveMany($result);
    }

}
