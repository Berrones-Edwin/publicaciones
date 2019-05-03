<?php

    include 'global/config.php';
    include 'global/conexion.php';
    include 'publicacion.php';

    include 'template/header.php';

    if(!isset($_SESSION['USUARIO'])){
        header('Location:index.php');
    }       
?>
<h3 class="text-center">Mis publicaciones</h3>

<!-- <a href="./perfil.php" name="btnAccion" 
           class="btn btn-outline-secondary btn-sm mb-3" 
           value="cerrarSesion">Nueva Publicacion</a> -->



<div class="card-columns">
<?php 
        $idUsuario = $_SESSION['USUARIO']['idUsuario'];
         $sentencia= $pdo->prepare("SELECT * FROM `publicacion` WHERE ESTATUS=1 AND idUsuario=$idUsuario ORDER BY idPublicacion DESC ");
         $sentencia->execute();
         if($sentencia){
            while($row = $sentencia->fetch()){
    ?>   
<div class="card border-info">
  

  <?php if($row['media'] != 'img.png'){?>
   
        <img  height="317px" src="./Media/<?php echo $row['media']; ?>" class="card-img-top" alt="..."> 
       
    
  <?php } ?>
   
      <div class="card-body">
      <h5 class="card-title"><?php echo $row['titulo']; ?></h5>
        <p class="card-text"><?php echo $row['cuerpo']; ?></p>
        <p class="card-text"><small class="text-muted"><?php echo $row['fecha']; ?></small></p>
        <div class="row">

          <form class="col-md-6" action="./editarPublicacion.php" method="post">
              <input class="id form-control" type="hidden" name="id"  id="id" value="<?php echo $row['idPublicacion']; ?>">
              <input class="titulo form-control" type="hidden" name="titulo" id="titulo" value="<?php echo $row['titulo']; ?>">
              <input class="cuerpo form-control" type="hidden" name="cuerpo" id="cuerpo" value="<?php echo $row['cuerpo']; ?>">
              <input class="media form-control" type="hidden" name="media" id="media" value="<?php echo $row['media']; ?>">
              <input class="idCategoria form-control" type="hidden" name="idCategoria" id="idCategoria" value="<?php echo $row['idCategoria']; ?>">
              <button type="submit" class="btn btn-warning btn-sm btnEditar"
                          name="editar" id="editar">Editar</button>
  
          </form>
          <form class="col-md-6" action="" method="post">
          <input class="id form-control" type="hidden" name="id"  id="id" value="<?php echo $row['idPublicacion']; ?>">
            <button class="btn btn-danger btn-sm" name="btnAccion" value="eliminar">Eliminar</button>
          </form>
        </div>
      </div>
    </div>

  <?php }} ?>


</div>

<?php include 'template/footer.php'; ?>
