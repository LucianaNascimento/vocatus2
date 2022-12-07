const logoLink = () => {
    window.location.href = "../pages/principal.html";
}

function sair() {
  if (confirm("Realmente deseja sair?")) {
    localStorage.removeItem("usuario_id")
    window.location.href = "../index.html"
  }
}

function nomeUsuario() {
  var id = localStorage.getItem("usuario_id")

  $.ajax({
    type: "POST",
    url: "../backend/usuario_dados.php?id=" + id,
    success: function (data) {
      $("#name-user").html("");
      $(data.dados[0]).each(function (index) {
        $("#name-user").html('<div>' + this.nome + '</div>');
      });
    },
    error: function () {
      alert('Erro no envio de dados');
    }
  });
}

