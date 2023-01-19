<?php
$db = new PDO("sqlite:vanligtHotelDB.sqlite");

$stmt = $db->prepare("SELECT * from booking");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $db->prepare("SELECT sum(total_cost) as revenue from booking");
$stmt->execute();
$revenue = $stmt->fetchAll(PDO::FETCH_DEFAULT);


$logbook = file_get_contents("logbook.json");
$logbook = json_decode($logbook, true);
$logbook = $logbook["vacation"];

$totalCost = 0;
$features = [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/logbook.css">
    <title>Document</title>
</head>

<body>
    <section class="factBoxes">
        <section class="factBox card">
            <?php foreach ($logbook as $vacation) {
                $totalCost += $vacation["total_cost"];
                foreach ($vacation["features"] as $feature) {
                    $features[] = $feature["name"];
                }
            }
            $featureCount = array_count_values($features);
            $mostCommonFeature = array_search(max($featureCount), $featureCount);
            $howManyTimes = $featureCount[$mostCommonFeature];
            ?>
            <h1>Fact box</h1>
            <h2>
                <?php echo "You have spent a total of $" . $totalCost . " on your vacations across the yrgopelago!" ?>
            </h2>
            <p><?php echo "Your favorite feature was: $mostCommonFeature"; ?></p>
            <p><?php echo "You purchased this feature " . $howManyTimes . " times" ?></p>

        </section>
        <section class="factBox card closed revenue">
            <h3>Revenue</h3>
            <h4><?php echo "People have paid a total of $" . ($revenue[0]["revenue"]) . " to stay at your hotel" ?></h2>
                <?php foreach ($bookings as $booking) : ?>
                    <div class="costumerBooking">
                        <p><?php echo $booking["costumer"] . " paid $" . $booking["total_cost"] ?></p>
                        <p><?php echo "arrived: " . $booking["arrival"] ?></p>
                        <p><?php echo "departed: " . $booking["departure"] ?></p>
                    </div>
                <?php endforeach ?>
                <div class="openBox">More</div>
        </section>
    </section>
    <section class="logbookCards">
        <?php foreach ($logbook as $vacation) : ?>
            <div class="card">
                <h2>
                    <?php echo $vacation["hotel"]; ?>
                </h2>
                <h2><?php for ($i = 0; $i < $vacation["stars"]; $i++) {
                        echo " * ";
                    } ?></h2>
                <h3><?= $vacation["island"] ?></h3>
                <section class="generalInfo">
                    <div>
                        <?= "arrival: " . $vacation["arrival_date"] ?>
                    </div>
                    <div>
                        <?= "departure: " . $vacation["departure_date"] ?>
                    </div>
                </section>
                <section class="features">
                    <h4>Features</h4>
                    <?php foreach ($vacation["features"] as $feature) : ?>
                        <p> <?= $feature["name"] ?></p>
                    <?php endforeach ?>
                </section>
                <h4><?php echo "Total cost: $" . $vacation["total_cost"] ?></h4>
            </div>
        <?php endforeach; ?>
    </section>


    <script>
        const openBoxButton = document.querySelector(".openBox");
        const revenueBox = document.querySelector(".revenue");
        openBoxButton.addEventListener("click", () => {
            revenueBox.classList.remove("closed");
            openBoxButton.remove();
        })
    </script>
</body>

</html>
