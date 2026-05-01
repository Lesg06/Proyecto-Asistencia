<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800">Asistencias</h1>
    
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <br>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Nº Cedula</th>
                        <th>Cargo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Empleado</th>
                        <th>Nº Cedula</th>
                        <th>Cargo</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php

                    $asistencias = ctrEmpleados::ctrMostrarEmpleados2();
                    foreach ($asistencias as $key => $value) {

                    ?>
                        <tr>
                            <td><?php echo $value["id_asistencia"] ?></td>
                            <td><?php echo $value['nombre_empleado'] . ' ' . $value['apellido_empleado']; ?></td>
                            <td><?php echo $value['ci']  ?></td>
                            <td><?php echo $value["nom_cargo"] ?></td>
                            <td><?php echo $value["entrada"] ?></td>
                            <td><?php echo $value["salida"] ?></td>

                          <td>
    <div class="btn-group">
        <?php if ($_SESSION['rol'] != 2): ?>
            <button class="btn btn-danger btn-sm eliminarAsistencia" idAsistenciaE="<?php echo $value["id_asistencia"] ?>">
                <i class="fas fa-trash"></i>
            </button>
        <?php else: ?>
            <span class="badge badge-secondary">Solo lectura</span>
        <?php endif; ?>
    </div>
</td>

                        </tr>

                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>