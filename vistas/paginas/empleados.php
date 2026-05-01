<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800">Empleados</h1>
    
    </a>
</div>

<div class="card shadow mb-4">
    <?php if ($_SESSION['rol'] != 2): ?>
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#modal-crear-empleado">
            <span class="icon text-white-50"><i class="fas fa-user-plus"></i></span>
            <span class="text">Registrar Empleado</span>
        </button>
    </div>
    <?php endif; ?>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Cargo</th>
                        <th>Nº Cedula</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $key => $value):
                        $item = "id_cargo";
                        $valor = $value["cargo"];
                        $cargos = ctrCargos::ctrMostrarCargos($item, $valor);
                    ?>
                    <tr>
                        <td><?php echo $value["id_empleado"] ?></td>
                        <th><?php echo $value["nombre"] ?></th>
                        <td><?php echo $value["apellido"] ?></td>
                        <td><?php echo $cargos["nombre"] ?></td>
                        <td><?php echo $value["ci"] ?></td>
                        <td>
                            <div class="btn-group">
                                <button class="btn btn-info btn-sm btnVerEmpleado" data-toggle="modal"
                                    idEmpleado="<?php echo $value["id_empleado"] ?>"
                                    data-target="#modal-ver-empleado">
                                    <i class="fas fa-eye"></i>
                                </button>

                                <?php if ($_SESSION['rol'] != 2): ?>
                                <button class="btn btn-warning btn-sm mr-1 btnEditarEmpleado"
                                    data-toggle="modal" idEmpleado="<?php echo $value["id_empleado"] ?>"
                                    data-target="#modal-editar-empleado">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-danger btn-sm eliminarEmpleado" idEmplea="<?php echo $value["id_empleado"] ?>">
                                    <i class="fas fa-user-minus"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- Modal Crear Empleado -->
<div class="modal modal-default fade" id="modal-crear-empleado">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="alert alert-success alert-dismissible">Agregar nuevo Empleado</h4>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data">
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" name="nom_empleado" placeholder="Nombre" required>
          </div>

          <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" name="ape_empleado" placeholder="Apellido" required>
          </div>

          <div class="form-group">
            <label>Cargo</label>
            <select name="cargo_empleado" class="form-control" required>
              <?php
              $cargos = ctrCargos::ctrMostrarCargos2();
              foreach ($cargos as $carg) {
                echo '<option value="' . $carg['id_cargo'] . '">' . $carg['nombre'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Número de Cédula</label>
            <input type="text" class="form-control" name="ci_empleado" placeholder="Cédula" required>
          </div>

          <div class="form-group">
            <label>Número de Teléfono</label>
            <input type="text" class="form-control" name="telefono" placeholder="Teléfono">
          </div>

          <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control" name="direccion" placeholder="Dirección">
          </div>

          <div class="form-group">
            <label>Fecha de Ingreso</label>
            <input type="date" class="form-control" name="fecha_ingreso">
          </div>

          <div class="form-group">
            <label>Años de Servicio</label>
            <input type="number" class="form-control" name="anio_servicio" placeholder="Años de Servicio">
          </div>

          <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" class="form-control" name="correo" placeholder="Correo">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
          </div>

          <?php
          $guardarUsuarios = new ctrEmpleados();
          $guardarUsuarios->ctrGuardarEmpleado();
          ?>
        </form>
      </div>
    </div>
  </div>
</div>


<!-- Modal Editar Empleado -->
<div class="modal modal-default fade" id="modal-editar-empleado">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="alert alert-success alert-dismissible">Editar Empleado</h4>
      </div>
      <div class="modal-body">
        <form id="formEditarEmpleado" method="post" enctype="multipart/form-data">
          <input type="hidden" id="id_empleado_ed" name="id_empleado">

          <div class="form-group">
            <label>Nombre</label>
            <input type="text" class="form-control" id="ed_nom_empleado" name="nombre" placeholder="Nombre">
          </div>

          <div class="form-group">
            <label>Apellido</label>
            <input type="text" class="form-control" id="ed_ape_empleado" name="apellido" placeholder="Apellido">
          </div>

          <div class="form-group">
            <label>Cargo</label>
            <select name="cargo" id="ed_carg_empleado" class="form-control" required>
              <?php
              $cargosEditar = ctrCargos::ctrMostrarCargos2();
              foreach ($cargosEditar as $carg) {
                echo '<option value="' . $carg['id_cargo'] . '">' . $carg['nombre'] . '</option>';
              }
              ?>
            </select>
          </div>

          <div class="form-group">
            <label>Número de Cédula</label>
            <input type="text" class="form-control" id="ed_ci_empleado" name="ci" placeholder="Cédula">
          </div>

          <div class="form-group">
            <label>Número de Teléfono</label>
            <input type="text" class="form-control" id="ed_tlf_empleado" name="telefono" placeholder="Teléfono">
          </div>

          <div class="form-group">
            <label>Dirección</label>
            <input type="text" class="form-control" id="ed_desc_empleado" name="direccion" placeholder="Dirección">
          </div>

          <div class="form-group">
            <label>Fecha de Ingreso</label>
            <input type="date" class="form-control" id="ed_ing_empleado" name="fecha_ingreso">
          </div>

          <div class="form-group">
            <label>Años de Servicio</label>
            <input type="number" class="form-control" id="ed_ans_empleado" name="anio_servicio" placeholder="Años de Servicio">
          </div>

          <div class="form-group">
            <label>Correo Electrónico</label>
            <input type="email" class="form-control" id="ed_mail_empleado" name="correo" placeholder="Correo">
          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary">Editar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver Empleado -->
<!-- Modal Ver Empleado -->
<div class="modal fade" id="modal-ver-empleado">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h4 class="modal-title text-white">Datos del Empleado</h4>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <p><strong>Nombre:</strong> <span id="ver_nombre"></span></p>
        <p><strong>Apellido:</strong> <span id="ver_apellido"></span></p>
        <p><strong>Cargo:</strong> <span id="ver_cargo"></span></p>
        <p><strong>Cédula:</strong> <span id="ver_ci"></span></p>
        <p><strong>Teléfono:</strong> <span id="ver_telefono"></span></p>
        <p><strong>Dirección:</strong> <span id="ver_direccion"></span></p>
        <p><strong>Fecha de Ingreso:</strong> <span id="ver_fecha_ingreso"></span></p>
        <p><strong>Años de Servicio:</strong> <span id="ver_anio_servicio"></span></p>
        <p><strong>Correo:</strong> <span id="ver_correo"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
