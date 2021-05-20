<?php include('../conexionDB.php');
?>


<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="../equipos/estiloEquipos.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>
    <?php require '../header.php' ?>
    
    <h1><br>CLASIFICACIÓN POR PUNTOS</h1>

    <?php
        $conexion = conectarbase();
        $query="select row_number() over (order by sum(puntos_ciclista) desc) as puesto,nomb_ciclista,apellido_ciclista,sum(puntos_ciclista) as total_puntos from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista group by nomb_ciclista,apellido_ciclista having sum(puntos_ciclista)!=0 order by total_puntos desc";
        $resultado=pg_query($conexion,$query) or die ("Error en consultar la base de datos");
        $nr=pg_num_rows($resultado);
        if($nr>0){
            echo "<table align=center>
                      <thead><td id=iz>Puesto</td><td>Nombre</td><td>Apellido</td><td id=der>Total puntos</td></thead>";
            while($filas=pg_fetch_array($resultado)){
                echo "<tr><td>".$filas["puesto"]."</td>";
                echo "<td>".$filas["nomb_ciclista"]."</td>";
                echo "<td>".$filas["apellido_ciclista"]."</td>";
                echo "<td>".$filas["total_puntos"]."</td>";
            }echo "</table>";
        }else{
            echo "No hay datos ingresados";
        }

    ?>
    
    <?php require '../footer.php' ?>
    
</body>
    
    
    
    
</html>