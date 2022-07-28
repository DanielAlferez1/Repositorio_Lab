

<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estiloRecorrido.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>

    <?php require '../header.php' ?>   

    <img id="fondo" src="https://wallpapercave.com/wp/wp2030957.jpg">

    <h1><br>GANADORES POR ETAPA</h1>

    <center><img id="reco" src="https://e00-marca.uecdn.es/assets/multimedia/imagenes/2020/11/01/16042614796672.jpg"></center>
    
    
    <?php

        //CREATE VIEW vganadores_etapa AS select etapa.cod_etapa,fecha_etapa,tipo,nomb_ciclista,apellido_ciclista,tiempo_ciclista from ciclistas inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where posicion_ciclista=1 order by etapa.cod_etapa;

        //VIEW vganadores_etapa: select etapa.cod_etapa,fecha_etapa,tipo,nomb_ciclista,apellido_ciclista,tiempo_ciclista from ciclistas inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where posicion_ciclista=1 order by etapa.cod_etapa;

        $query="SELECT * FROM vganadores_etapa;";
        $resultado=pg_query($conexion,$query) or die ("Error en consultar base");
        $nr=pg_num_rows($resultado);
        if($nr>0){
            echo "<table align=center>
                    <thead><td id=iz>Código</td><td>Fecha</td><td>Tipo</td><td>Nombre</td><td>Apellido</td><td id=der>Tiempo</td></thead>";
            while($filas=pg_fetch_array($resultado)){
                echo "<tr><td>".$filas["cod_etapa"]."</td>";
                echo "<td>".$filas["fecha_etapa"]."</td>";
                echo "<td>".$filas["tipo"]."</td>";
                echo "<td>".$filas["nomb_ciclista"]."</td>";
                echo "<td>".$filas["apellido_ciclista"]."</td>";
                echo "<td id=der>".$filas["tiempo_ciclista"]."</td>";
            }echo "</table>";
        }else{
            echo "No hay datos ingresados";
        }

    ?>


    <?php require '../footer.php' ?>  
    
</body>
    
    
    
    
</html>