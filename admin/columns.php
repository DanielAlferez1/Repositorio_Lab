<?php 
    
    function columnas($tabla,$conexion){
        $consulta = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME='$tabla'";
        $result = pg_query($conexion,$consulta);
        if(!$result){
            die("Hubo un error en la consulta nombre_columna");
        }
        else{
            return $result;
        }
    }
?>