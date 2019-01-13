<?php
/**
 * Plugin Name: Капча для формы комментария
 * Description: Тут описание
 * Plugin URI: /
 */

add_filter('comment_form_default_fields', 'wfm_captcha');
add_filter('preprocess_comment', 'wfm_check_captcha');
//add_filter('comment_form_field_comment', 'wfm_captcha_2');

function wfm_captcha($fields)
{
    unset($fields['url']);
    $fields['captcha'] = '<input type="checkbox" name="captcha">';
    return $fields;
}

function wfm_check_captcha($commentData)
{
    if (is_user_logged_in()) {
        return $commentData;
    }

    if (!isset($_POST['captcha'])) {
        wp_die('Ошибка');
    }

    return $commentData;
}

function wfm_captcha_2($commentField)
{
    $commentField .= '<input type="checkbox" name="captcha">';
    return $commentField;
}