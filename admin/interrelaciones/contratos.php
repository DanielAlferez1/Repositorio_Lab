<?php include '../../conexionDB.php';
    $valor = $_GET['valor'];
    $conexion = conectarbase();
    $queryequipo = "SELECT nomb_equipo FROM equipos WHERE cod_equipo=$valor";
    $resultequipo = pg_query($conexion,$queryequipo);
    $resultequipo2 = pg_fetch_object($resultequipo,0);
    $nombre = $resultequipo2->nomb_equipo;
    $querycontratos = "SELECT ciclistas.cod_ciclista,nomb_ciclista,apellido_ciclista,inicio_contrato,fin_contrato from ciclistas inner join contrato on ciclistas.cod_ciclista=contrato.cod_ciclista inner join equipos on contrato.cod_equipo=equipos.cod_equipo where equipos.cod_equipo=$valor";
    $resultcontratos = pg_query($conexion,$querycontratos);
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
    <br>
    <center><h2>CONTRATOS DE <?php echo $nombre;?></h2>
    <br>
    <?php
            echo "<table>
            <thead class='head'><td id=iz>Código ciclista</td><td>Nombre</td><td>Apellido</td><td>Inicio contrato</td><td>Fin contrato</td><td id=der>Opciones</td></thead>";
            while($filas=pg_fetch_array($resultcontratos)){
                echo "<tr class='linea'><td id='izq'>".$filas["cod_ciclista"]."</td>";
                $cod = $filas["cod_ciclista"];
                echo "<td>".$filas["nomb_ciclista"]."</td>";
                echo "<td>".$filas["apellido_ciclista"]."</td>";
                echo "<td>".$filas["inicio_contrato"]."</td>";
                echo "<td>".$filas["fin_contrato"]."</td>";
                echo "<td><section class='botones'>
                <a href='./contrato.php?valor=".$cod."&equipo=".$valor."'><img id='imgborrar' src='https://cdn.pixabay.com/photo/2017/06/06/00/33/edit-icon-2375785_960_720.png' width='35px'></a>
                    </section></td>";
            }echo "</table>";
        ?>
        <a href="../user.php?tablaxd=equipos"><div class="regresar"><p>Regresar</p></div></a>
        <br><br>
    </center>


    <?php if(isset($_GET['mes'])):?>
        <script type="text/javascript">
            alert("<?php echo $_GET['mes'];?>");
        </script>
    <?php endif;?>

</body>
</html>