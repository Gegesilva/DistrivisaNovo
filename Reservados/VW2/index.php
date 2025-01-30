<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/func.php";
validaUsuario($conn);
ini_set('max_input_vars', 3000);
error_reporting(0); // Desativa a exibição de todos os tipos de erros
ini_set('display_errors', '0'); // Garante que erros não sejam exibidos no navegador

/* pega o nome do usuario para passar para o modulo listar */
session_start();
$usuario = $_SESSION["username"];
strtoupper($usuario);

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>DATABIT</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="../CSS/styleTab.css">
        <link rel="stylesheet" href="../CSS/colunasfix.css">
        <link rel="stylesheet" href="../CSS/style2.css">
</head>

<body>
        <div class="div-geral">
                <div class="d-flex justify-content-between">
                        <h2>EQUIPAMENTOS EM ESTOQUE</h2>
                        <div>
                                <span id="rowCountDisplay" class="qtdeSerie"><b>Qtde itens:</b> 0</span>
                                <button class="btn-reset" id="resetBtn">Reset</button>
                        </div>
                </div>
                <form id="form-princ" action="../vw/index.php" method="post">
                        <div class="form-group mb-3">
                                <input type="text" class="form-control" id="globalFilter" placeholder="Filtro Geral">
                                <button type="submit" class="btn-selecionados">COTAÇÃO</button>
                        </div>
                        <div class="table-container">
                                <?php
                                $sql = "SELECT
                                                FORMAT(VALORVENDA, 'C', 'pt-br') VALORVENDA,
                                                VALORBASE VALORBASENUM,
                                                CONTAINER,
                                                STATUS,
                                                MARCA,
                                                MODELO,
                                                SERIE,
                                                PB,
                                                COLOR,
                                                TOTAL MedidorTotal,
                                                FATOR,
                                                SITUACAO,
                                                ORCAMENTO,
                                                CLIENTE,
                                                VENDEDOR,
                                                CLASSIFICACAO,
                                                OBSPEDIDO,
                                                OBSTECNICAS,
                                                NOTA,
                                                LOCAL
					FROM Equipamentos_Estoque_PHP
                                        ";
                                $stmt = sqlsrv_query($conn, $sql);

                                ?>

                                <table class="table table-borderless" id="sortableTable">
                                        <thead>
                                                <tr>
                                                        <th class="sticky filterAgrup ">
                                                                <div class="filter-container">MARCA <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(1)" id="filter1"
                                                                                type="text"
                                                                                class="form-control filter filter-input"
                                                                                data-column="0">
                                                                        <div class="dropdown" id="dropdown1">
                                                                        </div>
                                                                </div>
                                                        </th>

                                                        <th class="sticky filterAgrup fixed fixed-col ">
                                                                <div class="filter-container">MODELO <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(2)" id="filter2"
                                                                                type="text"
                                                                                class="form-control filter filter-input"
                                                                                data-column="1">
                                                                        <div class="dropdown" id="dropdown2">
                                                                        </div>
                                                                </div>
                                                        </th>
                                                        <th class="sticky  fixed2 fixed-col fixed-col-2">SÉRIE <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="2">
                                                        </th>
                                                        <th class="sticky ">STATUS <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="3">
                                                        </th>
                                                        <th class="sticky">PB <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="4">
                                                        </th>
                                                        <th class="sticky">COLOR <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="5">
                                                        </th>
                                                        <th class="sticky">TOTAL <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="6">
                                                        </th>
                                                        <th class="sticky">VALOR FINAL <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="7">
                                                        </th>
                                                        <th class="sticky">SITUAÇÃO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="8">
                                                        </th>
                                                        <th class="sticky">ORCAMENTO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="9">
                                                        </th>
                                                        <th class="sticky">CLIENTE <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="10">
                                                        </th>
                                                        <th class="sticky">VENDEDOR <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="11">
                                                        </th>
                                                        <th class="sticky">CLASSIFICAÇÃO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="12">
                                                        </th>
                                                        <th class="sticky">OBS PEDIDO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="13">
                                                        </th>
                                                        <th class="sticky">OBS TECNICAS <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="14">
                                                        </th>
                                                        <th class="sticky">NOTA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="15">
                                                        </th>
                                                        <th class="sticky">LOCAL <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter" data-column="16">
                                                        </th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <?php

                                                $tabela = "";
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $valorVenda = $row['VALORBASENUM'];
                                                        $contRef = $row['CONTREF'];
                                                        $medTotal = $row['MedidorTotal'];
                                                        $classificacao = $row['CODCLASSIFICACAO'];
                                                        $CodCliente = $row['CODCLIENTE'];
                                                        $dataChegada = $row['DATACHEGADA'];
                                                        $dtCad2018 = $row['DATACHEGADADATE'];
                                                        $pontuacao = $row['NOTA'];

                                                
                                                        /* Verifica se a serie esta na situação disponivel, se sim habilita a flag e input de valor */

                                                        $situacao = $row['SITUACAO'];
                                                        $inputRadio = "";
                                                        if ($situacao == 'DISPONIVEL') {
                                                                $inputRadio = "<input id='flagSerie' type='checkbox' name='selecionado[]' value='$row[SERIE]'>";
                                                                $inputVlr = "";//"<input id='vlrembalagem' class='vlrembalagem' type='number' step='0.01' placeholder='Vlr Emb' name='vlrembalagem[]'>";
                                                                $inputReadytorun = "";//"<input id='readytorun' class='vlrembalagem' type='number' step='0.01' placeholder='Readytorun' name='readytorun[]'>";
                                                        } else {
                                                                $primeiraLetra = substr($row['SITUACAO'], 0, 1);
                                                                $inputRadio = "";//"<span class='R-reservado'>$primeiraLetra</span>";
                                                                $inputVlr = "";
                                                                $inputReadytorun = "";
                                                        }


                                                        $tabela .= "<tr>";
                                                        $tabela .= "<td class=''>" . $row['MARCA'] . "</td>";
                                                        $tabela .= "<td class='sticky fixed fixed-col'>" . $row['MODELO'] . "</td>";
                                                        $tabela .= "<td class='sticky fixed2 fixed-col fixed-col-2'>$inputRadio " . $row['SERIE'] . "$inputVlr $inputReadytorun</td>";
                                                        $tabela .= "<td class=''>" . $row['STATUS'] . "</td>";
                                                        $tabela .= "<td>" . number_format($row['PB'], 0, '', '.') . "</td>";
                                                        $tabela .= "<td>" . number_format($row['COLOR'], 0, '', '.') . "</td>";
                                                        $tabela .= "<td>" . number_format($row['MedidorTotal'], 0, '', '.') . "</td>";
                                                        $tabela .= "<td>" . $row['VALORBASE'] . "</td>";
                                                        $tabela .= "<td>" . $row['SITUACAO'] . "</td>";
                                                        $tabela .= "<td>" . $row['ORCAMENTO'] . "</td>";
                                                        $tabela .= "<td>" . $row['CLIENTE'] . "</td>";
                                                        $tabela .= "<td>" . $row['VENDEDOR'] . "</td>";
                                                        $tabela .= "<td>" . $row['CLASSIFICACAO'] . "</td>";
                                                        $tabela .= "<td>" . $row['OBSPEDIDO'] . "</td>";
                                                        $tabela .= "<td>" . $row['OBSTECNICAS'] . "</td>";
                                                        $tabela .= "<td>" . $row['NOTA'] . "</td>";
                                                        $tabela .= "<td>" . $row['LOCAL'] . "</td>";
                                                        $tabela .= "</tr>";
                                                }
                                                $tabela .= "</table>";
                                                print ($tabela);
                                                ?>
                                        </tbody>
                                </table>
                </form>

        </div>
        <div class="acoes-rodape">
                <form action="../VW/cotacaoRec.php" method="POST">
                        <input class="input-rodape" name="codCotacao" type="text" placeholder="Recuperar Cotação">
                        <button class="btn-rodape">Gerar</button>
                </form>
                <form action="listar.php" method="POST">
                        <input type="hidden" name="usuario" id="usuario" value="<?= $usuario ?>">
                        <button class="btn-listar">Listar</button>

                </form>
                <button class="btn-exp" onclick="exportTableToExcel()">.xlsx</button>
                <form action="tabpreco.php" method="POST">
                        <input type="hidden" name="usuario" id="usuario" value="<?= $usuario ?>">
                        <!-- <button class="btn-preco">Tabela de preços</button> -->
                </form>
                <button class="btn-sair" onclick="location.href='../login.php'">Sair</button>
        </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <script src="../JS/filtros.js" charset="utf-8"></script>
        <script src="../JS/forms.js" charset="utf-8"></script>
</body>

</html>