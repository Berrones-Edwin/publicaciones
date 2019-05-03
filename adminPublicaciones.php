<?php

    include 'global/config.php';
    include 'global/conexion.php';
    include 'publicacion.php';

    include 'template/header.php';

    if(!isset($_SESSION['USUARIO'])){
        header('Location:index.php');
    }       
?>
<h3 class="text-center">Todas publicaciones</h3>
<!-- 
<a href="./admin.php" name="btnAccion" 
           class="btn btn-outline-secondary mb-3 btn-sm" 
           value="cerrarSesion">Nueva Publicacion</a> -->

<div class="card-columns">
<?php 
        $idUsuario = $_SESSION['USUARIO']['idUsuario'];
         $sentencia= $pdo->prepare("SELECT P.idPublicacion, P.titulo, P.cuerpo,P.fecha,P.media,U.nombre,U.idUsuario FROM publicacion AS P JOIN usuario AS U ON P.idUsuario = U.idUsuario WHERE P.estatus = 1 ORDER BY idPublicacion DESC");
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
        <p class="card-text"><small class="text-muted"><?php echo $row['fecha']; ?></small></p>
        <p class="card-text badge badge-pill badge-warning">Usuario <?php echo $row['nombre']; ?></p>

        <?php 
            if($row['idUsuario'] == $_SESSION['USUARIO']['idUsuario']){
            ?>
            <span class="mb-2 badge badge-success">Admin</span>
        <?php }?>
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
