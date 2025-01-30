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

function calculateTotals() {
    var totalValorBase = 0,
        totalValorIPI = 0,
        totalST = 0,
        totalDifalST = 0,
        totalValorFinal = 0;
        

        document.querySelectorAll('tbody tr').forEach(row => {
            /* totalValorBase += parseCurrency(row.cells[2].textContent);
            totalValorIPI += parseCurrency(row.cells[3].textContent);
            totalST += parseCurrency(row.cells[4].textContent);
            totalDifalST += parseCurrency(row.cells[5].textContent); */
            totalValorFinal += parseCurrency(row.cells[8].textContent);
        });
    
        /* document.getElementById('totalValorBase').textContent = formatToCurrency(totalValorBase);
        document.getElementById('totalValorIPI').textContent = formatToCurrency(totalValorIPI);
        document.getElementById('totalST').textContent = formatToCurrency(totalST);
        document.getElementById('totalDifalST').textContent = formatToCurrency(totalDifalST); */
        document.getElementById('totalValorFinal').textContent = formatToCurrency(totalValorFinal);
}

// Calcular totais ao carregar a página
window.onload = calculateTotals;