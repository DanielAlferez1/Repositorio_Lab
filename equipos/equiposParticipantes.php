<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estiloEquipos.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>
       
        <?php require '../header.php' ?>
        <div class="fondo">
        <h1><br>EQUIPOS PARTICIPANTES</h1>
    
    <div class="buscador">
            <form action="equiposParticipantes.php" method="GET" class="formulario">
            <input class="texto-ingreso" type="search" name="valor" placeholder="Buscar por pais" autocomplete="off">
            <select name="tipo" class="seleccion">
                <option hidden selected>Todos</option>
                <option value="Nombre">Nombre</option>
                <option value="Pais">Pais</option>    
            </select>
            <input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">
            </form>
    </div>
    </div>
    <?php
        if(isset($_GET["valor"]) && $_GET["valor"] != "" && isset($_GET["tipo"])){
            $valor = $_GET["valor"];
            if($_GET["tipo"] == "Nombre"){
                $query="select cod_equipo, nomb_equipo, pais_equipo from equipos inner join pais on equipos.pais_equipo=pais.cod_pais where UNACCENT(nomb_equipo) ilike '%$valor%' or nomb_equipo ilike '%$valor%'";
            }
            if($_GET["tipo"] == "Pais"){
                $query="select cod_equipo, nomb_equipo, pais_equipo from equipos inner join pais on equipos.pais_equipo=pais.cod_pais where UNACCENT(nomb_pais) ilike '%$valor%' or pais_equipo ilike '%$valor%'";
            }
        }else{
            $query="select * from equipos";
        }

        $resultado=pg_query($conexion,$query);

        if(!$resultado or pg_num_rows($resultado)==0){
            echo '<p  id="ingreso">Ingresa una busqueda nuevamente</p>';
            $resultado=pg_query($conexion,"select * from equipos") or die("Error");
        }
        echo "<table align=center>
        <thead><td id=iz>Codigo del equipo</td><td>Nombre del equipo</td><td id=der>País</td></thead>";
    while($filas=pg_fetch_array($resultado)){
    $valor = $filas["cod_equipo"];
    $var = $filas["nomb_equipo"];
    echo "<tr><td>".$filas["cod_equipo"]."</td>";
    echo "<td>".$filas["nomb_equipo"]." <a href='./infoEquipos.php?cod=".$valor."'><img class='libro' src='http://www.webquestcreator2.com/majwq/files/files_user/40279/guia.png'></a></td>";
    echo "<td id=izq>".$filas["pais_equipo"]."</td>";
}echo "</table>";

    ?>


    <?php require '../footer.php' ?>
    
</body>
    
    
</html>