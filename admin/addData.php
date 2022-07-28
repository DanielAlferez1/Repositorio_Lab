<?php require '../conexionDB.php';
    require './columns.php';
    $conexion = conectarbase();
    if(isset($_POST['tabla'])){
        $tabla = $_POST['tabla'];
        if($_POST['tabla'] === 'users' ){
            $email = $_POST['email'];
            $password = $_POST['password'];
            $query = "INSERT INTO users(email,password_user,fecha_registro) VALUES('$email','$password',current_date)";
            $stmt = pg_query($conexion,$query);
            if(!$stmt){
                die("Hubo un error al registrar la información");
            }
            $mensaje = "EL DATO HA SIDO INGRESADO CORRECTAMENTE.";
            

        }
        else{
            
            $result = columnas($tabla,$conexion);
            $result2 = columnas($tabla,$conexion);
            $data = array();
            $columns = array();
            $nr = 0;
            while($filas=pg_fetch_array($result)){
                $data[$nr] = $_POST[$filas['column_name']];
                $columns[$nr] = $filas['column_name'];
                $nr++;
            }
            
            
            if($data[0] === ""){
                $mensaje = "INSERTE UNA LLAVE PRIMARIA VALIDA.";
                
            }
            else if($tabla ==='pais' && strlen($data[0]) > 3){
                $mensaje = "INSERTE UNA LLAVE PRIMARIA VALIDA.";
            }
            else{
                $consult = "SELECT * FROM $tabla WHERE $columns[0]='$data[0]'";
                $comprobar = pg_query($conexion,$consult);
                if(pg_num_rows($comprobar) > 0){
                    $mensaje = "LA LLAVE PRIMARIA INGRESADA YA EXISTE.";
                    
                }
                else{
                    $nr = 0;
                    $query = "INSERT INTO $tabla($columns[0]) VALUES('$data[0]')";
                    $stmt = pg_query($conexion,$query);
                    if(!$stmt){
                        die("<script>window.location = './error.php';</script>");
                    }
                    else{
                
                        while($filas2=pg_fetch_array($result2)){
                            if($filas2['column_name'] != $columns[0]){
                                $query = "UPDATE $tabla SET  $columns[$nr]='".$data[$nr]."' WHERE $columns[0]='$data[0]'";
                                $stmt = pg_query($conexion,$query);
                                if(!$stmt){
                                    $query = "DELETE FROM $tabla WHERE $columns[0]='$data[0]'";
                                    $stmt = pg_query($conexion,$query);
                                    die("<script>window.location = './error.php';</script>");
                                }
                            }
                            $nr++;
                        }
                        $mensaje = "EL DATO HA SIDO INGRESADO CORRECTAMENTE.";
                    }
                }

                
            }
        }
    }
    
    header("Location: ./user.php?mes=$mensaje&tablaxd=$tabla");
    
    
?>
