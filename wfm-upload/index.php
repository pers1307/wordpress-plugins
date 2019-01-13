<?php
/**
 * Plugin Name: Загрузка файлов в wp
 * Description: Тут описание
 * Plugin URI: /
 */

// Добавление страницы меню
add_action('admin_menu', 'wfm_options_page');
// Добавление новых настроек
add_action('admin_menu', 'wfm_setting');

function wfm_options_page()
{
    add_options_page(
      'Опции темы',
      'Опции темы',
      'manage_options',
      'wfm-options-theme',
      'wfm_option_page'
    );
}

function wfm_setting()
{
    // Добавление настройки
    register_setting(
        'wfm_options_group',
        'wfm-options-theme',
        'wfm_options_sanitize'
    );

    // Добавление секции настроек
    add_settings_section(
        'wfm_options_section',
        'Опции темы',
        '',
        'wfm-options-theme'
    );

    // Добавление полей настроек
    add_settings_field(
        'wfm_body_bg_id',
        'Цвет фона',
        'wfm_body_bg_cb',
        'wfm-options-theme',
        'wfm_options_section',
        ['label_for' => 'wfm_body_bg_id']
    );

    add_settings_field(
        'wfm_header_pic_id',
        'Картинка в шапке',
        'wfm_header_pic_cb',
        'wfm-options-theme',
        'wfm_options_section',
        ['label_for' => 'wfm_header_pic_id']
    );
}

function wfm_options_sanitize($options)
{
    if (!empty($_FILES['wfm_options_file']['name'])) {
        $file = wp_handle_upload(
            $_FILES['wfm_options_file'],
            ['test_form' => false]
        );

        $options['file'] = $file['url'];
    } else {
        $old_options = get_option('wfm_options_theme');
        $options['file'] = $old_options['url'];
    }

    $clean_options = [];

    foreach ($options as $k => $v) {
        $clean_options[$k] = strip_tags($v);
    }

    return $clean_options;
}

function wfm_option_page()
{
    ?>
    <div class="wrap">
        <h2>Опции темы</h2>
        <form action="options.php" method="post" enctype="multipart/form-data">
            <? settings_fields('wfm_options_group') ?>
            <? do_settings_sections('wfm-options-theme') ?>
            <? submit_button() ?>
        </form>
    </div>
    <?php
}

/**
 * Не отображается ((
 */
function wfm_body_bg_cb()
{
    $options = get_option('wfm_options_theme');

    echo '
        <input 
        type="text" 
        name="wfm_options_theme[body_bg]" 
        id="wfm_body_bg_id"
        value="' . esc_attr($options['body_bg']) . '"
        class="regular-text"
        >
    ';
}

function wfm_header_pic_cb()
{
    ?>
    <input
        type="file"
        name="wfm_options_file"
        id="wfm_header_pic_id"
    >
    <?php

    $options = get_option('wfm_options_theme');

    if (!empty($options['file'])) {
        echo '<img src="' . $options['file'] . '">';
    }
}