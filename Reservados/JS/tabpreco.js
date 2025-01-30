/* Oculta colunas na tela desmarcando a flag */
/* document.querySelectorAll('.column-toggle').forEach(checkbox => {
    checkbox.addEventListener('change', function () {
            document.querySelectorAll(`.columnOcult-${this.dataset.column}`).forEach(el => {
                    el.style.display = this.checked ? '' : 'none';
            });
    });
  }); */

// Oculta as colunas ao carregar a página
/* document.querySelectorAll('.column-toggle').forEach(checkbox => {
        document.querySelectorAll(`.columnOcult-${checkbox.dataset.column}`).forEach(el => {
            el.style.display = 'none';
        });
    
        checkbox.addEventListener('change', function () {
            document.querySelectorAll(`.columnOcult-${this.dataset.column}`).forEach(el => {
                el.style.display = this.checked ? '' : 'none';
            });
        });
    }) */;


    document.querySelectorAll('.column-toggle').forEach(checkbox => {
        document.querySelectorAll(`.columnOcult-${checkbox.dataset.column}`).forEach(el => {
            // Se for a coluna especial, exibe por padrão, independentemente do checkbox
            if (checkbox.dataset.column === '35') {
                el.style.display = ''; // Mostra a coluna especial inicialmente
            } else {
                el.style.display = 'none'; // Oculta as demais colunas
            }
        });
    
        checkbox.addEventListener('change', function () {
            document.querySelectorAll(`.columnOcult-${this.dataset.column}`).forEach(el => {
                // Para a coluna especial, esconde quando desmarcado
                if (this.dataset.column === '35') {
                    el.style.display = this.checked ? '' : 'none';
                } else {
                    el.style.display = this.checked ? '' : 'none';
                }
            });
        });
    });
    
    
    
    


 /* Exportar para excel */
var usuario = document.getElementById('usuario').value;
function exportTableToExcel() {
    // Clonar a tabela original
    const originalTable = document.getElementById('sortableTable2');
    const cloneTable = originalTable.cloneNode(true);

    // Remover colunas ocultas
    document.querySelectorAll('.column-toggle').forEach(checkbox => {
        if (!checkbox.checked) {
            const columnIndex = parseInt(checkbox.dataset.column);
            cloneTable.querySelectorAll(`.columnOcult-${columnIndex}`).forEach(el => el.remove());
            cloneTable.querySelectorAll('tbody tr').forEach(row => {
                if (row.children.length > columnIndex) {
                    row.children[columnIndex].remove();
                }
            });
        }
    });

    // Remover elementos indesejados do clone
    const buttons = cloneTable.querySelectorAll('.dropdown-item');
    buttons.forEach(button => button.parentElement.remove()); // Remove células que contêm input

    // Exportar tabela limpa
    const workbook = XLSX.utils.table_to_book(cloneTable, { sheet: "Sheet1" });
    XLSX.writeFile(workbook, 'TABELA DE PREÇOS - '+usuario+'.xlsx');
}
