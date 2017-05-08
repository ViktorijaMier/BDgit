<?php
/**
 * @param $message
 * @param $exceptionMessage
 */
function add_log_line($message, $exceptionMessage)
{
    $file = 'logs' . DIRECTORY_SEPARATOR . 'log-' . date('Y-m-d') . '.log';

    $file = fopen($file, 'a');

    fwrite($file, $message . ' ' . $exceptionMessage . "\n");
    fclose($file);
}
