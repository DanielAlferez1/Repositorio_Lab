
<?php $conexion = conectarbase();
    $consulta = "SELECT cod_pais,nomb_pais FROM pais";
    $resultado = pg_query($conexion,$consulta);

?>
<link rel="stylesheet" type="text/css" href="./estiloCrud.css?v=<?php echo time(); ?>" />


<section class="agregar">
    <form action="./addData.php" method="post">
        <input type="hidden" name="tabla" value="<?php echo $tabla;?>" class="varT">
        <?php while($filas = pg_fetch_array($result)):?>
            <?php if($filas['column_name'] === 'fecha_etapa' || $filas['column_name'] === 'fech_nac'):?>
                
                <input type="text" name="<?php echo $filas['column_name'];?>" placeholder="Digite la <?php echo $filas['column_name']; ?>" onclick="ocultarError();" onfocus="(this.type='date')" onblur="(this.type='text')" autocomplete="off">
                
            <?php elseif($filas['column_name'] === 'pais_ciclista' || $filas['column_name'] === 'pais_equipo'):?>
                <select name="<?php echo $filas['column_name'];?>" id="selectPais">
                <option hidden selected><?php echo $filas['column_name'];?></option>
                    <?php while($filasK=pg_fetch_array($resultado)):?>
                        <option value="<?php echo $filasK['cod_pais'];?>"><?php echo $filasK['nomb_pais'];?></option>
                    <?php endwhile;?>
                </select>
            <?php else:?>
                <input type="text" name="<?php echo $filas['column_name'];?>" placeholder="Digite el <?php echo $filas['column_name']; ?>" autocomplete="off">
            <?php endif;?>
        <?php endwhile;?>
        <input type="submit" name="users" value="Agregar">
    </form>
</section>

