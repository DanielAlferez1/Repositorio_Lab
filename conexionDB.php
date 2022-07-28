
<?php 
function conectarbase(){
    $host="host=ec2-54-198-252-9.compute-1.amazonaws.com";
    $port="port=5432";
    $dbname="dbname=d45vt2n1k13dd6";
    $user="user=ydupgimdsncgvd";             $password="password=32fd9233ad4e8821dd5b8cdceae5d516d469c4abdc6a0b6c418b2ec15f6b33fe";

    $bd = pg_connect("$host $port $dbname $user $password");

    if(!$bd){
        echo "Error:" .pg_last_error;
    } else{
        return $bd;
    }
}
?>

