const logoLink = () => {
    window.location.href = "../index.html";
}

const gerarCodigo = () => {  
  let code = Math.floor(Date.now() * Math.random()).toString(36).slice(0,5)
  document.getElementById('generated-code').innerHTML = code
  document.getElementById( 'text-generate-code' ).style.display = 'none';
}


const cadastro = () => {
/*
    const formData = new FormData(this)
    const searchParams = URLSearchParams()

    for(const param of formData){
      searchParams.append(param[0], param[1], param[2])
    }
*/
  fetch('../backend/cadastro.php', {
      method: 'POST',
      //body: FormData

      body: {
        usuario: 0,
        nome: document.getElementById("name").value, 
        email: document.getElementById("email").value, 
        senha: document.getElementById('password').value,
        telefone: "", ra: "", senha: "", foto: ""
      }
    }).then(function(response) {
      document.getElementById("name").value = "";
      document.getElementById("email").value = "";
      document.getElementById('password').value = "";
      return console.log("response", response)
    }).catch(function(error){
      console.log(error)
    })
}
// const cadastrarUsuario  = () => {
//   app.dialog.confirm('Confirma o cadastro do item?', function () {

//     var name = document.getElementById("name").value;
//     var email = document.getElementById("email").value;
//     var password = document.getElementById('password').value;
//     // var descricao = app.textEditor.get('.text-editor').value;
//     // var preco = document.getElementById("preco").value;
//     // var disponivel = app.toggle.get('.toggle');
//     var disp = 0;
//     if(disponivel.checked) {
//       disp = 1;
//     }

//     var usuario = JSON.parse(localStorage.getItem("usuario"));

//     var dadosFormulario = new FormData();
//     dadosFormulario.append('name',name);  
//     dadosFormulario.append('email',email);  
//     dadosFormulario.append('password',password);
//     // dadosFormulario.append('descricao',descricao);  
//     // dadosFormulario.append('preco',preco);  
//     // dadosFormulario.append('empresa',usuario.id);  
//     // dadosFormulario.append('disponivel',disp);  

//     app.request({
//       url: "http://localhost/fatecfood/backend/cardapio.php", 
//       method: 'POST',
//       data: dadosFormulario,
//       mimeType: 'multipart/form-data',
//       success: function (res) {

//         console.log(res);

//         const resultado = JSON.parse(res);

//         if(resultado.status == 200) {
//           app.dialog.alert("Item cadastro com sucesso!")
//           ListarCardapio()

//           LimparDados()

//           app.popup.close("#novo_cardapio")
//         } else {
//           app.dialog.alert(resultado.mensagem)
//         }
//       }
//     });
      
//   });

// }




