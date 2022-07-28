<?php require 'conexionDB.php';
    session_start();
    $conexion = conectarbase();
    if(isset($_SESSION['cod_user'])){
        $cod = $_SESSION['cod_user'];
        $consulta = "SELECT * FROM users WHERE cod_user='".$cod."' ";
        $results = pg_query($conexion,$consulta);

        $user = null;

        if($results && pg_num_rows($results) > 0){
            $user = pg_fetch_object($results,0);
        }
        
    }

?>


<link rel="stylesheet" type="text/css" href="/tour-francia-app/estiloHeader.css?v=<?php echo time(); ?>" />

<header>
        <div id='logo'>
        <a href="/tour-francia-app/index.php"><img src="https://www.letour.fr/img/global/logo-reversed@2x.png"></a>
        </div>
        <?php if(!empty($user)): ?>
            <div id='log'>
                <a href="/tour-francia-app/admin/user.php"><img id ="user" src="https://cdn.pixabay.com/photo/2020/07/14/13/07/icon-5404125_960_720.png"></a>
                <a href="/tour-francia-app/admin/logout.php"><img id="salir" src="https://cdn.pixabay.com/photo/2017/05/29/23/02/logging-out-2355227_960_720.png"></a>
            </div>
        <?php endif;?>
        <nav id="menu">
            <ul>
                <li id="item"><a href="/tour-francia-app/index.php"><img src="https://atlanticellphone.github.io/Tienda_de_Smartphone/multimedia/img/icon/casao.png"> Inicio</a></li>
                <li id="item"><a href="#"><img src="https://lifemanagementresources.com/wp-content/uploads/2018/09/icon_48301.png"> Participantes</a>
                    <ul id="desple">
                        <li><a href="/tour-francia-app/equipos/equiposParticipantes.php">Equipos participantes</a></li>
                        <li><a href="/tour-francia-app/equipos/ciclistas.php">Ciclistas participantes</a></li>
                        <li><a href="/tour-francia-app/equipos/paisesParticipantes.php">Paises participantes</a></li>
                        <li><a href="/tour-francia-app/equipos/ciclistasRetirados.php">Ciclistas retirados</a></li>
                    </ul>
                </li>
                <li id="item"><a href="#"><img src="https://pngimage.net/wp-content/uploads/2018/06/icona-coppa-png-1.png"> Clasificaciones</a>
                    <ul id="desple2">
                        <li><a href="/tour-francia-app/clasificaciones/general.php">Clasificacion general</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/clasificacionEtapas.php">Clasificación por etapas</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/sprint.php">Clasificacion de Sprint</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/montaña.php">Clasificacion por montaña</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/puntos.php">Clasificacion por puntos</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/clasificacionEquipos.php">Clasificacion por equipos</a></li>
                    </ul>
                </li>
                <li id="item"><a href="#"><img src="https://images.emojiterra.com/google/android-10/512px/1f3f3.png"> Etapas</a>
                    <ul id="desple3">
                        <li><a href="/tour-francia-app/etapas/recorrido.php">Recorrido 2021</a></li>
                        <li><a href="/tour-francia-app/etapas/ganadores.php">Ganadores por etapas</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <nav id="menu-res">
            <ul>
                <li id="item"><a href="/tour-francia-app/index.php"><img src="https://atlanticellphone.github.io/Tienda_de_Smartphone/multimedia/img/icon/casao.png"></a></li>
                <li id="item"><a href="#"><img src="https://lifemanagementresources.com/wp-content/uploads/2018/09/icon_48301.png"></a>
                    <ul id="desple">
                        <li><a href="/tour-francia-app/equipos/equiposParticipantes.php">Equipos participantes</a></li>
                        <li><a href="/tour-francia-app/equipos/ciclistas.php">Ciclistas participantes</a></li>
                        <li><a href="/tour-francia-app/equipos/paisesParticipantes.php">Paises participantes</a></li>
                        <li><a href="/tour-francia-app/equipos/ciclistasRetirados.php">Ciclistas retirados</a></li>
                    </ul>
                </li>
                <li id="item"><a href="#"><img src="https://pngimage.net/wp-content/uploads/2018/06/icona-coppa-png-1.png"></a>
                    <ul id="desple2">
                        <li><a href="/tour-francia-app/clasificaciones/general.php">Clasificacion general</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/sprint.php">Clasificacion de Sprint</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/montaña.php">Clasificacion por montaña</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/puntos.php">Clasificacion por puntos</a></li>
                        <li><a href="/tour-francia-app/clasificaciones/clasificacionEquipos.php">Clasificacion por equipos</a></li>
                    </ul>
                </li>
                <li id="item"><a href="#"><img src="https://images.emojiterra.com/google/android-10/512px/1f3f3.png"></a>
                    <ul id="desple3">
                        <li><a href="/tour-francia-app/etapas/recorrido.php">Recorrido 2021</a></li>
                        <li><a href="/tour-francia-app/etapas/ganadores.php">Ganadores por etapas</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>