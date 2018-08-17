<?php
$cep = $_POST['cep'];

$cep = str_replace('.','',$cep);
$cep = str_replace('-','',$cep);


$url = 'http://viacep.com.br/ws/'.$cep.'/json/';

$json = file_get_contents($url);

$ender = json_decode($json);

echo '<div id="logradj">'.$ender->logradouro.'</div>';
echo '<div id="bairroj">'.$ender->bairro.'</div>';
echo '<div id="cidadej">'.$ender->localidade.'</div>';
echo '<div id="ufj">'.$ender->uf.'</div>';