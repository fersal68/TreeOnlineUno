<?php 
?>

<!-- login.php -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="./images/us.png" class="login-icon" alt="User Icon">
                <div class="form-group">
                    <div class="icon-container">
                        <i class="ri-user-fill username-icon"></i>
                    </div>
                    <input type="text" class="form-control" id="username" placeholder="Usuario">
                </div>
                <div class="form-group">
                    <div class="icon-container">
                        <i class="ri-key-2-fill password-icon"></i>
                    </div>
                    <input type="password" class="form-control" id="password" placeholder="Contraseña">
                    <i class="ri-eye-off-fill password-toggle" id="togglePassword"></i>
                </div>
                <button type="button" id="loginSubmit" class="btn btn-success btn-block">Ingresar</button>
                <div class="text-center mt-3">
                    <a href="./menu.php?sec=Registracion">¿Desea registrarse?</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>

