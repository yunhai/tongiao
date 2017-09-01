<?php

date_default_timezone_set('Asia/Tokyo');
setlocale(LC_ALL, 'ja_JP.UTF8');

class ApiShell extends AppShell {

    public function startup() {
        parent::startup();
    }

    public function main() {
        set_time_limit(0);
        
    }


}
