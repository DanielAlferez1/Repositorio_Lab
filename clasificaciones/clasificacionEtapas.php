
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
    <div class="fondo2">
    <h1><br>CLASIFICACIÓN POR ETAPAS</h1>

    <?php 
        $cons = "SELECT cod_etapa FROM etapa";
        $resulta = pg_query($conexion,$cons);
    ?>


    <div class="buscador">
        <form action="clasificacionEtapas.php" method="GET" class="formulario">
        <input class="texto-ingreso" type="search" name="valor" placeholder="Buscar ciclista" autocomplete="off">
        <select name="cicl" class="seleccion">
            <option hidden selected>Todos</option>
            <option value="nombre">Nombre</option>
            <option value="apellido">Apellido</option>
        </select>
        <select name="tipo" class="seleccion">
            <option value=1 selected>Etapa 1</option>
            <?php 
                while($filasxd = pg_fetch_array($resulta)){
                    if($filasxd['cod_etapa'] != 1){
                        echo "<option value=".$filasxd['cod_etapa'].">Etapa ".$filasxd['cod_etapa']."</option>";
                    }
                }?>
        </select>
       <input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">
        </form>
    </div>
    </div>

    <?php
        
    ?>
    <?php
        if(isset($_GET['tipo'])){
            $etapa = $_GET['tipo'];
        }
        else{
            $etapa = 1;
        }
        echo "<center><h2>ETAPA ".$etapa."</h2></center>";
        $consult2 = "select tipo from etapa where cod_etapa='$etapa'";

        if(isset($_GET['cicl'])){
            $cicl = $_GET['cicl'];
            if(isset($_GET['valor']) && $cicl!='Todos'){
                $valor = $_GET['valor'];

                if($valor != ''){
                    if($cicl==='nombre'){
                        $consult = "select posicion_ciclista as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista,(tiempo_ciclista-(select tiempo_ciclista from corre where cod_etapa='$etapa' order by tiempo_ciclista limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where etapa.cod_etapa='$etapa' AND UNACCENT(nomb_ciclista) ilike '%$valor%' group by puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista order by puesto";
                    }
                    else if($cicl==='apellido'){
                        $consult = "select posicion_ciclista as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista,(tiempo_ciclista-(select tiempo_ciclista from corre where cod_etapa='$etapa' order by tiempo_ciclista limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where etapa.cod_etapa='$etapa' AND UNACCENT(apellido_ciclista) ilike '%$valor%' group by puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista order by puesto";
                    }
                }
                else{
                    $consult = "select posicion_ciclista as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista,(tiempo_ciclista-(select tiempo_ciclista from corre where cod_etapa='$etapa' order by tiempo_ciclista limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where etapa.cod_etapa='$etapa' group by puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista order by puesto;";
                }
            }
            else{
                $consult = "select posicion_ciclista as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista,(tiempo_ciclista-(select tiempo_ciclista from corre where cod_etapa='$etapa' order by tiempo_ciclista limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where etapa.cod_etapa='$etapa' group by puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista order by puesto;";
            }
        }
        else{
            $consult = "select posicion_ciclista as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista,(tiempo_ciclista-(select tiempo_ciclista from corre where cod_etapa='$etapa' order by tiempo_ciclista limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where etapa.cod_etapa='$etapa' group by puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista order by puesto;";
        }

        
        $result = pg_query($conexion,$consult2);
        $result2 = pg_fetch_object($result,0);
        $tipo = $result2->tipo;
        echo "<center><h3>".$tipo."</h3></center>";

        $resultado = pg_query($conexion,$consult);
        if(pg_num_rows($resultado) === 0){
            echo "<center><h3>No se encontró un resultado, intentalo de nuevo.</h3></center>";
            $consult = "select posicion_ciclista as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista,(tiempo_ciclista-(select tiempo_ciclista from corre where cod_etapa='$etapa' order by tiempo_ciclista limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where etapa.cod_etapa='$etapa' group by puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,tiempo_ciclista order by puesto;";
            $resultado = pg_query($conexion,$consult);
        }

        

        echo "<table align=center>
                    <thead><td id=iz>Puesto</td><td>Nombre</td><td>Apellido</td><td>Equipo</td><td>Tiempo total</td><td id=der>Diferencia</td></thead>";
            while($filas1=pg_fetch_array($resultado)){
                //si el puesto ha sido encontrado, se muestra
                //if($check){
                    //echo "<tr><td>".$puesto[$n]."</td>";
                    //$n++;
                //}//en caso contrario, se muestra la tabla normal
                //else{
                    echo "<tr><td>".$filas1["puesto"]."</td>";
                //}
                echo "<td>".$filas1["nomb_ciclista"]."</td>";
                echo "<td>".$filas1["apellido_ciclista"]."</td>";
                echo "<td>".$filas1["nomb_equipo"]."</td>";
                echo "<td>".$filas1["tiempo_ciclista"]."</td>";
                echo "<td>+".$filas1["diferencia"]."</td>";
            }echo "</table>";

    ?>
    
    <?php require '../footer.php' ?>
    
</body>
    
    
    
    
</html>