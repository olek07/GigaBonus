<?php

$apiKey = 'f5hhGHJ346dffgnfdf237d87hfg';
$tolerance = 60;
$expire = time()+60*60*24*30;           // 30 days


if (isset($_GET['visitingTime']) && isset($_GET['userId']) && isset($_GET['token'])) {

    $visitingTime = $_GET['visitingTime'];
    $userId = $_GET['userId'];
    $token = $_GET['token'];

    $timeStamp = time();

    if (md5($userId . $visitingTime . $apiKey) == $token) {

        $visitingTime = 1485269493;

        if (abs($timeStamp - $visitingTime) < $tolerance) {
            setcookie('gb_userId', $userId, $expire, '/');
            header('Location:/');
            exit;
            # echo ($timeStamp - $visitingTime) . ' ok';
        }
        else {
            echo ($timeStamp - $visitingTime) . ' nicht ok';
        }
    }

}