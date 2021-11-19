<?php
    namespace yusupovbekseyid\cold_hot\Controller;
    use function yusupovbekseyid\cold_hot\View\showGame;

    function startGame(){
        echo "Game started".PHP_EOL;
        showGame();
    }
?>