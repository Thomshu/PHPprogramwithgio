<?php

declare(strict_types = 1);

$root = dirname(__DIR__) . DIRECTORY_SEPARATOR;

define('APP_PATH', $root . 'app' . DIRECTORY_SEPARATOR);
define('FILES_PATH', $root . 'transaction_files' . DIRECTORY_SEPARATOR);
define('VIEWS_PATH', $root . 'views' . DIRECTORY_SEPARATOR);

/* YOUR CODE (Instructions in README.md) */
//include("../app/App.php");
require APP_PATH . "App.php";

$filesArray = readCSVFiles(FILES_PATH); //Passing in the transaction_files folder path

$transactions = [];
foreach($filesArray as $file){
    $transactions = readFileValues($file);
}

#echo '<pre>';
#print_r($transactions);
#echo '</pre>';

$calculations = AmountCalc($transactions);

require VIEWS_PATH . 'transactions.php';

