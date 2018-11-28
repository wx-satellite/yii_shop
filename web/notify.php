<?php


$url="http://119.23.70.61:8080/pay/notify.html";

$post = $_POST;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
$out=curl_exec($ch);
curl_close($ch);
echo $out;