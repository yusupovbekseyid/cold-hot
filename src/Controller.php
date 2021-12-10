<?php

namespace yusupovbekseyid\cold_hot\Controller;

use function yusupovbekseyid\cold_hot\View\showGame;

function key($key)
{
    if ($key == "--new" || $key == "-n") {
        startGame();
    } elseif ($key == "--list" || $key == "-l") {
        echo "Database is being developed\n";
    } elseif ($key == "--replay" || $key == "-r") {
        echo "Replay is being developed\n";
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

function startGame()
{
    showGame();
    $number = 0;
    $currentNumber = random_int(100, 999);
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
                    restart();
                } else {
                    for ($i = 0; $i < 3; $i++) {
                        if ($numberArray[$i] == $currentNumber[$i]) {
                            echo "Горячо!\n";
                        } elseif (
                            $numberArray[$i] == $currentNumber[0] ||
                            $numberArray[$i] == $currentNumber[1] ||
                            $numberArray[$i] == $currentNumber[2]
                        ) {
                            echo "Тепло!\n";
                        } else {
                            echo "Холодно!\n";
                        }
                    }
                }
            }
        } else {
            echo "Ошибка! Введите число.\n";
        }
    }
}
