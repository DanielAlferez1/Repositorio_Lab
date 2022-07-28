
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

    <h1><br>RECORRIDO 2021</h1>

    <center><img id="reco" src="https://e00-marca.uecdn.es/assets/multimedia/imagenes/2020/11/01/16042614796672.jpg"></center>
    
    
    <?php
        
    echo "<center><h2>Tabla etapas</h2></center><table align=center>
    <thead><td id=iz>Codigo</td><td>Distancia (km)</td><td>Fecha</td><td>Ciudad origen</td><td>Ciudad destino</td>
    <td id=der><form action='recorrido.php' method='GET' class='filtro'>
    <select name='tipo' class='seleccion'>
    <option hidden selected value='Tipo'>Tipo</option>
    <option value='Todos'>Todos</option>
    <option value='Montaña'>Montaña</option>
    <option value='Media Montaña'>Media Montaña</option>
    <option value='Llana'>Llana</option>
    <option value='Contrarreloj'>Contrarreloj</option> 
    </select>
    <input class='img-buscador' type='image' src='https://cdn.pixabay.com/photo/2012/04/11/00/06/filter-27229__340.png'>
    </form></td>
    </thead>";

        if(isset($_GET["tipo"])){
            $tipo = $_GET["tipo"];
            if($tipo == "Todos" or $tipo == "Tipo"){
                $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad";
            }
            if($tipo == "Montaña"){
                $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad where tipo='MONTAÑA'";
            }
            if($tipo == "Media Montaña"){
                $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad where tipo='MEDIA MONTAÑA'";
            }
            if($tipo == "Llana"){
                $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad where tipo='LLANA'";
            }
            if($tipo == "Contrarreloj"){
                $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad where tipo='CONTRARRELOJ INDIVIDUAL'";
            }
        }else{
            $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad order by cod_etapa";
        }

        $resultado=pg_query($conexion,$query) or die ("Error en consultar base");

        while($filas=pg_fetch_array($resultado)){
            echo "<tr><td>".$filas["cod_etapa"]."</td>";
            echo "<td>".$filas["distancia"]."</td>";
            echo "<td>".$filas["fecha_etapa"]."</td>";
            echo "<td>".$filas["origen"]."</td>";
            echo "<td>".$filas["destino"]."</td>";
            echo "<td id=der>".$filas["tipo"]."</td>";
        }echo "</table>";
        
    ?>


    <?php require '../footer.php' ?>  
    
</body>
    
    
    
    
</html>