$(document).ready(function () {

  $("#buscar").click(function () {
    const filtro = $("#filtro").val();
    const termo = $("#pesquisa").val();

    $.ajax({
      url: "/TCC_Qualifica-o_Guilherme_Caio-master/controller/buscar.php",
      type: "POST",
      data: { filtro, termo },
      success: function (resposta) {
        $("#resultado").html(resposta);
      },
      error: function () {
        $("#resultado").html("<p class='text-danger'>Erro ao buscar dados.</p>");
      }
    });
  });

});
