/* Función general para validar y previsualizar imagen */
function validarYPrevisualizarImagen(inputSelector) {
  var imagen = $(inputSelector)[0].files[0];

  if (!imagen) return;

  if (imagen["type"] != "image/jpeg" && imagen["type"] != "image/png") {
    $(inputSelector).val("");
    Swal.fire({
      icon: "error",
      title: "Error al subir imagen",
      text: "¡La imagen debe estar en formato JPG o PNG!",
      confirmButtonColor: "#d33",
      confirmButtonText: "¡Cerrar!",
    });
  } else if (imagen["size"] > 2000000) {
    $(inputSelector).val("");
    Swal.fire({
      icon: "error",
      title: "Error al subir imagen",
      text: "¡La imagen no debe pesar más de 2MB!",
      confirmButtonColor: "#d33",
      confirmButtonText: "¡Cerrar!",
    });
  } else {
    var datosImagen = new FileReader();
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function (event) {
      var rutaImagen = event.target.result;
      $(".previsualizarImgUser").attr("src", rutaImagen);
    });
  }
}

/* Subir imagen temporal - Crear Usuario */
$("input[name='cr_subirImgUsuario']").change(function () {
  validarYPrevisualizarImagen("input[name='cr_subirImgUsuario']");
});

/* Subir imagen temporal - Editar Usuario */
$("input[name='ed_subirImgUsuario']").change(function () {
  validarYPrevisualizarImagen("input[name='ed_subirImgUsuario']");
});

/*Editar Usuarios*/

$(document).on("click", ".btnEditarUsuario", function () {
  var idUsuario = $(this).attr("idUsuario");

  var datos = new FormData();

  datos.append("idUsuario", idUsuario);

  $.ajax({
    url: "ajax/usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#ed_idPerfil").val(respuesta["id"]);
      $("#ed_nom_usuario").val(respuesta["nombre"]);
      $("#ed_ape_usuario").val(respuesta["apellido"]);
      $("#ed_nom_user").val(respuesta["usuario"]);
      $("#pass_useractual").val(respuesta["password"]);
      $("#ed_pass_user").val(""); // Campo vacío para edición segura
      $(".previsualizarImgUser").attr("src", respuesta["foto"]);
      $("#fotoActualE").val(respuesta["foto"]);
      
      $("#ed_subirImgUsuario").val("");
      //$("input[name='ed_subirImgUsuario']").val(respuesta["foto"]);
    },
  });
});

/*Eliminar usuairo*/
$(document).on("click", ".eliminarUsuario", function () {
  var idUsuario = $(this).attr("idUsuarioE");
  var rutaFoto = $(this).attr("rutaFoto");

  Swal.fire({
    title: "¿Estás seguro de eliminar a este usuario?",
    text: "Si no estás seguro, puedes cancelar esta acción.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí, eliminar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      var datos = new FormData();
      datos.append("idUsuarioE", idUsuario);
      datos.append("rutaFoto", rutaFoto);

      $.ajax({
        url: "ajax/usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          if (respuesta === "ok") {
            Swal.fire({
              title: "Usuario eliminado",
              text: "El usuario fue eliminado correctamente.",
              icon: "success",
              confirmButtonText: "Aceptar",
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload(); // o window.location = "usuarios";
              }
            });
          } else {
            Swal.fire("Error", "No se pudo eliminar el usuario.", "error");
          }
        },
        error: function () {
          Swal.fire("Error", "No se pudo conectar con el servidor.", "error");
        },
      });
    }
  });
});

