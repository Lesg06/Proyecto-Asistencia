/*Eliminar Cargo*/

$(document).on("click", ".eliminarAsistencia", function () {
  var idAsistenciaE = $(this).attr("idAsistenciaE");

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
      datos.append("idAsistenciaE", idAsistenciaE);

      $.ajax({
        url: "ajax/asistencias.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          if (respuesta == "ok") {
            Swal.fire(
              "La asistencia",
              "fue eliminado correctamente",
              "success"
            ).then(function (result) {
              if (result.value) {
                window.location = "asistencias";
              }
            });
          }
        },
      });
    }
  });
});

/*Eliminar Empleado*/

$(document).on("click", ".eliminarEmpleado", function () {
  var idEmpleadoE = $(this).attr("idEmplea");

  Swal.fire({
    title: "Estas seguro de eliminar a este empleado",
    text: "Si no estás seguro puedes cancelar esta acción!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then((result) => {
    if (result.value) {
      var datos = new FormData();
      datos.append("idEmpleadoE", idEmpleadoE);

      $.ajax({
        url: "ajax/empleados.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (respuesta) {
          if (respuesta == "ok") {
            Swal.fire(
              "Empleado eliminado",
              "fue eliminado correctamente",
              "success"
            ).then(function (result) {
              if (result.value) {
                window.location = "empleados";
              }
            });
          }
        },
      });
    }
  });
});
