<?php
    require '../conexionDB.php';
    require './columns.php';
    $conexion = conectarbase();
    $error = false;
    $message = "";
    $var = $_GET['var'];
    $valor = $_GET['valor'];
    $tabla = $_GET['tabla'];
    $tabla = str_replace("'","",$tabla);
    if($tabla==='users'){
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            $password = $_GET['password_user'];
            
            if($email != '' && $password != ''){
                $query = "UPDATE $tabla SET  email='".$email."' WHERE $var='$valor'";
                $result = pg_query($conexion,$query);
                if(!$result){
                    die("Hubo un error a la hora de editar el dato");
                }
                $query = "UPDATE $tabla SET  password_user='".$password."' WHERE $var='$valor'";
                $result = pg_query($conexion,$query);
                if(!$result){
                    die("Hubo un error a la hora de editar el dato");
                }
                else{
                    header_remove();
                    $message = "EL(LOS) DATO(S) HA(N) SIDO MODIFICADO CORRECTAMENTE";
                    header("Location: ./user.php?mes=$message&tablaxd=$tabla");
                }
            }
            else{
                if(isset($email) || isset($password)){
                    $message = "Ingrese el nuevo dato correctamente";
                    $error = true;
                }
            }
        }
    }
    else{
        
        if(isset($_GET['check'])){
            $result = columnas($tabla,$conexion);
            $result2 = columnas($tabla,$conexion);
            $result3 = columnas($tabla,$conexion);
            $data = array();
            $dataCopia = array();
            $columns = array();
            $nr = 0;
            $nrc = 0;
           
            
            
            while($filas=pg_fetch_array($result)){
                $data[$nr] = $_GET[$filas['column_name']];
                
                $columns[$nr] = $filas['column_name'];
                
                
                $nr++;
            }
            
            $queryCopia = "SELECT * FROM $tabla WHERE $var=$valor";
            $resultadoCopia = pg_query($conexion,$queryCopia);
            while($filasCopias=pg_fetch_array($resultadoCopia)){
                for($i=0;$i<$nr;$i++){
                    $dataCopia[$i] = $filasCopias[$columns[$i]];
                    //echo $dataCopia[$i];
                }
            }

            if($data[0] === ""){
                $message = "INSERTE UNA LLAVE PRIMARIA VALIDA.";
                $error = true;
            }
            else if($tabla === 'pais' && strlen($data[0]) > 3){
                    $message = "INSERTE UNA LLAVE PRIMARIA VALIDA";   
                    $error = true;
            }
            else{
                $nr = 0;
                $nr2 = 0;
                $consult = "SELECT * FROM $tabla WHERE $columns[0]='$data[0]'";
                $comprobar = pg_query($conexion,$consult);
                if(pg_num_rows($comprobar) > 0 && $valor!=$data[0]){
                    $message = "LA LLAVE PRIMARIA INGRESADA YA EXISTE.";
                    $error = true;
                }
                else{
                    while($filas2=pg_fetch_array($result2)){
                        
                        if($nr===0){
                            $query = "UPDATE $tabla SET  $columns[$nr]='".$data[$nr]."' WHERE $columns[0]='$data[0]'";
                            $llavepri = $data[0];
                        }
                        else if($llavepri != $valor){
                            $query = "UPDATE $tabla SET  $columns[$nr]='".$data[$nr]."' WHERE $columns[0]='$valor'";
                        }
                        else{
                            $query = "UPDATE $tabla SET  $columns[$nr]='".$data[$nr]."' WHERE $columns[0]='$data[0]'";
                        }
                        $stmt = pg_query($conexion,$query);
                        if(!$stmt){
                            while($filas3=pg_fetch_array($result3)){
                                if($nrc>0){
                                    $query = "UPDATE $tabla SET  $columns[$nrc]='".$dataCopia[$nrc]."' WHERE $columns[0]='$data[0]'";
                                    $llavepri = $data[0];
                                }
                                else if($llavepri != $valor){
                                    $query = "UPDATE $tabla SET  $columns[$nrc]='".$dataCopia[$nrc]."' WHERE $columns[0]='$valor'";
                                }
                                else{
                                    $query = "UPDATE $tabla SET  $columns[$nrc]='".$dataCopia[$nrc]."' WHERE $columns[0]='$data[0]'";
                                }
                                $stmt = pg_query($conexion,$query);
                                echo "xd";
                                echo $dataCopia[$nrc];
                                $nrc++;
                            }
                            die("<script>window.location = './error.php';</script>");
                        }
                        $nr++;
                    }
                    $mensaje = "EL(LOS) DATO(S) HA(N) SIDO MODIFICADO CORRECTAMENTE";
                    header("Location: ./user.php?mes=$mensaje&tablaxd=$tabla");
                    //die($stmt);
                }
            }
        }
    }
