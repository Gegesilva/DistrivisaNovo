<?php
header('Content-type: text/html; charset=ISO-8895-1');
include_once "../DB/conexaoSQL.php";
include_once "../DB/func.php";

session_start();
validaUsuarioFaixa($conn);

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
        <h4 class="titulo">Novo Registro</h4>
        <button class="btn-voltar" onclick="voltar()">Voltar</button>
    </div>

    <!-- Tabela -->
    <form id="form">
        <div class="filter-container">
            <div class="div-int-filter">
                <div>
                    <label for="produto">Produto</label>
                    <input id="produto" type="text" class="filters" minlength="5" maxlength="5" required>
                </div>
                <div>
                    <label for="nome">Nome</label>
                    <input id="nome" type="text" class="filters" required>
                </div>
                <div>
                    <label for="valida1">Valida 1</label>
                    <input id="valida1" type="text" class="filters" required>
                </div>
                <div>
                    <label for="valida2">Valida 2</label>
                    <input id="valida2" type="text" class="filters" required>
                </div>
                <div>
                    <label for="faixa">Faixa</label>
                    <input id="faixa" type="number" step="0.01" class="filters" required>
                </div>
            </div>
            <div>
                <button class="btn-inserir">Inserir</button>
            </div>

        </div>
    </form>
    <div class="resultados" id="resultados"></div>
    <script src="../JS/inserir.js" charset="utf-8"></script>
</body>

</html>