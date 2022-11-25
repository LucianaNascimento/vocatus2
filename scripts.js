const logoLink = () => {
    window.location.href = "../pages/principal.html";
}

const gerarCodigo = () => {  
  let code = Math.floor(Date.now() * Math.random()).toString(36).slice(0,5)
  document.getElementById('codigo').innerHTML = code
  document.getElementById( 'text-generate-code' ).style.display = 'none';
}



