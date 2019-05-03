<?php

    include 'global/config.php';
    include 'global/conexion.php';
    include 'publicacion.php';

    include 'template/header.php';

    if(!isset($_SESSION['USUARIO'])){
        header('Location:index.php');
    }
    
    if(isset($_POST['id']) && isset($_POST['titulo']) &&  isset($_POST['cuerpo']) 
        && isset($_POST['media']) && isset($_POST['idCategoria'])){
        $id = $_POST['id'];
        $titulo = $_POST['titulo'];
        $cuerpo = $_POST['cuerpo'];
        $media = $_POST['media'];
        $idCategoria = $_POST['idCategoria'];

        // echo "$id  $titulo 
        // $cuerpo 
        // $media 
        // $idCategoria  ";
    }
?>
<?php 
  if($_SESSION['USUARIO']['tipo']==2){
?>
<a href="./misPublicaciones.php" name="btnAccion" 
            class="btn btn-outline-secondary float-right btn-sm" 
            value="cerrarSesion">Regresar</a>

<?php }else{ ?>
  <a href="./adminPublicaciones.php" name="btnAccion" 
          class="btn btn-outline-secondary float-right btn-sm" 
          value="cerrarSesion">Regresar</a>
<?php }?>
<p class="text-center">Edicion de la publicacion</p>
<form method="POST" class="needs-validation mb-5 card p-2 text-center  bg-info" 
      novalidate enctype="multipart/form-data">
    <div class="bg-warning card-header mb-2">
     Edición de la publicación
   </div>
  <div class="form-group">
    <input type="text" class="form-control" 
            id="id" name="id" 
            required placeholder="Titulo de la publicación"
            autocomplete="off"
            value="<?php echo $id; ?>"
            >
    <div class="valid-feedback">Valido</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>
  <div class="form-group">
    <input type="text" class="form-control" 
            id="titulo" name="titulo" 
            required placeholder="Titulo de la publicación"
            autocomplete="off"
            value="<?php echo $titulo; ?>"
            >
    <div class="valid-feedback">Valido</div>
    <div class="invalid-feedback">Campo Obligatorio</div>
  </div>

  <div class="form-group">
    
    <textarea name="cuerpo" id="cuerpo" 
                cols="30" rows="3" placeholder="Descripción"
                 required
                 class="form-control"  autocomplete="off" 
                 ><?php echo $cuerpo; ?></textarea>

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

  <button type="submit" name="btnAccion" value="editarPublicacion"
           class="btn btn-dark float-right">Publicar</button>
</form>




<?php include 'template/footer.php'; ?>