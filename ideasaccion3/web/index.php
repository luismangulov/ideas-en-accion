<?php

// comment out the following two lines when deployed to production
/*
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');*/
session_start();
$_SESSION["nonce"] = base64_encode(rand());
$csp = "Content-Security-Policy: script-src 'strict-dynamic'  'nonce-".$_SESSION["nonce"]."'   'unsafe-inline' www.google-analytics.com fonts.gstatic.com www.youtube.com data: maxcdn.bootstrapcdn.com stats.g.doubleclick.net drive.google.com; object-src 'self'; base-uri 'none'; report-uri http://localhost:8080;";
//$csp = "Content-Security-Policy: script-src 'self'   'unsafe-inline' www.google-analytics.com fonts.gstatic.com www.youtube.com data: maxcdn.bootstrapcdn.com stats.g.doubleclick.net drive.google.com; object-src 'self'; base-uri 'none'; report-uri http://localhost:8080;";
header($csp);

function getnonceideas(){
    
    return $_SESSION["nonce"];
}

function zdateRelative($date)
{
    $now = time();
    $diff = $now - $date;

    if ($diff < 60){
        return sprintf($diff > 1 ? 'hace %s segundos' : 'recientemente', $diff);
    }

    $diff = floor($diff/60);

    if ($diff < 60){
        return sprintf($diff > 1 ? 'hace %s minutos' : 'hace un minuto', $diff);
    }

    $diff = floor($diff/60);

    if ($diff < 24){
        return sprintf($diff > 1 ? 'hace %s horas' : 'hace una hora', $diff);
    }

    $diff = floor($diff/24);

    if ($diff < 7){
        return sprintf($diff > 1 ? 'hace %s días' : 'hace un día', $diff);
    }

    if ($diff < 30)
    {
        $diff = floor($diff / 7);

        return sprintf($diff > 1 ? 'hace %s semanas' : 'hace una semana', $diff);
    }

    $diff = floor($diff/30);

    if ($diff < 12){
        return sprintf($diff > 1 ? 'hace %s meses' : 'hace un mes', $diff);
    }

    $diff = date('Y', $now) - date('Y', $date);

    return sprintf($diff > 1 ? 'hace %s años' : 'hace un año', $diff);
}

function rand_char($length) {
  $random = '';
  for ($i = 0; $i < $length; $i++) {
    $random .= chr(mt_rand(33, 126));
  }
  return $random;
}


require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/../config/web.php');



(new yii\web\Application($config))->run();

