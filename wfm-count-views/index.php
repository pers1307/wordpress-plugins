<?php
/**
 * Plugin Name: Количество просмотров статей
 * Description: Счетчик количества просмотров статей
 * Plugin URI: /
 */

include_once dirname(__FILE__) . '/wfm_check.php';

register_activation_hook(__FILE__, 'wfm_create_field');
add_filter('the_content', 'wfm_post_views');
add_action('wp_head', 'wfm_add_view');

function wfm_create_field() {
    global $wpdb;

    /**
     * todo: Поле не добавилось
     */
    if (!wfm_check('wfm_views')) {
        $query = "ALTER TABLE $wpdb->posts ADD `wfm_views` INT NOT MULL DEFAULT '0'";
        $wpdb->query($query);
    }
}

function wfm_post_views($content) {
    if (is_page()) {
        return $content;
    }

    global $post;

    $views = $post->wfm_views;

    if (is_single()) {
        ++$views;
    }

    return $content . 'Количество просмотров: ' . $views;
}

function wfm_add_view()
{
    if (!is_single()) {
        return;
    }

    global $post, $wpdb;

    $id = $post->id;
    $views = $post->wfm_views + 1;

    $wpdb->update(
        $wpdb->posts,
        [
            'wfm_views' => $views
        ],
        [
            'ID' => $id
        ]
    );
}
