<?php
    function tabla($conexion,$tabla,$var,$resultx,$resultfilas){
        if($tabla!="corre"){
            require './filtroresults.php';
        }
        if(isset($numero) && isset($busq)){
            if($tablaxa === $tabla){
                $nr = str_replace("'","",$numero);
                if($busq === ''){
                    $query = "select * from $tabla order by $var limit $nr";
                }
                else{
                    $resultC = columnas($tabla,$conexion);;
                    $n = 0;
                    while($filas2=pg_fetch_array($resultC)){
                        if($n === 1 && $tabla!='etapa'){
                            $nomb = $filas2['column_name'];
                            break 1;
                        }
                        else if($tabla === 'etapa' && $n===5){
                            $nomb = $filas2['column_name'];
                            break 1;
                        }
                        $n++;
                    }
                    $query1 = "select * from $tabla where UNACCENT($nomb) ilike '%$busq%' limit $nr";
                    
                    $result2 = pg_query($conexion,$query1);
                    if(!$result2){
                        die("NO HAY");
                    }
                    if(pg_num_rows($result2) > 0 && $result2){
                        $query = $query1;
                    }
                    else{
                        $mensaje = "NO EXISTE UN DATO CON LA INFORMACION INGRESADA.";
                        
                        echo '<script type="text/javascript">
                        window.location="./user.php?mes='.$mensaje.'&tablaxd='.$tabla.'";
                        </script>';
                    }
                }
            }
            else{
                $query = "select * from $tabla order by $var limit 5";
            }
        }
        else{
            $query = "select * from $tabla order by $var limit 5";
        }
        $resultado=pg_query($conexion,$query) or die("Error al consultar usuarios");
        echo "<table><thead class='head'>";
        $nc = 1;
        while($filasK=pg_fetch_array($resultx)){
            if($nc===1){
                echo '<td id=iz>'.$filasK["column_name"].'</td>';
            }
            else{
                echo '<td>'.$filasK['column_name'].'</td>';
            }
            
            $nc++;
        }
        
        if($tabla != 'ciclistas' && $tabla!='equipos'){
            echo '<td id=der>Opciones</td>';
        }
        else{
            echo '<td>Participaciones</td>';
            echo '<td id=der>Opciones</td>';
        }
        
        echo "</thead>";
        $nombres = array();
        while($filasZ = pg_fetch_array($resultfilas)){
            $nombres[] = $filasZ['column_name'];
        }
        
        $nct = pg_num_rows($resultfilas);
        while($filas=pg_fetch_array($resultado)){
            $nc = 1;
            echo "<tr class='linea'><td id='izq'>".$filas[$nombres[0]]."</td>";
            $valor = $filas[$nombres[0]];
            for($i=1;$i<$nct;$i++){
                echo "<td>".$filas[$nombres[$i]]."</td>";
            }
            $nc++;
            if($tabla==='ciclistas'){
                echo "<td><a href='./interrelaciones/contrato.php?valor=".$valor."'><img id='imgcontrato' src='https://cdn3.altiria.com/wp-content/uploads//2018/04/firma-contrato-sms.png' width='35px'></a>";
                echo "<a href='./interrelaciones/corre.php?valor=".$valor."'> <img id='imgparticipa' src='https://imagenesgratis.com.ar/wp-content/uploads/2020/04/bike-png-bicicleta-bycicle-design.png' width='35px'></a></td>";
            }
            else if($tabla === 'equipos'){
                echo "<td><a href='./interrelaciones/contratos.php?valor=".$valor."'><img id='imgcontrato' src='https://cdn3.altiria.com/wp-content/uploads//2018/04/firma-contrato-sms.png' width='35px'></a>";
                echo "<a href='./interrelaciones/participa.php?valor=".$valor."'> <img id='imgparticipa' src='https://imagenesgratis.com.ar/wp-content/uploads/2020/04/bike-png-bicicleta-bycicle-design.png' width='35px'></a></td>";
            }
            echo "<td><section class='botones'>
            <a href='./delete.php?valor=".$valor."&tabla=".$tabla."&var=".$var."'><img id='imgborrar' src='https://ayudawp.com/wp-content/uploads/2018/04/borrar-plugins-wordpress.png' width='40px'></a>";
            if($tabla != 'corre'){
                echo "<a href='./edit.php?valor=".$valor."&tabla=".$tabla."&var=".$var."' ><img id='imgeditar' src='https://cdn.pixabay.com/photo/2017/06/06/00/33/edit-icon-2375785_960_720.png' width='35px'></a>";
            }
            echo "</section></td>";
            
            
            
        }echo "</table>";
    }
?>

<?php 
    function filtro($conexion,$tabla,$query){
        $resultado = pg_query($conexion,$query);
        $nr = pg_num_rows($resultado);
        if($tabla != 'etapa'){
            echo '<section class="buscador">';
            echo    '<form action="user.php" method="POST" class="formulario">';
            echo     '<input class="texto-ingreso" type="search" name="busq" placeholder="Buscar dato por nombre" autocomplete="off">';
            echo        '<select name="numero" class="seleccion">';
            echo            '<option value="5" selected>5</option>';
            echo            '<option value="10">10</option>';
            echo            '<option value="'.$nr.'">'.$nr.'</option>';
            echo        '</select>';
            echo     '<input type="hidden" name="tablaxd" value="'.$tabla.'">';
            echo     '<input type="hidden" name="tablaxa" value="'.$tabla.'">';        
            echo    '<input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">';
            echo    '</form>';
            echo '</section>';
        }
        else{
            echo '<section class="buscador">';
            echo    '<form action="user.php" method="POST" class="formulario">';
            echo     '<input class="texto-ingreso" type="search" name="busq" placeholder="Buscar dato por tipo" autocomplete="off">';
            echo        '<select name="numero" class="seleccion">';
            echo            '<option value="5" selected>5</option>';
            echo            '<option value="10">10</option>';
            echo            '<option value="'.$nr.'">'.$nr.'</option>';
            echo        '</select>';
            echo     '<input type="hidden" name="tablaxd" value="'.$tabla.'">';
            echo     '<input type="hidden" name="tablaxa" value="'.$tabla.'">';        
            echo    '<input class="img-buscador" type="image" src="https://image.flaticon.com/icons/png/128/2932/2932802.png">';
            echo    '</form>';
            echo '</section>';
        }

    }
?>