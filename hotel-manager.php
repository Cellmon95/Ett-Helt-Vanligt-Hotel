<?php

declare(strict_types=1);
session_start();
if (!$_SESSION["loginVerified"]) {
    header("location:adminLogin.php");
}
// Always require autoload when using packages
require(__DIR__ . '/vendor/autoload.php');

// Tell PHP to use this fine package
use Dotenv\Dotenv;

// "Connect" to .env and load it's content into $_ENV
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$db = new PDO("sqlite:vanligtHotelDB.sqlite");

$stmt = $db->prepare("SELECT room, price from prices");
$stmt->execute();
$prices = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <?php require("header.php") ?>

    <h1>Hotel Stars</h1>
    <section class="starsSection">

        <?php
        $howmanyStars = 3;

        if (isset($_POST['submit'])) {
            $input = $_POST['input'];
            if (empty($input)) {
                echo "Please enter how many stars you want";
            } else {
                preg_match('/\d+/', $input, $extractedStars);
                $howmanyStars = $extractedStars[0];
                if (!preg_match('/please/i', $input)) {
                    echo "Please?";
                } else {
                    if ($howmanyStars === 1) {
                        if (!preg_match('/star/i', $input)) {
                            echo $howmanyStars . " what? apples? bananas?";
                        } else {
                            if ($howmanyStars >= 1 && $howmanyStars <= 5) {
                                echo "Number of stars set to: " . $howmanyStars;
                                putenv("STARS=$howmanyStars");
                                $env = file_get_contents(".env");
                                $env = preg_replace("/STARS=.*/", "STARS=$howmanyStars", $env);
                                file_put_contents(".env", $env);
                            } else {
                                echo "You can only have between 1 and 5 stars!";
                            }
                        }
                    } else {
                        if (!preg_match('/stars/i', $input)) {
                            echo $howmanyStars . " what? apples? bananas?";
                        } else {
                            if ($howmanyStars >= 1 && $howmanyStars <= 5) {
                                echo "Number of stars set to: " . $howmanyStars;
                                putenv("STARS=$howmanyStars");
                                $env = file_get_contents(".env");
                                $env = preg_replace("/STARS=.*/", "STARS=$howmanyStars", $env);
                                file_put_contents(".env", $env);
                            } else {
                                echo "You can only have between 1 and 5 stars!";
                            }
                        }
                    }
                }
            }
        }
        ?>


        <form action="" method="post">
            <h3>How many stars do you want?</h3>
            <textarea name="input" id="" cols="30" rows="5"></textarea>
            <input type="submit" name="submit" value="Submit">
        </form>

    </section>
</body>

</html>
