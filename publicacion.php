<?php
    session_start();
   

    $mensaje ="";

    if(isset($_POST['btnAccion'])){

        switch ($_POST['btnAccion']) {
            case 'ingresar':
                    
                   if(isset($_POST['email']) && isset($_POST['pwd'])){

                    $email = $_POST['email'];
                    $pwd = $_POST['pwd'];

                   

                    $sentencia = $pdo->prepare("SELECT * FROM usuario 
                                                WHERE EMAIL=:EMAIL AND PASSWORD=:PASSWORD AND ESTATUS=1");
                    
                    $datos = array(

                        ":EMAIL" => $email,
                        ":PASSWORD" => $pwd
                    );

                    $sentencia->execute($datos);

                    // $mensaje = $sentencia->rowCount();
                    if($sentencia) {

                        if($sentencia->rowCount()>0){

                            $user = $sentencia->fetch(PDO::FETCH_ASSOC);
                            
                            $mensaje =  $user;
                            
                            $_SESSION['USUARIO'] = $user;
    
                            if($_SESSION['USUARIO']['tipo']==1){
    
                                header('Location:admin.php');
                            }else{
    
                                header('Location:perfil.php');
                            }
                        }
                        

                        
                    }else{
                        
                        $mensaje .=  " datos no correctos";
                    }
                   }
                    
                break;

            case  "registrar":

                   if(isset($_POST['nombre']) && isset($_POST['apellidos'])
                   && isset($_POST['email']) && isset($_POST['pwd']) && isset($_POST['tipo'])){

                    $nombre =$_POST['nombre'];
                    $apellidos =$_POST['apellidos'];
                    $email =$_POST['email'];
                    $pwd=$_POST['pwd'];
                    $tipo=$_POST['tipo'];

                    $sentencia = $pdo->prepare("INSERT INTO `usuario` (`nombre`, `apellidos`, `email`, `password`, `tipo`) VALUES (:NOMBRE,:APELLIDOS,:EMAIL,:PWD,:TIPO);");

                    $datos = array(
                        ":NOMBRE"=>$nombre,
                        ":APELLIDOS"=>$apellidos,
                        ":EMAIL"=>$email,
                        ":PWD"=>$pwd,
                        ":TIPO"=>$tipo
                    );

                    $sentencia->execute($datos);

                    if($sentencia){
                        header('Location:index.php');
                    }

                   }
                break;
            case  "cerrarSesion":

                   session_destroy();
                   header('Location:index.php');
                break;

            case  "agregarPublicacion":
                if(isset($_POST['titulo']) && isset($_POST['cuerpo']) 
                    && isset($_POST['categoria']) && isset($_POST['referencia']) 
                    ){

                        $titulo = $_POST['titulo'];
                        $cuerpo = $_POST['cuerpo'];
                        $categoria = $_POST['categoria'];
                        $referencia = $_POST['referencia'];
                        $media = (isset($_FILES['media']['name'])) ? $_FILES['media']['name'] : '' ;

            

                        $mensaje = " $titulo $cuerpo $categoria $referencia";

                        $sentencia = $pdo->prepare("INSERT INTO `publicacion`(`titulo`, `cuerpo`, `idUsuario`, `idCategoria`,`media`) 
                                                    VALUES (:TITULO,:CUERPO,:IDUSUARIO,:IDCATEGORIA,:MEDIA)");

                        $fechaImagen = new DateTime();
                         // Mover img a la carpeta media del proyecto
                         $nombreImagen = ($media!="") ? $fechaImagen->getTimeStamp().'_'.$_FILES['media']['name'] : 'img.png' ;

                         //Directorio temporal
                         $tmpFoto = $_FILES['media']['tmp_name'];
             
                         //Validar si no viene vacío
                         if($tmpFoto!=""){
             
                             //Mover la img con el nombre modificado
                             //a la carpeta de img de nuestro proyecto
                             //paramentros el directorio temporal y el nombre
                             move_uploaded_file($tmpFoto,'./Media/'.$nombreImagen);
                         }

                        $datos = array(
                            ":TITULO"=> $titulo,
                            ":CUERPO"=>$cuerpo,
                            ":IDUSUARIO"=> $_SESSION['USUARIO']['idUsuario'],
                            ":IDCATEGORIA"=>$categoria,
                            ":MEDIA"=> $nombreImagen
                        );

                        $sentencia->execute($datos);

                        $idPublicacion = $pdo->lastInsertId();

                        $sentenciaRef = $pdo->prepare("INSERT INTO `publicacionreferencia`(`idPublicacion`, `idReferencia`) 
                                                        VALUES (:IDPUBLICACION,:IDREFERENCIA)");
                        $datosRef = array(
                            ":IDPUBLICACION"=> $idPublicacion,
                            ":IDREFERENCIA" => $referencia
                        );

                        $sentenciaRef -> execute($datosRef);
                       

                    
                }

                   
                break;
            case  "editarPublicacion":
                if(isset($_POST['titulo']) && isset($_POST['cuerpo']) 
                    && isset($_POST['categoria']) && isset($_POST['referencia']) 
                    ){

                        $id = $_POST['id'];
                        $titulo = $_POST['titulo'];
                        $cuerpo = $_POST['cuerpo'];
                        $categoria = $_POST['categoria'];
                        $referencia = $_POST['referencia'];
                        $media = (isset($_FILES['media']['name'])) ? $_FILES['media']['name'] : '' ;


                        if($media != ""){

                            $fechaImagen = new DateTime();
                             // Mover img a la carpeta media del proyecto
                             $nombreImagen = ($media!="") ? $fechaImagen->getTimeStamp().'_'.$_FILES['media']['name'] : 'img.png' ;
    
                             //Directorio temporal
                             $tmpFoto = $_FILES['media']['tmp_name'];
                 
                             //Validar si no viene vacío
                             if($tmpFoto!=""){
                 
                                 //Mover la img con el nombre modificado
                                 //a la carpeta de img de nuestro proyecto
                                 //paramentros el directorio temporal y el nombre
                                 move_uploaded_file($tmpFoto,'./Media/'.$nombreImagen);
                             }

                             $sentencia = $pdo->prepare("UPDATE `publicacion` SET `titulo`=:TITULO,`fecha`=:FECHA,`cuerpo`=:CUERPO,
                                                            `media`=:MEDIA,`idCategoria`=:IDCATEGORIA WHERE idPublicacion=:ID");
    
                            $datos = array(
                                ":TITULO"=> $titulo,
                                ":FECHA" =>date("Y-m-d H:i:s"),
                                ":CUERPO"=>$cuerpo,
                                ":MEDIA"=> $nombreImagen,
                                ":IDCATEGORIA"=>$categoria,
                                ":ID" =>$id
                            );
    
                            $sentencia->execute($datos);
                        }else{
                            $sentencia = $pdo->prepare("UPDATE `publicacion` SET `titulo`=:TITULO,`fecha`=:FECHA,`cuerpo`=:CUERPO,
                                                            `idCategoria`=:IDCATEGORIA WHERE idPublicacion=:ID");
    
                            $datos = array(
                                ":TITULO"=> $titulo,
                                ":FECHA" =>date("Y-m-d H:i:s"),
                                ":CUERPO"=>$cuerpo,
                                ":IDCATEGORIA"=>$categoria,
                                ":ID" =>$id
                            );
    
                            $sentencia->execute($datos);
                        }    

                        if($_SESSION['USUARIO']['tipo']==1){
                            header("Location:adminPublicaciones.php");

                        }else{
                           
                            header("Location:misPublicaciones.php");

                        }

                }

                   
                break;

            case  "eliminar":

               if(isset($_POST['id'])){

                $id = $_POST['id'];
                $mensaje=$id;

                $sentencia = $pdo->prepare("UPDATE `publicacion` SET estatus = 0 WHERE `idPublicacion`=:ID");

                $datos=array(
                    ":ID"=> $id
                );
                $sentencia->execute($datos);

               }
             break;
        }
    }

?>