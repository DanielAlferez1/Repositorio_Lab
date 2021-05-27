<link rel="stylesheet" type="text/css" href="../estiloCrud.css?v=<?php echo time(); ?>" />

<?php
    require '../../conexionDB.php';
    $conexion = conectarbase();
    $valor = $_GET['valor'];
    if(isset($_GET['cod_equipo'])){
        $cod_equipo = $_GET['cod_equipo'];
        $inicio = $_GET['inicio_contrato'];
        $fin = $_GET['fin_contrato'];
        if($_GET['existes'] === 'no'){
            $query = "INSERT INTO contrato VALUES($valor,$cod_equipo,'$inicio','$fin')";
            $result = pg_query($conexion,$query);
            if(!$result){
                die("<script>window.location = '../error.php';</script>");
                //die($result);
            }
            else{
                $mensaje = "NUEVO CONTRATO CREADO";
                header("Location: ../user.php?mes=$mensaje");
            }
        }
        else{
            $querycopia = "SELECT * FROM contrato where cod_ciclista=$valor";
            $resultcopia = pg_query($conexion,$querycopia);
            $rc = pg_fetch_object($resultcopia);
            $codcopia = $cod_equipo;
            $iniciocopia = $inicio;
            $fincopia = $fin;

            $query1 = "UPDATE contrato SET cod_equipo=$cod_equipo WHERE cod_ciclista=$valor";
            $query2 = "UPDATE contrato SET inicio_contrato='$inicio' WHERE cod_ciclista=$valor";
            $query3 = "UPDATE contrato SET fin_contrato='$fin' WHERE cod_ciclista=$valor";
            $result1 = pg_query($conexion,$query1);
            $result2 = pg_query($conexion,$query2);
            $result3 = pg_query($conexion,$query3);
            if(!$result1 || !$result2 || !$result3){
                $query1 = "UPDATE contrato SET cod_equipo='$codcopia' WHERE cod_ciclista=$valor";
                $query2 = "UPDATE contrato SET inicio_contrato='$iniciocopia' WHERE cod_ciclista=$valor";
                $query3 = "UPDATE contrato SET fin_contrato='$fincopia' WHERE cod_ciclista=$valor";
                $result1 = pg_query($conexion,$query1);
                $result2 = pg_query($conexion,$query2);
                $result3 = pg_query($conexion,$query3);
                die("<script>window.location = '../error.php';</script>");
            }
            else{
                $mensaje = "CONTRATO MODIFICADO";
                header("Location: ../user.php?mes=$mensaje");
            }

        }
    }
    $query = "select * from contrato where cod_ciclista=$valor";
    $query2 = "select nomb_ciclista,apellido_ciclista from ciclistas where cod_ciclista=$valor";
    $result = pg_query($conexion,$query);
    if(pg_num_rows($result) > 0){
        $existe = true;
        $cod_ciclista = $valor;
        $data = pg_fetch_object($result,0);
        $cod_equipo = $data->cod_equipo;
        $inicio = $data->inicio_contrato;
        $fin = $data->fin_contrato;
    }
    else{
        $existe = false;
    }
    $result2 = pg_query($conexion,$query2);
    $resultado = pg_fetch_object($result2,0);
    $nombre = $resultado->nomb_ciclista;
    $apellido = $resultado->apellido_ciclista;
    ?>

<br><br>
<center><h2>Contrato de <?php echo $nombre;?> <?php echo $apellido;?></h2></center>

<?php if(!$existe):?>
    <form action="contrato.php" method="GET" class="dato">
        <input type="hidden" name="valor" value="<?php echo $valor;?>">
        <input type="hidden" name="existes" value="no">
        <p class ="toc">CODIGO EQUIPO</p><input type="text" name="cod_equipo" placeholder="Inserte el código del equipo" autocomplete="off">
        <p class ="toc">INICIO CONTRATO</p><input type="text" name="inicio_contrato" placeholder="Inserte la fecha de inicio" autocomplete="off">
        <p class ="toc">FIN CONTRATO</p><input type="text" name="fin_contrato" placeholder="Inserte la fecha de fin" autocomplete="off">
        <input type="submit" value="Editar" id="editboton">
    </form>
<?php else:?>
    <form action="contrato.php" method="GET" class="dato">
        <input type="hidden" name="valor" value="<?php echo $valor;?>">
        <input type="hidden" name="existes" value="si">
        <p class ="toc">CODIGO EQUIPO</p><input type="text" name="cod_equipo" placeholder="Inserte el código del equipo" autocomplete="off" value="<?php echo $cod_equipo;?>">
        <p class ="toc">INICIO CONTRATO</p><input type="text" name="inicio_contrato" placeholder="Inserte la fecha de inicio" autocomplete="off" value="<?php echo $inicio;?>">
        <p class ="toc">FIN CONTRATO</p><input type="text" name="fin_contrato" placeholder="Inserte la fecha de fin" autocomplete="off" value="<?php echo $fin;?>">
        <input type="submit" value="Editar" id="editboton">
    </form>
<?php endif;?>
<a href="../user.php"><div class="regresar"><p>Regresar</p></div></a>