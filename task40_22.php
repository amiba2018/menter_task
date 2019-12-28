<?php
const HAND_INPUT = '1: グー 2: チョキ 3: パー 9: 終了する' . PHP_EOL;

const HAND_ROCK = 1;
const HAND_PAPER = 2;
const HAND_SCISSORS = 3;
const END_GAME_KEY = 9;

const SELECT_LIST = [
    HAND_ROCK => 'グー',
    HAND_PAPER => 'チョキ',
    HAND_SCISSORS => 'パー',
    END_GAME_KEY => '終了する'
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
    show($result, $playerHand, $comHand);

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
        echo sprintf('あなたの成績 : ' .'%d' .'勝' . '%d' .'敗' . '%d' . '分',$victory, $defeat, $draw) . PHP_EOL;
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

function show($result, $playerHand, $comHand) {
    switch ($result) {
        case RESULT_DRAW:
            $result = 'あいこで...';
        break;
        case RESULT_LOSE:
            $result = '負け!!';
        break;
        case RESULT_WIN:
            $result = '勝ち!!';
        break;
    }
    echo sprintf('あなた: ' . '%s' .' COM: ' . '%s', SELECT_LIST[$playerHand] ,SELECT_LIST[$comHand]) . PHP_EOL;
    echo $result . PHP_EOL;
}

function inputHand() {
    echo HAND_INPUT;
    echo ': ';
    $selectHand = trim(fgets(STDIN));
    if ($selectHand == END_GAME_KEY) {
        return gameEnd();
    }
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
    
    if(array_key_exists($selectHand, SELECT_LIST)) {
            return true;    
    }
        return false;
}

function gameEnd() {
    echo 'ゲームを終了します' . PHP_EOL;
    exit();
}
?>