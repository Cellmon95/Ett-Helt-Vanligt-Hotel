<?php

declare(strict_types=1);
session_start();
require __DIR__ . "/vendor/autoload.php";

//load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


if (isset($_POST["api_key"])) {
    $key = htmlspecialchars($_POST["api_key"]);
    if ($key == $_ENV["API_KEY"]) {
        $_SESSION["loginVerified"] = true;
        header("location:hotel-manager.php");
    } else {
        header("location:adminLogin.php");
    }
}
