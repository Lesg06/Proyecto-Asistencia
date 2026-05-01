<div class="content-wrapper" style="min-height: 717px;">
	<section class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<h1>Asministrar Role</h1>
			</div>
		</div>
	</section>
	<section class="content">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-12">
					<div class="card card-info card-outline">
						<div class="card-header">
							<button type="button" class="btn btn-success crear-rol" data-toggle="modal"
							data-target="#modal-crear-roles"> 
								Crear nuevo rol
							</button>
						</div>
						<br>

						<div class="card-body">
							<table class="table table-bordered table-striped dt-responsive tablaRoles" width="100%">
								<thead>
									<tr>
										<th style="width:10px">#</th>
										<th>Nombre del Rol</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
								<?php 
									foreach($roles as $key => $value){

									?>

									<tr>
										<td><?php echo ($key+1) ?></td>
										<td><?php echo $value["nom_rol"]?></td>
										<td>
											<div class="btn-group">
												<button class="btn btn-warning btn-sm btnEditarRol" 
													data-toggle="modal" idRol="<?php echo $value["id_roles"]?>"
													data-target="#modal-editar-rol">
													<i class="fa fa-pencil text-white"></i>
												</button>
												<button 
													class="btn btn-danger btn-sm eliminarRol" 
													idRol="<?php echo $value["id_roles"]?>">
													<i class="fa fa-trash text-white"></i>
												</button>
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
			</div>
		</div>
	</section>
</div>


<!--Modal Crear Rol-->
<div class="modal modal-default fade" id="modal-crear-roles">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="alert alert-success alert-dismissible">Agregar nuevo Rol</h4>
			</div>
			<div class="modal-body">
			<form method="post" enctype="multipart/form-data">
				<div class="form-group has-feedback" bis_skin_checked="1">
					<input type="text" class="form-control" name="nom_rol" placeholder="nombre del rol">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
				<?php 

				$guardarRol = new ctrRoles();
				$guardarRol->ctrGuardarRol();
				
				?>
			</form>
			</div>
		</div>
	</div>
	
</div>

<!--Modal Editar Rol-->

<div class="modal modal-default fade" id="modal-editar-rol">

	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="alert alert-success alert-dismissible">Editar nuevo Rol</h4>
			</div>
			<div class="modal-body">
			<form method="post" enctype="multipart/form-data">
				<div class="form-group has-feedback" bis_skin_checked="1">
					<input type="hidden" name="id_rolE">
					<input type="text" class="form-control" name="nom_rolE" placeholder="nombre del rol">
					<span class="glyphicon glyphicon-user form-control-feedback"></span>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary">Guardar</button>
				</div>
				<?php 

					$editarRol = new ctrRoles();
					$editarRol->ctrEditarRol();
				
				?>
			</form>
			</div>
		</div>
	</div>
	
</div>