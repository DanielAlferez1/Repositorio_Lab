<?php
    if(isset($_POST['tablaxd']) || isset($_GET['tablaxd'])){
        if(isset($_POST['tablaxd'])){
            $tablaxd = $_POST['tablaxd'];
        }
        else if(isset($_GET['tablaxd'])){
            $tablaxd = $_GET['tablaxd'];
        }
        if($tablaxd === 'users'){
            echo '<input type="radio" name="radio" id="radio1" checked>';
            echo '<input type="radio" name="radio" id="radio2">';
            echo '<input type="radio" name="radio" id="radio3">';
            echo '<input type="radio" name="radio" id="radio4">';
            echo '<input type="radio" name="radio" id="radio5">';
            echo '<input type="radio" name="radio" id="radio6">';
            
        }
        else if($tablaxd === 'pais'){
            echo '<input type="radio" name="radio" id="radio1">';
            echo '<input type="radio" name="radio" id="radio2" checked>';
            echo '<input type="radio" name="radio" id="radio3">';
            echo '<input type="radio" name="radio" id="radio4">';
            echo '<input type="radio" name="radio" id="radio5">';
            echo '<input type="radio" name="radio" id="radio6">';
            
        }
        else if($tablaxd === 'ciudad'){
            echo '<input type="radio" name="radio" id="radio1">';
            echo '<input type="radio" name="radio" id="radio2">';
            echo '<input type="radio" name="radio" id="radio3" checked>';
            echo '<input type="radio" name="radio" id="radio4">';
            echo '<input type="radio" name="radio" id="radio5">';
            echo '<input type="radio" name="radio" id="radio6">';
            
        }
        else if($tablaxd === 'ciclistas' || $tablaxd === 'corre' || $tablaxd==='contrato'){
            echo '<input type="radio" name="radio" id="radio1">';
            echo '<input type="radio" name="radio" id="radio2">';
            echo '<input type="radio" name="radio" id="radio3">';
            echo '<input type="radio" name="radio" id="radio4" checked>';
            echo '<input type="radio" name="radio" id="radio5">';
            echo '<input type="radio" name="radio" id="radio6">';
            
        }
        else if($tablaxd === 'equipos' || $tablaxd === 'contratos' || $tablaxd === 'participa'){
            echo '<input type="radio" name="radio" id="radio1">';
            echo '<input type="radio" name="radio" id="radio2">';
            echo '<input type="radio" name="radio" id="radio3">';
            echo '<input type="radio" name="radio" id="radio4">';
            echo '<input type="radio" name="radio" id="radio5" checked>';
            echo '<input type="radio" name="radio" id="radio6">';
            
        }
        else if($tablaxd === 'etapa'){
            echo '<input type="radio" name="radio" id="radio1">';
            echo '<input type="radio" name="radio" id="radio2">';
            echo '<input type="radio" name="radio" id="radio3">';
            echo '<input type="radio" name="radio" id="radio4">';
            echo '<input type="radio" name="radio" id="radio5">';
            echo '<input type="radio" name="radio" id="radio6" checked>';
            
        }
    }
    else{
        echo '<input type="radio" name="radio" id="radio1" checked>';
        echo '<input type="radio" name="radio" id="radio2">';
        echo '<input type="radio" name="radio" id="radio3">';
        echo '<input type="radio" name="radio" id="radio4">';
        echo '<input type="radio" name="radio" id="radio5">';
        echo '<input type="radio" name="radio" id="radio6">';
        echo '<input type="radio" name="radio" id="radio7">';
        echo '<input type="radio" name="radio" id="radio8">';
    }
?>