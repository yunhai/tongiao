<?php
/**
 * This file is loaded automatically by the app/webroot/index.php file after core.php
 *
 * This file should load/create any application wide configuration settings, such as
 * Caching, Logging, loading additional configuration files.
 *
 * You should also use this file to include any files that provide global functions/constants
 * that your application uses.
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
 * @package       app.Config
 * @since         CakePHP(tm) v 0.10.8.2117
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

// Setup a 'default' cache configuration for use in the application.
Cache::config('default', array('engine' => 'File'));

/**
 * The settings below can be used to set additional paths to models, views and controllers.
 *
 * App::build(array(
 *     'Model'                     => array('/path/to/models/', '/next/path/to/models/'),
 *     'Model/Behavior'            => array('/path/to/behaviors/', '/next/path/to/behaviors/'),
 *     'Model/Datasource'          => array('/path/to/datasources/', '/next/path/to/datasources/'),
 *     'Model/Datasource/Database' => array('/path/to/databases/', '/next/path/to/database/'),
 *     'Model/Datasource/Session'  => array('/path/to/sessions/', '/next/path/to/sessions/'),
 *     'Controller'                => array('/path/to/controllers/', '/next/path/to/controllers/'),
 *     'Controller/Component'      => array('/path/to/components/', '/next/path/to/components/'),
 *     'Controller/Component/Auth' => array('/path/to/auths/', '/next/path/to/auths/'),
 *     'Controller/Component/Acl'  => array('/path/to/acls/', '/next/path/to/acls/'),
 *     'View'                      => array('/path/to/views/', '/next/path/to/views/'),
 *     'View/Helper'               => array('/path/to/helpers/', '/next/path/to/helpers/'),
 *     'Console'                   => array('/path/to/consoles/', '/next/path/to/consoles/'),
 *     'Console/Command'           => array('/path/to/commands/', '/next/path/to/commands/'),
 *     'Console/Command/Task'      => array('/path/to/tasks/', '/next/path/to/tasks/'),
 *     'Lib'                       => array('/path/to/libs/', '/next/path/to/libs/'),
 *     'Locale'                    => array('/path/to/locales/', '/next/path/to/locales/'),
 *     'Vendor'                    => array('/path/to/vendors/', '/next/path/to/vendors/'),
 *     'Plugin'                    => array('/path/to/plugins/', '/next/path/to/plugins/'),
 * ));
 *
 */

/**
 * Custom Inflector rules can be set to correctly pluralize or singularize table, model, controller names or whatever other
 * string is passed to the inflection functions
 *
 * Inflector::rules('singular', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 * Inflector::rules('plural', array('rules' => array(), 'irregular' => array(), 'uninflected' => array()));
 *
 */

/**
 * Plugins need to be loaded manually, you can either load them one by one or all of them in a single call
 * Uncomment one of the lines below, as you need. Make sure you read the documentation on CakePlugin to use more
 * advanced ways of loading plugins
 *
 * CakePlugin::loadAll(); // Loads all plugins at once
 * CakePlugin::load('DebugKit'); //Loads a single plugin named DebugKit
 *
 */

/**
 * To prefer app translation over plugin translation, you can set
 *
 * Configure::write('I18n.preferApp', true);
 */

/**
 * You can attach event listeners to the request lifecycle as Dispatcher Filter. By default CakePHP bundles two filters:
 *
 * - AssetDispatcher filter will serve your asset files (css, images, js, etc) from your themes and plugins
 * - CacheDispatcher filter will read the Cache.check configure variable and try to serve cached content generated from controllers
 *
 * Feel free to remove or add filters as you see fit for your application. A few examples:
 *
 * Configure::write('Dispatcher.filters', array(
 *		'MyCacheFilter', //  will use MyCacheFilter class from the Routing/Filter package in your app.
 *		'MyCacheFilter' => array('prefix' => 'my_cache_'), //  will use MyCacheFilter class from the Routing/Filter package in your app with settings array.
 *		'MyPlugin.MyFilter', // will use MyFilter class from the Routing/Filter package in MyPlugin plugin.
 *		array('callable' => $aFunction, 'on' => 'before', 'priority' => 9), // A valid PHP callback type to be called on beforeDispatch
 *		array('callable' => $anotherMethod, 'on' => 'after'), // A valid PHP callback type to be called on afterDispatch
 *
 * ));
 */
Configure::write('Dispatcher.filters', array(
    'AssetDispatcher',
    'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
    'engine' => 'File',
    'types' => array('notice', 'info', 'debug'),
    'file' => 'debug',
));
CakeLog::config('error', array(
    'engine' => 'File',
    'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
    'file' => 'error',
));
CakeLog::config('default', array(
    'engine' => 'File'
));

define('CONG_GIAO', 1);
define('PHAT_GIAO', 2);
define('TIN_LANH', 3);
define('CAO_DAI', 4);
define('TINH_DO_CU_SI', 5);
define('HOA_HAO', 6);
define('HOI_GIAO', 7);
define('TIN_NGUONG', 8);
define('KHAC', 99);

$location = [
    'bien-hoa' => 'BIÊN HÒA',
    'long-khanh' => 'LONG KHÁNH',
    'xuan-loc' => 'XUÂN LỘC',
    'cam-my' => 'CẨM MỸ',
    'tan-phu' => 'TÂN PHÚ',
    'dinh-quan' => 'ĐỊNH QUÁN',
    'thong-nhat' => 'THỐNG NHẤT',
    'trang-bom' => 'TRẢNG BOM',
    'vinh-cuu' => 'VĨNH CỬU',
    'nhon-trach' => 'NHƠN TRẠCH',
    'long-thanh' => 'LONG THÀNH'
];

