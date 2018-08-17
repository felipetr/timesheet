<?php
session_start();
$nome = $_SESSION['ts_nome'];
$hash = $_SESSION['ts_hash'];
$sexo = $_SESSION['ts_sexo'];
$id = $_SESSION['ts_id'];
session_destroy();
session_unset();

session_start();
$_SESSION['ts_nome'] = $nome;
$_SESSION['ts_hash'] = $hash;
$_SESSION['ts_sexo'] = $sexo;
$_SESSION['ts_id'] = $id;
?>
<META http-equiv="refresh" content="0;URL=./">