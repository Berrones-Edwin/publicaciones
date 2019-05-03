<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Proyecto</title>
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/styles.css">
    <meta name="description" content="Bienvenidos al administrador de publicaciones">

    <meta name="theme-color" content="#F0DB4F">
    <meta name="MobileOptimized" content="width">
    <meta name="HandheldFriendly" content="true">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="shortcut icon" type="image/png" href="./img/icon.png">
    <link rel="apple-touch-icon" href="./img/icon.png">
    <link rel="apple-touch-startup-image" href="./img/icon.png">
    <link rel="manifest" href="./manifest.json">
</head>

<body>
    <?php if(isset($_SESSION['USUARIO'])){ ?>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark mb-5">
    <!-- Brand -->
    <a class="navbar-brand" href="#">Bienvenido <?php echo $_SESSION['USUARIO']['nombre']; ?></a>

    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar links -->
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item">
                <?php if($_SESSION['USUARIO']['tipo']==1){?>
                    <a class="nav-link" href="admin.php">Agregar Publicación</a>
                <?php }else{ ?>
                    <a class="nav-link" href="perfil.php">Agregar Publicación</a>
                <?php } ?>
            </li>
            <li class="nav-item">
                <?php if($_SESSION['USUARIO']['tipo']==1){?>
                    <a class="nav-link" href="misPublicacionesAdmin.php">Mis Publicaciones</a>
                <?php }else{?>
                    <a class="nav-link" href="misPublicaciones.php">Mis Publicaciones</a>
                <?php } ?>
            </li>
            <?php if($_SESSION['USUARIO']['tipo']==1){?>
            <li class="nav-item">
                    <a class="nav-link" href="adminPublicaciones.php">Todas las Publicaciones</a>
                </li>
            <?php } ?>
            <li class="nav-item">
                <form  method="post" >
                    <button style="
                background-color: transparent;
                border: none;color:#FFF;  padding-top:6px;"  
                        value="cerrarSesion" 
                        name="btnAccion" >Cerrar Sesion </button>
                </form>
            </li>
        </ul>
    </div> 
    </nav>
    <?php }?>
    <div class="container mt-5">