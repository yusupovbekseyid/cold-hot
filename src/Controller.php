<?php

namespace yusupovbekseyid\cold_hot\Controller;

use function yusupovbekseyid\cold_hot\View\showGame;
use function yusupovbekseyid\cold_hot\Model\insertDB;
use function yusupovbekseyid\cold_hot\Model\insertReplay;
use function yusupovbekseyid\cold_hot\Model\showList;
use function yusupovbekseyid\cold_hot\Model\showReplay;
use function yusupovbekseyid\cold_hot\Model\updateDB;

function key($key, $id)
{
    if ($key == "--new" || $key == "-n") {
        startGame();
    } elseif ($key == "--list" || $key == "-l") {
        showList();
    } elseif ($key == "--replay" || $key == "-r") {
        showReplay($id);
    } else {
        echo "Wrong key\n";
    }
}

function restart()
{
    $restart = readline("Хотите сыграть ещё?[Y/N]\n");
    if ($restart == "Y") {
        startGame();
    } else {
        exit;
    }
}

function chekResult($numberArray, $currentNumber)
{
    $result = "Исходы:";
    for ($i = 0; $i < 3; $i++) {
        if ($numberArray[$i] == $currentNumber[$i]) {
            $result .= " Горячо!;";
            echo "Горячо!\n";
        } elseif (
            $numberArray[$i] == $currentNumber[0] ||
            $numberArray[$i] == $currentNumber[1] ||
            $numberArray[$i] == $currentNumber[2]
        ) {
            $result .= " Тепло!;";
            echo "Тепло!\n";
        } else {
            $result .= " Холодно!;";
            echo "Холодно!\n";
        }
    }
    return $result;
}

function startGame()
{
    showGame();
    $number = 0;
    $currentNumber = random_int(100, 999);
    $id = insertDB($currentNumber);
    $turn = 0;

    $currentNumber = str_split($currentNumber);
    while ($number != $currentNumber) {
        $number = readline("Введите трехзначное число : ");
        if (is_numeric($number)) {
            if (strlen($number) != 3) {
                echo "Ошибка! Число должно быть трехзначным\n";
            } else {
                $numberArray = str_split($number);
                if ($numberArray == $currentNumber) {
                    echo "Вы выиграли!\n";
                    $result = "Победа";
                    updateDB($id, $result);
                    $turn++;
                    $turnRes = chekResult($numberArray, $currentNumber);
                    $turnResult = $turn . " | " . $number . " | " . $turnRes;
                    insertReplay($id, $turnResult);
                    restart();
                } else {
                    $turn++;
                    $turnRes = chekResult($numberArray, $currentNumber);
                    $turnResult = $turn . " | " . $number . " | " . $turnRes;
                    insertReplay($id, $turnResult);
                }
            }
        } else {
            echo "Ошибка! Введите число.\n";
        }
    }
}
