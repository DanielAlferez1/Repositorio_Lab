

<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estiloInfo.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>
<div class="cuadro0">
    <?php require 'header.php' ?>    
    <h1>Conoce más sobre nosotros</h1>
</div>

<div class="lbl">
                    <label for="radio1">Objetivo</label>
                    <label for="radio2">Metodologia</label>
                    <label for="radio3">About Us</label>
    </div>

<div class="cuadro">
    <div class="cuadro1" id='cuadro1'>
        <h1>Objetivos</h1>
        <input type="radio" name="radio" id="radio1">
        <p>Comunicar toda la información sobre la última edición del torneo ciclístico más importante del mundo
            a todos los amantes de este deporte. Aquí podrás encontrar los datos de cada ciclista, su clasificación
            en las tablas, información de cada equipo, contratos, el recorrido del Tour, etc.
            <br><br>Toda la información está almacenada en nuestra base de datos para que cualquier usuario pueda consultarla
            y conocer más sobre la presente edición.
            <br><br>No olvides estar atento a nuestras redes sociales para conocer más sobre la actualidad del Tour.
        </p>
    </div>    
    <div class="cuadro2">
        <img src="https://www.lafayettesports.com.co/wp-content/uploads/tdf.jpg">
    </div>
    <div class="cuadro3">
        <h1>Metodología</h1>
        <input type="radio" name="radio" id="radio2">
        <p>La creación de la pagina web se realizó mediante el uso HTML y CSS para la estructura básica del diseño web.
            <br><br>Se utilizó PostgreSQL como motor de bases de datos, Apache y Heroku como servidor web, y PHP como herramienta para
            mostrar correctamente toda la información en la pagina web.
        </p>
    </div>    
    <div class="cuadro4">
        <img src="https://softwareblog03.files.wordpress.com/2017/04/metodologia.png"> 
    </div>
    <div class="cuadro5">
        <h1>About us</h1>
        <input type="radio" name="radio" id="radio3">
        <p>Este sitio web fue realizado por los estudiantes de 4to semestre de Ingeniería de sistemas de la Universidad de los Llanos, Juan David Torres Barreto y Daniel Camilo Alférez García,
            como proyecto para la materia "Bases de datos". <br><br>
            El objetivo principal es demostrar una de las tantas aplicaciones que
            tienen las bases de datos y el manejo de la información alojada en estas.
        </p>
    </div>
    <div class="cuadro6">
        <img src="http://3.bp.blogspot.com/-8QPMwYDrvzE/TqormESdBoI/AAAAAAAADBY/grIGhK-YL30/s1600/Unillanos.png">
    </div>
</div> 

</body>
    
<?php require 'footer.php' ?>

    
</html>
