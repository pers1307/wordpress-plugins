<?php
/**
 * Plugin Name: Капча для формы авторизации
 * Description: Тут описание
 * Plugin URI: /
 */

//add_action('login_form', 'wfm_captcha_login');
//add_action('wp_authenticate', 'wfm_authenticate', 10, 2);
//
//function wfm_captcha_login()
//{
//    return '<input type="checkbox" name="check" value="check"> Сними галочку!';
//}
//
//function wfm_authenticate($username, $password)
//{
//    if (isset($_POST['check'])) {
////        wp_die('Ошибка, уберите галочку');
//        add_filter('login_errors', 'wfm_login_errors');
//        $username = null;
//    }
//}
//
///**
// * Переопределение ошибки авторизации
// * @return string
// */
//function wfm_login_errors()
//{
//    return 'Ошибка авторизации';
//}

add_action('login_form', 'wfm_captcha_login');
// Для этой функции важен приоритет
add_filter('authenticate', 'wp_auth_singon', 30, 3);

function wfm_captcha_login()
{
    return '<input type="checkbox" name="check" value="check"> Сними галочку!';
}

function wp_auth_singon($user, $username, $password)
{
    if (isset($_POST['check'])) {
        $user = new WP_Error('broke', 'Ошибка!');
    }

    if (
        isset($user->errors['invalid_username'])
        || isset($user->errors['incorrect_password'])
    ) {
        return new WP_Error('broke', 'Неверный логин или пароль');
    }

    return $user;
}