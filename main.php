<?php

declare(strict_types=1);

$db = connect('vanligtHotelDB.sqlite');
$query = 'SELECT * FROM booking';

$sth = $db->prepare($query);
$sth->execute();

$array = $sth->fetchAll();

var_dump($array[0]['costumer']);