?>

<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estiloCrud.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>
    <br><br><br><br>
    <center><h2>Editar registro <?php echo $var;?>=<?php echo $valor;?> de la tabla <?php echo $tabla;?></h2></center>
    <?php if($error):?>
        <center><h2><?php echo $message; ?></h2></center>
    <?php endif; ?>


    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="GET" class="dato">
    <input type="hidden" name="tabla" value="<?php echo $tabla;?>" class="tablaE">
    <input type="hidden" name="valor" value="<?php echo $valor;?>" class="valorE">
    <input type="hidden" name="var" value="<?php echo $var;?>" class="varE">

    <?php 
        $result = columnas($tabla,$conexion);
        $resulttext = columnas($tabla,$conexion);
        $resultx = columnas($tabla,$conexion);
        $columnasD = array();
        while($filasA=pg_fetch_array($resultx)){
            $columnasD[] = $filasA['column_name'];
        }
        $consultaData = "SELECT * FROM $tabla WHERE $var='$valor'";
        $consultaUSERS = pg_query($conexion,$consultaData);
        $datosU = pg_fetch_object($consultaUSERS,0);
    ?>
    
    <?php if($tabla === 'users'):?>
        <p class ="toc">EMAIL</p><input type="text" name="email" placeholder="Inserte el nuevo dato" autocomplete="off" value="<?php echo $datosU->email;?>">
        <p class ="toc">CONTRASEÑA</p><input type="text" name="password_user" placeholder="Inserte el nuevo dato" autocomplete="off" value="<?php echo $datosU->password_user;?>">

        <input type="submit" value="Editar" id="editboton">
            
            

    <?php else: ?>
        <?php
            $consultaData = "SELECT * FROM $tabla WHERE $var='$valor'";
            
            $datos = array();
            for($i=0;$i<pg_num_rows($result);$i++){
                $resultadoConsultaData = pg_query($conexion,$consultaData);
                while( $filasT=pg_fetch_array($resultadoConsultaData)){
                    $datos[] = $filasT[$columnasD[$i]];
                }
            }
            $nd = 0;
        ?>
            <?php if(!$resultadoConsultaData):?>
                <?php die("HUBO UN ERROR");?>
            
            <?php else:?>
                <?php while($filasD=pg_fetch_array($resulttext)):?>
                    <p class="toc"><?php echo $filasD['column_name'];?></p>
                    <input type="text" name="<?php echo $filasD['column_name'];?>" placeholder="Inserte el nuevo dato" autocomplete="off" value="<?php echo $datos[$nd];?>">
                    <?php $nd++;?>
                <?php endwhile;?>
            <?php endif;?>
        
        <input type="hidden" name="check" value="enviado">
        
        <input type="submit" value="Editar" id="editboton">
            
        <?php endif;?>

        </form>
        <a href="./user.php?tablaxd=<?php echo $tabla;?>"><div class="regresar"><p>Regresar</p></div></a>
        <br><br>
        

    
</html>
