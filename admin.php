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

<div class="row">
  <form method="POST" class="col-sm-12 col-md-8 needs-validation mb-5 card p-2 text-center  bg-info" 
    novalidate enctype="multipart/form-data">
  <div class="card-header mb-2 bg-warning">
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
  <div class="col-sm-12 col-md-4">
    <h4 class="text-center">Ultimos Usuarios Registrados</h4>
    
    <?php 
        $sentencia= $pdo->prepare("SELECT * FROM `usuario` WHERE ESTATUS=1 ORDER BY idUsuario DESC");
        $sentencia->execute();

        if($sentencia){
    ?>
    <?php while($row = $sentencia->fetch()){ ?>
    <div class="col-md-12 mb-3">
      <div class="alert alert-primary" role="alert">
        Usuario: <?php echo $row['nombre']; ?>
        <span class="badge badge-pill badge-warning"><?php echo $row['tipo'] ==1 ?  'Admin' : 'User'; ?></span>
      </div>
    </div>
    <?php } }?>
   
  </div>
</div>

<hr>

<h3 class="text-center">Las ultimas publicaciones</h3>

<div class="card-columns">
    <?php 
        $idUsuario = $_SESSION['USUARIO']['idUsuario'];
         $sentencia= $pdo->prepare("SELECT P.idPublicacion, P.titulo, P.cuerpo,P.fecha,P.media,U.nombre,U.idUsuario FROM publicacion AS P JOIN usuario AS U ON P.idUsuario = U.idUsuario WHERE P.estatus = 1  ORDER BY P.idPublicacion DESC LIMIT 5 ");
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

                <p class="card-text badge badge-pill badge-warning">Usuario <?php echo $row['nombre']; ?></p>

                <?php 
                  if($row['idUsuario'] == $_SESSION['USUARIO']['idUsuario']){
                ?>
                <span class="badge badge-success">Admin</span>
                  <?php }?>
            </div>
        </div>
    <?php }} ?>



</div>

<a class="btn btn-dark float-right" href="./adminPublicaciones.php">Ver Todas</a>



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
