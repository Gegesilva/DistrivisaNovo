<?php
session_start();

header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/filtros.php";
include_once "../DB/func.php";

validaUsuario($conn);

$Vendedor = validaUsuario($conn);

$codCotacao = $_POST['codCotacao'];

$sql = "SELECT TOP 1 [CODIGO]
            ,CAST(CLIENTE AS TEXT) CLIENTE
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
        FROM [dbo].[GS_COTACOES]
        WHERE CODIGO = '$codCotacao'
            ";
$stmt = sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $condicao = $row['CONDICAO'];
    $tabelaCust = $row['TABELA'];
    $cliente = strval($row['CLIENTE']);
    $pessoa = $row['PESSOA'];
    $classificacao = $row['CLASSIFICACAO'];
    $obs = $row['OBS'];
    $embalagem = $row['VLREMBALAGEM'];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $series = explode(',', $_POST['selecionado']); // Converte a string em array
    /* print_r($series); */ // Exibe o array
}

$serieEnvio = urlencode(serialize($series));

/* Pega o codigo da condição pelo nome passado pelo input da lista */
$sql = "SELECT TB01014_NOME NomeCond
        FROM TB01014
        WHERE TB01014_CODIGO = '$condicao'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $NomeCond = $row['NomeCond'];
}

/* Pega o codigo da tabela pelo nome passado pelo input da lista */
$sql = "SELECT TB01020_CODIGO Cod FROM TB01020
        WHERE TB01020_NOME = '$tabelaCust'
        AND TB01020_SITUACAO = 'A'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $tabelaCustCod = $row['Cod'];
}

/* Pega o codigo da tabela pelo nome passado pelo input da cliente */
$sql = "SELECT TB01008_NOME NomeCli FROM TB01008 
        WHERE TB01008_SITUACAO = 'A'
        AND TB01008_CODIGO = '$cliente'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $NomeCli = $row['NomeCli'];
}

/* Pega codigo de classificação */
$sql = "SELECT 
            TB01068_CODIGO Cod,
            TB01068_NOME Class
        FROM TB01068
        WHERE TB01068_SITUACAO = 'A'
        AND TB01068_NOME = '$classificacao'";

$stmt = sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $codClass = $row['Cod'];
}


/* Testa para ver oq foi preenchido no form Cliente/estado */
$QtCarac = mb_strlen($cliente, "utf-8");
if ($QtCarac == 8) {
    $cliente = $cliente[0];
} else {
    $cliente = $cliente[2].$cliente[3];
}

/* Da o nome correto para a variavel consumo */
if ($consumo == 'N') {
    $nomeConsumo = 'Revenda';
} else {
    $nomeConsumo = 'Consumo';
}

