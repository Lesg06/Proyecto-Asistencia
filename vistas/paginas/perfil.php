<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-4 text-gray-800">Mi Perfil</h1>
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#modal-editar-usuarios">
        <i class="fas fa-user-edit fa-sm text-white-50"></i> Editar Perfil
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-body text-center">
        <img src="<?php echo $_SESSION['foto']; ?>" class="img-thumbnail mb-3" width="150" height="150" alt="Foto de perfil">
        <h4><?php echo $_SESSION['nombre'] . ' ' . $_SESSION['apellido']; ?></h4>
        <p class="text-muted"><?php echo $_SESSION['email']; ?></p>
        <hr>
        <div class="text-left">
            <p><strong>ID:</strong> <?php echo $_SESSION['id']; ?></p>
            <p><strong>Usuario:</strong> <?php echo $_SESSION['usuario']; ?></p>
            <p><strong>Rol:</strong> <?php echo $_SESSION['nom_rol']; ?></p>
        </div>
    </div>
</div>

<div class="modal modal-default fade" id="modal-editar-usuarios">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="alert alert-success alert-dismissible">Editar Perfil</h4>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data">
                    <input type="hidden" id="ed_idPerfil" name="ed_idPerfil" value="<?php echo $_SESSION['id']; ?>">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" class="form-control" id="ed_nom_usuario" name="ed_nom_usuario" value="<?php echo $_SESSION['nombre']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Apellido</label>
                        <input type="text" class="form-control" id="ed_ape_usuario" name="ed_ape_usuario" value="<?php echo $_SESSION['apellido']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" class="form-control" id="ed_nom_user" name="ed_nom_user" value="<?php echo $_SESSION['usuario']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="email" class="form-control" id="ed_email_usuario" name="ed_email_usuario" value="<?php echo $_SESSION['email']; ?>">
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
                        <input type="hidden" id="fotoActualE" name="fotoActualE" value="<?php echo $_SESSION['foto']; ?>">
                        <img src="<?php echo $_SESSION['foto']; ?>" class="previsualizarImgUser img-fluid py-2" width="200" height="200">
                        <p class="help-block small">Dimensiones: 480px * 382px | Peso Max. 2MB | Formato: PNG</p>
                    </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <input type="text" name="ed_rol_user" class="form-control" required readonly value="<?php echo $_SESSION['rol']; ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Editar</button>
                    </div>
                    <?php
                    $editarPerfil = new ctrUsuarios();
                    $editarPerfil->ctrEditarPerfilPropio();
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>
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