$group = [
    CONG_GIAO => 'CÔNG GIÁO',
    PHAT_GIAO => 'PHẬT GIÁO',
    CAO_DAI => 'CAO ĐÀI',
    TINH_DO_CU_SI => 'TĐCSPHVN',
    HOI_GIAO => 'HỒI GIÁO',
    HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
    TIN_NGUONG => 'TÍN NGƯỠNG',
    KHAC => 'Khac',
];

Configure::write('export.filter', compact('location', 'group'));

Configure::write('export.excel', [
    TONG_HOP_DAT_DAI => [
        'filename' => 'TONG HOP DAT DAI',
        'component' => 'ExportThTkDat'
    ],
    TH_TON_GIAO_CO_SO => [
        'filename' => 'TH TON GIAO CO SO',
        'component' => 'ExportThTcTgCs'
    ],
    TH_CO_SO_TON_GIAO => [
        'filename' => 'TH CO SO TON GIAO',
        'component' => 'ExportThTgCsTinh'
    ],
    TONG_HOP_DI_TICH => [
        'filename' => 'TONG HOP DI TICH',
        'component' => 'ExportThDt'
    ],
    BANG_TONG_HOP_TIN_DO => [
        'filename' => 'BANG TONG HOP TIN DO',
        'component' => 'ExportThTdTg'
    ],
    TH_CS_THAM_GIA_CT_XH_CAP_XA => [
        'filename' => 'TH CS THAM GIA CT-XH CAP XA',
        'component' => 'ExportThCtxhXa'
    ],
    TH_CS_THAM_GIA_CT_XH_CAP_HUYEN => [
        'filename' => 'TH CS THAM GIA CT-XH CAP HUYEN',
        'component' => 'ExportThCtxhHuyen'
    ],
    TH_CS_THAM_GIA_CT_XH_CAP_TINH => [
        'filename' => 'TH CS THAM GIA CT-XHCAP TINH',
        'component' => 'ExportThCtxhTinh'
    ],
    THBNCS => [
        'filename' => 'THBNCS',
        'component' => 'ExportThCsCy'
    ],
    DO_TUOI_CUA_CHAC_SAC => [
        'filename' => 'DO TUOI CUA CHAC SAC',
        'component' => 'ExportThDtCs'
    ]
]);

define('TONGIAO', serialize(array(
            1 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TĐCSPHVN',
                HOI_GIAO => 'HỒI GIÁO',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                TIN_NGUONG => 'TÍN NGƯỠNG'
            ),
            2 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ VIỆT NAM',
                HOI_GIAO => 'HỒI GIÁO',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO'
            ),
            3 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ VIỆT NAM',
                HOI_GIAO => 'HỒI GIÁO',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                TIN_NGUONG => 'TÍN NGƯỠNG'
            ),
            4 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ VIỆT NAM',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                HOI_GIAO => 'HỒI GIÁO'
            ),
            5 => array(
                CONG_GIAO => 'Công giáo',
                PHAT_GIAO => 'Phật giáo',
                TIN_LANH => 'Tin lành',
                CAO_DAI => 'Cao đài',
                TINH_DO_CU_SI => 'Tịnh độ Cư sĩ Phật hội VN',
                HOA_HAO => 'Phật giáo Hòa Hảo',
                HOI_GIAO => 'Hồi giáo',
                TIN_NGUONG => 'Tín ngưỡng'
            ),
            6 => array(
                CONG_GIAO => 'Công giáo',
                PHAT_GIAO => 'Phật giáo',
                TIN_LANH => 'Tin lành',
                CAO_DAI => 'Cao đài',
                TINH_DO_CU_SI => 'Tịnh độ Cư sĩ Phật hội VN',
                HOA_HAO => 'Phật giáo Hòa Hảo',
                HOI_GIAO => 'Hồi giáo',
                TIN_NGUONG => 'Tín ngưỡng'
            ),
            7 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TĐCSPHVN',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                HOI_GIAO => 'HỒI GIÁO',
                KHAC => 'CÁC TÔN GIÁO KHÁC'
            ),
            14 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                HOI_GIAO => 'HỒI GIÁO'
            ),
            15 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                HOI_GIAO => 'HỒI GIÁO'
            ),
            16 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                HOI_GIAO => 'HỒI GIÁO'
            ),
            18 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                HOI_GIAO => 'HỒI GIÁO',
                TINH_DO_CU_SI => 'TĐCSPHVN'
            ),
            20 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                HOI_GIAO => 'HỒI GIÁO',
                TINH_DO_CU_SI => 'TĐCSPHVN'
            ),
            21 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                HOI_GIAO => 'HỒI GIÁO'
            ),
            22 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TỊNH ĐỘ CƯ SĨ PHẬT HỘI VIỆT NAM',
                HOI_GIAO => 'HỒI GIÁO'
            ),
            26 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                TINH_DO_CU_SI => 'TĐCSPHVN'
            ),
            27 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO'
            ),
            28 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                HOI_GIAO => 'HỒI GIÁO',
                TINH_DO_CU_SI => 'TĐCSPHVN'
            ),
            29 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                TIN_LANH => 'TIN LÀNH',
                CAO_DAI => 'CAO ĐÀI',
                HOI_GIAO => 'HỒI GIÁO',
                TINH_DO_CU_SI => 'TĐCSPHVN'
            ),
            30 => array(
                CONG_GIAO => 'CÔNG GIÁO',
                PHAT_GIAO => 'PHẬT GIÁO',
                CAO_DAI => 'CAO ĐÀI',
                TINH_DO_CU_SI => 'TĐCSPHVN',
                HOI_GIAO => 'HỒI GIÁO',
                HOA_HAO => 'PHẬT GIÁO HÒA HẢO',
                TIN_NGUONG => 'TÍN NGƯỠNG'
            )
        )
    )
);
