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
                <div class="d-flex justify-content-between align-items-center">
                        <h2>EQUIPAMENTOS EM ESTOQUE</h2>
                        <div class="ms-3">
                                <label><input type="checkbox" class="column-toggle" data-column="12" checked> A VISTA</label>
                                <label><input type="checkbox" class="column-toggle" data-column="13" checked> A VISTA + 3%</label>
                                <label><input type="checkbox" class="column-toggle" data-column="14" checked> A VISTA + 6%</label>
                                <label><input type="checkbox" class="column-toggle" data-column="15" checked> A VISTA + 9%</label>
                                <label><input type="checkbox" class="column-toggle" data-column="16" checked> BASICO</label>
                                <label><input type="checkbox" class="column-toggle" data-column="17" checked> BASICO + 3%</label>
                                <label><input type="checkbox" class="column-toggle" data-column="18" checked> BASICO + 6%</label>
                                <label><input type="checkbox" class="column-toggle" data-column="19" checked> BASICO + 9%</label>
                                <label><input type="checkbox" class="column-toggle" data-column="20" checked> ALMEJADO</label>
                                <label><input type="checkbox" class="column-toggle" data-column="21" checked> PALLET A VISTA</label>
                                <label><input type="checkbox" class="column-toggle" data-column="22" checked> PALLET</label>
                        </div>
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
                        <?php
                                $sql = "SELECT 
                                                REFERENCIA,
                                                DESCRICAO,
                                                MARCA,
                                                FAIXA,
                                                AVISTA,
                                                AVISTA3,
                                                AVISTA6,
                                                AVISTA9,
                                                BASICO,
                                                BASICO3,
                                                BASICO6,
                                                BASICO9,
                                                ALMEJADO,
                                                PALLET_AVISTA,
                                                PALLET

                                        FROM TABELA_MODELO_PHP";
                $stmt = sqlsrv_query($conn, $sql);
                        ?>
                        <div class="table-container">
                                <table class="table table-borderless" id="sortableTable">
                                        <thead>
                                                <tr>
                                                        <th class="sticky column-12">A VISTA <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-13">A VISTA + 3% <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-14">A VISTA + 6% <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-15">A VISTA + 9% <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-16">BASICO <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-17">BASICO + 3% <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-18">BASICO + 6% <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-19">BASICO + 9% <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-20">ALMEJADO <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-21">PALLET A VISTA <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                        <th class="sticky column-22">PALLET <i class="fa fa-sort" aria-hidden="true"></i><input onclick="clicouNoFilho(event)" type="text" class="form-control filter"></th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $tabela = "";
                                                while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                                                        $tabela .= "<tr>";
                                                        
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA3'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA6'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ffff89;'>" . $row['AVISTA9'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO3'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO6'] . "</td>";
                                                        $tabela .= "<td style= 'background-color: #ade0ee;'>" . $row['BASICO9'] . "</td>";
                                                        $tabela .= "<td style='background-color: #e2f1bb;'>" . $row['ALMEJADO'] . "</td>";
                                                        $tabela .= "<td style='background-color: #ffae69;'>" . $row['PALLET_AVISTA'] . "</td>";
                                                        $tabela .= "<td style='background-color: #ffae69;'>" . $row['PALLET'] . "</td>";
                                                        $tabela .= "</tr>";
                                                }
                                                $tabela .= "</table>";
                                                print ($tabela);
                                                ?>
                                        </tbody>
                                </table>
                </form>
        </div>
        <script>
                document.querySelectorAll('.column-toggle').forEach(checkbox => {
                        checkbox.addEventListener('change', function () {
                                document.querySelectorAll(`.column-${this.dataset.column}`).forEach(el => {
                                        el.style.display = this.checked ? '' : 'none';
                                });
                        });
                });
        </script>
</body>

</html>
