<?php
/**
 * Plugin Name: Options & Settings
 * Description: Тут описание
 * Plugin URI: /
 */

//add_option('wfm_test', '111');
//update_option('wfm_test', '2');
//delete_option('wfm_test');

add_action('admin_init', 'wfm_first_option');
add_action('admin_init', 'wfm_theme_options');

function wfm_first_option()
{
    register_setting(
        'general', // Страница меню опций
        'wfm_first_option' // Название опции
    );

    add_settings_field(
        'wfm_first_option', // id опции
        'Первая опция', // Заголовок настройки
        'wfm_option_cb', // callback function
        'general' // Страница меню опций
    );
}

function wfm_option_cb()
{
    echo '
        <input 
        type="text" 
        name="wfm_first_option" 
        id="wfm_first_option"
        value="' . esc_attr(get_option('wfm_first_option')) . '"
        class="regular-text"
        >
    ';
}

function wfm_theme_options()
{
    register_setting(
        'general', // Страница меню опций
        'wfm_theme_options' // Название опции
    );

    add_settings_section(
        'wfm_theme_section_id', // id секции
        'Опции темы', // Заголовок
        'wfm_theme_options_section_cb', // callback function
        'general' // Страница для вывода
    );

    add_settings_field(
        'wfm_theme_options_body', // id опции
        'Цвет фона', // Заголовок настройки
        'wfm_theme_options_body_cb', // callback function
        'general', // Страница меню опций
        'wfm_theme_section_id' // id секции
    );

    add_settings_field(
        'wfm_theme_options_header', // id опции
        'Цвет шапки', // Заголовок настройки
        'wfm_theme_options_header_cb', // callback function
        'general', // Страница меню опций
        'wfm_theme_section_id'
    );
}

function wfm_theme_options_section_cb()
{
    echo 'Описание секции';
}

function wfm_theme_options_body_cb()
{
    $option = get_option('wfm_theme_options');

    echo '
        <input 
        type="text" 
        name="wfm_theme_options[wfm_theme_options_body]" 
        id="wfm_theme_options_body"
        value="' . esc_attr($option['wfm_theme_options_body']) . '"
        class="regular-text"
        >
    ';
}

function wfm_theme_options_header_cb()
{
    $option = get_option('wfm_theme_options');

    echo '
        <input 
        type="text" 
        name="wfm_theme_options[wfm_theme_options_header]" 
        id="wfm_theme_options_header"
        value="' . esc_attr($option['wfm_theme_options_header']) . '"
        class="regular-text"
        >
    ';
}

// Добавляем свою страницу

add_action('admin_menu', 'wfm_admin_menu');

function wfm_admin_menu()
{
    add_options_page(
        'Опции темы (titile)', // title страницы
        'Опции темы',
        'manage_options',
        'wfm-theme-options',
        'wfm_option_page'
    );

    // Добавление в консоль
//    add_dashboard_page(
//        'Опции темы (titile)', // title страницы
//        'Опции темы',
//        'manage_options',
////        'wfm-theme-options',
//        __FILE__,
//        'wfm_option_page'
//    );

//    add_media_page()
}

//function wfm_option_page()
//{
//    if (
//        !empty($_POST)
//        && check_admin_referer()
//    ) {
//        update_option(
//            'wfm_theme_options',
//            [
//                'wfm_theme_options_body'   => $_POST['wfm_theme_options']['wfm_theme_options_body'],
//                'wfm_theme_options_header' => $_POST['wfm_theme_options']['wfm_theme_options_header'],
//            ]
//        );
//        echo 'Настройки сохранены';
//    }
//
//    $option = get_option('wfm_theme_options');
//
//    ?>
<!--    <div class="wrap">-->
<!--        <h2>Заголовок темы</h2>-->
<!--        <p>Настройки темы плагина</p>-->
<!---->
<!--        <form action="" method="post">-->
<!--            --><?// wp_nonce_field() ?>
<!--            <p>-->
<!--                <label for="wfm_theme_options_body">Цвет фона</label>-->
<!--                <input-->
<!--                    type="text"-->
<!--                    name="wfm_theme_options[wfm_theme_options_body]"-->
<!--                    id="wfm_theme_options_body"-->
<!--                    value="--><?//= esc_attr($option['wfm_theme_options_body']) ?><!--"-->
<!--                    class="regular-text"-->
<!--                >-->
<!--            </p>-->
<!--            <p>-->
<!--                <label for="wfm_theme_options_header">Цвет header</label>-->
<!--                <input-->
<!--                    type="text"-->
<!--                    name="wfm_theme_options[wfm_theme_options_header]"-->
<!--                    id="wfm_theme_options_header"-->
<!--                    value="--><?//= esc_attr($option['wfm_theme_options_header']) ?><!--"-->
<!--                    class="regular-text"-->
<!--                >-->
<!--            </p>-->
<!--            --><?// submit_button() ?>
<!--        </form>-->
<!--    </div>-->
<!--    --><?php
//}

add_action('admin_init', 'wfm_admin_settings');

function wfm_admin_settings()
{
    register_setting(
        'wfm_theme_options_group',
        'wfm_theme_options',
        'wfm_theme_options_sanitize'
    );

    add_settings_section(
        'wfm_theme_options_id',
        'Секция опций',
        '',
        'wfm-theme-options' // add_options_page menu slug
    );

    add_settings_field(
        'wfm_theme_options_body',
        'Цвет фона',
        'wfm_theme_options_body_cb',
        'wfm-theme-options',
        'wfm_theme_options_id'
    );


}


/**
 * Функция для обработки полей
 * @param $options
 * @return array
 */
function wfm_theme_options_sanitize($options)
{
    $cleanOptions = [];

    foreach ($options as $key => $option) {
        $cleanOptions[$key] = strip_tags($option);
    }

    return $cleanOptions;
}

function wfm_option_page()
{
    $option = get_option('wfm_theme_options');
    ?>
    <div class="wrap">
        <h2>Заголовок темы</h2>
        <p>Настройки темы плагина</p>

        <form action="options.php" method="post">
            <? settings_fields('wfm_theme_options_group') ?>
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