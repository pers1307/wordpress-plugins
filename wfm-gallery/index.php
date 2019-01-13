<?php
/**
 * Plugin Name: Плагин с галлереей
 * Description: Тут описание
 * Plugin URI: /
 */

remove_shortcode('gallery');
add_shortcode('gallery', 'wfm_gallery');

function wfm_gallery($atts)
{
    $imgIds = explode(',', $atts['ids']);

    if (empty($imgIds)) {
        return '';
    }

    foreach ($imgIds as $imgId) {
        $imgData = get_posts(
            [
                'p'         => $imgId,
                'post_type' => 'attachment',
            ]
        );

        $content = $imgData[0]->post_content;
        $excerpt = $imgData[0]->post_excerpt;
        $title   = $imgData[0]->post_title;

        $thumb = wp_get_attachment_image_src($imgId);
        $full  = wp_get_attachment_image_src($imgId, 'full');
    }

    return '';
}