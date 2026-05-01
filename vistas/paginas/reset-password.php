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
                                        <img src="vistas/imagenes/logo.png" alt="logo" class="rounded mx-auto d-block">
                                        <br>
                                        <h1 class="h3 text-gray-900 mb-2 font-weight-bold">¿Olvidaste tu contraseña?</h1>
                                        <p class="mb-4">Lo entendemos, a veces pasan cosas. ¡Ingresa tu correo electrónico a
                                            continuación y te enviaremos una contraseña temporal!</p>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Ingrese su nombre de ususairo..." name="reset-password" require>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">Restaurar contraceña</button>
                                        <?php
                                        $ingreso = new ctrResetPassword();
                                        $ingreso->ctrResetPassword();
                                        ?>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="login">¡Iniciar sesión!</a>
                                    </div>
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