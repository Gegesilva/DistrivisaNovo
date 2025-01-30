/* totalizadores */
function formatToCurrency(value) {
    return new Intl.NumberFormat('pt-BR', {
        style: 'currency',
        currency: 'BRL'
    }).format(value);
}

function parseCurrency(value) {
    return parseFloat(value.replace(/[R$.\s]/g, '').replace(',', '.') || 0);
}

function calculateTotals2() {
    let totalProduto = 0,
        totalIPI = 0,
        totalST2 = 0,
        totalDifalST2 = 0,
        totalValorFinal2 = 0;

    document.querySelectorAll('tbody tr').forEach(row => {
        totalProduto += parseCurrency(row.cells[2].textContent);
        totalIPI += parseCurrency(row.cells[3].textContent);
        totalST2 += parseCurrency(row.cells[4].textContent);
        totalDifalST2 += parseCurrency(row.cells[5].textContent);
        totalValorFinal2 += parseCurrency(row.cells[6].textContent);
    });

    document.getElementById('totalProduto').textContent = formatToCurrency(totalProduto);
    document.getElementById('totalIPI').textContent = formatToCurrency(totalIPI);
    document.getElementById('totalST2').textContent = formatToCurrency(totalST2);
    document.getElementById('totalDifalST2').textContent = formatToCurrency(totalDifalST2);
    document.getElementById('totalValorFinal2').textContent = formatToCurrency(totalValorFinal2);
}
// Calcular totais ao carregar a página
window.onload = calculateTotals2;