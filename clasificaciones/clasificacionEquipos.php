

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
    <h1><br>CLASIFICACIÓN POR EQUIPOS</h1>
    <div class="buscador">
        <form action="clasificacionEquipos.php" method="GET" class="formulario">
        <input class="texto-ingreso" type="search" name="valor" placeholder="Buscar equipo" autocomplete="off">
        <input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">
        </form>
    </div>
    </div>
    <?php
        //declaramos los chequeos como falso
        $check2=false;
        $check=false;
        //verificamos si existe alguna busqueda
        if(isset($_GET["valor"]) && $_GET["valor"] != ""){
            $valor = $_GET["valor"];
            //realizamos la consulta con el valor ingresado
                $query="select nomb_equipo, avg(tiempo_ciclista) as tiempo from corre as co, ciclistas as ci, contrato as con, equipos as e where co.cod_ciclista=ci.cod_ciclista and ci.cod_ciclista=con.cod_ciclista and con.cod_equipo=e.cod_equipo and UNACCENT(nomb_equipo) ilike '%$valor%' and e.cod_equipo in (select participa.cod_equipo from participa group by cod_equipo having count(*)=21) and ci.cod_ciclista in (select cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_equipo order by tiempo";
            //realizamos la consulta para obtener los puestos 
                $pos="select row_number() over (order by avg(tiempo_ciclista)) as puesto, nomb_equipo as nombre from corre as co, ciclistas as ci, contrato as con, equipos as e where co.cod_ciclista=ci.cod_ciclista and ci.cod_ciclista=con.cod_ciclista and con.cod_equipo=e.cod_equipo and e.cod_equipo in (select participa.cod_equipo from participa group by cod_equipo having count(*)=21) and ci.cod_ciclista in (select cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_equipo";
            //ejecutamos la consulta de los puestos
            //se declara que la consulta con la busqueda ha sido realizada
                $check2 = true;
            
        }else{
            //en caso de no exister una busqueda, realizamos la consulta con todos los equipos y sus puestos
            $query="select row_number() over (order by avg(tiempo_ciclista)) as puesto, nomb_equipo, avg(tiempo_ciclista) as tiempo from corre as co, ciclistas as ci, contrato as con, equipos as e where co.cod_ciclista=ci.cod_ciclista and ci.cod_ciclista=con.cod_ciclista and con.cod_equipo=e.cod_equipo and e.cod_equipo in (select participa.cod_equipo from participa group by cod_equipo having count(*)=21) and ci.cod_ciclista in (select cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_equipo  order by tiempo";
            $check = false;
            $check2 = false;
        }
        //ejecutamos la consulta general
        $resultado=pg_query($conexion,$query);
        $resultado3=pg_query($conexion,$query);
        //verificamos si la consulta con la busqueda ha tenido resultados
        //en caso contrario, se declara que la consulta con la busqueda no fue realizada correctamente
        if(pg_num_rows($resultado) === 0 && $check2 === true){
            $check2 = false;
        }
        $puesto = array();
        //se verifica si la consulta con la busqueda ha sido realizada correctamente
        if($check2){
            //se extrae el nombre del equipo buscado
            while($result=pg_fetch_array($resultado3)){
                $resultado4=pg_query($conexion,$pos);
                while($filas=pg_fetch_array($resultado4)){
                    //se busca el nombre del equipo buscado en la consulta de los puestos
                    if($filas['nombre'] === $result['nomb_equipo']){
                        //una vez ha sido encontrada, se guarda el puesto y se declara que el puesto ha sido encontrado
                        $check = true;
                        $puesto[] = $filas['puesto'];
                        break;
                    }
                }
            }

        }
        

        if(!$resultado or pg_num_rows($resultado)==0){
            echo '<p  id="ingreso">Ingresa una busqueda nuevamente</p>';
            $resultado=pg_query($conexion,"select row_number() over (order by avg(tiempo_ciclista)) as puesto, nomb_equipo, avg(tiempo_ciclista) as tiempo from corre as co, ciclistas as ci, contrato as con, equipos as e where co.cod_ciclista=ci.cod_ciclista and ci.cod_ciclista=con.cod_ciclista and con.cod_equipo=e.cod_equipo and e.cod_equipo in (select participa.cod_equipo from participa group by cod_equipo having count(*)=21) and ci.cod_ciclista in (select cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_equipo  order by tiempo;") or die("Error");
        }


        $n=0;
        echo "<table align=center>
                    <thead><td id=iz>Puesto</td><td>Equipo</td><td id=der>Tiempo total</td></thead>";
            while($filas1=pg_fetch_array($resultado)){
                //si el puesto ha sido encontrado, se muestra
                if($check){
                    echo "<tr><td>".$puesto[$n]."</td>";
                    $n++;
                }//en caso contrario, se muestra la tabla normal
                else{
                    echo "<tr><td>".$filas1["puesto"]."</td>";
                }
                echo "<td>".$filas1["nomb_equipo"]."</td>";
                echo "<td>".$filas1["tiempo"]."</td></tr>";
            }echo "</table>";

    ?>
    
    <?php require '../footer.php' ?>
    
</body>
    
    
    
    
</html>