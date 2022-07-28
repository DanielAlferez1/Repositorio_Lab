<?php
    require '../conexionDB.php';
    $conexion = conectarbase();
    $var = $_GET['var'];
    $valor = $_GET['valor'];
    $tabla = $_GET['tabla'];
    $tabla = str_replace("'","",$tabla);
    if(isset($_GET['cod_etapa'])){
        $etapa = $_GET['cod_etapa'];
        $query = "DELETE FROM $tabla WHERE $var='$valor' AND cod_etapa=$etapa";
    }
    else{
        $query = "DELETE FROM $tabla WHERE $var='$valor'";
    }
    $result = pg_query($conexion,$query);
    if(!$result){
        die("Hubo un error a la hora de eliminar el dato");
    }
    $mensaje = "EL DATO HA SIDO ELIMINADO CORRECTAMENTE.";
    if($tabla != 'corre' && $tabla !='participa'){
        header("Location: ./user.php?mes=$mensaje&tablaxd=$tabla");
    }
    else if($tabla === 'participa'){
        header("Location: ./interrelaciones/participa.php?mes=$mensaje&valor=$valor");
    }
    else{
        header("Location: ./interrelaciones/corre.php?mes=$mensaje&valor=$valor");
    }
    
?>
