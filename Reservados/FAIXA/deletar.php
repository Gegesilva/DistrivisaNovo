<?php

include_once "../DB/conexaoSQL.php";

// 2. Receber os dados POST
$produto = $_POST['produto'];
$nome = $_POST['nome'];
$valida1 = $_POST['valida1'];
$valida2 = $_POST['valida2'];
$faixa = $_POST['faixa'];

// 3. Comando SQL para deletar o registro
$sql = "DELETE FROM GS_FAIXA 
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
     echo json_encode('Faixa deletada!');
}