<?php

function readLines($filePath)
{
    return file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function extractData($line)
{
    return [
        'id'       => trim(substr($line, 0, 12)),
        'userID'   => trim(substr($line, 12, 6)),
        'bytesTX'  => (int) trim(substr($line, 18, 8)),
        'bytesRX'  => (int) trim(substr($line, 26, 8)),
        'dateTime' => trim(substr($line, 34, 17)),
    ];
}

function formatDateTime($dateTime)
{
    $date = date('D, d F Y H:i:s', strtotime($dateTime));
    return $date;
}

function formatLog($data)
{
    $bytesTX = number_format($data['bytesTX']);
    $bytesRX = number_format($data['bytesRX']);
    $date    = formatDateTime($data['dateTime']);

    return "{$data['userID']}|$bytesTX|$bytesRX|$date|{$data['id']}";
}

function writeOutput($filePath, $logs, $ids, $userIDs)
{

    file_put_contents($filePath, implode(PHP_EOL, $logs) . PHP_EOL . PHP_EOL);

    natsort($ids);
    file_put_contents($filePath, implode(PHP_EOL, $ids) . PHP_EOL . PHP_EOL, FILE_APPEND);

    $uniqueUsers = array_unique($userIDs);
    sort($uniqueUsers);

    foreach ($uniqueUsers as $index => $userID) {
        $line = "[" . ($index + 1) . "] $userID\n";
        file_put_contents($filePath, $line, FILE_APPEND);
    }
}
