<?php


declare(strict_types=1);
require __DIR__ . "/vendor/autoload.php";
include 'hotelFunctions.php';

const roomPrices = [
    'budget' => 3,
    'standard' => 5,
    'luxury' => 8
];

$client = new \GuzzleHttp\Client();

$transferCode = $_POST['transferCode'];
$arrival = $_POST['arrival'];
$departure = $_POST['departure'];
//$totalPrice = calcTotalPrice();


function calcTotalPrice()
{
    $roomPrice = $_POST['room'];
    $daysStayed = $_POST['departure'] - $_POST['arrival'];
    $totalPrice = $roomPrice * $daysStayed;
    return $totalPrice;
}

function checkIfTransferCodeIsValid(string $transferCode, int $roomPrice, $client)
{
    $response =  $client->post('https://www.yrgopelago.se/centralbank/transferCode', [
        'form_params' => [
            'transferCode' => $transferCode,
            'totalcost' => roomPrices[$roomPrice]
        ]
    ]);

    $responseBody = json_decode((string)$response->getBody(), true);

    if (isset($responseBody['error'])) {
        return true;
    } else {
        return false;
    }
}

//TODO:: don't have user name in code
function beginTransaction($client, $transferCode)
{
    $response =  $client->post('https://www.yrgopelago.se/centralbank/transferCode', [
        'form_params' => [
            'user' => 'Lucas',
            'transfercode' => $transferCode
        ]
    ]);
}

function printJson()
{
    $confirmJson = [
        'island' => 'La isla normal',
        'hotel' => 'Det Vanliga Hotelet',
        'arrival_date' => $arrival,
        'departure_date' => $departure,
        'total_cost' => $totalCost,
        'stars' => 3,
        'features' => 'none',
        'additional_info' => 'Din Mamma'
    ];

    echo json_encode($confirmJson);
}

function logToDB($arrival, $departure, $costumer, $room)
{
    $db = connect('vanligtHotelDB.sqlite');
    $query = 'INSERT INTO booking VALUES
    (3, ' . $arrival . '. , ' . $departure . ', "' . $costumer . '" , "' . $room . '")';


    $sth = $db->prepare($query);
    $sth->execute();
}

function calcDaysBeetwenArrivalAndDepature($arrival, $departure)
{
    $test = strtotime($arrival) - strtotime(($departure));
    return abs(round($test / 86400));
}

//execute
/*
if (checkIfTransferCodeIsValid($transferCode, $roomPrice, $client)) {
    beginTransaction($client, $transferCode);
    logToDB();
} else {
    echo 'The transferCode is not valid';
}
*/
