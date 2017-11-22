<?php

session_start();
if(empty($_SESSION["__id"])){
	exit;
}else{

$file = getcwd().'/'.$_GET["path"];
//echo $file. " - ".filesize($file); exit;

if(file_exists($file)){
	$type = 'image/png';
	header('Content-Type:'.$type);
	header('Content-Length: ' . filesize($file));
	readfile($file);
}

/*$img = file_get_contents($file);
    echo $img;*/

}


?>