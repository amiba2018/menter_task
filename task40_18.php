<?php
const HAND_INPUT = '1: グー 2: チョキ 3: パー' . PHP_EOL;

const HAND_ROCK = 1;
const HAND_PAPER = 2;
const HAND_SCISSORS = 3;

const HAND_TYPE = [
    HAND_ROCK => "グー",
    HAND_PAPER => "チョキ",
    HAND_SCISSORS => "パー"
];

const RESULT_DRAW = 0;
const RESULT_LOSE = 1;
const RESULT_WIN = 2;

const CONTINUE_YES = 'y';
const CONTINUE_NO = 'n';

main();

function main() {
    static $draw = 0;    
    static $defeat = 0;
    static $victory = 0;

    $playerHand = inputHand();
    $comHand = getComHand();
    $result = judge($playerHand, $comHand);
    show($result,$playerHand, $comHand);

    switch ($result) {
        case RESULT_DRAW:
            $draw ++;    
        break;
        case RESULT_LOSE:
            $defeat ++;
        break;
        case RESULT_WIN:
            $victory ++;    
        break;
    }

    if($result === RESULT_DRAW){
        return main();
    }

    if(selectContinue()) {
        return main();
    } else {
        echo 'あなたの成績は' .$victory .'勝' .$defeat  .'敗' .$draw .'引き分けです' . PHP_EOL;
    }
}

function startShow() {
    echo '数値で入力してください' . PHP_EOL;
    echo HAND_INPUT;
    echo ': ';
}

function selectContinue() {
    echo 'もう一度やりますか？(yes/no)[y/n]: ';
    $answer = trim(fgets(STDIN));
    if ($answer === CONTINUE_YES) {
        return true;
    } elseif ($answer === CONTINUE_NO) {
        return false;
    } else {
        echo '"y"または"n"を入力して下さい' . PHP_EOL;
        return selectContinue();
    }
}

function show($result,$playerHand, $comHand) {
    switch ($result) {
        case RESULT_DRAW:
            $result = 'あいこで...';
        break;
        case RESULT_LOSE:
            $result = "あなたの負けです";
        break;
        case RESULT_WIN:
            $result = "あなたの勝ちです";
        break;
    }
    $result = '自分: ' . HAND_TYPE[$playerHand] . PHP_EOL . '相手: ' . HAND_TYPE[$comHand] . PHP_EOL . $result;
    echo $result . PHP_EOL;
}



function inputHand() {
    startShow();
    $selectHand = trim(fgets(STDIN));
    if(checkHand($selectHand) === false) {
        return inputHand();        
    }
    return $selectHand;
}

function getComHand() {
    $randomHand = mt_rand(1, 3);
    return $randomHand;
}

function judge($playerHand, $comHand) {
    $result = ($playerHand - $comHand + 3) % 3;
    return $result;
}

function checkHand($selectHand) {
    if($selectHand === '') {
        echo "入力値が空です" . PHP_EOL;
        echo "下記の数字を入力して下さい" . PHP_EOL;
        return false;
    }

    if(is_numeric($selectHand) === false) {
        echo "入力値が数字ではありません。" . PHP_EOL;
        echo "下記の数字を入力して下さい" . PHP_EOL;
        return false;
    }
    
    if(array_key_exists($selectHand, HAND_TYPE)) {
            return true;    
    }
    echo $selectHand . PHP_EOL;
    echo "下記の数字を入力して下さい" . PHP_EOL;
        return false;
}

?>