/* evita que a função de log seja executada ao atualizar a pagina */
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SESSION['funcao_executada'] == false) {
    $rodarlog = true;
    $_SESSION['funcao_executada'] = true;
    /* Gerar contador */
    $contador = contador($conn);
    $_SESSION['mostra_contador'] = contador($conn);
} else {
    $rodarlog = false;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/styleResult.css">
    <link rel="stylesheet" href="../CSS/styleBtn.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="cabecalho-result">
    <H3 class="titulo">COTAÇÃO</H3>
        <img class="logo" src="../img/logo.jpg" alt="logo">
        <div class="info-bloco">
            <div>
                <span><b><?= $QtCarac == 8 ? "Cliente: " : "Estado: " ?></b>
                         <?= $QtCarac == 8 ? $NomeCli : $cliente; ?></span>
                <span><b>Pessoa: </b> <?= $pessoa; ?></span>
            </div>
            <div>
                <span><b>Aplicação: </b> <?= $nomeConsumo; ?></span>
                <span><b>Condição: </b> <?= $NomeCond ?></span>
            </div>
            <div>
                <span><b>Vendedor: </b> <?= $Vendedor; ?></span>
                <span><b>Classificação: </b> <?= $classificacao; ?></span>
            </div>
            <div>
                <span><b>Cotação: </b> <?= $_SESSION['mostra_contador']; ?></span>
            </div>
        </div>
    </div>

    <h6 class="msg-os"></h6>
    <div class="form-group">
        <div class="form-input">
            <table id="tabelaValores" class="table table-sm" style="font-size: 12px;">
                <thead>
                    <tr>
                    <tr>
                        <th>PRODUTO</th>
                        <th>REFERENCIA</th>
                        <th>SÉRIE</th>
                        <th>FAIXA</th>
                        <!-- <th class="currency">PREVISÃO CHEGADA</th> -->
                        <th class="currency">STATUS</th>
                        <th>CONTADOR PB</th>
                        <th>CONTADOR COLOR</th>
                        <th>CONTADOR TOTAL</th>
                        <th class="currency">VALOR FINAL</th>
                    </tr>
                    </tr>
                </thead>
                <?php


                if (isset($series) && is_array($series)) {
                    // Recupera os valores das células selecionadas
                    $selecionados = $series;

                    foreach ($selecionados as $item) {
                        $serie = htmlspecialchars($item);
                        $sql = "SELECT [CODIGO]
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
                                    ,FORMAT(VALORFINAL, 'C','PT-BR') VALORFINAL
                                    ,[NUMSERIE]
                                    ,[FAIXA]
                                    ,[DATA]
                                    ,[TABELA]
                                FROM [dbo].[GS_COTACOES]
                                WHERE CODIGO = '$codCotacao'
                                    ";
                        $stmt = sqlsrv_query($conn, $sql);

                        ?>
                        <tbody>
                            <?php
                            $tabela = "";
                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                $tabela .= "<tr>";
                                $tabela .= "<td>" . $row['PRODUTO'] . "</td>";
                                $tabela .= "<td>" . $row['REFERENCIA'] . "</td>";
                                $tabela .= "<td>" . $row['NUMSERIE'] . "</td>";
                                $tabela .= "<td>" . $row['FAIXA'] . "</td>";
                                /* $tabela .= "<td class='currency'>" . $row['PREVISAOCHEGADA'] . "</td>"; */
                                $tabela .= "<td class='currency'>" . $row['STATUS'] . "</td>";
                                $tabela .= "<td>" . $row['MEDIDORPB'] . "</td>";
                                $tabela .= "<td>" . $row['MEDIDORCOLOR'] . "</td>";
                                $tabela .= "<td>" . $row['MEDIDORTOTAL'] . "</td>";
                                $tabela .= "<td class='currency'>" . $row['VALORFINAL'] . "</td>";
                                $tabela .= "</tr>";
                            }

                            print ($tabela);
                    }
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                        <th colspan="6">Total</th>
                        <th></th>
                        <th></th>
                        <th id="totalValorFinal" class="currency">R$ 0,00</th>
                    </tr>
                    <tr>
                        <th colspan="6">Valor Embalagem</th>
                        <th></th>
                        <th></th>
                        <th class="currency" id="ValorEmbalagem"><?=$embalagem?></th>
                    </tr>
                    <tr>
                        <th colspan="6">Total Geral</th>
                        <th></th>
                        <th></th>
                        <th class="currency" id="TotalGeral">R$ 0,00</th>
                    </tr>
                </tfoot>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="obs">
        <P><b>OBS: </b> VALIDADE DA COTACÃO - 1 DIA</P>
        &nbsp;<p> - ESSA COTACÃO NÃO RESERVA AS SÉRIES CONTIDAS NO MESMO. <?=$tabelaCust?></p>
    </div>
    <div class="obs-ins">
        <P><?=$obs?></p>
    </div>
    <div class="btn-index">
        <input type="hidden" name="trava" id="trava" value="1">
        <!-- <button type="submit" class="voltar-btn-form">Voltar</button>
            <input name="selecionado[]" type="hidden" value="<?= $selecionados ?>"> -->

        <button class="voltar-btn-form" onClick="window.location='../VW2/index.php';" type="submit"
            class="voltar-btn-form">Voltar</button>
    </div>
    <input type="hidden" id="urlOS" value="<?= $url ?>/save.php">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../JS/script.js" charset="utf-8"></script>
    <script src="../JS/totalizadores.js" charset="utf-8"></script>
</body>

</html>