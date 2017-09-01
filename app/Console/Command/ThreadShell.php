<?php

class ThreadShell extends AppShell {

    public function main() {
        $type_notificaiton = $this->args[0];
        $user_api_cd = @$this->args[1];
        $content = @$this->args[2];
        $content = str_replace(DEFAULT_SPACE_CHAT, " ", $content);
        $title = @$this->args[3];
        $title = str_replace(DEFAULT_SPACE_CHAT, " ", $title);
        $key_notification = @$this->args[4];

        APP::import("Model", array("User", "Shop"));
        $this->User = new User();
        $this->Shop = new Shop();
        $passphrase = PASSWORD_NOTIFICATION;
        $ctx = stream_context_create();
        $path = WWW_ROOT . "ios" . DS . "ck_dis.pem";
        stream_context_set_option($ctx, 'ssl', 'local_cert', $path);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        $user = $this->User->getInfoUser($user_api_cd);
        if (empty($user["device_token"]) || $user["delete_flg"] == 1 || $user["is_block"] == 1)
            return;
        $avatar = "";
        if ($type_notificaiton == NOTI_FAVOURITE || $type_notificaiton == NOTI_SHOP_DETAIL) {
            $user2 = $this->User->getInfoUser($key_notification);
            if (!empty($user2["avatar"])) {
                $avatar = $user2["avatar"];
            }
        }
        $avatar = str_replace(Router::url('/', true), "", $avatar);

        if ($user["is_type"] == TYPE_USER) {
            $user["badge"] = intval($user["badge"]) + 1;
            $this->User->create();
            $this->User->save($user);
        } else {
            $user["badge"] = intval($user["badge"]) + 1;
            $this->Shop->create();
            $this->Shop->save($user);
        }
        $options = array(
            "avatar" => $avatar,
            "body" => "",
            "is_type" => intval($user2["is_type"]),
            "key_notification" => intval(trim($key_notification)),
            "type_notification" => $type_notificaiton,
            "title" => $title,
            "deviceToken" => $user["device_token"],
            "badge" => intval($user["badge"]),
        );
        $options['message'] = $content;
        $fp = @stream_socket_client('ssl://gateway.push.apple.com:2195', $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        $body['aps'] = array(
            'alert' => array(
                'body' => $options['message'],
                'action-loc-key' => "open" // 
            ),
            'data' => $options, //
            'badge' => intval($options['badge']),
            'sound' => 'oven.caf',
        );
        //$options['deviceToken'] = "e1f9a39a1e649ba2ab1f0644cc0770319f0d0db31864ce19b2747e1051078f80";
        $payload = json_encode($body);
        if (!empty($options['deviceToken'])) {
            $msg = chr(0) . pack('n', 32) . @pack('H*', $options['deviceToken']) . @pack('n', strlen($payload)) . $payload;
            $result = fwrite($fp, $msg, strlen($msg));
            fclose($fp);
        }
    }

}
