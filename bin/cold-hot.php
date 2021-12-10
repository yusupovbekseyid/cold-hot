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
    if ($argv[1] === "-r" || $argv[1] === "--replay") {
        key($argv[1], $argv[2]);
    } else {
        key($argv[1], null);
    }
} else {
    key("-n", null);
}
