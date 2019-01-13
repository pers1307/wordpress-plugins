<?php

function wfm_deactivate()
{
    $date = date('Y-m-d H:i:s');
    error_log(
        $date . ' Плагин активирован\r\n',
        3,
        dirname(__FILE__) . '/errors.log'
    );
}