<?php
/**
 * Plugin Name: Первый плагин
 * Description: Описание
 * Plugin URI: /
 */

include_once dirname(__FILE__) . '/deactivate.php';

register_activation_hook(__FILE__, 'wfm_activate');
register_deactivation_hook(__FILE__, 'wfm_deactivate');
//register_uninstall_hook(__FILE__, 'wfm_uninstall');

function wfm_activate()
{
    wp_mail(
        get_bloginfo('admin_email'),
        'Плагин активирован',
        'Успешная активация плагина'
    );

    if (version_compare(PHP_VERSION, '5.3.0', '<')) {
        header('Content-type: text/html; Charset=utf-8');
        exit('Для работы плагина нужна версия болле 5.3');
    }
}

/**
 * Полное удаление плагина
 */
//function wfm_uninstall()
//{
//
//}

//class WFMActivate
//{
//    public function __construct()
//    {
//        register_activation_hook(
//            __FILE__,
//            [
//                $this,
//                'wfm_activate'
//            ]
//        );
//    }
//
//    public function wfm_activate()
//    {
//        $date = date('Y-m-d H:i:s');
//        error_log(
//            $date . ' Плагин активирован\r\n',
//            3,
//            dirname(__FILE__) . '/errors.log'
//        );
//    }
//}
//
//$instance = new WFMActivate();
