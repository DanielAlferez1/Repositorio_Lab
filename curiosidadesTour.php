
<!doctype html>
<html lang="es">
    <meta charset="UTF -8" />
    <head>
        <title>TOUR DE FRANCIA 2021</title>
        <link rel="stylesheet" type="text/css" href="estiloCuriosidades.css?v=<?php echo time(); ?>" />
        <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
    </head>
    <body>
        <div class="contenedor">
            <div class="header">
                <?php require 'header.php' ?>
                <div class="banner"><h1>CONOCE MÁS SOBRE EL TOUR</h1></div>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#000000" fill-opacity="1" d="M0,64L80,96C160,128,320,192,480,186.7C640,181,800,107,960,74.7C1120,43,1280,53,1360,58.7L1440,64L1440,320L1360,320C1280,320,1120,320,960,320C800,320,640,320,480,320C320,320,160,320,80,320L0,320Z"></path>
                </svg>
            </div>
            <div class="Menu">
                <div class="lbl">
                    <label for="radio1"><img src="https://img.icons8.com/material/452/home--v5.png"> Inicio</label>
                    <label for="radio2"><img src="https://image.flaticon.com/icons/png/512/64/64575.png">Ciclistas</label>
                    <label for="radio3"><img src="https://image.flaticon.com/icons/png/512/484/484565.png"> Equipos</label>
                    <label for="radio4"><img src="https://image.flaticon.com/icons/png/512/59/59375.png"> Etapas</label>
                    <label for="radio5"><img src="https://image.flaticon.com/icons/png/512/47/47799.png"> Ganadores</label>
                </div>
                <div class="lbl-respo">
                    <label for="radio1"><img src="https://img.icons8.com/material/452/home--v5.png"></label>
                    <label for="radio2"><img src="https://image.flaticon.com/icons/png/512/64/64575.png"></label>
                    <label for="radio3"><img src="https://image.flaticon.com/icons/png/512/484/484565.png"></label>
                    <label for="radio4"><img src="https://image.flaticon.com/icons/png/512/59/59375.png"></label>
                    <label for="radio5"><img src="https://image.flaticon.com/icons/png/512/47/47799.png"></label>
                </div>
                <div class="contenido">
                    <input type="radio" name="radio" id="radio1" checked="active">
                    <div class="tab1">
                        <h1>Inicio</h1>
                        <h3>Aquí podrás encontrar información y datos interesantes de nuestros ciclistas participantes, equipos participantes, etapas y curiosidades sobre algunos de los ganadores de las etapas en este nuevo Tour de Francia 2021</h3>
                        <center><img src="https://cdn.skoda-storyboard.com/2018/07/TdF-icon-cyclists-e1530707300809.png"></center>
                        </div>
                    <input type="radio" name="radio" id="radio2">
                    <div class="tab2">
                        <h1>Ciclistas</h1>
                        <h2>Ciclista con menos edad</h2>
                        <?php
                            $conexion = conectarbase();
                            //select cod_ciclista, nomb_ciclista, apellido_ciclista, (current_date-fech_nac)/365 as edad, nomb_pais from ciclistas inner join pais on pais.cod_pais=ciclistas.pais_ciclista where fech_nac in (select max(fech_nac) from ciclistas)
                            //Vista creada cic_menos_edad
                            $query="SELECT * FROM cic_menos_edad";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Codigo del ciclista</td><td>Nombre del ciclistas</td><td>Apellido del ciclista</td><td>Edad</td><td id=der>Nacionalidad</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["cod_ciclista"]."</td>";
                                echo "<td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["edad"]."</td>";
                                echo "<td class='derecha'>".$filas["nomb_pais"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Ciclista con más edad</h2>
                        <?php
                            $conexion = conectarbase();
                            //vista "cic_mas_edad":select cod_ciclista, nomb_ciclista, apellido_ciclista, (current_date-fech_nac)/365 as edad, nomb_pais from ciclistas inner join pais on pais.cod_pais=ciclistas.pais_ciclista where fech_nac in (select min(fech_nac) from ciclistas)
                            $query="SELECT * FROM cic_mas_edad";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Codigo del ciclista</td><td>Nombre del ciclistas</td><td>Apellido del ciclista</td><td>Edad</td><td id=der>Nacionalidad</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["cod_ciclista"]."</td>";
                                echo "<td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["edad"]."</td>";
                                echo "<td>".$filas["nomb_pais"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Top 3 paises con mas ciclistas</h2>
                        <?php
                            $conexion = conectarbase();
                            //vista "paises_mas_cic" :select pais.nomb_pais, count(cod_ciclista) cantidad from ciclistas inner join pais on pais.cod_pais=ciclistas.pais_ciclista  group by nomb_pais order by cantidad desc limit 3
                            $query="SELECT * FROM paises_mas_cic";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nacionalidad</td><td id=der>Cantidad de ciclistas</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_pais"]."</td>";
                                echo "<td>".$filas["cantidad"]."</td>";
                            }echo "</table>";
                        ?>
                    </div>
                    <input type="radio" name="radio" id="radio3">
                    <div class="tab3">
                        <h1>Equipos</h1>
                        <h2>Top 3 paises con mas equipos</h2>
                        <?php
                            $conexion = conectarbase();
                            //vista "paises_mas_equ": select pais.nomb_pais, count(cod_equipo) as cantidad from equipos inner join pais on pais.cod_pais=equipos.pais_equipo group by nomb_pais order by cantidad desc limit 3
                            $query="SELECT * FROM paises_mas_equ";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nacionalidad</td><td id=der>Cantidad de equipos</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_pais"]."</td>";
                                echo "<td>".$filas["cantidad"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Equipo con un ciclista contratado por mayor tiempo</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select nomb_equipo, nomb_ciclista, apellido_ciclista, (fin_contrato-inicio_contrato) as dias from ciclistas, contrato, equipos where ciclistas.cod_ciclista=contrato.cod_ciclista and contrato.cod_equipo=equipos.cod_equipo and (fin_contrato-inicio_contrato) in (select max(fin_contrato-inicio_contrato) from contrato)";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nombre equipo</td><td>Nombre ciclista</td><td>Apellido ciclista</td><td id=der>Dias de contrato</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_equipo"]."</td>";
                                echo "<td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["dias"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Equipo de Francia con un ciclista contratado por menor tiempo</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select nomb_equipo, nomb_ciclista, apellido_ciclista, (fin_contrato-inicio_contrato) as dias from ciclistas, contrato, equipos where ciclistas.cod_ciclista=contrato.cod_ciclista and contrato.cod_equipo=equipos.cod_equipo and  pais_equipo='FRA'  and (fin_contrato-inicio_contrato) in (select min(fin_contrato-inicio_contrato) from contrato, equipos where contrato.cod_equipo=equipos.cod_equipo and pais_equipo='FRA')";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nombre equipo</td><td>Nombre ciclista</td><td>Apellido ciclista</td><td id=der>Dias de contrato</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_equipo"]."</td>";
                                echo "<td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["dias"]."</td>";
                            }echo "</table>";
                        ?>
                    </div>
                    <input type="radio" name="radio" id="radio4">
                    <div class="tab4">
                        <h1>Etapas</h1>
                        <h2>Etapa más larga</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select cod_etapa,distancia,fecha_etapa,c.nombre_ciudad as destino,d.nombre_ciudad as origen,tipo from ciudad c inner join etapa on c.cod_ciudad=ciudad_destino inner join ciudad d on ciudad_origen=d.cod_ciudad where distancia in (select max(distancia) from etapa)";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Codigo</td><td>Distancia</td><td>Fecha</td><td>Ciudad destino</td><td>Ciudad origen</td><td id=der>Tipo de etapa</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["cod_etapa"]."</td>";
                                echo "<td>".$filas["distancia"]."</td>";
                                echo "<td>".$filas["fecha_etapa"]."</td>";
                                echo "<td>".$filas["origen"]."</td>";
                                echo "<td>".$filas["destino"]."</td>";
                                echo "<td>".$filas["tipo"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Etapa en la que un ciclista duró más tiempo en completarla</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select corre.cod_etapa, distancia, fecha_etapa, tipo, nomb_ciclista, apellido_ciclista, tiempo_ciclista from etapa, corre, ciclistas where etapa.cod_etapa=corre.cod_etapa and ciclistas.cod_ciclista=corre.cod_ciclista and tiempo_ciclista in (select max(tiempo_ciclista) from corre)";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Codigo</td><td>Distancia</td><td>Fecha</td><td>Tipo de etapa</td><td>Nombre ciclista</td><td>Apellido ciclista</td><td id=der>Tiempo</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["cod_etapa"]."</td>";
                                echo "<td>".$filas["distancia"]."</td>";
                                echo "<td>".$filas["fecha_etapa"]."</td>";
                                echo "<td>".$filas["tipo"]."</td>";
                                echo "<td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["tiempo_ciclista"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Etapa en la que un ciclista duró menos tiempo en completarla</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select corre.cod_etapa, distancia, fecha_etapa, tipo, nomb_ciclista, apellido_ciclista, tiempo_ciclista from etapa, corre, ciclistas where etapa.cod_etapa=corre.cod_etapa and ciclistas.cod_ciclista=corre.cod_ciclista and tiempo_ciclista in (select min(tiempo_ciclista) from corre)";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Codigo</td><td>Distancia</td><td>Fecha</td><td>Tipo de etapa</td><td>Nombre ciclista</td><td>Apellido ciclista</td><td id=der>Tiempo</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["cod_etapa"]."</td>";
                                echo "<td>".$filas["distancia"]."</td>";
                                echo "<td>".$filas["fecha_etapa"]."</td>";
                                echo "<td>".$filas["tipo"]."</td>";
                                echo "<td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["tiempo_ciclista"]."</td>";
                            }echo "</table>";
                        ?>
                    </div>
                    <input type="radio" name="radio" id="radio5">
                    <div class="tab5">
                        <h1>Ganadores</h1>
                        <h2>Ganador con mayor edad</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select nomb_ciclista, apellido_ciclista, (current_date-fech_nac)/365 as edad, nomb_pais, cod_etapa from corre, ciclistas, pais where corre.cod_ciclista=ciclistas.cod_ciclista and ciclistas.pais_ciclista=pais.cod_pais and posicion_ciclista=1 and fech_nac in (select min(fech_nac) from ciclistas, corre where ciclistas.cod_ciclista=corre.cod_ciclista and posicion_ciclista=1);
                            ";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nombre ciclista</td><td>Apellido ciclista</td><td>Edad ciclista</td><td>Pais ciclista</td><td id=der>Número de etapa</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["edad"]."</td>";
                                echo "<td>".$filas["nomb_pais"]."</td>";
                                echo "<td>".$filas["cod_etapa"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Ganador con menor edad</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select nomb_ciclista, apellido_ciclista, (current_date-fech_nac)/365 as edad, nomb_pais, cod_etapa from corre, ciclistas, pais where corre.cod_ciclista=ciclistas.cod_ciclista and ciclistas.pais_ciclista=pais.cod_pais and posicion_ciclista=1 and fech_nac in (select max(fech_nac) from ciclistas, corre where ciclistas.cod_ciclista=corre.cod_ciclista and posicion_ciclista=1);
                            ";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nombre ciclista</td><td>Apellido ciclista</td><td>Edad ciclista</td><td>Pais ciclista</td><td id=der>Número de etapa</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["edad"]."</td>";
                                echo "<td>".$filas["nomb_pais"]."</td>";
                                echo "<td>".$filas["cod_etapa"]."</td>";
                            }echo "</table>";
                        ?>
                        <br>
                        <h2>Ganador que duró mas tiempo en ganar una etapa</h2>
                        <?php
                            $conexion = conectarbase();
                            $query="select nomb_ciclista, apellido_ciclista, (current_date-fech_nac)/365 as edad, nomb_pais, cod_etapa, tiempo_ciclista from corre, ciclistas, pais where corre.cod_ciclista=ciclistas.cod_ciclista and ciclistas.pais_ciclista=pais.cod_pais and posicion_ciclista=1 and tiempo_ciclista in (select max(tiempo_ciclista) from ciclistas, corre where ciclistas.cod_ciclista=corre.cod_ciclista and posicion_ciclista=1);";
                            $resultado=pg_query($conexion,$query) or die ("Error en consultar universidad");
                            echo "<table>
                            <thead><td id=iz>Nombre ciclista</td><td>Apellido ciclista</td><td>Edad ciclista</td><td>Pais ciclista</td><td>Número de etapa</td><td id=der>Tiempo ciclista</td></thead>";
                            while($filas=pg_fetch_array($resultado)){
                                echo "<tr class='linea'><td>".$filas["nomb_ciclista"]."</td>";
                                echo "<td>".$filas["apellido_ciclista"]."</td>";
                                echo "<td>".$filas["edad"]."</td>";
                                echo "<td>".$filas["nomb_pais"]."</td>";
                                echo "<td>".$filas["cod_etapa"]."</td>";
                                echo "<td>".$filas["tiempo_ciclista"]."</td>";
                            }echo "</table>";
                        ?>
                    </div>
                </div>
            </div>
            <div class="sidebar">
                <center><img src="http://clipart.coolclips.com/480/vectors/tf05134/CoolClips_vc000652.png"></center>
            </div>
            <div class="footer">
                <?php require 'footer.php' ?>
            </div>
        </div>
    </body>
    
</html>
