<?php

require "../conexion.php";
session_start();

$nombre_empleado = "";
$numero_empleado = "";
$correo_empleado="";

function function_alert($message) {
echo "<script>alert('$message');</script>";
}

if(isset($_POST['continuar']) && !empty($_POST['correo_empleado']) && !empty($_POST['num_empleado'])){

  $numero_empleado = $_POST['num_empleado'];
  $correo_empleado = $_POST['correo_empleado'];

  $sql = "SELECT primer_nombre,segundo_nombre,primer_apellido,segundo_apellido FROM tbl_empleados
  WHERE cod_empleado='$numero_empleado' and correo_personal='$correo_empleado'";
  //echo $sql;
  $resultado = $mysqli->query($sql);
  $num = $resultado->num_rows;

      if($num>0){
        $row = $resultado->fetch_assoc();
          $nombre_empleado = $row['primer_nombre']." ".$row['segundo_nombre']." ".$row['primer_apellido']." ".$row['segundo_apellido'];
          header("Location: register.php");
        } else {
            function_alert("Los datos ingresados no coiciden, ingrese nuevamente");
        
        }
    }else {
      function_alert("Por favor llene todos los campos");
      
}
$_SESSION['pasar_nombre']=$nombre_empleado;
$_SESSION['pasar_numempleado']=$numero_empleado;
$_SESSION['pasar_correo']=$correo_empleado;
 ?>


<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Identificarse</title>

        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
      <a href="register.php">ir a Registro</a>
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-2 rounded-lg mt-5" style="margin:20px">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Identificación de empleados</h3></div>
                                    <div class="card-body">
                                        <form class="" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <div class="form-row" style="margin:20px" >
                                                  <div class="col-md-6">
                                                      <div class="form-group"><label class="small mb-1" for="num_empleadoid"><b>Su úmero de empleado</b> </label><input class="form-control py-4" id="num_empleadoid" type="number" placeholder="Número de empleado" value="" name="num_empleado" required /></div>
                                                  </div>

                                                  <div class="col-md-6">
                                                      <div class="form-group"><label class="small mb-1" for="nomb_empleadoid"><b>Su correo correctamente</b> </label><input class="form-control py-4" id="nomb_empleadoid" type="email" placeholder="Su correo registrado" value="" name="correo_empleado" required/></div>
                                                  </div>


                                                </div>

                                              <div class="form-row " style="margin:20px 20px 10px 20px">
                                                  <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0"><button class="btn btn-primary" type="submit" name="continuar">Continuar con el registro de su cuenta en nph...</button></div>
                                              </div>
                                                  <div class="col-md-7">
                                                      <div class="small" ><a href="../index.php">Ya tienes cuenta en NPH?</a></div>
                                                  </div>
                                              </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Vilches 2022</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
