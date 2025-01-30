<?php
function validaUsuario($conn)
{
    session_start();

    $login = $_SESSION["username"];
    $senha = $_SESSION["password"];

    $sql = "SELECT 
           TB01066_USUARIO Usuario,
           TB01066_SENHA Senha
       FROM 
           TB01066
       WHERE 
           TB01066_USUARIO = '$login'
           AND TB01066_SENHA = '$senha'";
    $stmt = sqlsrv_query($conn, $sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $usuario = $row['Usuario'];
        $senha = $row['Senha'];
    }
    if ($usuario != NULL) {
        return strtoupper($login);

    } else {
        return print "<script>window.alert('É necessário fazer login!')</script>
                        <script>location.href='../login.php'</script>";
    }
}

function validaUsuarioFaixa($conn)
{
    session_start();

    $login = $_SESSION["username"];
    $senha = $_SESSION["password"];

    $sql = "SELECT 
           TB01066_USUARIO Usuario,
           TB01066_SENHA Senha
       FROM 
           TB01066
       WHERE 
           TB01066_USUARIO = '$login'
           AND TB01066_SENHA = '$senha'";
    $stmt = sqlsrv_query($conn, $sql);
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $usuario = $row['Usuario'];
        $senha = $row['Senha'];
    }
    if ($usuario != NULL) {
        return strtoupper($login);

    } else {
        return print "<script>window.alert('É necessário fazer login!')</script>
                        <script>location.href='login2.php'</script>";
    }
}



function contador($conn)
{
    /* Pega o ultimo contador da tabela GS_COTACAOES e soma +1 */
    $sql = "SELECT TOP 1 
                SUBSTRING(CODIGO, 0, 2)+FORMAT(CAST(SUBSTRING(CODIGO, 2, 6) AS NUMERIC) + 1, '00000') contadorTabMais,
                CODIGO UltimoContTab
                FROM GS_COTACOES
            ORDER BY DATA DESC";
    $stmt = sqlsrv_query($conn, $sql);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $contadorTabMais = $row['contadorTabMais'];
        $UltimoContTab = $row['UltimoContTab'];
    }

    /* Pega o ultimo contador do modulo definições de contadores */
    $sql = "SELECT TOP 1
                    SUBSTRING(TB00002_COD, 0, 2)+FORMAT(CAST(SUBSTRING(TB00002_COD, 2, 6) AS NUMERIC) + 1, '00000') contadorSisMais,
                    TB00002_COD UlitimoContSis
            FROM TB00002
            WHERE TB00002_TABELA = 'TB02018'";
    $stmt = sqlsrv_query($conn, $sql);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $contadorSisMais = $row['contadorSisMais'];
        $UlitimoContSis = $row['UlitimoContSis'];
    }

    if ($UltimoContTab == '' || $UltimoContTab == NULL) {
        $contador = $UlitimoContSis;
    } else {
        $contador = $contadorTabMais;
    }
    if ($contadorTabMais == $UlitimoContSis) {
        $contador = $contadorSisMais;
    }

    /* Confere se o contador repetiu */
    $sql = "SELECT TOP 1 
                CODIGO contRep
            FROM GS_COTACOES
            WHERE CODIGO = '$contadorTabMais;'";
    $stmt = sqlsrv_query($conn, $sql);

    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $contRep = $row['contRep'];
    }

    if ($contRep) {
        $contador = $contadorSisMais;
    }

    return $contador;
}

function insereLog($conn, $contador, $numSerie, $definiCli, $consumo, $Vendedor, $pessoa, $codCond, $codClass, $CodProd, $referencia, $status, $medPB, $medCOLOR, $medTOT, $vlrTOTAL, $tabela, $obs, $embalagem, $faixa, $readytorun)
{

    $sql = "INSERT INTO [dbo].[GS_COTACOES]
                        ([CODIGO]
                        ,[CLIENTE]
                        ,[TIPOCONS]
                        ,[VENDEDOR]
                        ,[PESSOA]
                        ,[CONDICAO]
                        ,[CLASSIFICACAO]
                        ,[PRODUTO]
                        ,[REFERENCIA]
                        ,[STATUS]
                        ,[MEDIDORPB]
                        ,[MEDIDORCOLOR]
                        ,[MEDIDORTOTAL]
                        ,[VALORFINAL]
                        ,[NUMSERIE]
                        ,[DATA]
                        ,[TABELA]
                        ,[OBS]
                        ,[VLREMBALAGEM]
                        ,[FAIXA]
                        ,[READYTORUN]
                        )
                    VALUES
                        ('$contador'
                        ,'$definiCli'
                        ,'$consumo'
                        ,'$Vendedor'
                        ,'$pessoa'
                        ,'$codCond'
                        ,'$codClass'
                        ,'$CodProd'
                        ,'$referencia'
                        ,'$status'
                        ,$medPB
                        ,$medCOLOR
                        ,$medTOT
                        ,$vlrTOTAL
                        ,'$numSerie'
                        ,GETDATE()
                        ,'$tabela'
                        ,'$obs'
                        ,'$embalagem'
                        ,'$faixa'
                        ,'$readytorun'
                        )
             ";

    $stmt = sqlsrv_query($conn, $sql);

    /* if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
        //print('Erro ao gravar log!');
    } */

}