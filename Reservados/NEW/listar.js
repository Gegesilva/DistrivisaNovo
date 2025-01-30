const applyFiltersButton = document.getElementById("applyFilters");
const resetFiltersButton = document.getElementById("resetFilters");
const startDateInput = document.getElementById("startDate");
const endDateInput = document.getElementById("endDate");
const filterClientInput = document.getElementById("filterClient");
const filterCodeInput = document.getElementById("filterCode");
const table = document.getElementById("dataTable");
const loadingScreen = document.getElementById("loadingScreen");

function showLoadingScreen() {
  loadingScreen.style.display = "block";
}

function hideLoadingScreen() {
  loadingScreen.style.display = "none";
}

// Função para converter data do formato yyyy-MM-dd para dd/mm/yyyy
function formatDateToDDMMYYYY(dateString) {
  const [year, month, day] = dateString.split("-");
  return `${day}/${month}/${year}`;
}

// Função para converter data do formato yyyy-MM-dd para objeto Date
function parseDate(dateString) {
  const [year, month, day] = dateString.split("-");
  return new Date(year, month - 1, day);
}

function applyFilters() {
  showLoadingScreen();

  const startDate = startDateInput.value ? parseDate(startDateInput.value) : null;
  const endDate = endDateInput.value ? parseDate(endDateInput.value) : null;
  const filterClient = filterClientInput.value.toLowerCase();
  const filterCode = filterCodeInput.value.toLowerCase();

  const rows = table.querySelectorAll("tbody tr");
  rows.forEach(row => {
    const dateText = row.cells[1].innerText; // Data no formato dd/mm/yyyy
    const client = row.cells[2].innerText.toLowerCase();
    const code = row.cells[0].innerText.toLowerCase();

    let showRow = true;

    // Filtro por período de data
    if (startDate || endDate) {
      const rowDate = parseDate(row.cells[1].dataset.date); // Data no formato yyyy-MM-dd armazenada no dataset
      if (startDate && rowDate < startDate) {
        showRow = false;
      }
      if (endDate && rowDate > endDate) {
        showRow = false;
      }
    }

    // Filtro por cliente
    if (filterClient && !client.includes(filterClient)) {
      showRow = false;
    }

    // Filtro por código
    if (filterCode && !code.includes(filterCode)) {
      showRow = false;
    }

    row.style.display = showRow ? "" : "none";
  });

  setTimeout(hideLoadingScreen, 500); // Simula carregamento
}

function resetFilters() {
  showLoadingScreen();

  // Limpa os valores dos inputs
  startDateInput.value = "";
  endDateInput.value = "";
  filterClientInput.value = "";
  filterCodeInput.value = "";

  // Mostra todas as linhas da tabela
  const rows = table.querySelectorAll("tbody tr");
  rows.forEach(row => {
    row.style.display = "";
  });

  setTimeout(hideLoadingScreen, 500); // Simula carregamento
}

applyFiltersButton.addEventListener("click", applyFilters);
resetFiltersButton.addEventListener("click", resetFilters);

// Preenche a tabela com o formato dd/mm/yyyy ao carregar
document.querySelectorAll("tbody tr").forEach(row => {
  const dateCell = row.cells[1];
  const originalDate = dateCell.innerText; // Supondo formato yyyy-MM-dd
  dateCell.dataset.date = originalDate; // Armazena a data original no dataset
  dateCell.innerText = formatDateToDDMMYYYY(originalDate); // Formata para dd/mm/yyyy
});

// Adiciona evento de clique duplo na coluna "Código"
table.addEventListener("dblclick", (event) => {
    const target = event.target;

    // Verifica se o elemento clicado é uma célula da coluna "Código"
    if (target.tagName === "TD" && target.cellIndex === 0) {
      const codCotacao = target.innerText;

      // Redireciona para a nova página usando POST
      const form = document.createElement("form");
      form.method = "POST";
      form.action = "../VW/cotacaoRec.php";

      const input = document.createElement("input");
      input.type = "hidden";
      input.name = "codCotacao";
      input.value = codCotacao;

      form.appendChild(input);
      document.body.appendChild(form);
      form.submit();
    }
  });



  const table2 = document.getElementById("dataTable");

  // Adiciona evento de clique aos cabeçalhos
  table.querySelectorAll("th").forEach((header, index) => {
    header.addEventListener("click", () => sortTable(index, header.dataset.type));
  });

  function sortTable(columnIndex, type) {
    const tbody = table2.querySelector("tbody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    // Alterna a ordem de classificação
    const isAscending = table2.dataset.sortOrder !== "asc";
    table2.dataset.sortOrder = isAscending ? "asc" : "desc";

    rows.sort((rowA, rowB) => {
      const cellA = rowA.cells[columnIndex].innerText.trim();
      const cellB = rowB.cells[columnIndex].innerText.trim();

      if (type === "numeric") {
        return isAscending ? cellA - cellB : cellB - cellA;
      } else if (type === "date") {
        return isAscending
          ? new Date(cellA) - new Date(cellB)
          : new Date(cellB) - new Date(cellA);
      } else if (type === "text") {
        return isAscending
          ? cellA.localeCompare(cellB)
          : cellB.localeCompare(cellA);
      }
    });

    // Reanexa as linhas ordenadas ao tbody
    rows.forEach(row => tbody.appendChild(row));
  }