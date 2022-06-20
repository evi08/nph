<?php
require "../conexion.php";
session_start();

function function_alert($message) {
echo "<script>alert('$message');</script>";
}

function validar_clave($clave,&$error_clave){
    if(strlen($clave) < 6){
       $error_clave = "La clave debe tener al menos 6 caracteres";
       return false;
    }
    if(strlen($clave) > 16){
       $error_clave = "La clave no puede tener más de 16 caracteres";
       return false;
    }
    if (!preg_match('`[a-z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra minúscula";
       return false;
    }
    if (!preg_match('`[A-Z]`',$clave)){
       $error_clave = "La clave debe tener al menos una letra mayúscula";
       return false;
    }
    if (!preg_match('`[0-9]`',$clave)){
       $error_clave = "La clave debe tener al menos un caracter numérico";
       return false;
    }
    if (preg_match('" "',$clave)){
        $error_clave = "No se permiten espacios";
        return false;
     }
    $error_clave = "";
    return true;
 }

$idempleado=$_SESSION['pasar_numempleado'];
$nombre_completo=$_SESSION['pasar_nombre'];
$correo_usuario = $_SESSION['pasar_correo'];
$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+6 month' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );



if(isset($_POST['crear_cuenta']) && !empty($_POST['clave_empleado1']) && !empty($_POST['clave_empleado2'])){

  $clave1 = $_POST['clave_empleado1'];
  $clave2 = $_POST['clave_empleado2'];
  $error_encontrado="";

        if($clave1!=$clave2){
            function_alert("Las contraseñas no coiciden ó el empleado no existe");
            
        }else{
            if (validar_clave($clave1, $error_encontrado)){

                $sql = "SELECT *FROM tbl_usuarios_login
                WHERE cod_empleado='$idempleado'";
                //echo $sql;
                $resultado = $mysqli->query($sql);
                $num = $resultado->num_rows;

                    if($num>0){
                        $row = $resultado->fetch_assoc();
                        session_destroy();
                        function_alert("Este usuario ya está registrado");
                        header("Location: ../index.php");
                       

                    } else {

                        $sql = "INSERT INTO tbl_usuarios_login (id_rol_usuario, estado_usuario, nombre_usuario_correo, clave_usuario, cod_empleado, fecha_ultima_conexion,num_preguntas_contestadas,numero_ingresos, fecha_caducidad,creado_por,fecha_creacion,modificado_por,fecha_modificacion)
                                                         VALUES(1, 'activo',UPPER('$correo_usuario'), SHA1('$clave1'),'$idempleado', NOW(),0,0,'$nuevafecha', 1,now(),1,now())";

                        $resultado = $mysqli->query($sql);
                        function_alert("datos registrados correctamente");
                        header("Location: ../index.php");
                    }
                }else{
                    echo "Su contraseña no es valida: " . $error_encontrado;
            }
        }
    }else {
      function_alert("Por favor llene todos los campos");
}
 ?>




<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Registrarse-NPH</title>
        <link href="css/styles.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.slim.min.js" integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI=" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-7">
                                <div class="card shadow-lg border-2 rounded-lg mt-5" style="margin:20px">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Registro de su contraseña</h3></div>
                                    <div class="card-body">
                                        
                                        <form class="" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                                                <div class="form-row " style="margin:20px 20px 10px 20px">
                                                    <div class="col-md-7">
                                                            <div class="form-group" ><label class="small mb-1" for="inputEmailAddress" >Su nombre completo</label><input class="form-control py-4" id="inputEmailAddress" type="text" aria-describedby="emailHelp" value="<?php echo $nombre_completo; ?>" placeholder="Su nombre" disabled="disabled" /></div>
                                                        </div>     
                                                    
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputPassword"><b>Ingrese una contraseña</b> </label><input class="form-control py-4" id="registroclave1" type="txt" name="clave_empleado1" placeholder="Ingrese su contraseña" /></div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group"><label class="small mb-1" for="inputConfirmPassword"><b>Confirme su contraseña</b></label><input class="form-control py-4" id="registroclave2" type="txt" name="clave_empleado2" placeholder="Confirme su contraseña" /></div>
                                                        </div>

                                                  </div>
                                                  <p><b>Su contraseña debe contener:</b>  <br><small>
                                                            °Al menos 6 caracteres y como máximo 16 caracteres. <br>
                                                            °Al menos una letra mayúscula y una letra mayúscula.. <br>
                                                            °Al menos una número. <br>
                                                            °No se permiten espacios.</p></small>
                                              <div class="form-row " style="margin:20px 20px 10px 20px">
                                                  <div class="col-md-7">
                                                      <div ><button  class= "btn btn-primary" type="submit" name="crear_cuenta" >Crear cuenta</button></div>
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
