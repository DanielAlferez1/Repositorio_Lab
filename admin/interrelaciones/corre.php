<?php
    include '../../conexionDB.php';
    include '../columns.php';
    include '../tabla.php';
    $conexion = conectarbase();
    $valor = $_GET['valor'];

    if(isset($_GET['cod_etapa'])){
        $etapa = $_GET['cod_etapa'];
        //$puntos = $_GET['puntos'];
        $tiempo = $_GET['tiempo'];
        //$posicion = $_GET['posicion'];
        $query2 = "INSERT INTO corre(cod_ciclista,cod_etapa,tiempo_ciclista) VALUES($valor,$etapa,'$tiempo')";
        $result2 = pg_query($conexion,$query2);
        if(!$result2){
            die("<script>window.location = '../error.php';</script>");
        }
        else{
            $mensaje = "NUEVA PARTICIPACIÓN DE CICLISTA AGREGADA";
            header("Location: ./corre.php?mes=$mensaje&valor=$valor");
        }
    }

    
    $query = "SELECT nomb_ciclista,apellido_ciclista FROM ciclistas WHERE cod_ciclista=$valor";
    $querycorre = "SELECT * FROM corre WHERE cod_ciclista=$valor";
    $resultcorre = pg_query($conexion,$querycorre);
    $result = pg_query($conexion,$query);
    $ciclista = pg_fetch_object($result,0);
    $nombre = $ciclista->nomb_ciclista;
    $apellido = $ciclista->apellido_ciclista;
?>


<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="../estiloCrud.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

    <body>
        <br><br>
        <center><h2>Participaciones de <?php echo $nombre; echo $apellido;?> en el Tour de Francia 2021</h2></center>
        <center><h3>Agregar participación</h3>
        <form action="corre.php" method="GET" class="datos">
            <input type="hidden" name="valor" value="<?php echo $valor;?>">
            <input type="text" name="cod_etapa" placeholder="Inserte cod etapa" autocomplete="off">
            <!--<input type="text" name="puntos" placeholder="Inserte los puntos" autocomplete="off">-->
            <input type="text" name="tiempo" placeholder="Inserte el tiempo" autocomplete="off">
            <!--input type="text" name="posicion" placeholder="Inserte la posición" autocomplete="off">-->
            <input type="submit" value="Agregar" id="editboton">
        </form>
        <a href="../user.php?tablaxd=ciclistas"><div class="regresar"><p>Regresar</p></div></a>
        <h3>Tabla corre</h3>

        <?php
            echo "<table>
            <thead class='head'><td id=iz>Código etapa</td><td>Puntos</td><td>Tiempo</td><td>Posición</td><td id=der>Opciones</td></thead>";
            while($filas=pg_fetch_array($resultcorre)){
                echo "<tr class='linea'><td id='izq'>".$filas["cod_etapa"]."</td>";
                $etapa2 = $filas['cod_etapa'];
                echo "<td>".$filas["puntos_ciclista"]."</td>";
                echo "<td>".$filas["tiempo_ciclista"]."</td>";
                echo "<td>".$filas["posicion_ciclista"]."</td>";
                echo "<td><section class='botones'>
                <a href='../delete.php?valor=".$valor."&tabla=corre&var=cod_ciclista&cod_etapa=".$etapa2."'><img id='imgborrar' src='https://ayudawp.com/wp-content/uploads/2018/04/borrar-plugins-wordpress.png' width='40px'></a>
                    </section></td>";
            }echo "</table>";
        ?>
</center>

<?php if(isset($_GET['mes'])):?>
        <script type="text/javascript">
            alert("<?php echo $_GET['mes'];?>");
        </script>
    <?php endif;?>

    </body>
</html>