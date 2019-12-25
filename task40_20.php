<?php
const HAND_INPUT = '1: グー 2: チョキ 3: パー' . PHP_EOL;

const HAND_ROCK = 1;
const HAND_PAPER = 2;
const HAND_SCISSORS = 3;

const HAND_TYPE = [
    HAND_ROCK => 'グー',
    HAND_PAPER => 'チョキ',
    HAND_SCISSORS => 'パー'
];

const RESULT_DRAW = 0;
const RESULT_LOSE = 1;
const RESULT_WIN = 2;

const CONTINUE_YES = 'y';
const CONTINUE_NO = 'n';

startShow();
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

    if(selectContinue('end')) {
        return main();
    } else {
        echo 'あなたの成績 : ' .$victory .'勝' .$defeat  .'敗' .$draw .'分' . PHP_EOL;
    }
}

function startShow() {
    if(selectContinue('start')) {
        echo '数値で入力してください' . PHP_EOL;
        return;
    } else {
        exit();
    }
}

function selectContinue($type) {
    if ($type === 'start') {
        echo 'ゲーム開始？(y/n)[yes/no]: ';
    } elseif ($type === 'end') {
        echo 'もう一度やりますか？(y/n)[yes/no]: ';
    }
    $answer = trim(fgets(STDIN));
    if ($answer === CONTINUE_YES) {
        return true;
    } elseif ($answer === CONTINUE_NO) {
        return false;
    } else {
        echo 'yesの"y"またはnoの"n"を入力して下さい' . PHP_EOL;
        return selectContinue($type);
    }
}

function show($result,$playerHand, $comHand) {
    switch ($result) {
        case RESULT_DRAW:
            $result = 'あいこで...';
        break;
        case RESULT_LOSE:
            $result = '勝ち!!';
        break;
        case RESULT_WIN:
            $result = '負け!!';
        break;
    }
    $result = 'あなた: ' . HAND_TYPE[$playerHand] .' COM: ' . HAND_TYPE[$comHand] . PHP_EOL . $result;
    echo $result . PHP_EOL;
}



function inputHand() {
    echo HAND_INPUT;
    echo ': ';
    $selectHand = trim(fgets(STDIN));
    if(checkHand($selectHand) === false) {
        echo '指定された数字を入力して下さい(半角)' . PHP_EOL;
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
        return false;
    }

    if(is_numeric($selectHand) === false) {
        return false;
    }
    
    if(array_key_exists($selectHand, HAND_TYPE)) {
            return true;    
    }
        return false;
}

?>