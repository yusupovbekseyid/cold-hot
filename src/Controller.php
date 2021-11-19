<?php
    namespace ssiffonn\cold_hot\Controller;
    use function ssiffonn\cold_hot\View\showGame;

    function startGame(){
        echo "Game started".PHP_EOL;
        showGame();
    }
?>