<?php
const HAND_INPUT = 'グー(0)、チョキ(1)、パー(2)' . PHP_EOL;

const HAND_ROCK = 0;
const HAND_PAPER = 1;
const HAND_SCISSORS = 2;

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
    echo HAND_INPUT;
    echo '上記からを数値で入力してください: ';
    $playerHand = trim(fgets(STDIN));
    if(checkHand($playerHand) === false) {
        return inputHand();        
    }
    return $playerHand;
}

function getComHand() {
    $comHand = mt_rand(0,2);
    return $comHand;
}

function judge($playerHand, $comHand) {
    $result = ($playerHand - $comHand + 3) % 3;
    return $result;
}

function checkHand($playerHand) {
    if($playerHand === '') {
        echo "入力値が空です" . PHP_EOL;
        echo "数値の0~2を入力して下さい" . PHP_EOL;
        return false;
    }

    if(is_numeric($playerHand) === false) {
        echo "入力値が数字ではありません。" . PHP_EOL;
        echo "数値の0~2を入力して下さい" . PHP_EOL;
        return false;
    }
    
    if(array_key_exists($playerHand, HAND_TYPE)) {
            return true;    
    }
    echo $playerHand . PHP_EOL;
    echo "数値の0~2を入力して下さい" . PHP_EOL;
        return false;
}

?>