
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800">Respaldo de la base de datos</h1>
</div>

<div class="row">

    <!-- Importar -->
    <div class="col-lg-6">
        <div class="card shadow mb-4 border-bottom-warning">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Importar Base de Datos</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="respaldo2/importar_db.php" enctype="multipart/form-data">
                    <div class="input-group">
                        <div class="custom-file mr-1">
                            <input type="file" class="custom-file-input" id="archivo_sql" name="archivo_sql" accept=".sql" required>
                            <label class="custom-file-label" for="archivo_sql">Seleccione Archivo .sql</label>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-warning btn-icon-split" type="submit">
                                <span class="icon text-white-50"><i class="fas fa-exclamation-triangle"></i></span>
                                <span class="text">Importar Base de Datos</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Exportar -->
    <div class="col-lg-6">
        <div class="card shadow mb-4 border-bottom-success">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Exportar Base de Datos</h5>
            </div>
            <div class="card-body text-center">
                <button id="btnExportar" class="btn btn-success btn-icon-split">
                    <span class="icon text-white-50"><i class="fas fa-download"></i></span>
                    <span class="text">Exportar base de datos</span>
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Tabla de respaldos -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h5 class="m-0 font-weight-bold text-primary">Historial de Respaldos</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered text-center" id="tablaRespaldos">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    fetchRespaldos();

    function fetchRespaldos() {
        fetch('ajax/respaldo.ajax.php', {
            method: 'POST',
            body: new URLSearchParams({accion: 'listar'})
        })
        .then(res => res.json())
        .then(data => {
            const tbody = document.querySelector('#tablaRespaldos tbody');
            tbody.innerHTML = '';
            if (data.status === 'success') {
                data.data.forEach(r => {
                    tbody.innerHTML += `
                        <tr>
                            <td>${r.id}</td>
                            <td>${r.nombre}</td>
                            <td>${r.fecha}</td>
                            <td>
                                <button class="btn btn-primary btn-sm restaurar-btn" data-id="${r.id}">
                                    <i class="fas fa-database"></i> Restaurar
                                </button>
                            </td>
                        </tr>`;
                });
                document.querySelectorAll('.restaurar-btn').forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.getAttribute('data-id');
                        Swal.fire({
                            title: '¿Estás seguro?',
                            text: "Esto restaurará toda la base de datos",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Sí, restaurar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                restaurarRespaldo(id);
                            }
                        });
                    });
                });
            }
        });
    }

    function restaurarRespaldo(id) {
        fetch('ajax/respaldo.ajax.php', {
            method: 'POST',
            body: new URLSearchParams({accion: 'restaurar', id})
        })
        .then(res => res.json())
        .then(data => {
            Swal.fire({
                icon: data.status === 'success' ? 'success' : 'error',
                title: data.message
            });
            if (data.status === 'success') fetchRespaldos();
        });
    }

    document.getElementById('btnExportar').addEventListener('click', () => {
        Swal.fire({
            title: 'Generando respaldo...',
            text: 'Espere unos segundos.',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        fetch('respaldo2/exportar_db.php')
            .then(response => response.blob())
            .then(blob => {
                Swal.close();

                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                const fecha = new Date().toISOString().replace(/[:.]/g, '-');
                a.download = `sistema_asistencia_${fecha}.sql`;
                document.body.appendChild(a);
                a.click();
                a.remove();
                window.URL.revokeObjectURL(url);

                fetchRespaldos();
            })
            .catch(() => {
                Swal.fire('Error', 'No se pudo generar el respaldo', 'error');
            });
    });
});
</script>
