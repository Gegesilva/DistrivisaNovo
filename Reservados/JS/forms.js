document.getElementById('form-princ').addEventListener('submit', function(event) {
    var form = this;
    var elements = form.elements;

    // Loop para verificar todos os campos do formulário
    for (var i = 0; i < elements.length; i++) {
        var element = elements[i];

        // Se o campo não estiver preenchido, removemos o atributo 'name'
        if (element.type !== 'submit' && element.value === '') {
            element.removeAttribute('name');
        }
    }
});

/* Exportar para excel */
    var usuario = document.getElementById('usuario').value;
    function exportTableToExcel() {
        // Clonar a tabela original
        const originalTable = document.getElementById('sortableTable');
        const cloneTable = originalTable.cloneNode(true);
    
        // Remover elementos indesejados do clone
        const buttons = cloneTable.querySelectorAll('.dropdown-item');
        buttons.forEach(button => button.parentElement.remove()); // Remove células que contêm input
    
        // Exportar tabela limpa
        const workbook = XLSX.utils.table_to_book(cloneTable, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, 'COTAÇÕES - '+usuario+'.xlsx');
    }





    
      