<?php
/**
 * Plugin Name: Хлебные крошки в title
 * Description: Тут описание
 * Plugin URI: /
 */

add_filter('wp_title', 'wfm_title2', 20);

function wfm_title2($title)
{
    $title = null;
    $sep = ' - ';

    $site = get_bloginfo('name');

    // Главная страница
    // is_home(); // Если выводятся последние записи
    // is_front_page(); // Тут без разницы
    if (is_home() || is_front_page()) {
        $title = [$site];
    } elseif (is_page()) {
        // Постоянная страница
        $title = [get_the_title(), $site];
    } elseif (is_tag()) {
        // Метка
        $title = [single_tag_title('Метка: ', false), $site];
    } elseif (is_search()) {
        // Поиск
        $title = ['Результаты поиска: ' . get_search_query(), $site];
    } elseif (is_404()) {
        $title = ['404', $site];
    } elseif (is_category()) {
        // Категория
        $catId = get_cat_ID('cat');
        // Данные категории
        $cat = get_category($catId);
        if ($cat->parent) {
            $categories = rtrim(get_category_parents($catId, false, $sep), $sep);
            $categories = explode($sep, $categories);
            $categories = get_the_title();
            $categories = array_reverse($categories);
            $categories[] = $site;
            $title = $categories;
        } else {
            $title = [$cat->name, $site];
        }

        if (is_single()) {
            $category = get_the_category();
            $catId = $category[0]->cat_ID;
            $categories = rtrim(get_category_parents($catId, false, $sep), $sep);
            $categories = explode($sep, $categories);
            $categories = array_reverse($categories);
            $categories[] = $site;
            $title = $categories;
        }

    } elseif (is_archive()) {
        // архив
        $title = ['Архив за: ' . get_the_time('F Y'), $site];
    }

    return implode($sep, $title);
}