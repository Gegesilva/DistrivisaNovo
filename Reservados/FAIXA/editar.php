<?php
include_once "../DB/conexaoSQL.php";
// 2. Receber os dados POST
$produto = $_POST['produto'];
$nome = $_POST['nome'];
$valida1 = $_POST['valida1'];
$valida2 = $_POST['valida2'];
$faixa = $_POST['faixa'];


$sql = "SELECT 
            CODIGO,
            NOME,
            VALIDA1,
            VALIDA2,
            FAIXA
        FROM GS_FAIXA 
                WHERE 
                codigo = '$produto' 
                AND nome = '$nome' 
                AND valida1 = '$valida1' 
                AND valida2 = '$valida2' 
                AND faixa = $faixa ";
$stmt = sqlsrv_query($conn, $sql);


    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $codigo = $row['CODIGO'];
        $nome = $row['NOME'];
        $valida1 = $row['VALIDA1'];
        $valida2 = $row['VALIDA2'];
        $faixa = $row['FAIXA'];
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/inserir.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Filtro -->
    <div class="filter-container">
        <h4 class="titulo">Editar</h4>
        <button class="btn-voltar" onclick="voltar()">Voltar</button>
    </div>

    <!-- Tabela -->
    <form id="form2">
        <div class="filter-container">
            <div class="div-int-filter">
                <div>
                    <label for="produto">Produto</label>
                    <input id="produtoIn" type="text" class="filters"  minlength="6" maxlength="6" value="<?= $codigo ?>" disabled required>
                </div>
                <div>
                    <label for="nome">Nome</label>
                    <input id="nomeIn" type="text" class="filters" value="<?= $nome ?>" required>
                </div>
                <div>
                    <label for="valida1">Valida 1</label>
                    <input id="valida1In" type="text" class="filters" value="<?= $valida1 ?>" required>
                </div>
                <div>
                    <label for="valida2">Valida 2</label>
                    <input id="valida2In" type="text" class="filters" value="<?= $valida2 ?>" required>
                </div>
                <div>
                    <label for="faixa">Faixa</label>
                    <input id="faixaIn" type="number" step="0.01" class="filters" value="<?= $faixa ?>" required>
                </div>
            </div>
            <div>
                <button class="btn-inserir">Salvar</button>
            </div>

        </div>
        <input id="produto" type="hidden" value="<?= $codigo ?>">
        <input id="nome" type="hidden" value="<?= $nome ?>">
        <input id="valida1" type="hidden" value="<?= $valida1 ?>">
        <input id="valida2" type="hidden" value="<?= $valida2 ?>">
        <input id="faixa" type="hidden" value="<?= $faixa ?>">
    </form>
    <div class="resultados" id="resultados"></div>
    <script src="../JS/inserir.js" charset="utf-8"></script>
</body>

</html>