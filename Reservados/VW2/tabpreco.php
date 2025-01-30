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
$usuario = $_POST["usuario"];
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
                <div class="d-flex justify-content-between align-items-center">
                        <h2>TABELA DE PREÇOS</h2>
                        <div class="ms-3">

                                <!-- <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="1" >
                                        REFERENCIA</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="2" >
                                        DESCRICAO</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="3" >
                                        MARCA</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="4" >
                                        FAIXA</label> -->
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="35" checked>
                                        ALMEJADO</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="5"> A
                                        VISTA</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="6"> A VISTA +
                                        3%</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="7"> A VISTA +
                                        6%</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="8"> A VISTA +
                                        9%</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="9">
                                        BASICO</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="10"> BASICO +
                                        3%</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="11"> BASICO +
                                        6%</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="12"> BASICO +
                                        9%</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="14"> PALLET A
                                        VISTA</label>
                                <label class="labelTabPreco"><input type="checkbox" class="column-toggle"
                                                data-column="15">
                                        PALLET</label>
                        </div>
                        <div>
                                <!-- <span id="rowCountDisplay" class="qtdeSerie"><b>Qtde itens:</b> 0</span> -->
                                <button class="btn-reset" id="resetBtn">Reset</button>
                        </div>
                </div>
                <form id="form-princ" action="../vw/index.php" method="post">
                        <div class="form-group mb-3">
                                <input type="text" class="form-control" id="globalFilter" placeholder="Filtro Geral">
                                <!-- <button type="submit" class="btn-selecionados">COTAÇÃO</button> -->
                        </div>
                        <?php
                        $sql = "SELECT 
                                                REFERENCIA,
                                                DESCRICAO,
                                                MARCA,
                                                FAIXA,
                                                FORMAT(AVISTA, 'C', 'pt-br') AVISTA,
                                                FORMAT(AVISTA3, 'C', 'pt-br') AVISTA3,
                                                FORMAT(AVISTA6, 'C', 'pt-br') AVISTA6,
                                                FORMAT(AVISTA9, 'C', 'pt-br') AVISTA9,
                                                FORMAT(BASICO, 'C', 'pt-br') BASICO,
                                                FORMAT(BASICO3, 'C', 'pt-br') BASICO3,
                                                FORMAT(BASICO6, 'C', 'pt-br') BASICO6,
                                                FORMAT(BASICO9, 'C', 'pt-br') BASICO9,
                                                FORMAT(ALMEJADO, 'C', 'pt-br') ALMEJADO,
                                                FORMAT(PALLET_AVISTA, 'C', 'pt-br') PALLET_AVISTA,
                                                FORMAT(PALLET, 'C', 'pt-br') PALLET

                                        FROM TABELA_MODELO_PHP";
                        $stmt = sqlsrv_query($conn, $sql);
                        ?>
                        <div class="table-container">
                                <table class="table table-borderless" id="sortableTable2">
                                        <thead>
                                                <tr>
                                                        <!-- <th class="sticky columnOcult-1">REFERENCIA <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-1"
                                                                        data-column="1"></th> -->

                                                        <th
                                                                class="sticky filterAgrup columnOcult-1 fixed-preco fixed-col-preco">
                                                                <div class="filter-container">REFERÊNCIA <i
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

                                                        <th class="sticky columnOcult-2">DESCRICAO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-2"
                                                                        data-column="1"></th>

                                                        <!-- <th class="sticky filterAgrup columnOcult-2">
                                                                <div class="filter-container">DESCRIÇÃO <i
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
                                                        </th> -->

                                                        <!-- <th class="columnOcult-3">MARCA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-3"
                                                                        data-column="3"></th> -->

                                                        <th
                                                                class="sticky filterAgrup columnOcult-3 fixed2-preco fixed-col-preco2">
                                                                <div class="filter-container">MARCA <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(3)" id="filter3"
                                                                                type="text"
                                                                                class="form-control filter filter-input"
                                                                                data-column="2">
                                                                        <div class="dropdown" id="dropdown3">
                                                                        </div>
                                                                </div>
                                                        </th>


                                                        <!-- <th class="sticky columnOcult-4">FAIXA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-4"
                                                                        data-column="4"></th> -->

                                                        <th class="sticky filterAgrup columnOcult-4">
                                                                <div class="filter-container">FAIXA <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(4)" id="filter4"
                                                                                type="text"
                                                                                class="form-control filter filter-input"
                                                                                data-column="3">
                                                                        <div class="dropdown" id="dropdown4">
                                                                        </div>
                                                                </div>
                                                        </th>
                                                        <th class="sticky columnOcult-35">ALMEJADO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-35"
                                                                        data-column="4"></th>
                                                        <th class="sticky columnOcult-5">A VISTA <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-5"
                                                                        data-column="5"></th>
                                                        <th class="sticky columnOcult-6">A VISTA + 3% <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-6"
                                                                        data-column="6"></th>
                                                        <th class="sticky columnOcult-7">A VISTA + 6% <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-7"
                                                                        data-column="7"></th>
                                                        <th class="sticky columnOcult-8">A VISTA + 9% <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-8"
                                                                        data-column="8"></th>
                                                        <th class="sticky columnOcult-9">BASICO <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-9"
                                                                        data-column="9"></th>
                                                        <th class="sticky columnOcult-10">BASICO + 3% <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-10"
                                                                        data-column="10"></th>
                                                        <th class="sticky columnOcult-11">BASICO + 6% <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-11"
                                                                        data-column="11"></th>
                                                        <th class="sticky columnOcult-12">BASICO + 9% <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-12"
                                                                        data-column="11"></th>
                                                        <th class="sticky columnOcult-14">PALLET A VISTA <i
                                                                        class="fa fa-sort" aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-14"
                                                                        data-column="13"></th>
                                                        <th class="sticky columnOcult-15">PALLET <i class="fa fa-sort"
                                                                        aria-hidden="true"></i><input
                                                                        onclick="clicouNoFilho(event)" type="text"
                                                                        class="form-control filter columnOcult-15"
                                                                        data-column="14"></th>

                                                        <!-- <th class="sticky ">STATUS OS <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter" data-column="6"> -->

                                                        <!-- <th class="sticky filterAgrup ">
                                                                <div class="filter-container">MARCA <i
                                                                                class="fa fa-sort"
                                                                                aria-hidden="true"></i><input
                                                                                onclick="clicouNoFilho(event)"
                                                                                oninput="showDropdown(3)" id="filter3"
                                                                                type="text"
                                                                                class="form-control filter filter-input"
                                                                                data-column="2">
                                                                        <div class="dropdown" id="dropdown3">
                                                                        </div>
                                                                </div>
                                                        </th> -->
                                                </tr>
                                        </thead>
                                        <tbody>
                                                <?php
                                                $tabela = "";
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $tabela .= "<tr>";

                                                        $tabela .= "<td class='columnOcult-1 fixed-preco fixed-col-preco'>" . $row['REFERENCIA'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-2'>" . $row['DESCRICAO'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-3 fixed2-preco fixed-col-preco2'>" . $row['MARCA'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-4'>" . $row['FAIXA'] . "</td>";

                                                        $tabela .= "<td class='columnOcult-35' style='background-color: #e2f1bb;'> " . $row['ALMEJADO']. "</td>";
                                                        $tabela .= "<td class='columnOcult-5' style= 'background-color: #ffff89;'> " . $row['AVISTA'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-6' style= 'background-color: #ffff89;'> " . $row['AVISTA3'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-7' style= 'background-color: #ffff89;'> " . $row['AVISTA6'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-8' style= 'background-color: #ffff89;'> " . $row['AVISTA9'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-9' style= 'background-color: #ade0ee;'> " . $row['BASICO'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-10' style= 'background-color: #ade0ee;'> " . $row['BASICO3'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-11' style= 'background-color: #ade0ee;'> " . $row['BASICO6'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-12' style= 'background-color: #ade0ee;'> " . $row['BASICO9'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-14' style='background-color: #ffae69;'> " . $row['PALLET_AVISTA'] . "</td>";
                                                        $tabela .= "<td class='columnOcult-15' style='background-color: #ffae69;'> " . $row['PALLET'] . "</td>";
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
                        <!-- <input class="input-rodape" name="codCotacao" type="text" placeholder="Recuperar Cotação">
                        <button class="btn-rodape">Gerar</button> -->
                </form>
                <input type="hidden" name="usuario" id="usuario" value="<?= $usuario ?>">

                <button class="btn-exp" onclick="exportTableToExcel()">Exportar .xlsx</button>
                <button class="btn-sair" onclick="location.href='index.php'">Voltar</button>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
        <script src="../JS/tabprecoFiltros.js" charset="utf-8"></script>
        <script src="../JS/forms.js" charset="utf-8"></script>
        <script src="../JS/tabpreco.js" charset="utf-8"></script>
</body>

</html>