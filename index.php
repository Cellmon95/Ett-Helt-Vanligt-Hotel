<?php
session_start();
$_SESSION["loginVerified"] = false;
include 'Calendar.php';
include 'hotelFunctions.php';

$calendarBudget = new Calendar('2023-01-01');
$calendarStandard = new Calendar('2023-01-01');
$calendarLuxury = new Calendar('2023-01-01');
$db = connect('vanligtHotelDB.sqlite');

$occupiedDatesBudget = getOccupiedDatesFromDB($db, 'budget');
$occupiedDatesStandard = getOccupiedDatesFromDB($db, 'standard');
$occupiedDatesLuxury = getOccupiedDatesFromDB($db, 'luxury');

foreach ($occupiedDatesBudget as $occupiedDateBudget) {
    $calendarBudget->add_event('Booked', $occupiedDateBudget, 1, 'red');
}

foreach ($occupiedDatesStandard as $occupiedDateStandard) {
    $calendarStandard->add_event('Booked', $occupiedDateStandard, 1, 'red');
}

foreach ($occupiedDatesLuxury as $occupiedDateLuxury) {
    $calendarLuxury->add_event('Booked', $occupiedDateLuxury, 1, 'red');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./css/style.css" />
    <link rel="stylesheet" href="./css/index.css" />
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Google+Sans:300,400,500" /> -->
    <link rel="stylesheet" href="css/calendar.css" />

    <title>Ett Helt Vanligt Hotel</title>
</head>

<body>
    <?php require("header.php") ?>
    <section id="hero">
        <img src="images/hero.jpg" />
        <h1>Ett Helt Vanligt Hotel</h1>
        <h2>Inget Fjanteri eller Trams</h2>
    </section>
    <section id="description">
        <p>
            Känner du dig också trött på allt hipster trams. Att du inte längre kan
            bara beställa en öl utan en stor lista på hundra tals så kallade “ipa”.
            Trött på alla dinosaurie, Beksinski och hårdrock hotel. När allt man
            bara vill ha är, just det, ett Helt Vanligt Hotel.
        </p>
        <img src="images/desc-img.jpg" />
    </section>

    <section id="rooms">
        <h2>Våra Rum</h2>
        <h3>Economy</h3>
        <img src="images/economy-room.jpg" />
        <p>
            Vårat simpla men ändå bekväma rum. Som sagt inga konstigheter, bara ett
            rum med säng, soffa, tv, skrivbord och toalett med dusch. Ett Wi-Fi som
            är lite sisådär och en minibar.
        </p>

        <h3>Standard</h3>
        <img src="images/standard-room.jpg" />
        <p>
            Vårat standard rum. Har allt som budget har men här får du havsutsikt
            och en liten mer bekvämare säng. Det kommer finnas chocklad på kudden
            när ni anländer och ni kommer där också ha tillgång till badkar.
        </p>

        <h3>Luxury</h3>
        <img src="images/luxury-room.jpg" />
        <p>
            Vårat finaste rum. Sängen är king size och extra mjuk. Rummet är i
            klassisk stil och när ni anländer kommer vi se till så att det finns en
            flaska champagne tillgänglig. I badrummet har ni också tillgång till ett
            härligt bubbelbad.
        </p>
    </section>

    <section id="status">
        <h3>Budget</h3>
        <?= $calendarBudget; ?>
        <h3>Standard</h3>
        <?= $calendarStandard; ?>
        <h3>Luxury</h3>
        <?= $calendarLuxury; ?>

    </section>

    <section id="booking">
        <form action="./book.php" method="post">
            <label for="transferCode">Transfear Code:</label>
            <input type="text" id="transferCode" name="transferCode"><br><br>
            <label for="name">Name:</label>
            <input type="text" id="costumerName" name="costumerName"><br><br>
            <label for="arrival">Arrival:</label>
            <input type="date" min="2023-01-01" max="2023-01-31" id="arrival" name="arrival"><br><br>
            <label for="departure">Departure:</label>
            <input type="date" min="2023-01-01" max="2023-01-31" id="departure" name="departure"><br><br>
            <label for="room">Room:</label>
            <div id="room">
                <input type="radio" id="roomType" name="roomType" value="budget" checked>
                <label for="radio">Budget</label><br>
                <input type="radio" id="roomType" name="roomType" value="standard">
                <label for="radio">Standard</label><br>
                <input type="radio" id="roomType" name="roomType" value="luxury">
                <label for="radio">Luxury</label><br>
            </div>

            <input type="submit" value="Boka">

        </form>
    </section>




    <footer>
        <div id="footer-left">
            <div></div>
            <svg width="123" height="91" viewBox="0 0 123 91" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M85.2244 46.8382C85.2244 59.675 74.8181 70.0812 61.9814 70.0812C49.1446 70.0812 38.7384 59.675 38.7384 46.8382C38.7384 34.0015 49.1446 23.5952 61.9814 23.5952C74.8181 23.5952 85.2244 34.0015 85.2244 46.8382Z" fill="#FFC700" />
                <line x1="84.226" y1="23.0744" x2="105.638" y2="6.60382" stroke="#FFC700" />
                <line x1="94.3693" y1="46.855" x2="122.369" y2="44.3844" stroke="#FFC700" />
                <line x1="83.9212" y1="69.9599" x2="108.681" y2="81.6733" stroke="#FFC700" />
                <line x1="61.9715" y1="73.682" x2="62.795" y2="90.9761" stroke="#FFC700" />
                <line x1="39.5552" y1="69.1501" x2="20.6141" y2="84.7972" stroke="#FFC700" />
                <line x1="31.8456" y1="50.3231" x2="0.0205851" y2="51.6343" stroke="#FFC700" />
                <path d="M60.2368 19.7645L55.7074 -0.000139508" stroke="#FFC700" />
                <path d="M38.98 26.6719L17.0449 12.3962" stroke="#FFC700" />
            </svg>
            <h4>Ett Helt Vanligt Hotel</h4>
        </div>

        <div id="footer-right">
            <h5>Kontakt</h5>
            <p>Vågvägen 6 1234 Spanien Plalla de Sol</p>
            <h5>Snabblänkar</h5>
            <ul>
                <li><a>Hem</a></li>
                <li><a>Rum</a></li>
                <li><a>Boka</a></li>
                <li><a>Kalender</a></li>
            </ul>
        </div>
    </footer>
</body>

</html>
