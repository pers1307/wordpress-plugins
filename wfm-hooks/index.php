<?php
/**
 * Plugin Name: Примеры работы хуков
 * Description: Несколько примеров работы хуков
 * Plugin URI: /
 */

add_filter('the_title', 'wfm_title');
add_filter('the_content', 'wfm_content');
add_action('comment_post', 'wfm_comment_post');

function wfm_title($title)
{
    if (is_admin()) {
        return $title;
    }

    return mb_convert_case(
        $title,
        MB_CASE_TITLE,
        'UTF-8');
}

function wfm_content($content)
{
    if (is_page()) {
        return $content;
    }

    if (!is_user_logged_in()) {
        return 'Авторизуйтесь!';
    }

    return $content;
}

function wfm_comment_post()
{
    /**
     * Делаем что то при добавлении комментария
     */
}