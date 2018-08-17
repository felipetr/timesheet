<?php
session_start();
include 'configuracoes.php';
include 'conectar.php';
date_default_timezone_set('America/Recife');

$idhora = $_SESSION['ts_horaid'];

$agora = date("Y-m-d H:i:s");

$query = mysqli_query($link_db, "UPDATE ft_horas SET datasaida = '{$agora}'  WHERE  id='{$idhora}'") or die("Erro " . mysqli_error($link_db));

$agorastr= $agora.'';
$iniciostr= $_SESSION['ts_datainiciodb'].'';

$inicioc = new DateTime($iniciostr);
$agorac   = new DateTime($agorastr);


$diferenca = $inicioc->diff($agorac);

$horas = $diferenca->format("%H");
$minutos = $diferenca->format("%I");

$hora = $horas.':'.$minutos;
if ($hora == '00:00')
{
    echo 'menos de um minuto';
}

$horas = intval($horas);
$minutos = intval($minutos);

if($horas > 0)
{
    echo $horas.' hora';
    if($horas > 1)
    {
        echo 's';
    }
    if($minutos > 0)
    {
        echo ' e ';
    }

}


if($minutos > 0)
{
    echo $minutos.' minuto';
    if($minutos > 1)
    {
        echo 's';
    }

}







?>
