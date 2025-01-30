<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/func.php";
include_once "../DB/filtros.php";


$usuario = $_POST['usuario'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/listar.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>

    <div id="loadingScreen">Carregando...</div>

    <div class="filter-container">
        <div class="div-int-filter">
            <div>
                <label for="startDate">Data Início:</label>
                <input type="date" id="startDate" class="filters">
            </div>
            <div>
                <label for="endDate">Data Fim:</label>
                <input type="date" id="endDate" class="filters">
            </div>
                <div class="custom-select">
                    <label for="filterClient">Cliente:</label>
                    <input type="text" id="filterClient" placeholder="Digite o nome do cliente" class="filters"
                        onkeyup="filterCliente()">
                    <div id="selectClienteLista" class="select-items">
                        <?php filtroCliente($conn); ?>
                    </div>
                </div>
            <div>
                <label for="filterCode">Código:</label>
                <input type="text" id="filterCode" placeholder="Digite o código" class="filters">
            </div>
        </div>
        <div class="div-btn-filter">
            <button class="btn-aplicar" id="applyFilters">Aplicar</button>
            <button class="btn-resetar" id="resetFilters">Resetar</button>
        </div>
        <button class="btn-voltar-lista" onclick="window.location.href='index.php'">Voltar</button>
    </div>
    </div>
    <div class="table-container">
        <table id="dataTable" class="table-container">
            <thead>
                <tr>
                    <th style = "text-align:center;" data-type="numeric">COTAÇÃO</th>
                    <th style = "text-align:center;" data-type="date">DATA</th>
                    <th style = "text-align:center;" data-type="text">CLIENTE</th>
                    <th style = "text-align:center;" data-type="numeric">QUANTIDADE</th>
                    <th style = "text-align:center;" data-type="numeric">VLR EMBALAGEM</th>
                    <th style = "text-align:center;" data-type="numeric">VALOR TOTAL</th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT 
                        CODIGO Cotacao,
                        FORMAT(CAST([DATA] AS DATE), 'yyyy-MM-dd') [Data],
                        ISNULL(TB01008_NOME, CLIENTE) NomeCli,
                        COUNT(NUMSERIE) QtProd,
                        FORMAT(SUM(VALORFINAL),'C','PT-BR') ValorTotal,
						FORMAT(SUM(VLREMBALAGEM),'C','PT-BR') vlrEmbalagem

                    FROM GS_COTACOES
                    LEFT JOIN TB01008 ON TB01008_CODIGO = CLIENTE
                    WHERE DATEDIFF(DAY,GETDATE(), DATA) <= 30
                    AND VENDEDOR = '$usuario'
                    GROUP BY CODIGO,
                            CAST(DATA AS DATE),
                            CLIENTE,
                            TB01008_NOME";
            $stmt = sqlsrv_query($conn, $sql);
            ?>
            <tbody>
                <?php
                $tabela = "";

                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $tabela .= "<tr>";
                    $tabela .= "<td style='color: red; cursor: pointer; text-align:center;'>" . $row['Cotacao'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['Data'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['NomeCli'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['QtProd'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['vlrEmbalagem'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['ValorTotal'] . "</td>";
                    $tabela .= "</tr>";
                }
                print ($tabela);
                ?>
            </tbody>
        </table>
    </div>
    <script src="../JS/listar.js" charset="utf-8"></script>
    <script src="../JS/filtrosListar.js" charset="utf-8"></script>
</body>

</html>