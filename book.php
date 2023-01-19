<?php

declare(strict_types=1);
require __DIR__ . "/vendor/autoload.php";
include 'hotelFunctions.php';
header('Content-Type: application/json; charset=utf-8');

//load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
$db = new PDO("sqlite:vanligtHotelDB.sqlite");

$stmt = $db->prepare("SELECT room, price from prices");
$stmt->execute();
$prices = $stmt->fetchAll(PDO::FETCH_ASSOC);
$roomPrices = [
    $prices[0]["room"] => $prices[0]["price"],
    $prices[1]["room"] => $prices[1]["price"],
    $prices[2]["room"] => $prices[2]["price"]
];



$client = new \GuzzleHttp\Client();

$transferCode = $_POST['transferCode'];
$arrival = $_POST['arrival'];
$departure = $_POST['departure'];
$costumerName = $_POST['costumerName'];
$db = connect('vanligtHotelDB.sqlite');
$roomType = $_POST['roomType'];
//$totalPrice = calcTotalPrice();

function checkIfDateIsFree(DateTime $arrival, DateTime $departure, PDO $db, string $roomType)
{

    $dayIntervall = DateInterval::createFromDateString('1 day');
    $datesStaying = new DatePeriod($arrival, $dayIntervall, $departure);


    $datesOccupied = getOccupiedDatesFromDB($db, $roomType);

    foreach ($datesStaying as $dateStaying) {
        $dateStayingAsString = $dateStaying->format('l Y-m-d');
        foreach ($datesOccupied as $dateOccuppied) {
            if ($dateStayingAsString === $dateOccuppied) {
                return false;
            }
        }
    }

    return true;
}

function checkIfTransferCodeIsValid(string $transferCode, int $roomPrice, $client)
{
    $response =  $client->post('https://www.yrgopelago.se/centralbank/transferCode', [
        'form_params' => [
            'transferCode' => $transferCode,
            'totalcost' => $roomPrice
        ]
    ]);
    $responseBody = json_decode((string)$response->getBody(), true);

    if (isset($responseBody['error'])) {
        return false;
    } else {
        return true;
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

function printJson($arrival, $departure, $totalCost)
{
    $confirmJson = [
        'island' => $_ENV['ISLAND_NAME'],
        'hotel' => $_ENV['HOTEL_NAME'],
        'arrival_date' => $arrival,
        'departure_date' => $departure,
        'total_cost' => $totalCost,
        'stars' => $_ENV['STARS'],
        'features' => 'none',
        'additional_info' => ''
    ];

    echo json_encode($confirmJson);
}

function logToDB($arrival, $departure, $costumer, $roomType, $totalCost)
{
    $db = connect('vanligtHotelDB.sqlite');
    $query = 'INSERT INTO booking(arrival, departure, costumer, room, total_cost) VALUES
    ("' . $arrival . '" , "' . $departure . '", "' . $costumer . '" , "' . $roomType . '" , "' .  $totalCost . '")';


    $sth = $db->prepare($query);
    $sth->execute();
}

function calcDaysBeetwenArrivalAndDepature($arrival, $departure)
{
    $daysInSeconds = strtotime($arrival) - strtotime($departure);
    return abs(round($daysInSeconds / 86400));
}

//execute

if (checkIfDateIsFree(new Datetime($arrival), new DateTime($departure), $db, $roomType)) {

    //calculate total cost
    $roomPrice = $roomPrices[$roomType];
    $daysStayed = calcDaysBeetwenArrivalAndDepature($arrival, $departure);
    $totalCost = $roomPrice * $daysStayed;

    if (checkIfTransferCodeIsValid($transferCode, (int)$totalCost, $client)) {
        beginTransaction($client, $transferCode);
        logToDB($arrival, $departure, $costumerName, $roomType, $totalCost);
        printJson($arrival, $departure, $totalCost);
    } else {
        echo '{
            "error": "TransferCode är inte giltig eller redan använd!!!"
        }';
    }
} else {
    echo '{
            "error": "Rummet är inte ledigt!!!"
        }';
}
