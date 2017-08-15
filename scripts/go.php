<?php

    $getToken = isset($_GET['getToken']) ? $_GET['getToken'] : '';
    $sessionId = isset($_GET['sId']) ? $_GET['sId'] : '';
    $token = isset($_GET['token']) ? $_GET['token'] : '';

    if ($getToken == 1) {
        session_start();
        $_SESSION['token'] = md5(uniqid());

        echo json_encode(array('token' => $_SESSION['token'], 'sessionId' => session_id()));

        exit;
    }

    if ($sessionId != '' && $token != '') {
        session_id($sessionId);
        session_start();
        if ($_SESSION['token'] == $token) {
            $uid = (int)$_GET['uid'];
            setcookie('gbuid', $uid, time() + 3600 * 24 * 31, '/');
            echo 'matches';
        }
        else {
            echo 'doesn\'t match';
        }

        session_destroy();
        exit;

    }

?>
