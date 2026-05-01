<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800">Cargos</h1>
    
    </a>
</div>

<div class="card shadow mb-4">
    <?php if ($_SESSION['rol'] != 2): ?>
    <div class="card-header py-3">
        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#modal-crear-cargo">
            <span class="icon text-white-50"><i class="fas fa-user-plus"></i></span>
            <span class="text">Registrar Cargo</span>
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($cargos as $key => $value): ?>
                    <tr>
                        <td><?php echo $value["id_cargo"] ?></td>
                        <td><?php echo $value["nombre"] ?></td>
                        <td>
                            <div class="btn-group">
                                <?php if ($_SESSION['rol'] != 2): ?>
                                <button class="btn btn-warning btn-sm mr-1 btnEditarCargo"
                                        idCargo="<?php echo $value["id_cargo"] ?>"
                                        data-toggle="modal"
                                        data-target="#modal-editar-cargo">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <button class="btn btn-danger btn-sm eliminarCargo"
                                        idCargo="<?php echo $value["id_cargo"] ?>">
                                    <i class="fa fa-trash text-white"></i>
                                </button>
                                <?php else: ?>
                                <span class="badge badge-secondary">Solo lectura</span>
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

<?php if ($_SESSION['rol'] != 2): ?>
<!-- Modal Crear Cargos -->
<div class="modal modal-default fade" id="modal-crear-cargo">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="alert alert-success alert-dismissible">Agregar nuevo Cargo</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="nom_cargo" placeholder="nombre del Cargo" required>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                    <?php
                    $guardarRol = new ctrCargos();
                    $guardarRol->ctrGuardarCargo();
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar Cargo -->
<div class="modal fade" id="modal-editar-cargo" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form id="formEditarCargo" method="post">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="alert alert-success w-100 mb-0">Editar Cargo</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_cargoE" name="id_cargoE">
          <div class="form-group">
            <label>Nombre del Cargo</label>
            <input type="text" class="form-control" id="nom_cargoE" name="nom_cargoE" placeholder="Nombre del Cargo" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<?php endif; ?>
