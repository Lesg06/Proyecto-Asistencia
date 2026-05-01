<div class="d-sm-flex align-items-center justify-content-between mb-4">
	<h1 class="h3 mb-4 text-gray-800">Usuarios</h1>
	<!-- <a href="vistas/fpdf/ReporteUsuario.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" target="_blank">
		<i class="fas fa-download fa-sm text-white-50"></i> Generar Reporte
	</a> -->
</div>

<div class="card shadow mb-4">
	<?php if ($_SESSION['rol'] != 2): ?>
	<div class="card-header py-3">
		<button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#modal-crear-usuarios">
			<span class="icon text-white-50">
				<i class="fas fa-user-plus"></i>
			</span>
			<span class="text">Registrar Usuario</span>
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
						<th>Usuario</th>
						<th>Rol</th>
						<th>Foto</th>
						<th>Acciones</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($usuarios as $key => $value) {
						$item = "id_roles";
						$valor = $value["rol"];
						$roles = ctrRoles::ctrMostrarRoles($item, $valor);
					?>
					<tr>
						<td><?php echo $value["id"] ?></td>
						<td><?php echo $value["nombre"] ?></td>
						<td><?php echo $value["apellido"] ?></td>
						<td><?php echo $value["usuario"] ?></td>
						<td><?php echo $roles["nom_rol"] ?></td>
						<td><img src="<?php echo $value["foto"] ?>" width="40" height="40" alt="foto de perfil"></td>
						<td>
							<?php if ($_SESSION['rol'] != 2): ?>
							<div class="btn-group">
								<button class="btn btn-warning btn-sm mr-1 btnEditarUsuario"
									data-toggle="modal" idUsuario="<?php echo $value["id"] ?>"
									data-target="#modal-editar-usuarios">
									<i class="fas fa-pen"></i>
								</button>
								<button class="btn btn-danger btn-sm eliminarUsuario" idUsuarioE="<?php echo $value["id"] ?>" rutaFoto="<?php echo $value["foto"]; ?>">
									<i class="fas fa-user-minus"></i>
								</button>
							</div>
							<?php else: ?>
							<span class="badge badge-secondary">Solo lectura</span>
							<?php endif; ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<?php if ($_SESSION['rol'] != 2): ?>
<!-- Modal Crear Usuarios -->
<div class="modal modal-default fade" id="modal-crear-usuarios">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="alert alert-success alert-dismissible">Agregar nuevo usuario</h4>
			</div>
			<div class="modal-body">
				<form method="post" enctype="multipart/form-data">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" class="form-control" id="cr_nom_usuario" name="cr_nom_usuario" required>
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" class="form-control" id="cr_ape_usuario" name="cr_ape_usuario" required>
					</div>
					<div class="form-group">
						<label>Usuario</label>
						<input type="text" class="form-control" id="cr_nom_user" name="cr_nom_user" required>
					</div>
					<div class="form-group">
    <label>Contraseña</label>
    <input type="password" class="form-control" id="cr_pass_user" name="cr_pass_user" required>
    <div id="cr_password_strength" class="mt-2"></div>
    <small id="cr_password_requirements" class="text-muted">
        <ul>
            <li id="cr_length" class="text-danger">Mínimo 8 caracteres</li>
            <li id="cr_upper" class="text-danger">Al menos una mayúscula</li>
            <li id="cr_lower" class="text-danger">Al menos una minúscula</li>
            <li id="cr_number" class="text-danger">Al menos un número</li>
            <li id="cr_special" class="text-danger">Al menos un símbolo</li>
        </ul>
    </small>
</div>

					<div class="form-group">
						<div class="btn btn-default btn-file">
							<i class="fa fa-paperclip"></i> Adjuntar Imagen de Perfil
							<input type="file" name="cr_subirImgUsuario" id="cr_subirImgUsuario">
						</div>
						<img class="previsualizarImgUser img-fluid py-2" width="200" height="200">
						<p class="help-block small">Dimensiones: 480px * 382px | Peso Max. 2MB | Formato: JPG PNG</p>
					</div>
					<div class="form-group">
						<label>Rol</label>
						<select name="cr_rol_user" id="cr_rol_user" class="form-control" required>
							<?php
							$roles = ctrRoles::ctrMostrarRoles2();
							foreach ($roles as $rol) {
								echo '<option value="' . $rol['id_roles'] . '">' . $rol['nom_rol'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
					<?php
					$guardarUsuarios = new ctrUsuarios();
					$guardarUsuarios->ctrGuardarusuarios();
					?>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Modal Editar Usuario -->
<div class="modal modal-default fade" id="modal-editar-usuarios">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="alert alert-success alert-dismissible">Editar usuario</h4>
			</div>
			<div class="modal-body">
				<form method="post" enctype="multipart/form-data">
					<input type="hidden" id="ed_idPerfil" name="ed_idPerfil">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" class="form-control" id="ed_nom_usuario" name="ed_nom_usuario">
					</div>
					<div class="form-group">
						<label>Apellido</label>
						<input type="text" class="form-control" id="ed_ape_usuario" name="ed_ape_usuario">
					</div>
					<div class="form-group">
						<label>Usuario</label>
						<input type="text" class="form-control" id="ed_nom_user" name="ed_nom_user">
					</div>
					<div class="form-group">
    <label>Contraseña</label>
    <input type="hidden" id="pass_useractual" name="pass_useractual">
    <input type="password" class="form-control" id="ed_pass_user" name="ed_pass_user">
    <div id="ed_password_strength" class="mt-2"></div>
    <small id="ed_password_requirements" class="text-muted">
        <ul>
            <li id="ed_length" class="text-danger">Mínimo 8 caracteres</li>
            <li id="ed_upper" class="text-danger">Al menos una mayúscula</li>
            <li id="ed_lower" class="text-danger">Al menos una minúscula</li>
            <li id="ed_number" class="text-danger">Al menos un número</li>
            <li id="ed_special" class="text-danger">Al menos un símbolo</li>
        </ul>
    </small>
</div>

					<div class="form-group">
						<div class="btn btn-default btn-file">
							<i class="fa fa-paperclip"></i> Adjuntar Imagen de Perfil
							<input type="file" name="ed_subirImgUsuario" id="ed_subirImgUsuario">
						</div>
						<input type="hidden" id="fotoActualE" name="fotoActualE">
						<img class="previsualizarImgUser img-fluid py-2" width="200" height="200">
						<p class="help-block small">Dimensiones: 480px * 382px | Peso Max. 2MB | Formato: JPG PNG</p>
					</div>
					<div class="form-group">
						<label>Rol</label>
						<select name="ed_rol_user" class="form-control" required>
							<?php
							foreach ($roles as $rol) {
								echo '<option value="' . $rol['id_roles'] . '">' . $rol['nom_rol'] . '</option>';
							}
							?>
						</select>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary">Editar</button>
					</div>
					<?php
					$editarUsuarios = new ctrUsuarios();
					$editarUsuarios->ctrEditaruarios();
					?>
				</form>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<script>
function checkPasswordStrength(inputIdPrefix) {
    const passwordInput = document.getElementById(inputIdPrefix + '_pass_user');
    const strengthDiv = document.getElementById(inputIdPrefix + '_password_strength');
    const lengthEl = document.getElementById(inputIdPrefix + '_length');
    const upperEl = document.getElementById(inputIdPrefix + '_upper');
    const lowerEl = document.getElementById(inputIdPrefix + '_lower');
    const numberEl = document.getElementById(inputIdPrefix + '_number');
    const specialEl = document.getElementById(inputIdPrefix + '_special');

    if (!passwordInput) return;

    passwordInput.addEventListener('input', () => {
        const val = passwordInput.value;
        const hasLength = val.length >= 8;
        const hasUpper = /[A-Z]/.test(val);
        const hasLower = /[a-z]/.test(val);
        const hasNumber = /[0-9]/.test(val);
        const hasSpecial = /[^A-Za-z0-9]/.test(val);

        lengthEl.className = hasLength ? 'text-success' : 'text-danger';
        upperEl.className = hasUpper ? 'text-success' : 'text-danger';
        lowerEl.className = hasLower ? 'text-success' : 'text-danger';
        numberEl.className = hasNumber ? 'text-success' : 'text-danger';
        specialEl.className = hasSpecial ? 'text-success' : 'text-danger';

        const score = [hasLength, hasUpper, hasLower, hasNumber, hasSpecial].filter(Boolean).length;
        let strength = '';
        let color = '';

        if (score <= 2) {
            strength = 'Débil';
            color = 'danger';
        } else if (score === 3 || score === 4) {
            strength = 'Media';
            color = 'warning';
        } else {
            strength = 'Fuerte';
            color = 'success';
        }

        strengthDiv.innerHTML = `
            <div class="progress">
                <div class="progress-bar bg-${color}" role="progressbar" style="width: ${score * 20}%" aria-valuenow="${score * 20}" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <small class="text-${color}">Fortaleza: ${strength}</small>
        `;
    });
}

// Activar validación para crear y editar
checkPasswordStrength('cr'); // creación
checkPasswordStrength('ed'); // edición
</script>
