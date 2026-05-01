

<?php date_default_timezone_set("America/Caracas"); ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-7 col-lg-6 col-md-9">
            <div class="text-center m-5">
                <h1 class="h2 mb-2 text-black">Bienvenido, registra tu asistencia</h1>
                <h2 class="h4 mb-2 text-black" id="fecha"><?= date("d/m/Y, h:i:s") ?></h2>
            </div>

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h2 class="h4 text-gray-900 mb-2">Ingresar Cédula de identidad</h2>
                                </div>
                                <form id="formAsistencia">
                                    <div class="form-group">
                                        <input type="number" class="form-control form-control-user" name="txtci" placeholder="Número de cédula" required>
                                    </div>
                                    <div class="btn-group d-flex justify-content-between">
                                        <button type="button" class="btn btn-success btn-user" onclick="enviarAsistencia('entrada')">Entrada</button>
                                        <button type="button" class="btn btn-danger btn-user" onclick="enviarAsistencia('salida')">Salida</button>
                                    </div>
                                </form>
                                <hr>
                          
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->



  </body>


</html>
<!-- Actualizar hora en tiempo real -->
<script>
    setInterval(() => {
        const fecha = new Date();
        document.getElementById("fecha").textContent = fecha.toLocaleString();
    }, 1000);
</script>

<script>
function enviarAsistencia(tipo) {
    const ci = document.querySelector('[name="txtci"]').value;

    if (!ci) {
        Swal.fire({ icon: 'error', title: 'Ingrese la cédula', timer: 1500, showConfirmButton: false });
        return;
    }

    const formData = new FormData();
    formData.append("ci", ci);
    formData.append("tipo", tipo);

    fetch("ajax/asistencia.ajax.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .then(respuesta => {
        Swal.fire({
            icon: respuesta.status,
            title: respuesta.message,
            showConfirmButton: false,
            timer: 2000
        });
    })
    .catch(error => {
        Swal.fire({ icon: 'error', title: 'Error en el servidor', text: error.message });
    });
}
</script>


