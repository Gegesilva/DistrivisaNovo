<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/func.php";
include_once "../DB/filtros.php";

session_start();
validaUsuarioFaixa($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/faixa.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <h4 class="titulo-geral">FAIXAS</h4>
    <div class="filter-container">
        <div>
            <label for="filtro-produto">Produto:</label>
            <input class="filters" type="text" id="filtro-produto" placeholder="Digite o código">
        </div>
        <div class="div-btn-filter">
            <button class="btn-aplicar" onclick="aplicarFiltro()">Aplicar</button>
            <button class="btn-resetar" onclick="resetarFiltro()">Resetar</button>
        </div>
        <button class="btn-inserir" onclick="window.location.href='inserir.php'">Inserir</button>
    </div>

    <!-- Tabela -->
    <div class="table-container">
        <table id="tabela-produtos" class="table-container">
            <thead>
                <tr>
                    <th style="text-align:center;" data-type="numeric">PRODUTO</th>
                    <th style="text-align:center;" data-type="text">NOME</th>
                    <th style="text-align:center;" data-type="text">VALIDA 1</th>
                    <th style="text-align:center;" data-type="numeric">VALIDA 2</th>
                    <th style="text-align:center;" data-type="numeric">FAIXA</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <?php
            $sql = "SELECT 
                        CODIGO,
                        CAST(NOME AS VARCHAR) NOME,
                        VALIDA1,
                        VALIDA2,
                        FAIXA
                    FROM GS_FAIXA";
            $stmt = sqlsrv_query($conn, $sql);
            ?>
            <tbody>
                <?php
                $tabela = "";

                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                    $tabela .= "<tr>";
                    $tabela .= "<td style='text-align:center;'>" . $row['CODIGO'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['NOME'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['VALIDA1'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['VALIDA2'] . "</td>";
                    $tabela .= "<td style='text-align:center;'>" . $row['FAIXA'] . "</td>";
                    $tabela .= "<td><button class='btn-editar' onclick='editarLinha(this)'>Editar</button></td>";
                    $tabela .= "<td><button class='btn-deletar' onclick='deletarLinha(this)'>Deletar</button></td>";
                    $tabela .= "</tr>";
                }
                print ($tabela);
                ?>
            </tbody>
        </table>
    </div>
    <script src="../JS/faixa.js" charset="utf-8"></script>
</body>

</html>