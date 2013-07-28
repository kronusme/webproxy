<?php

function webproxy_session_start() {
    if (isset($_COOKIE['PHPSESSID'])) {
        $sessid = $_COOKIE['PHPSESSID'];
        if (!preg_match('/^[a-z0-9]*$/', $sessid)) {
            return false;
        }
    }
    session_start();
    return true;
}