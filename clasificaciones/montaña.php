
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
    <h1><br>CLASIFICACIÓN POR MONTAÑA</h1>

    <div class="buscador">
        <form action="montaña.php" method="GET" class="formulario">
        <input class="texto-ingreso" type="search" name="valor" placeholder="Buscar ciclista" autocomplete="off">
        <select name="tipo" class="seleccion">
            <option hidden selected>Todos</option>
            <option value="Nombre">Nombre</option>
            <option value="Apellido">Apellido</option>
        </select>
       <input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">
        </form>
    </div>
    </div>

    <?php
        //declaramos los chequeos como falso
        $check2=false;
        $check=false;
        //verificamos si existe alguna busqueda
        if(isset($_GET["valor"]) && $_GET["valor"] != "" && isset($_GET["tipo"])){
            $valor = $_GET["valor"];
            //realizamos la consulta con el valor ingresadl
            if($_GET["tipo"] == "Nombre"){
                $query="select ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(tiempo_ciclista) as total,(sum(tiempo_ciclista)-(select sum(tiempo_ciclista) as total from corre inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' group by cod_ciclista order by total limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where UNACCENT(nomb_ciclista) ilike '%$valor%' AND tipo='MONTAÑA' and ciclistas.cod_ciclista in (select corre.cod_ciclista from corre group by cod_ciclista having count(*)=21) group by ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo order by total";
            }
            else if($_GET["tipo"] == "Apellido"){
                $query="select ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(tiempo_ciclista) as total,(sum(tiempo_ciclista)-(select sum(tiempo_ciclista) as total from corre inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' group by cod_ciclista order by total limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where UNACCENT(apellido_ciclista) ilike '%$valor%' AND tipo='MONTAÑA' and ciclistas.cod_ciclista in (select corre.cod_ciclista from corre group by cod_ciclista having count(*)=21) group by ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo order by total";
            }
            else{
                $query="select row_number() over (order by sum(tiempo_ciclista)) as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(tiempo_ciclista) as total,(sum(tiempo_ciclista)-(select sum(tiempo_ciclista) as total from corre inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' group by cod_ciclista order by total limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' and ciclistas.cod_ciclista in (select corre.cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_ciclista,apellido_ciclista,nomb_equipo order by total";
                $check2 = true;
            }
            //realizamos la consulta para obtener los puestos 
                $pos="select row_number() over (order by sum(tiempo_ciclista)) as puesto,ciclistas.cod_ciclista from ciclistas inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' and ciclistas.cod_ciclista in (select corre.cod_ciclista from corre group by cod_ciclista having count(*)=21) group by ciclistas.cod_ciclista";
            //ejecutamos la consulta de los puestos
                $resultado2=pg_query($conexion,$pos) or die("Error");
            //se declara que la consulta con la busqueda ha sido realizada
            if($check2){
                $check2 = false;
            }
            else{
                $check2 = true;
            }
            
        }else{
            //en caso de no exister una busqueda, realizamos la consulta con todos los equipos y sus puestos
            $query="select row_number() over (order by sum(tiempo_ciclista)) as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(tiempo_ciclista) as total,(sum(tiempo_ciclista)-(select sum(tiempo_ciclista) as total from corre inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' group by cod_ciclista order by total limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' and ciclistas.cod_ciclista in (select corre.cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_ciclista,apellido_ciclista,nomb_equipo order by total";
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
                while($filas=pg_fetch_array($resultado2)){
                    //se busca el nombre del equipo buscado en la consulta de los puestos
                    if($filas['cod_ciclista'] === $result['cod_ciclista']){
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
            $resultado=pg_query($conexion,"select row_number() over (order by sum(tiempo_ciclista)) as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(tiempo_ciclista) as total,(sum(tiempo_ciclista)-(select sum(tiempo_ciclista) as total from corre inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' group by cod_ciclista order by total limit 1)) as diferencia from equipos inner join contrato on equipos.cod_equipo=contrato.cod_equipo inner join ciclistas on contrato.cod_ciclista=ciclistas.cod_ciclista inner join corre on ciclistas.cod_ciclista=corre.cod_ciclista inner join etapa on corre.cod_etapa=etapa.cod_etapa where tipo='MONTAÑA' and ciclistas.cod_ciclista in (select corre.cod_ciclista from corre group by cod_ciclista having count(*)=21) group by nomb_ciclista,apellido_ciclista,nomb_equipo order by total") or die("Error");
        }

        $n = 0;
        echo "<table align=center>
                    <thead><td id=iz>Puesto</td><td>Nombre</td><td>Apellido</td><td>Equipo</td><td>Tiempo total</td><td id=der>Diferencia</td></thead>";
            while($filas1=pg_fetch_array($resultado)){
                //si el puesto ha sido encontrado, se muestra
                if($check){
                    echo "<tr><td>".$puesto[$n]."</td>";
                    $n++;
                }//en caso contrario, se muestra la tabla normal
                else{
                    echo "<tr><td>".$filas1["puesto"]."</td>";
                }
                echo "<td>".$filas1["nomb_ciclista"]."</td>";
                echo "<td>".$filas1["apellido_ciclista"]."</td>";
                echo "<td>".$filas1["nomb_equipo"]."</td>";
                echo "<td>".$filas1["total"]."</td>";
                echo "<td>+".$filas1["diferencia"]."</td>";
            }echo "</table>";

    ?>
    
    <?php require '../footer.php' ?>
    
</body>
    
    
    
    
</html>