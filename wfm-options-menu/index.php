<?php
/**
 * Plugin Name: Options & Settings Menu
 * Description: Тут описание
 * Plugin URI: /
 */

add_action('admin_menu', 'wfm_admin_menu2');

function wfm_admin_menu2()
{
    add_menu_page(
            'Опции темы (title)',
            'Опции темы',
            'manage_options',
            __FILE__,
            'wfm_option_page2',
            'dashicons-smiley'
//            '5.5'
//            plugins_url('path-to-icon', __FILE__)
    );

    add_submenu_page(
            __FILE__,
            'Опции header',
            'Опции header',
            'manage_options',
            'wfm-header-options',
            'wfm_options_submenu'
    );
}

function wfm_options_submenu()
{
    ?>
    <div class="wrap">
        <h2>Настройки темы. Секция HEADER</h2>
        <form action="options.php" method="post">
            <? settings_fields('wfm_theme_options_group') ?>
            <? do_settings_sections('wfm-header-options') ?>
            <? submit_button() ?>
        </form>
    </div>
    <?php
}

add_action('admin_init', 'wfm_admin_settings2');

function wfm_admin_settings2()
{
    register_setting(
        'wfm_theme_options_group',
        'wfm_theme_options',
        'wfm_theme_options_sanitize2'
    );

    add_settings_section(
        'wfm_theme_options_id',
        'Секция опций',
        '',
        'wfm-header-options' // add_options_page menu slug
    );

    add_settings_field(
        'wfm_theme_options_body',
        'Цвет фона',
        'wfm_theme_options_body_cb',
        'wfm-header-options',
        'wfm_theme_options_id'
    );
}

/**
 * Функция для обработки полей
 * @param $options
 * @return array
 */
function wfm_theme_options_sanitize2($options)
{
    $cleanOptions = [];

    foreach ($options as $key => $option) {
        $cleanOptions[$key] = strip_tags($option);
    }

    return $cleanOptions;
}

function wfm_option_page2()
{
    $option = get_option('wfm_theme_options');
    ?>
    <div class="wrap">
        <h2>Заголовок темы</h2>
        <p>Настройки темы плагина</p>

        <form action="options.php" method="post">
            <p>
                <label for="wfm_theme_options_body">Цвет фона</label>
                <input
                        type="text"
                        name="wfm_theme_options[wfm_theme_options_body]"
                        id="wfm_theme_options_body"
                        value="<?= esc_attr($option['wfm_theme_options_body']) ?>"
                        class="regular-text"
                >
            </p>
            <p>
                <label for="wfm_theme_options_header">Цвет header</label>
                <input
                        type="text"
                        name="wfm_theme_options[wfm_theme_options_header]"
                        id="wfm_theme_options_header"
                        value="<?= esc_attr($option['wfm_theme_options_header']) ?>"
                        class="regular-text"
                >
            </p>
            <? do_settings_sections('wfm-theme-options') ?>
            <? submit_button() ?>
        </form>
    </div>
    <?php
}