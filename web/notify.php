<?php


$url="http://blog.w.labyun.com.cn/index.php?r=pay/notify";

$post = $_POST;
$ch=curl_init();
curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);
curl_setopt($ch,CURLOPT_POSTFIELDS,$post);
$out=curl_exec($ch);
curl_close($ch);
echo $out;