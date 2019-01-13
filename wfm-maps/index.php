<?php
/**
 * Plugin Name: Google карта
 * Description: Тут описание
 * Plugin URI: /
 */

add_shortcode('test', 'wfm_test');

function wfm_test($atts, $content)
{
    $user = isset($atts['user']) ? $atts['user'] : '';
    $login = isset($atts['login']) ? $atts['login'] : '';

    // Можно использовать как альтернативу проверке
//    $atts = shortcode_atts(
//        [
//            'user'    => '',
//            'login'   => '',
//            'content' => '',
//        ], $atts
//    );
//    extract($atts);

    return "User: {$user}; Login: {$login}; Content: {$content}";
}

// Передает параметры из php в js
//wp_localize_script()