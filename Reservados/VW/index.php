<?php
header('Content-type: text/html; charset=ISO-8895-1');
session_start();
include_once "../DB/conexaoSQL.php";
include_once "../DB/filtros.php";
ini_set('max_input_vars', 3000);
error_reporting(0); // Desativa a exibição de todos os tipos de erros
ini_set('display_errors', '0'); // Garante que erros não sejam exibidos no navegador

/* atualiza variavel para que o log seja gerado em result.php */
$_SESSION['funcao_executada'] = false;

//Pega as series selecionadas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se alguma célula foi selecionada
    if (isset($_POST['selecionado']) && is_array($_POST['selecionado'])) {
        // Recupera os valores das células selecionadas
        $selecionados = $_POST['selecionado'];

        // Coloca os valores dentro de aspas simples e os separa por vírgula
        $seriesSelecionadas = implode(",", array_map('htmlspecialchars', $selecionados));
    }
}
/* Coverte o que enviado na URL */
$serieEnvio = urlencode(serialize($selecionados));

/* $serie = $_GET['serie']; */

/* pega o array recebido no formado de URL e transforma em array comum */
$serie = unserialize(urldecode($_GET['serie']));

if ($serie) {
    /* coloca os itens do array saparados por virgula */
    $seriesSelecionadas = implode(",", array_map('htmlspecialchars', $serie));
    /* coloca os itens ds array entre aspas simples e separa por virgula */
    $seriesSelecionadasAspas = "'" . implode("', '", array_map('htmlspecialchars', $serie)) . "'";
}


//Pega as vlr da embalagem
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se alguma célula foi selecionada
    if (isset($_POST['vlrembalagem']) && is_array($_POST['vlrembalagem'])) {
        // Recupera os valores das células selecionadas
        $vlrembalagem = array_sum($_POST['vlrembalagem']);

    }
}

/* valor da embalagem fixo 0 caso não seja preechida */
if ($vlrembalagem == NULL) {
    $vlrembalagem = 0;
}

//Pega as vlr da readytorun
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verifica se alguma célula foi selecionada
    if (isset($_POST['readytorun']) && is_array($_POST['readytorun'])) {
        // Recupera os valores das células selecionadas
        $vlrReadytorun = array_sum($_POST['readytorun']);

    }
}

/* valor da readytorun fixo 0 caso não seja preechida */
if ($vlrReadytorun == NULL) {
    $vlrReadytorun = 0;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DATABIT</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/styleBtn.css">
</head>

<body>
    <!--  <form method="POST" class="form-geral" action="<?= $url ?>/save.php"> -->
    <div class="div-save" id="div-save"></div>
    <div class="form-geral">
        <img src="../img/logo.jpg" alt="logo">
        <div class="btn-solic-btn">
        </div>
        <h1 class="titulos"></h1>
        <div class="buttons-forms">
            <!-- <button class="btn-req" id="btn-req" style="color: black; opacity: 0.4;"
                onClick="window.location='index.php';" type="submit" class="voltar-btn-form">Equipamentos</button>
            <button class="btn-req" id="btn-req-sup" onClick="window.location='index2.php?serie=<? $serieEnvio; ?>';"
                type="submit" class="voltar-btn-form">suprimentos</button> -->
        </div>
        <form method="POST" action="result.php">

            <h6 class="msg-os"></h6>
            <div class="form-group">
                <div class="form-input">
                    <label for="selecionado">Series *</label>
                    <textarea id="selecionado" name="selecionado" rows="1"
                        required><?= $seriesSelecionadas; ?></textarea>
                </div>
                <div class="form-input">
                    <label for="estado">Estado</label>
                    <div class="custom-select">
                        <input type="text" name="estado" class="estado" id="selectEstado"
                            placeholder="Digite para filtrar" onkeyup="filterEstado()">
                        <div id="selectEstadoLista" class="select-items">
                            <?php filtroEstado($conn); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-input">
                    <label for="pessoa">Tipo Pessoa *</label>
                    <select name="pessoa" id="">
                        <option value="J">Juridica</option>
                        <option value="F">Fisica</option>
                    </select>
                </div>
                <div class="form-input">
                    <label for="consumo">CONS/REV *</label>
                    <select name="consumo" id="">
                        <option value="S">Consumo</option>
                        <option value="N">Revenda</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="form-input">
                    <label for="condicao">Condição de Receb *</label>
                    <div class="custom-select">
                        <input type="text" name="condicao" class="condicao" id="selectCondicao"
                            placeholder="Digite para filtrar" onkeyup="filterCondicao()" required>
                        <div id="selectCondicaoLista" class="select-items">
                            <?php filtroCondicao($conn); ?>
                        </div>
                    </div>
                </div>
                <div class="form-input">
                    <label for="condicao">Tabela *</label>
                    <div class="custom-select">
                        <input type="text" name="tabela" class="tabela" id="selectTabela"
                            placeholder="Digite para filtrar" onkeyup="filterTabela()" required>
                        <div id="selectTabelaLista" class="select-items">
                            <?php filtroTabela($conn); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-input">
                    <label for="class">Classificação *</label>
                    <div class="custom-select">
                        <input type="text" name="class" class="class" id="selectClass" placeholder="Digite para filtrar"
                            onkeyup="filterClass()" required>
                        <div id="selectClassLista" class="select-items">
                            <?php filtroClass($conn); ?>
                        </div>
                    </div>
                </div>
               <!--  <div class="form-input">
                    <label for="class">Embalagem *</label>
                    <div class="custom-select">
                        <input type="number" step="0.01" name="embalagem" class="class" id="embalagemClass"
                            value="<= $vlrembalagem ?>" required>
                    </div>
                </div> -->
           <!--  </div>
            <div class="form-group"> -->
                <div class="form-input">
                    <label for="class">Cliente</label>
                    <div class="custom-select">
                        <input type="text" name="cliente" class="cliente" id="selectCliente"
                            placeholder="Digite para filtrar" onkeyup="filterCliente()">
                        <div id="selectClienteLista" class="select-items">
                            <?php filtroCliente($conn); ?>
                        </div>
                    </div>
                </div>
                <!-- <div class="form-input">
                    <label for="class">Readytorun *</label>
                    <div class="custom-select">
                        <input type="number" step="0.01" name="readytorun" class="class" id=readytorunClass"
                            value="<= $vlrReadytorun ?>" required>
                    </div>
                </div>-->
            </div> 
            <div class="form-group">
                <div class="form-input">
                    <label for="class">Observações</label>
                    <div class="custom-select">
                        <textarea type="text" name="obs" class="cliente" id="selectObs"></textarea>
                    </div>
                </div>
            </div>
            <div class="flag-omitir">
                <input type="checkbox" class="OmitirSerie" name="OmitirSerie" value="1">Omitir Seriais
            </div>
            <div class="btn-index">
                <input type="hidden" name="trava" id="trava" value="1">
                <button type="submit" class="submit-btn">Gerar</button>
                <a onClick="window.location='../vw2/index.php';" type="" class="voltar-btn-form">Voltar</a>
            </div>
            <input type="hidden" id="urlOS" value="<?= $url ?>/save.php">
        </form>
        <?php
        /* gera um codigo de 6 numeros pseudo aleatorio */

        //echo 'A'.sprintf("%'.05d\n",  mt_rand(0, 0xF00));
        ?>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../JS/script.js" charset="utf-8"></script>
</body>

</html>