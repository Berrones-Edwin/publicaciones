<?php

    include 'global/config.php';
    include 'global/conexion.php';
    include 'publicacion.php';

    include 'template/header.php';

    if(!isset($_SESSION['USUARIO'])){
        header('Location:index.php');
    }       
?>

<!-- <form  method="post" >

    <button name="btnAccion" 
            class="btn btn-outline-secondary float-right btn-sm" 
            value="cerrarSesion">Cerrar Sesión</button>
</form> -->

<!-- <h2 class="text-center">Bienvenido <?php echo $_SESSION['USUARIO']['nombre']; ?></h2> -->

<form method="POST" class="needs-validation mb-5 card p-2 text-center  bg-info" 
      novalidate enctype="multipart/form-data">
    <div class="bg-warning card-header mb-2">
     ¿Qué estas pensando <?php echo $_SESSION['USUARIO']['nombre']; ?>?
   </div>

  <div class="form-group" >
    <input type="text" class="form-control" 
            id="titulo" name="titulo" 
            required placeholder="Titulo de la publicación"
            autocomplete="off"
            >
    <div class="valid-feedback">Valido</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>

  <div class="form-group">
    
    <textarea name="cuerpo" id="cuerpo" 
                cols="30" rows="3" placeholder="Descripción"
                 required
                 class="form-control"  autocomplete="off"></textarea>

    <div class="valid-feedback">Valido.</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>
  <div class="form-group">
    
   <input type="file" name="media" id="media" class="form-control">

    <div class="valid-feedback">Valido.</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>

<div class="row">
  <div class="form-group col-md-6">
    <?php 
         $sentencia= $pdo->prepare("SELECT * FROM `categoria` WHERE ESTATUS=1");
         $sentencia->execute();

         if($sentencia){
            
         
    ?>
    <select name="categoria" id="categoria" class="form-control" required>
        <option value="">Seleccione una categoria..</option>
        <?php while($row = $sentencia->fetch()){ ?>
            <option value="<?php echo $row['idCategoria']; ?>">
                            <?php echo $row['nombre']; ?>
            </option>
        <?php } }?>
       
    </select>
    <div class="valid-feedback">Valido.</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>

  <div class="form-group col-md-6">
    <?php 
         $sentencia= $pdo->prepare("SELECT * FROM `referencia` WHERE ESTATUS=1");
         $sentencia->execute();

         if($sentencia){
            
         
    ?>
    <select name="referencia" id="referencia" class="form-control" required>
        <option value="">Seleccione una referencia..</option>
        <?php while($row = $sentencia->fetch()){ ?>
            <option value="<?php echo $row['idReferencia']; ?>">
                            <?php echo $row['nombre']; ?>
            </option>
        <?php } }?>
       
    </select>
    <div class="valid-feedback">Valido.</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>
</div>

  <div class="form-group">
    <button type="submit" name="btnAccion" 
            value="agregarPublicacion" 
            class="btn btn-dark float-right">Publicar</button>
  </div>
</form>


<h3 class="text-center">Tus ultimas publicaciones</h3>

<div class="card-columns">
    <?php 
        $idUsuario = $_SESSION['USUARIO']['idUsuario'];
         $sentencia= $pdo->prepare("SELECT * FROM `publicacion` WHERE ESTATUS=1 AND idUsuario=$idUsuario ORDER BY idPublicacion DESC LIMIT 3");
         $sentencia->execute();
         if($sentencia){
            while($row = $sentencia->fetch()){
    ?>   
        <div class="card border-info">
            <?php $partes_ruta = pathinfo($row['media'] ); ?>
            <?php if($row['media'] != "img.png" || $row['media'] != ""){ ?> 
                <?php if($partes_ruta['extension']=='mp4'){ ?>   
                  <video height="317px" poster="./img/video_icon.jpg" src="./Media/<?php echo $row['media']; ?>" class="card-img-top" controls> </video> 
                <?php }else{ ?>    
                <img  height="317px" src="./Media/<?php echo $row['media']; ?>" class="card-img-top" alt="..."> 
                <?php } ?>    
            <?php }?>
            <div class="card-body">
                <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
                <p class="card-text"><?php echo $row['cuerpo']; ?></p>
            </div>
        </div>
    <?php }} ?>



</div>

<a class="btn btn-dark float-right" href="./misPublicaciones.php">Ver Todas</a>



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
