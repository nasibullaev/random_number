<?php

define('API_KEY', 'token');
$admin = 1062436669; 

require 'functions.php';

if($msg == "/start") {
    // logic
    $min = file_get_contents("users/$userid/min.txt");
    $max = file_get_contents("users/$userid/max.txt");
    $miqdor = file_get_contents("users/$userid/miqdor.txt");
    $random = [];
    for ($i = 0; $i < $miqdor; $i++) {
        array_push($random, rand($min,$max));
    }
    sort($random);
    $str = implode(',', $random);
    $str = str_replace(',', '
', $str);
    sm($str, null, $userid, 'html');
}

if($msg == "/min") {
    $min = file_get_contents("users/$userid/min.txt");
    sm("Minimal raqam - $min. O'zgartirish uchun yangi raqam yuboring");
    pstep('min');
}
if($step == 'min') {
    put("users/$userid/min.txt", $msg);
    sm("Minimal raqam o'zgartirildi - $msg");
    pstep('success');
}

if($msg == "/max") {
    $max = file_get_contents("users/$userid/max.txt");
    sm("Maksimal raqam - $min. O'zgartirish uchun yangi raqam yuboring");
    pstep('max');
}
if($step == 'max') {
    put("users/$userid/max.txt", $msg);
    sm("Maksimal raqam o'zgartirildi - $msg");
    pstep('success');
}

if($msg == "/miqdor") {
    $miqdor = file_get_contents("users/$userid/miqdor.txt");
    sm("Generatsiya qilinadigan raqamlar miqdori - $miqdor. O'zgartirish uchun yangi raqam yuboring:");
    pstep('miqdor');
}
if($step == 'miqdor') {
    if(is_string($msg)){
        put("users/$userid/miqdor.txt", $msg);
        sm("Miqdor o'zgartirildi - $msg");
        pstep('success');
    }
    else {
        sm('Raqam jo\'nating');
    }
}

