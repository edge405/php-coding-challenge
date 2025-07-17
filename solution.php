<?php
require_once 'utils.php';

$inputFile = 'sample-log.txt';
$outputFile = 'output.txt';

$lines = readLines($inputFile);

$formattedLogs = [];
$ids = [];
$userIDs = [];

foreach ($lines as $line) {
    $data = extractData($line);

    if ($data) {
        $formattedLogs[] = formatLog($data);
        $ids[] = $data['id'];
        $userIDs[] = $data['userID'];
    }
}

writeOutput($outputFile, $formattedLogs, $ids, $userIDs);
