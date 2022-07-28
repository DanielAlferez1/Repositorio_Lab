<?php
    include '../../conexionDB.php';
    $conexion = conectarbase();
    $valor = $_GET['valor'];

    if(isset($_GET['cod_etapa'])){
        $etapa = $_GET['cod_etapa'];
        $query1 = "INSERT INTO participa VALUES($valor,$etapa)";
        $consulta1 = pg_query($conexion,$query1);
        if(!$consulta1){
            die("<script>window.location = '../error.php';</script>");
            
        }
        else{
            $mensaje = "PARTICIPACIÓN AGREGADA CORRECTAMENTE";
            header("Location: ./participa.php?mes=$mensaje&valor=$valor");
        }

    }
    
    $query = "SELECT nomb_equipo FROM equipos WHERE cod_equipo=$valor";
    $query2 = "SELECT * FROM participa WHERE cod_equipo=$valor";
    $consulta = pg_query($conexion,$query);
    $consulta2 = pg_query($conexion,$query2);
    $result = pg_fetch_object($consulta,0);
    $nombre = $result->nomb_equipo;
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
        <center><h2>Participaciones de <?php echo $nombre;?> en el Tour de Francia 2021</h2></center>
        <center><h3>Agregar participación</h3>
        <form action="participa.php" method="GET" class="datos">
            <input type="hidden" name="valor" value="<?php echo $valor;?>">
            <input type="text" name="cod_etapa" placeholder="Inserte cod etapa" autocomplete="off">
            <input type="submit" value="Agregar" id="editboton">
        </form>
        <a href="../user.php?tablaxd=equipos"><div class="regresar"><p>Regresar</p></div></a>
        <h3>Tabla participa</h3>

        <?php
            echo "<table>
            <thead class='head'><td id=iz>Código etapa</td></td><td id=der>Opciones</td></thead>";
            while($filas=pg_fetch_array($consulta2)){
                echo "<tr class='linea'><td id='izq'>".$filas["cod_etapa"]."</td>";
                $cod = $filas["cod_etapa"];
                echo "<td><section class='botones'>
                <a href='../delete.php?valor=".$valor."&tabla=participa&var=cod_equipo&cod_etapa=".$cod."'><img id='imgborrar' src='https://ayudawp.com/wp-content/uploads/2018/04/borrar-plugins-wordpress.png' width='40px'></a>
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