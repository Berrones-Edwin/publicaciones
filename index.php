<?php

    include 'global/config.php';
    include 'global/conexion.php';
    include 'publicacion.php';

    include 'template/header.php';

?>
<div class="row mx-auto ">
    <h2 class="text-center col-md-12">Login</h2>
    <form method="post" 
          class="mx-auto text-center col-md-5 col-sm-12 needs-validation "
          novalidate>
      <div class="form-group">
        <label for="uname">Correo:</label>
        <input type="text" class="form-control" id="email" 
                placeholder="Introduzca su email" 
                autocomplete="off" name="email"
                
                required
        >
        <div class="valid-feedback">Correcto.</div>
        <div class="invalid-feedback">Campo Obligatorio</div>
      </div>
      <div class="form-group">
        <label for="pwd">Contraseña:</label>
        <input type="password" class="form-control" id="pwd" 
                placeholder="Introduzca su contraseña" name="pwd" 
                minlength=8 
                required>
        <div class="valid-feedback">Correcto</div>
        <div class="invalid-feedback">Campo Obligatorio</div>
      </div>
      <button type="submit" class="btn btn-primary" 
                name="btnAccion" 
                value="ingresar">Entrar</button>
    </form>
</div>
<div class="container mx-auto">
    <a class="d-flex justify-content-center text-center" href="./registrar.php">Registrar</a>
</div>

<script>
// Disable form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Get the forms we want to add validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<?php include 'template/footer.php'; ?>
