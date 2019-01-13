<?php
/**
 * Plugin Name: Сбор подписчиков & Cron
 * Description: Тут описание
 * Plugin URI: /
 */

// wp_cron - эмулирует работу cron
add_action('wfm_cron_action', 'wfm_cron_cb');

if (!wp_next_scheduled('wfm_cron_action')) {
    wp_schedule_event(time(), 'hourly', 'wfm_cron_action');
}

//wp_clear_scheduled_hook('wfm_cron_action');
//wp_schedule_event(time(), 'hourly', 'wfm_cron_action');

function wfm_cron_cb()
{
    error_log('Cron worked' . date('i:s', time()));
}

//-----------------------------------------------------------------------
add_action('wp', 'wfm_setup_schedule');

function wfm_setup_schedule()
{
    if (!wp_next_scheduled('wfm_cron_action')) {
        wp_schedule_event(time(), 'hourly', 'wfm_cron_action');
    }
}

add_filter('cron_schedules', 'wfm_add_schedule');

/**
 * @param array $schedules
 *
 * @return array
 */
function wfm_add_schedule($schedules)
{
    $schedules['minute'] = [
        'interval' => 60,
        'display'  => 'Every 1 minute'
    ];

    return $schedules;
}