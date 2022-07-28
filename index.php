

<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estilo.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>
    
    <?php require 'header.php' ?>

    <center><div class="presentacion">
        <br>
        <h1>Tour de Francia 2021</h1>
        <p>Bienvenidos a la web (no) oficial del Tour de Francia 2021, en este medio podrás consultar
        toda la información sobre la competencia más grande del ciclismo.<br><br>
        La 108ª edición del Tour de France arrancará en Brest, al oeste del país francés, el sábado 26 de junio del 2021.
        Y terminará el 18 de julio del mismo año en la capital francesa, París.<br><br>
        </p>
    </div></center>
    
    <center>
    <section>
        <img id="imgTour" src="https://imagenes.elpais.com/resizer/6aCXXj1jPg3bddyUtwZER5_mgu0=/394x295/cloudfront-eu-central-1.images.arcpublishing.com/prisa/FUQGTGBAURBN5GSP2ZU4QMTQF4.jpg">
        <p>¡Conoce más datos interesantes<br> sobre el Tour!</p>
        <a href="curiosidadesTour.php"><div id="cuadrito">Más sobre el tour</div></a>
    </section>
    <section>
        <img id="imgClasificaciones" src="https://cadenaser00.epimg.net/ser/imagenes/2007/09/20/deportes/1190244492_740215_0000000000_noticia_normal.jpg">
        <p>¡Mira las clasificaciones<br> de los deportistas!</p>
        <a href="clasificaciones/general.php"><div id="cuadrito">Clasificaciones</div></a>
    </section>
    <section>
        <img id="imgAbout" src="https://ciclismoepico.com/wp-content/uploads/2020/12/tour-de-francia-2021-recorrido-favorito-y-perfiles-de-etapa-I.jpg">
        <p>¡Conoce más sobre<br> nuestra página!</p>
        <a href="infoPag.php"><div id="cuadrito">Sobre nosotros</div></a>
    </section>
        </center>
    

    <div class="boxLogin">
        <img src="https://cdn.pixabay.com/photo/2016/01/19/16/49/laptop-1149412_960_720.jpg">
        <?php if(!empty($user)): ?>
            <h2>Ya has ingresado</h2>
            <a href="./admin/user.php"><div id="boton"><p>Ir al gestor</p></div></a>
        <?php else: ?>
            <h2>¿Eres administrador?</h2>
            <a href="admin/login.php"><div id="boton"><p>¡Inicia sesión!</p></div></a>
        <?php endif; ?>
    </div>
</body>
    
<?php require 'footer.php' ?>

    
</html>
