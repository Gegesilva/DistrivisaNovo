$('#form').submit(function(e){
    e.preventDefault();    /*Interronpendo a atualização automatica da pagina*/ 
  
      var d_produto = $('#produto').val();
      var d_nome = $('#nome').val();
      var d_valida1 = $('#valida1').val();
      var d_valida2 = $('#valida2').val();
      var d_faixa = $('#faixa').val();
  
      let resultados = document.getElementById('resultados');
  
      console.log(d_produto, d_nome, d_valida1, d_valida2, d_faixa);
  
      $.ajax({
          url: 'inserirUpd.php',
          method: 'POST',
          data: {produto: d_produto, nome: d_nome, valida1: d_valida1, valida2: d_valida2, faixa: d_faixa},
          //dataType: 'json'
      }).done(function(result){
          $('#produto').val('').focus();
          $('#nome').val('');
          $('#valida1').val('');
          $('#valida2').val('');
          $('#faixa').val('');
          console.log(result);
          
          resultados.innerHTML = result;
          /* getResultados(); */ 
      });
  });


  
  $('#form2').submit(function(e){
    e.preventDefault();    /*Interronpendo a atualização automatica da pagina*/ 
  
      var d_produto = $('#produto').val();
      var d_nome = $('#nome').val();
      var d_valida1 = $('#valida1').val();
      var d_valida2 = $('#valida2').val();
      var d_faixa = $('#faixa').val();
      
      var d_produtoIn = $('#produtoIn').val();
      var d_nomeIn = $('#nomeIn').val();
      var d_valida1In = $('#valida1In').val();
      var d_valida2In = $('#valida2In').val();
      var d_faixaIn = $('#faixaIn').val();

      let resultados = document.getElementById('resultados');
  
      console.log(d_produto, d_nome, d_valida1, d_valida2, d_faixa);
      console.log(d_produtoIn, d_nomeIn, d_valida1In, d_valida2In, d_faixaIn);
  
      $.ajax({
          url: 'update.php',
          method: 'POST',
          data: {produto: d_produto, nome: d_nome, valida1: d_valida1, valida2: d_valida2, faixa: d_faixa,
                 produtoIn: d_produtoIn, nomeIn: d_nomeIn, valida1In: d_valida1In, valida2In: d_valida2In, faixaIn: d_faixaIn
          },
          //dataType: 'json'
      }).done(function(result){
          $('#produto').val('').focus();
          $('#nome').val('');
          $('#valida1').val('');
          $('#valida2').val('');
          $('#faixa').val('');
          console.log(result);
          
          resultados.innerHTML = result;
          /* getResultados(); */ 
      });
  });


  function voltar() {
    window.location.href = "faixa.php";
}