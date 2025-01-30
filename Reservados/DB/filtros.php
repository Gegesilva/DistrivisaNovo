<?php
function filtroEstado($conn)
{
    $sql = "SELECT DISTINCT TB00043_ESTADO Estado FROM TB00043";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao .= "<div data-value='$row[Estado]'>$row[Estado]</div>";

    }
    return print ($opcao);
}

function filtroCondicao($conn)
{
    $sql = "SELECT TB01014_NOME CondRec, TB01014_CODIGO Cod FROM TB01014 WHERE TB01014_SITUACAO = 'A'";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao .= "<div id='itemSelect' data-condicao='$row[Cod]'>$row[CondRec]</div>";

    }
    return print ($opcao);
}

function filtroTabela($conn)
{
    $sql = "SELECT 
                TB01020_CODIGO Cod, 
                TB01020_NOME Nome 
            FROM TB01020
            WHERE TB01020_SITUACAO = 'A'";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao .= "<div  data-tabela='$row[Cod]'>$row[Nome]</div>";

    }
    return print ($opcao);
}


function filtroClass($conn)
{
    $sql = "SELECT 
                TB01068_CODIGO Cod,
                TB01068_NOME Class
            FROM TB01068
            WHERE TB01068_SITUACAO = 'A'";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao .= "<div  data-tabela='$row[Cod]'>$row[Class]</div>";

    }
    return print ($opcao);
}



function filtroCliente($conn)
{
    $sql = "SELECT 
                TB01008_CODIGO Cod,
                TB01008_NOME Nome
            FROM TB01008
            WHERE TB01008_SITUACAO = 'A'";

    $stmt = sqlsrv_query($conn, $sql);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }


    $opcao = "";

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $opcao .= "<div  data-tabela='$row[Cod]'>$row[Nome]</div>";

    }
    return print ($opcao);
}


