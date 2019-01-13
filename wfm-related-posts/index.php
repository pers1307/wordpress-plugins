<?php
/**
 * Plugin Name: Похожие записи
 * Description: плагин с похожими записями
 * Plugin URI: /
 */

add_filter('the_content', 'wfm_related_posts');
add_action('wp_enqueue_scripts', 'wp_register_styles_scripts');

function wp_register_styles_scripts() {
    /**
     * Зарегистрировал скрипт
     */
    wp_register_script(
        'wfm-js',
        plugins_url('js/wfm-js.js', __FILE__),
        ['jquery']
    );

    wp_register_style(
        'wfm-style',
        plugins_url('css/wfm-style.css', __FILE__)
    );

    wp_enqueue_script('wfm-js');
    wp_enqueue_style('wfm-style');
}

function wfm_related_posts($content)
{
    if (!is_single()) {
        return $content;
    }

    /**
     * Взять id записи
     */
    $id = get_the_ID();
    $categories = get_the_category($id);

    $catIds = [];

    foreach ($categories as $category) {
        $catIds[] = $category->cat_ID;
    }

    $related_posts = new WP_Query(
      [
          'posts_per_page'   => 5,
          'category__in'     => $catIds,
          'post__not_in'     => [$id],
          'orderby'          => 'rand'
      ]
    );

    if ($related_posts->have_posts()) {
        $content .= 'Похожие записи';
        while ($related_posts->have_posts()) {
            $related_posts->the_post();

            if (has_post_thumbnail()) {
                $image = get_the_post_thumbnail(
                    get_the_ID(),
                    [100, 100],
                    [
                        'alt' => 'alt'
                    ]
            );
            } else {
                $image = plugins_url('images/no-image.jpg', __FILE__);
            }

            $content .= get_permalink() . ' ' . get_the_title() . $image .'\n';
        }

        // Нужно для сброса глобального запроса
        wp_reset_query();
    }

    return $content . '!!!';
}