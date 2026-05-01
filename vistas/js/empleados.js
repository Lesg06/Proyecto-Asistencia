// Llenar formulario al hacer clic en "Editar"
$(document).on("click", ".btnEditarEmpleado", function () {
  let idEmpleado = $(this).attr("idEmpleado");
  let datos = new FormData();
  datos.append("idEmpleado", idEmpleado);

  $.ajax({
    url: "ajax/empleados.ajax.php",
    method: "POST",
    data: datos,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $("#id_empleado_ed").val(respuesta["id_empleado"]);
      $("#ed_nom_empleado").val(respuesta["nombre"]);
      $("#ed_ape_empleado").val(respuesta["apellido"]);
      $("#ed_ci_empleado").val(respuesta["ci"]);
      $("#ed_carg_empleado").val(respuesta["cargo"]).trigger('change');
      $("#ed_tlf_empleado").val(respuesta["num_tlf"]);
      $("#ed_desc_empleado").val(respuesta["direccion"]);
      $("#ed_ing_empleado").val(respuesta["fecha_ingreso"]);
      $("#ed_ans_empleado").val(respuesta["anio_servicio"]);
      $("#ed_mail_empleado").val(respuesta["correo"]);
    },
  });
});

// Enviar formulario por AJAX
$("#formEditarEmpleado").submit(function (e) {
  e.preventDefault();

  const datos = new FormData(this);
  datos.append("opcion", "editarEmpleado");

  $.ajax({
    url: "ajax/empleados.ajax.php",
    method: "POST",
    data: datos,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (res) {
      console.log("Respuesta del servidor:", res);
      if (res.status === "ok") {
        Swal.fire("¡Correcto!", "Empleado actualizado correctamente", "success").then(() => {
          location.reload();
        });
      } else {
        Swal.fire("Error", res.message || "No se pudo actualizar el empleado", "error");
      }
    },
    error: function (xhr, status, error) {
      console.error("Error AJAX:", error);
      console.log("Respuesta bruta:", xhr.responseText);
      Swal.fire("Error", "Falló la conexión o la respuesta no es válida", "error");
    }
  });
});

$(document).on("click", ".btnVerEmpleado", function () {
  const idEmpleado = $(this).attr("idEmpleado");

  const datos = new FormData();
  datos.append("verEmpleado", idEmpleado);

  $.ajax({
    url: "ajax/empleados.ajax.php",
    method: "POST",
    data: datos,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (res) {
      if (res) {
        $("#ver_nombre").text(res.nombre);
        $("#ver_apellido").text(res.apellido);
        $("#ver_cargo").text(res.nombre_cargo);
        $("#ver_ci").text(res.ci);
        $("#ver_telefono").text(res.num_tlf);
        $("#ver_direccion").text(res.direccion);
        $("#ver_fecha_ingreso").text(res.fecha_ingreso);
        $("#ver_anio_servicio").text(res.anio_servicio);
        $("#ver_correo").text(res.correo);
      } else {
        Swal.fire("Error", "No se encontraron datos del empleado.", "error");
      }
    },
    error: function () {
      Swal.fire("Error", "No se pudo conectar al servidor", "error");
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
