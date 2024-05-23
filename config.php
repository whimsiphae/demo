<?php
$link = mysqli_connect('localhost', 'scratch', 'lilcal', 'auto');

function fetch($query) {
    $result = db_query($query);
    return mysqli_fetch_assoc($result);
}

function db_query($query) {
    global $link;
    $result = mysqli_query($link, $query);
    return $result;
}