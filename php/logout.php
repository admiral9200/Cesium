<?php
session_start();

if (!isset($_SESSION['email'])) {
    http_response_code(400);
    header('location: ../');
}

session_unset();
session_destroy();

header("location: ../");