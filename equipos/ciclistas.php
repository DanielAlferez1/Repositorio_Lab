
<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estiloEquipos.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>
    
<img id="fondo"src="https://wallpapercave.com/wp/wp2030957.jpg">

<?php require '../header.php' ?>
    
    <h1><br>CICLISTAS PARTICIPANTES</h1>

    <div class="buscador">
        <form action="ciclistas.php" method="GET" class="formulario">
        <input class="texto-ingreso" type="search" name="valor" placeholder="Realizar una busqueda" autocomplete="off">
        <select name="tipo" class="seleccion">
            <option hidden selected>Todos</option>
            <option value="Codigo">Codigo</option>
            <option value="Nombre">Nombre</option>
            <option value="Apellido">Apellido</option>
            <option value="Edad">Edad</option>
            <option value="Nacionalidad">Nacionalidad</option>    
        </select>
       <input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">
        </form>
    </div>


    <?php
        
        if(isset($_GET["valor"]) && $_GET["valor"] != "" && isset($_GET["tipo"])){
            $valor = $_GET["valor"];
            if($_GET["tipo"] == "Codigo"){
                $query="select * from ciclistas where cod_ciclista=$valor";
            }
            if($_GET["tipo"] == "Nombre"){
                $query="select * from ciclistas where nomb_ciclista ilike '%$valor%'";
            }
            if($_GET["tipo"] == "Apellido"){
                $query="select * from ciclistas where apellido_ciclista ilike '%$valor%'";
            }
            if($_GET["tipo"] == "Edad"){
                $query="select * from ciclistas where date_part('year',age(current_date,fech_nac))=$valor";
            }
            if($_GET["tipo"] == "Nacionalidad"){
                $query="select cod_ciclista, nomb_ciclista, apellido_ciclista, fech_nac, pais_ciclista from ciclistas inner join pais on ciclistas.pais_ciclista=pais.cod_pais where unaccent(nomb_pais) ilike '%$valor%' or pais_ciclista ilike '%$valor%' or nomb_pais ilike '%$valor%'";
            }
        }else{
            $query="select * from ciclistas";
        }

        $resultado=pg_query($conexion,$query);

        if(!$resultado or pg_num_rows($resultado)==0){
            echo '<p  style="font-size:30px; tex height:80px; color: white; text-align:center; font-family: Arial, Helvetica, sans-serif; ">Ingresa una busqueda nuevamente</p>';
            $resultado=pg_query($conexion,"select * from ciclistas") or die("Error");
        }

            echo "<table align=center>
                      <thead><td id=iz>Codigo del ciclista</td><td>Nombre del ciclistas</td><td>Apellido del ciclista</td><td>Fecha de nacimiento</td><td id=der>Nacionalidad</td></thead>";
            while($filas=pg_fetch_array($resultado)){
                echo "<tr><td>".$filas["cod_ciclista"]."</td>";
                echo "<td>".$filas["nomb_ciclista"]."</td>";
                echo "<td>".$filas["apellido_ciclista"]."</td>";
                echo "<td>".$filas["fech_nac"]."</td>";
                echo "<td id=der>".$filas["pais_ciclista"]."</td>";
            }echo "</table>";

    ?>
    
    <?php require '../footer.php' ?>    
    
</body>
    
    
    
    
</html>