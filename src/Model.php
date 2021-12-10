<?php

namespace yusupovbekseyid\cold_hot\Model;

use SQLite3;

function openDB()
{
    if (!file_exists("DB.db")) {
        $db = createDB();
    } else {
        $db = new SQLite3("DB.db");
    }

    return $db;
}

function createDB()
{
    $db = new SQLite3("DB.db");

    $game = "CREATE TABLE games(
        gameId INTEGER PRIMARY KEY,
        gameDate DATE,
        gameTime TIME,
        playerName TEXT,
        secretNumber INTEGER,
        gameResult TEXT
    )";
    $db->exec($game);

    $turns = "CREATE TABLE info(
        gameId INTEGER,
        gameResult TEXT
    )";
    $db->exec($turns);

    return $db;
}

function insertDB($currentNumber)
{
    $db = openDB();

    date_default_timezone_set("Europe/Moscow");
    $gameData = date("d") . "." . date("m") . "." . date("Y");
    $gameTime = date("H") . ":" . date("i") . ":" . date("s");
    $playerName = getenv("username");

    $db->exec("INSERT INTO games (
        gameDate, 
        gameTime,
        playerName,
        secretNumber,
        gameResult
        ) VALUES (
        '$gameData', 
        '$gameTime',
        '$playerName',
        '$currentNumber',
        'Не закончено'
        )");

    return $db;
}

function updateDB($id, $result)
{
    $db = openDB();
    $db -> exec("UPDATE games
        SET gameResult = '$result'
        WHERE gameId = '$id'");
}

function showList()
{
    $db = openDB();
    $query = $db->query('SELECT Count(*) FROM games');
    $DBcheck = $query->fetchArray();
    $query = $db->query('SELECT * FROM games');
    if ($DBcheck[0] != 0) {
        while ($row = $query->fetchArray()) {
            \cli\line("ID $row[0])\n Дата: $row[1]\n Время: $row[2] 
 Имя: $row[3]\n Загаданное число: $row[4]\n Результат: $row[5]");
        }
    } else {
        \cli\line("База данных пуста.");
    }
}

function insertReplay($id, $turnResult)
{
    $db = openDB();
    $db -> exec("INSERT INTO info (
    gameID,
    gameResult
    ) VALUES (
    '$id',
    '$turnResult')");
}

function showReplay($id)
{
    $db = openDB();
    $query = $db->query("SELECT Count(*) FROM info WHERE gameID = '$id'");
    $DBcheck = $query->fetchArray();
    if ($DBcheck[0] != 0) {
        \cli\line("Повтор игры с id = " . $id);
        $query = $db->query("SELECT gameResult FROM info WHERE gameID = '$id'");
        while ($row = $query->fetchArray()) {
            \cli\line("$row[0]");
        }
    } else {
        \cli\line("База данных пуста, либо не правильный id игры.");
    }
}
