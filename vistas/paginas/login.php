<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-5 col-lg-6 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="vistas/imagenes/cspol.png" alt="logo" width="160" height="190">
                                        <br>
                                        <br>
                                        <h1 class="h3 text-gray-900 mb-4 font-weight-bold">Sistema de Control de Asistencias</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user" name="log_user" placeholder="Nombre de usuario">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="log_pass" placeholder="Contraseña">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Recuérdame</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Ingresar</button>
                                        <?php
                                        $ingreso = new ctrUsuarios();
                                        $ingreso->ctrIngresoUsusrio();
                                        ?>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="reset-password"></a>
                                    </div>
                                    <!-- <div class="text-center">
                                        <a class="small text-success" href="/">Registrar asistencia</a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vistas/recursos/vendor/jquery/jquery.min.js"></script>
    <script src="vistas/recursos/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vistas/recursos/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="vistas/recursos/dist/js/sb-admin-2.min.js"></script>
    <script>
        document.querySelector('.bg-gradient-primary').classList.add('fondo-imagen');
    </script>

</body>