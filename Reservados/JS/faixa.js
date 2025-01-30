// Adiciona o evento de pressionar Enter no campo de entrada
document.getElementById('filtro-produto').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') { // Verifica se a tecla pressionada foi Enter
        event.preventDefault(); // Evita comportamento padrão
        aplicarFiltro(); // Chama a função de filtro
    }
});

 // Aplicar filtro
 function aplicarFiltro() {
    const filtro = document.getElementById('filtro-produto').value.trim().toLowerCase();
    const linhas = document.querySelectorAll('#tabela-produtos tbody tr');

    linhas.forEach(linha => {
        const valorProduto = linha.cells[0].innerText.toLowerCase();
        linha.style.display = valorProduto.includes(filtro) ? '' : 'none';
    });

    // Salvar o filtro no sessionStorage
    sessionStorage.setItem('filtroProduto', document.getElementById('filtro-produto').value);
}

// Navegar para outra página
/* function irParaOutraPagina() {
    window.location.href = "inserir.php";
} */

// Restaurar estado ao carregar a página
window.onload = function () {
    const filtro = sessionStorage.getItem('filtroProduto');
    if (filtro) {
        document.getElementById('filtro-produto').value = filtro;
        aplicarFiltro();
    }
};


// Função para resetar filtro
function resetarFiltro() {
    sessionStorage.clear(); 
    document.getElementById('filtro-produto').value = '';
    const linhas = document.querySelectorAll('#tabela-produtos tbody tr');
    linhas.forEach(linha => linha.style.display = '');
}

function editarLinha(botao) {
    // Pega a linha (tr) do botão clicado
    const linha = botao.parentNode.parentNode;

    // Coleta os valores das células da linha
    const produto = linha.cells[0].innerText;
    const nome = linha.cells[1].innerText;
    const valida1 = linha.cells[2].innerText;
    const valida2 = linha.cells[3].innerText;
    const faixa = linha.cells[4].innerText;

    // Cria um formulário dinamicamente
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'editar.php'; // Página de destino para edição

    // Adiciona os dados como campos ocultos no formulário
    form.innerHTML = `
        <input type="hidden" name="produto" value="${produto}">
        <input type="hidden" name="nome" value="${nome}">
        <input type="hidden" name="valida1" value="${valida1}">
        <input type="hidden" name="valida2" value="${valida2}">
        <input type="hidden" name="faixa" value="${faixa}">
    `;

    // Adiciona o formulário ao corpo do documento e o submete
    document.body.appendChild(form);
    form.submit();
}



// Função para deletar linha (AJAX)
function deletarLinha(botao) {
    // Exibe uma confirmação antes de excluir
    const confirmar = confirm("Tem certeza que deseja deletar a faixa?");
    
    // Se o usuário clicar em "OK" (true), prossegue com a exclusão
    if (confirmar) {
        // Pega a linha (tr) do botão clicado
        const linha = botao.parentNode.parentNode;

        // Coleta os valores das células da linha
        const produto = linha.cells[0].innerText;
        const nome = linha.cells[1].innerText;
        const valida1 = linha.cells[2].innerText;
        const valida2 = linha.cells[3].innerText;
        const faixa = linha.cells[4].innerText;

        // Cria um objeto FormData para enviar via POST
        const formData = new FormData();
        formData.append('produto', produto);
        formData.append('nome', nome);
        formData.append('valida1', valida1);
        formData.append('valida2', valida2);
        formData.append('faixa', faixa);

        // Envia os dados via fetch para o arquivo 'deletar.php'
        fetch('deletar.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text()) // Resposta do servidor
        .then(mensagem => {
            alert(mensagem); // Exibe a resposta do PHP (sucesso ou erro)
            linha.remove(); // Remove a linha da tabela visualmente
        })
        .catch(error => console.error('Erro ao deletar:', error));
    } else {
        // Se o usuário clicar em "Cancelar", não faz nada
        console.log('Exclusão cancelada.');
    }
}


 