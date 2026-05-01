<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800">Estadisticas</h1>
    
</div>


<div class="row" id="kpi-container">
    <div class="col-md-6 col-xl-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Empleados</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalEmpleados">...</div>
                </div>
                <i class="fas fa-users fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Cargos</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalCargos">...</div>
                </div>
                <i class="fas fa-briefcase fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Entradas Hoy</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="entradasHoy">...</div>
                </div>
                <i class="fas fa-door-open fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Salidas Hoy</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800" id="salidasHoy">...</div>
                </div>
                <i class="fas fa-door-closed fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>

<br>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Entradas por mes (Asistencia)</h6>
    </div>
    <div class="card-body">
        <div class="chart-bar">
            <canvas id="asistenciaBarChart"></canvas>
        </div>
        <hr>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Entradas por mes del año</h6>
    </div>
    <div class="card-body">
        <div class="chart-bar">
            <canvas id="asistenciaAnualChart"></canvas>
        </div>
        <hr>
    </div>
</div>
<br>
<br>
<!-- Modal Entradas -->
<div class="modal fade" id="modalEntradasHoy" tabindex="-1" aria-labelledby="entradasHoyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="entradasHoyLabel">Entradas de Hoy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="entradasHoyBody">
        Cargando...
      </div>
    </div>
  </div>
</div>

<!-- Modal Salidas -->
<div class="modal fade" id="modalSalidasHoy" tabindex="-1" aria-labelledby="salidasHoyLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="salidasHoyLabel">Salidas de Hoy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="salidasHoyBody">
        Cargando...
      </div>
    </div>
  </div>
</div>
<!-- Modal Empleados Nuevos -->
<div class="modal fade" id="modalEmpleadosMes" tabindex="-1" aria-labelledby="empleadosMesLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="empleadosMesLabel">Empleados ingresados este mes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="empleadosMesBody">
        Cargando...
      </div>
    </div>
  </div>
</div>



<!-- Page level plugins -->
<script src="vistas/recursos/vendor/chart.js/Chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    async function getEstadisticaMensual() {
        try {
            const response = await fetch('ajax/estadistica.ajax.php');
            if (!response.ok) throw new Error('Error al obtener datos');

            const data = await response.json(); // Espera un array de 12 números
            generarGrafico(data);
        } catch (error) {
            console.error("Error al cargar estadísticas:", error);
        }
    }

function generarGrafico(datos) {
    const ctx = document.getElementById("asistenciaBarChart").getContext("2d");

    const hoy = new Date();
    const year = hoy.getFullYear();
    const month = hoy.getMonth();
    const diasEnMes = new Date(year, month + 1, 0).getDate();
    const labels = Array.from({ length: diasEnMes }, (_, i) => (i + 1).toString());

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Entradas por día",
                    backgroundColor: "#4e73df",
                    hoverBackgroundColor: "#2e59d9",
                    borderColor: "#4e73df",
                    data: datos.entradas
                },
                {
                    label: "Salidas por día",
                    backgroundColor: "#e74a3b",
                    hoverBackgroundColor: "#c0392b",
                    borderColor: "#e74a3b",
                    data: datos.salidas
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        autoSkip: true,
                        maxTicksLimit: 31
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: value => value
                    }
                }
            },
            plugins: {
                legend: { display: true },
                tooltip: {
                    callbacks: {
                        label: context => `${context.dataset.label}: ${context.parsed.y}`
                    }
                }
            }
        }
    });
}

async function getEstadisticaAnual() {
    try {
        const response = await fetch('ajax/estadistica.ajax.php?anual=true');
        const data = await response.json(); // Espera {entradas: [], salidas: []}

        const ctx = document.getElementById("asistenciaAnualChart").getContext("2d");

        const meses = [
            "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
            "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: meses,
                datasets: [
                    {
                        label: "Entradas por mes",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: data.entradas
                    },
                    {
                        label: "Salidas por mes",
                        backgroundColor: "#e74a3b",
                        hoverBackgroundColor: "#c0392b",
                        borderColor: "#e74a3b",
                        data: data.salidas
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                layout: { padding: { left: 10, right: 25, top: 25, bottom: 0 } },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            callback: value => value
                        }
                    }
                },
                plugins: {
                    legend: { display: true },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.dataset.label}: ${context.parsed.y}`
                        }
                    }
                }
            }
        });

    } catch (error) {
        console.error("Error al cargar estadísticas anuales:", error);
    }
}



    async function getKPIs() {
    try {
        const response = await fetch('ajax/estadistica.ajax.php?kpi=true');
        const data = await response.json();

        document.getElementById('totalEmpleados').textContent = data.totalEmpleados;
        document.getElementById('totalCargos').textContent = data.totalCargos;
        document.getElementById('entradasHoy').textContent = data.entradasHoy;
        document.getElementById('salidasHoy').textContent = data.salidasHoy;
    } catch (error) {
        console.error("Error al cargar los KPIs:", error);
    }
}
document.getElementById("entradasHoy").parentElement.addEventListener("click", async () => {
    const res = await fetch("ajax/estadistica.ajax.php?list=entradas");
    const data = await res.text();
    document.getElementById("entradasHoyBody").innerHTML = data;
    new bootstrap.Modal(document.getElementById("modalEntradasHoy")).show();
});

document.getElementById("salidasHoy").parentElement.addEventListener("click", async () => {
    const res = await fetch("ajax/estadistica.ajax.php?list=salidas");
    const data = await res.text();
    document.getElementById("salidasHoyBody").innerHTML = data;
    new bootstrap.Modal(document.getElementById("modalSalidasHoy")).show();
});
document.getElementById("totalEmpleados").parentElement.addEventListener("click", async () => {
    try {
        const res = await fetch("ajax/estadistica.ajax.php?list=empleados_mes");
        const html = await res.text();
        document.getElementById("empleadosMesBody").innerHTML = html;
        new bootstrap.Modal(document.getElementById("modalEmpleadosMes")).show();
    } catch (error) {
        document.getElementById("empleadosMesBody").innerHTML = "<p class='text-danger'>Error al cargar los datos.</p>";
    }
});


    // Llama al inicio
getEstadisticaAnual(); // <--- Añade esta línea
   getEstadisticaMensual();
getKPIs();

});
</script>
