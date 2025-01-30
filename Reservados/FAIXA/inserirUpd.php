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

// 3. Comando SQL para deletar o registro
$sql = "INSERT INTO GS_FAIXA(
                            CODIGO,
                            NOME,
                            VALIDA1,
                            VALIDA2,
                            FAIXA
                        )VALUES(
                            '$produto',
                            '$nome',
                            '$valida1',
                            '$valida2',
                            $faixa
                        )";

$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    echo json_encode($sql);
    /* die (print_r(sqlsrv_errors(), true)); */
} else {
     echo json_encode('Faixa inserida!');
}