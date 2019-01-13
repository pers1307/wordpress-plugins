<?php
include_once dirname(__FILE__) . '/wfm_check.php';
/**
 * Срабатывает при удалении
 */
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit();
}
global $wpdb;

if (wfm_check('wfm_views')) {
    $query = "ALTER TABLE $wpdb->posts DROP `wfm_views`";
    $wpdb->query($query);
}