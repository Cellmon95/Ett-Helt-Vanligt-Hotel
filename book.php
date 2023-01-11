<?php


declare(strict_types=1);

$postdata = json_encode([
    "form_params" => [
        "transferCode" => '2e3c06ea-3b95-4ca6-b2ba-4346d9005d9e',
        "totalCost" => 10
    ]
]);

$options = [
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/json;  charset=UTF-8',
        'content' => $postdata
    ]
];

$context  = stream_context_create($options);

$result = file_get_contents('https://www.yrgopelago.se/centralbank/transfercode', false, $context);
header('Content-Type: application/json');
echo $result;
