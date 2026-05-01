/*Editar Roles*/

$(".tablaRoles").on("click", ".btnEditarRol", function () {
  var idRoles = $(this).attr("idRol");

  //console.log(idRoles);

  var datos = new FormData();

  datos.append("idRoles", idRoles);

  $.ajax({
    url: "ajax/roles.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("input[name='id_rolE']").val(respuesta["id_roles"]);
      $("input[name='nom_rolE']").val(respuesta["nom_rol"]);
    },
  });
});

/*Eliminar Rol*/

$(document).on("click", ".eliminarRol", function () {
  var idRolE = $(this).attr("idRol");

  Swal.fire({
    title: "Estas seguro de eliminar a este rol",
    text: "Si no estás seguro puedes cancelar esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.value) {
      var datos = new FormData();
      datos.append("idRolE", idRolE);

      $.ajax({
        url: "ajax/roles.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          if (respuesta == "ok") {
            Swal.fire(
              "Usuario eliminado",
              "El Rol fue eliminado correctamente",
              "success"
            ).then(function (result) {
              if (result.value) {
                window.location = "roles";
              }
            });
          }
        },
      });
    }
  });
});
