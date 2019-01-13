<?php
/**
 * Plugin Name: Ajax
 * Description: Тут описание
 * Plugin URI: /
 */

/**
 * Типо стандартный способ работы с ajax запросами
 */
//if (isset($_POST['test'])) {
//    print_r($_POST);
//    die;
//}

add_action('admin_menu', 'wfm_admin_menu3');
add_action('admin_init', 'wfm_admin_settings3');
//add_action('admin_enqueue_scripts', 'wfm_admin_scripts');

// Повесили обработчик на ajax запрос
add_action('wp_ajax_wfm_action', 'wfm_ajax_check');

function wfm_ajax_check()
{
    if (!wp_verify_nonce($_POST['security'], 'wfmajax')) {
        die('NO');
    }

    if (isset($_POST['formData'])) {
        update_option('wfm_theme_options', $_POST['formData']);
        echo 'OK';
    }
}

/**
 * Подключение скриптов к админке
 */
function wfm_admin_scripts()
{
    wp_register_script(
            'wfm-script',
            plugins_url('ajax_script.js', __FILE__),
            ['jquery']
    );

    wp_enqueue_script('wfm-script');

    wp_localize_script(
            'wfm-script',
            'wfmajax',
            [
                    'nonce' => wp_create_nonce('wfmajax')
            ]
    );
}

function wfm_admin_settings3()
{
    /**
     * Регистрируем настройки
     */
    register_setting(
        'wfm_theme_options_group',
        'wfm_theme_options'
    );

    /**
     * Добавляем секцию настроек
     */
    add_settings_section(
            'wfm_theme_options_id',
            'Секция опции темы',
            '',
            'wfm_theme_options'
    );

    /**
     * Добавление поля в секцию настроек
     */
    add_settings_field(
            'wfm_theme_options_body',
            'Цвет фона',
            'wfm_theme_body_cb',
            'wfm_theme_options',
            'wfm_theme_options_id',
            ['label_for' => 'wfm_theme_options_body']
    );
}

/**
 * Коллбек для поля
 */
function wfm_theme_body_cb()
{
    $options = get_option('wfm_theme_options');
    ?>
        <p>
            <input
                type="text"
                name="wfm_theme_options"
                id="wfm_theme_options_body"
                value="<?= esc_attr($options) ?>"
                class="regular-text"
            >
        </p>
    <?php
}

/**
 * Добавление в меню отдельной страницы
 */
function wfm_admin_menu3()
{
    $hookSuffix = add_options_page(
      'Опции темы',
      'Опции Ajax',
      'manage_options',
      __FILE__,
      'wfm_options_page'
    );

    // Подключение к определенной странице
    add_action('admin_print_scripts-' . $hookSuffix, 'wfm_admin_scripts');
}

/**
 * Содержание этой отдельной страницы
 */
function wfm_options_page()
{
    ?>
    <div class="wrap">
        <h2>Опции темы Ajax</h2>
        <p>
            Проверка опций без перезагрузки
            <form action="options.php" method="post" id="wfm-form">
                <? settings_fields('wfm_theme_options_group') ?>
                <? do_settings_sections('wfm_theme_options') ?>
                <? submit_button() ?>
            </form>
        </p>
    </div>


    <?php
}