// Filtro Global
$('#globalFilter').on('keyup', function () {
    var value = $(this).val().toLowerCase();
    filterTable();
});

// Filtro por Coluna
$('.filter').on('keyup', function () {
    filterTable();
});

function filterTable() {
    var globalValue = $('#globalFilter').val().toLowerCase();

    $('#sortableTable tbody tr').filter(function () {
        var row = $(this);
        var showRow = true;

        // Aplicar filtro global
        if (globalValue && row.text().toLowerCase().indexOf(globalValue) === -1) {
            showRow = false;
        }

        // Aplicar filtro por coluna
        $('.filter').each(function () {
            var columnIndex = $(this).data('column');
            var columnValue = $(this).val().toLowerCase();
            var cell = row.find('td').eq(columnIndex).text().toLowerCase();

            if (columnValue && cell.indexOf(columnValue) === -1) {
                showRow = false;
            }
        });

        row.toggle(showRow);
    });
}

// Botão Resetar Filtros
$('#resetBtn').on('click', function () {
    $('#globalFilter').val('');
    $('.filter').val('');
    filterTable();
});

// Ordenação das Colunas
$('th').on('click', function () {
    var table = $(this).parents('table').eq(0);
    var rows = table.find('tbody tr').toArray().sort(comparer($(this).index()));
    this.asc = !this.asc;
    if (!this.asc) rows = rows.reverse();
    table.children('tbody').empty().html(rows);
});

function comparer(index) {
    return function (a, b) {
        var valA = getCellValue(a, index),
            valB = getCellValue(b, index);
        return $.isNumeric(valA) && $.isNumeric(valB) ? valA - valB : valA.localeCompare(valB);
    };
}

function getCellValue(row, index) {
    return $(row).children('td').eq(index).text();
}

/* Evita que os inputs do cabeçalho ordenem as colunas */
function clicouNoFilho(event) {
    event.stopPropagation();  // Isso impede o clique de propagar para o pai
    console.log('Clicou no filho');
}








let filters = [[], [], [], [], []];

    // Função que mostra o dropdown (lista suspensa) de filtros para cada coluna
    function showDropdown(columnIndex) {
      const input = document.getElementById(`filter${columnIndex}`);
      const dropdown = document.getElementById(`dropdown${columnIndex}`);
      const filterText = input.value.toLowerCase(); // Texto digitado no filtro

      const table = document.getElementById("sortableTable");
      const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

      const uniqueValues = new Set(); // Usado para armazenar os valores únicos encontrados

      // Itera pelas linhas da tabela e coleta valores da coluna correspondente
      for (let i = 0; i < rows.length; i++) {
        const cell = rows[i].getElementsByTagName("td")[columnIndex - 1];
        if (cell) {
          const value = cell.innerText.trim();
          // Se o valor da célula contiver o texto do filtro, adiciona na lista
          if (value.toLowerCase().includes(filterText)) {
            uniqueValues.add(value);
          }
        }
      }

      dropdown.innerHTML = ""; // Limpa a lista antes de adicionar os novos itens

      // Adiciona a opção "Selecionar todos"
      const selectAllDiv = document.createElement("div");
      selectAllDiv.className = "dropdown-item";
      const selectAllCheckbox = document.createElement("input");
      selectAllCheckbox.type = "checkbox";
      selectAllCheckbox.id = `selectAll${columnIndex}`;
      selectAllCheckbox.onclick = () => selectAll(columnIndex, selectAllCheckbox.checked); // Atualiza os filtros de todos
      const selectAllLabel = document.createElement("label");
      selectAllLabel.textContent = "Selecionar todos";
      selectAllDiv.appendChild(selectAllCheckbox);
      selectAllDiv.appendChild(selectAllLabel);
      dropdown.appendChild(selectAllDiv);

      // Adiciona os itens únicos encontrados à lista suspensa
      uniqueValues.forEach(value => {
        const div = document.createElement("div");
        div.className = "dropdown-item";

        // Cria um checkbox para cada valor encontrado
        const checkbox = document.createElement("input");
        checkbox.type = "checkbox";
        checkbox.value = value;
        checkbox.onchange = () => updateFilter(columnIndex, checkbox.value, checkbox.checked); // Atualiza o filtro quando o checkbox é marcado/desmarcado

        const label = document.createElement("label");
        label.textContent = value;

        div.appendChild(checkbox);
        div.appendChild(label);
        dropdown.appendChild(div);
      });

      // Botão "Aplicar" para confirmar a seleção dos filtros
      const applyButton = document.createElement("button");
      applyButton.className = "apply-button";
      applyButton.innerText = "Aplicar";
      applyButton.onclick = (event) => {
        event.preventDefault();
        applyFilters(); // Aplica os filtros
        dropdown.style.display = "none"; // Esconde o dropdown após aplicar
      };
      dropdown.appendChild(applyButton);

      dropdown.style.display = "block"; // Exibe a lista suspensa
    }

    // Função que seleciona ou desmarca todos os checkboxes de um filtro
    function selectAll(columnIndex, isChecked) {
      const checkboxes = document.querySelectorAll(`#dropdown${columnIndex} .dropdown-item input[type="checkbox"]`);
      checkboxes.forEach(checkbox => {
        checkbox.checked = isChecked;
        updateFilter(columnIndex, checkbox.value, isChecked); // Atualiza os filtros conforme a seleção
      });
    }

    // Função que atualiza os filtros com base na seleção dos checkboxes
    function updateFilter(columnIndex, value, isChecked) {
      if (!filters[columnIndex - 1]) {
        filters[columnIndex - 1] = [];
      }

      if (isChecked) {
        filters[columnIndex - 1].push(value);
      } else {
        filters[columnIndex - 1] = filters[columnIndex - 1].filter(item => item !== value);
      }
    }

    // Aplica os filtros na tabela com base nas seleções
    function applyFilters() {
      const table = document.getElementById("sortableTable");
      const rows = table.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

      for (let i = 0; i < rows.length; i++) {
        let showRow = true;

        for (let columnIndex = 0; columnIndex < filters.length; columnIndex++) {
          const cell = rows[i].getElementsByTagName("td")[columnIndex];
          if (cell) {
            const value = cell.innerText.trim();
            if (filters[columnIndex].length > 0 && !filters[columnIndex].includes(value)) {
              showRow = false;
              break;
            }
          }
        }

        // Mostra ou esconde a linha com base nos filtros
        rows[i].style.display = showRow ? "" : "none";
      }
    }

    // Fechar o dropdown quando clicar fora da lista
    document.addEventListener("click", function(event) {
      const dropdowns = document.querySelectorAll('.dropdown');
      const inputs = document.querySelectorAll('.form-control');
      
      dropdowns.forEach(dropdown => {
        if (!dropdown.contains(event.target) && !event.target.matches('.form-control')) {
          dropdown.style.display = "none";
        }
      });
    });







    document.getElementById("resetBtn").addEventListener("click", () => {
        // Recarrega a página forçando o navegador a ignorar o cache
        location.reload(true);
    });