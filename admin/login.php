<?php 
    require'../header.php';
    if(isset($_SESSION['cod_user'])){
        echo '<script type="text/javascript">
                window.location="./user.php";
                </script>';
    }

    $message = '';
    if(!empty($_POST['email']) && !empty($_POST['password'])){
        $email1 = $_POST['email'];
        $password1 = $_POST['password'];
        $consulta = "SELECT * FROM users WHERE email='".$email1."' ";
        $results = pg_query($conexion,$consulta);
        if($results && pg_num_rows($results) > 0){
            $resultado = pg_fetch_object($results,0);
            if($password1 == $resultado->password_user){
                
                $_SESSION['cod_user'] = $resultado->cod_user;

                echo '<script type="text/javascript">
                window.location="./user.php";
                </script>';
            }
            
            else{
                $message = 'La contraseña no coincide';
            }
        }
        else{
            $message = "El usuario no existe";
        }
        
    }
?>


<!doctype html>
<html lang="es">
<meta charset="UTF -8" />
    
<head>
    <title>TOUR DE FRANCIA 2021</title>
    <link rel="stylesheet" type="text/css" href="estiloLogin.css?v=<?php echo time(); ?>" />
    <link rel="shortcut icon" href="https://www.letour.fr/img/global/logo-reversed@2x.png"/>
</head>

<body>

    <h1>Iniciar sesión en el administrador de la base de datos</h1>
    <form action="login.php" method="post">
        <input type="text" name="email" placeholder="Digite el correo" autocomplete="off" required>
        <input type="password" name="password" placeholder="Digite la contraseña" required>
        <input type="submit" value="Iniciar sesión">
    </form>

    <?php if(!empty($message)): ?>
        <p> <?php echo $message ?></p>
    <?php endif;?>

    <p>¿No tienes cuenta de administrador? <a href="./signup.php">¡Registrate!</p></a>

    <br><br><br><br>
</body>
    
<?php require '../footer.php' ?>

    
</html>
