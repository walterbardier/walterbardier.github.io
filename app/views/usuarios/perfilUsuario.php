<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- <meta name="author" content="Devcrud"> -->
    <title>Perfil | Río Negro Conectado</title>
    
    <!-- font icons -->
    <link rel="stylesheet" href="assets/vendors/themify-icons/css/themify-icons.css">
    <!-- Bootstrap + LeadMark main styles -->
	<link rel="stylesheet" href="assets/css/leadmark.css?v=<?php echo(rand()); ?>">
    
    <link rel="stylesheet" href="assets/css/leadmark.css?v=<?php echo(rand()); ?>" />
    <!-- <script src="/js/mi_script.js?v=<?php echo(rand()); ?>"></script> -->
     


</head>
<body data-spy="scroll" data-target=".navbar" data-offset="40" id="home">

    <!-- page Navigation -->
    <nav class="navbar custom-navbar navbar-expand-md navbar-light fixed-top" data-spy="affix" data-offset-top="10">
        <div class="container">
            <a class="navbar-brand" href="startPage.php">
                <img src="assets/imgs/logoaqua3.png" alt="">
            </a>
            <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                &#160 <!-- esto es para dejar espacio -->
                &#160 <!-- esto es para dejar espacio -->

                <li class="nav-item">
                    <a href="./startPage.php">
                        <button class="btn btn-primary rounded" type="button">
                            Volver atrás
                        </button>
                    </a>
                </li>
            </ul>

            </div>
        </div>
    </nav>
    <!-- End Of Second Navigation -->
    
    <!-- Page Header -->
    <header class="header">
        <ea class="overlay">
        <br><br><br><br><br>

        <div class="container">
            <div class="row justify-content-between">

                <!-- Sección izquierda con listado de preguntas -->
                <div class="col-md-6 pr-md-5 mb-4 mb-md-0">
                    <?php
                    require_once('../../models/conexionModel.php'); // Asegúrate de que la ruta sea la correcta

                    // Obtener la instancia de la conexión
                    $db = ConexionModel::getInstance()->getDatabaseInstance();

                    // Obtener el nombre de usuario de la sesión
                    $nombre_usuario = $_SESSION['usuario']['username'];

                    // Realizar la consulta para obtener los datos del usuario
                    $sql = "SELECT * FROM usuarios WHERE nombre_usuario = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->execute([$nombre_usuario]);
                    $usuario = $stmt->fetch();
                    ?>

                    <h2>Perfil de Usuario</h2>
                    <form action="../../controllers/actualizarPerfil.php" method="post">
                        <div class="form-group">
                            <label for="nombre_usuario">Nombre de Usuario</label>
                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" value="<?php echo $usuario['nombre_usuario']; ?>" readonly>
                        </div>

                        <div class="form-group">
                            <label for="correo_electronico">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?php echo $usuario['correo_electronico']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="nombre_completo">Nombre Completo</label>
                            <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" value="<?php echo $usuario['nombre_completo']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" value="<?php echo $usuario['fecha_nacimiento']; ?>">
                        </div>

                        <div class="form-group">
                            <label for="numero_telefono">Número de Teléfono</label>
                            <input type="text" class="form-control" id="numero_telefono" name="numero_telefono" value="<?php echo $usuario['numero_telefono']; ?>">
                        </div>

                        <button type="submit" class="btn btn-primary rounded">Guardar cambios</button>
                    </form>
                </div>


                <div class="col-md-6 pl-md-5">
                    <div class="row">
                        <div class="col-6">
                            <img src="assets/imgs/about-1.jpg" alt="" class="w-100 shadow-sm">
                        </div>
                        <div class="col-6">
                            <img src="assets/imgs/about-2.jpg" alt="" class="w-100 shadow-sm">
                        </div>
                    
                    </div>
                </div>
            </div>              
        </div>
    </header>

    <!-- Modal de éxito -->
    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="successModalLabel">Actualización Exitosa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            ¡Los datos han sido actualizados correctamente!
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
        </div>
        </div>
    </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    <script>
    $(document).ready(function() {
        // Intercepta el envío del formulario
        $('form').submit(function(e) {
            e.preventDefault(); // Prevenir el comportamiento por defecto del formulario

            var formData = $(this).serialize(); // Serializar los datos del formulario

            $.ajax({
                url: '../../controllers/actualizarPerfil.php', // Ruta del archivo PHP que procesa el formulario
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Si la respuesta es exitosa, mostrar el modal
                        $('#successModal').modal('show');
                    } else {
                        // Si hay un error, puedes mostrar una alerta (o manejarlo como desees)
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Hubo un error al procesar el formulario.');
                }
            });
        });
    });
    </script>



</body>
