
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
    <h1><br>CLASIFICACIÓN POR PUNTOS</h1>

    <div class="buscador">
        <form action="puntos.php" method="GET" class="formulario">
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
                $query="select ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(puntos_ciclista) as total from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo group by ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo having sum(puntos_ciclista)!=0 AND UNACCENT(nomb_ciclista) ilike '%$valor%' order by total desc";
            }
            else if($_GET["tipo"] == "Apellido"){
                $query="select ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(puntos_ciclista) as total from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo group by ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,nomb_equipo having sum(puntos_ciclista)!=0 AND UNACCENT(apellido_ciclista) ilike '%$valor%' order by total desc;";
            }
            else{
                $query="select row_number() over (order by sum(puntos_ciclista) desc) as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(puntos_ciclista) as total from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo group by nomb_ciclista,apellido_ciclista,nomb_equipo having sum(puntos_ciclista)!=0 AND nomb_equipo='' order by total desc";
                $check2 = true;
            }
            //realizamos la consulta para obtener los puestos 
                $pos="select row_number() over (order by sum(puntos_ciclista) desc) as puesto,ciclistas.cod_ciclista from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo group by ciclistas.cod_ciclista having sum(puntos_ciclista)!=0";
            //ejecutamos la consulta de los puestos
            //se declara que la consulta con la busqueda ha sido realizada
            if($check2){
                $check2 = false;
            }
            else{
                $check2 = true;
            }
            
        }else{
            //en caso de no exister una busqueda, realizamos la consulta con todos los equipos y sus puestos
            $query="select row_number() over (order by sum(puntos_ciclista) desc) as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(puntos_ciclista) as total from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo group by nomb_ciclista,apellido_ciclista,nomb_equipo having sum(puntos_ciclista)!=0 order by total desc";
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
                    if($filas['cod_ciclista'] === $result['cod_ciclista']){
                        //una vez ha sido encontrada, se guarda el puesto y se declara que el puesto ha sido encontrado
                        $check = true;
                        $puesto[] = $filas['puesto'];
                        break 1;
                    }
                }
            }

        }
        

        if(!$resultado or pg_num_rows($resultado)==0){
            echo '<p  id="ingreso">Ingresa una busqueda nuevamente</p>';
            $resultado=pg_query($conexion,"select row_number() over (order by sum(puntos_ciclista) desc) as puesto,nomb_ciclista,apellido_ciclista,nomb_equipo,sum(puntos_ciclista) as total from corre inner join ciclistas on corre.cod_ciclista=ciclistas.cod_ciclista inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo group by nomb_ciclista,apellido_ciclista,nomb_equipo having sum(puntos_ciclista)!=0 order by total desc") or die("Error");
        }

        $n = 0;

        echo "<table align=center>
                    <thead><td id=iz>Puesto</td><td>Nombre</td><td>Apellido</td><td>Equipo</td><td id=der>Puntos</td></thead>";
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
            }echo "</table>";

    ?>
    
    <?php require '../footer.php' ?>
    
</body>
    
    
    
    
</html>