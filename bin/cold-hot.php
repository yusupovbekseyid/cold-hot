<?php

$github = __DIR__ . '/../vendor/autoload.php';
$packagist = __DIR__ . '/../../../autoload.php';

if (file_exists($github)) {
    require_once($github);
} else {
    require_once($packagist);
}

use function yusupovbekseyid\cold_hot\Controller\key;
if (isset($argv[1])) {
    $key = $argv[1];
    key($key);
} else {
    $key = "-n";
    key($key);
}
