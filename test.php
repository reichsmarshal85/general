<?php
include('config.php');

$qryObj = new mysqliQueryClass();
$query = $qryObj->getEmployeeName(1019);

if ($query) {
    print_r($query);
} else {
    echo 'An error occurred!';
}