<div class="container">
    <div class="page-header">
        <h1>REGISTRO <small class="tittles-pages-logo"></small></h1>
    </div>
    <p class="lead text-center">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident assumenda asperiores architecto nostrum blanditiis excepturi voluptatibus, velit ad enim. Aperiam voluptatum est, fugit quisquam libero distinctio nobis porro numquam minus.
    </p>
    <div class="row">
        <!-- División izquierda -->
        <div class="col-sm-6 col-with-border">
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-center lead">Registro de Clientes</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <figure>
                        <img src="./images/registrar.png" alt="store" class="img-responsive">
                    </figure>
                </div>
            </div>
        </div>
           
        <!-- funcion para el simbolo de carga 
         <div id="loading" class="loading">
                <img src="./images/loading.png" alt="Cargando...">
        </div> -->  
        <!-- funcion para el simbolo de carga , abajo esta el js en Registracion.js-->

        <!-- División derecha -->
        <div class="col-sm-6">
            <div id="container-form">
                <form id="RegistracionForm" class="RegistracionForm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <legend><i class="fa fa-user"></i> &nbsp; Datos personales</legend>
                                <div class="fieldset-border">
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="regdni"><i class="fa fa-address-card" aria-hidden="true"></i>&nbsp; Ingrese su número de DNI</label>
                                        <input class="form-control" id="regdni" type="text" required name="regdni" pattern="[0-9]{1,15}" title="Ingrese su número de DNI. Solamente números" maxlength="15">
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label" for="regfullname"><i class="fa fa-user"></i>&nbsp; Ingrese sus nombres</label>
                                                <input class="form-control" id="regfullname" type="text" required name="regfullname" title="Ingrese sus nombres (solamente letras)" pattern="[a-zA-Z ]{1,50}" maxlength="50">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label" for="reglastname"><i class="fa fa-user"></i>&nbsp; Ingrese sus apellidos</label>
                                                <input class="form-control" id="reglastname" type="text" required name="reglastname" title="Ingrese sus apellidos (solamente letras)" pattern="[a-zA-Z ]{1,50}" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label" for="regphone"><i class="fa fa-mobile"></i>&nbsp; Ingrese su n° telefónico</label>
                                                <input class="form-control" id="regphone" type="tel" required name="regphone" maxlength="15" title="Ingrese su número telefónico. Mínimo 8 dígitos máximo 15">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label" for="regemail"><i class="fa fa-envelope" aria-hidden="true"></i>&nbsp; Ingrese su Email</label>
                                                <input class="form-control" id="regemail" type="email" required name="regemail" title="Ingrese la dirección de su Email" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="regdir"><i class="fa fa-home"></i>&nbsp; Ingrese su dirección</label>
                                        <input class="form-control" id="regdir" type="text" required name="regdir" title="Ingrese la dirección en la que reside actualmente" maxlength="100">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <legend><i class="fa fa-lock"></i> &nbsp; Datos de la cuenta</legend>
                                <div class="fieldset-border">
                                    <div class="form-group label-floating">
                                        <label class="control-label" for="regname"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Ingrese su nombre de usuario</label>
                                        <input class="form-control" id="regname" type="text" required name="regname" title="Ingrese su nombre. Máximo 9 caracteres (solamente letras y números sin espacios)" pattern="[a-zA-Z0-9]{1,9}" maxlength="9">
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label" for="regpass"><i class="fa fa-lock"></i>&nbsp; Introduzca una contraseña</label>
                                                <input class="form-control" id="regpass" type="password" required name="regpass" title="Defina una contraseña para iniciar sesión">
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-6">
                                            <div class="form-group label-floating">
                                                <label class="control-label" for="regpass2"><i class="fa fa-lock"></i>&nbsp; Repita la contraseña</label>
                                                <input class="form-control" id="regpass2" type="password" required name="regpass2" title="Repita la contraseña">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <p><button type="button" id="RegSubmit" onclick="showLoading()" class="btn btn-primary">Registrarse</button></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
