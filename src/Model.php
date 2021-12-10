<?php

namespace yusupovbekseyid\cold_hot\Model;

use SQLite3;
use RedBeanPHP\R;

R::setup("sqlite:DB.db");

function insertDB($currentNumber)
{
    date_default_timezone_set("Europe/Moscow");

    $gameData = date("d") . "." . date("m") . "." . date("Y");
    $gameTime = date("H") . ":" . date("i") . ":" . date("s");

    $db = R::dispense('gamesinfo');
    $db->date = $gameData;
    $db->time = $gameTime;
    $db->playerName = getenv("username");
    $db->secretNumber = $currentNumber;
    $db->gameResult = "Не закончено";
    return R::store($db);
}

function updateDB($id, $result)
{
    $db = R::load('gamesinfo', $id);
    $db->game_result = $result;
    R::store($db);
}

function showList()
{
    $db = R::getAll('SELECT * FROM gamesinfo');
    if (sizeof($db) != 0) {
        foreach ($db as $row) {
            \cli\line("ID: $row[id]");
            \cli\line("Дата: $row[date]");
            \cli\line("Время: $row[time]");
            \cli\line("Имя: $row[player_name]");
            \cli\line("Загаданное число: $row[secret_number]");
            \cli\line("Результат: $row[game_result]");
        }
    } else {
        \cli\line("База данных пуста.");
    }
}

function insertReplay($id, $turnResult)
{
    $db = R::dispense('turnsnfo');
    $db->gameID = $id;
    $db->turnResult = $turnResult;
    R::store($db);
}

function showReplay($id)
{
    $db = R::getAll("SELECT * FROM turnsnfo WHERE game_id = '$id'");
    if (sizeof($db) != 0) {
        foreach ($db as $row) {
            \cli\line("$row[turn_result]");
        }
    } else {
        \cli\line("База данных пуста, либо не правильный id игры.");
    }
}

R::close();
