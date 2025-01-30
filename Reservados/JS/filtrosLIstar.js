/* Clientes */

// Mostrar as opções ao focar no campo de texto
document.getElementById("filterClient").addEventListener("focus", function () {
    document.getElementById("selectClienteLista").style.display = "block";
  });
  
  // Ocultar as opções ao clicar fora
  document.addEventListener("click", function (e) {
    if (!e.target.closest(".custom-select")) {
      document.getElementById("selectClienteLista").style.display = "none";
    }
  });
  
  // Função de filtro para o select
  function filterCliente() {
    const filter = document.getElementById("filterClient").value.toLowerCase();
    const options = document.getElementById("selectClienteLista").getElementsByTagName("div");
  
    for (let i = 0; i < options.length; i++) {
      const optionText = options[i].textContent || options[i].innerText;
      if (optionText.toLowerCase().indexOf(filter) > -1) {
        options[i].style.display = "";
      } else {
        options[i].style.display = "none";
      }
    }
  }
  
  // Selecionar um item da lista
  const items5 = document.getElementById("selectClienteLista").getElementsByTagName("div");
  for (let i = 0; i < items5.length; i++) {
    items5[i].addEventListener("click", function () {
      document.getElementById("filterClient").value = this.innerText;
      document.getElementById("selectClienteLista").style.display = "none";
    });
  }