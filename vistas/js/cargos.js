/*Eliminar Cargo*/
 
$(document).on("click", ".eliminarCargo", function () {
  var idCargoE = $(this).attr("idCargo");

  Swal.fire({
    title: "Estas seguro de eliminar a este Cargo",
    text: "Si no estás seguro, puedes cancelar esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.value) {
      var datos = new FormData();
      datos.append("idCargoE", idCargoE);

      $.ajax({
        url: "ajax/cargos.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          if (respuesta == "ok") {
            Swal.fire(
              "El cargo",
              "fue eliminado correctamente",
              "success"
            ).then(function (result) {
              if (result.value) {
                window.location = "cargos";
              }
            });
          }
        },
      });
    }
  });
});
// Editar cargo - cargar datos en modal
$(document).on("click", ".btnEditarCargo", function () {
  const idCargo = $(this).attr("idCargo");

  const datos = new FormData();
  datos.append("idCargos", idCargo);

  $.ajax({
    url: "ajax/cargos.ajax.php",
    method: "POST",
    data: datos,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta && respuesta.id_cargo) {
        $("#id_cargoE").val(respuesta.id_cargo);
        $("#nom_cargoE").val(respuesta.nombre);
      } else {
        Swal.fire("Error", "No se encontraron datos del cargo.", "error");
      }
    },
    error: function (xhr) {
      Swal.fire("Error", "No se pudo cargar el cargo.", "error");
      console.error("Error AJAX:", xhr.responseText);
    }
  });
});

// Guardar cambios al editar
$("#formEditarCargo").submit(function (e) {
  e.preventDefault();

  const datos = new FormData(this);
  datos.append("opcion", "editarCargo");

  $.ajax({
    url: "ajax/cargos.ajax.php",
    method: "POST",
    data: datos,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      if (respuesta.status === "ok") {
        Swal.fire("Actualizado", "El cargo fue actualizado correctamente", "success")
          .then(() => location.reload());
      } else {
        Swal.fire("Error", respuesta.message || "No se pudo actualizar el cargo", "error");
      }
    },
    error: function (xhr) {
      Swal.fire("Error", "Error del servidor al intentar actualizar", "error");
    }
  });
});

