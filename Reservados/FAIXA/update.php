<?php
include_once "../DB/conexaoSQL.php";
include_once "../DB/func.php";

session_start();
validaUsuarioFaixa($conn);

// 2. Receber os dados POST
$produto = $_POST['produto'];
$nome = $_POST['nome'];
$valida1 = $_POST['valida1'];
$valida2 = $_POST['valida2'];
$faixa = $_POST['faixa'];


$produtoIn = $_POST['produtoIn'];
$nomeIn = $_POST['nomeIn'];
$valida1In = $_POST['valida1In'];
$valida2In = $_POST['valida2In'];
$faixaIn = $_POST['faixaIn'];


$sql = "UPDATE 
            GS_FAIXA
        SET NOME = '$nomeIn',
            VALIDA1 = '$valida1In',
            VALIDA2 = '$valida2In',
            FAIXA = $faixaIn
        WHERE  
            codigo = '$produto' 
            AND nome = '$nome' 
            AND valida1 = '$valida1' 
            AND valida2 = '$valida2' 
            AND faixa = $faixa";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    echo json_encode($sql);
    /* die (print_r(sqlsrv_errors(), true)); */
} else {
     echo json_encode('Faixa atualizada!');
}