<?php
// Exports the expense totalizer to CSV
require_once $_SERVER['DOCUMENT_ROOT'] . "/../vendor/autoload.php";

use Classes\ExpenseTotalizer;
session_start();
if (isset($_SESSION['totalizer'])) {
    ExpenseTotalizer::exportToCsv(unserialize($_SESSION['totalizer']));
}