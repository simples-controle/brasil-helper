<?php
// Report all PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include('BrasilHelper.php');
include('lib/pierophp/InscricaoEstadual.php');
$BrasilHelper = new sururulab\BrasilHelper\BrasilHelper();

// cnpj
echo "<b>USO</b>: BrasilHelper::checkCNPJ('23.419.212/0001-03')<br> <b>RETORNO</b>: ".$BrasilHelper::checkCNPJ('23.419.212/0001-03') . '<hr>';

// cpf
echo "<b>USO</b>: BrasilHelper::checkCPF('635.850.266-21')<br> <b>RETORNO</b>: ".$BrasilHelper::checkCPF('635.850.266-21') . '<hr>';

// cpf
echo "<b>USO</b>: BrasilHelper::checkIE('0136042371217', 'AC')<br> <b>RETORNO</b>: ".$BrasilHelper::checkIE('0136042371217', 'AC') . '<hr>';

// estados
echo "<b>USO</b>: BrasilHelper::estados()<br> <b>RETORNO</b>: <hr>";
var_dump($BrasilHelper::estados() );




