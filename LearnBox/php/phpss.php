<?php
session_start();
    require_once'conexion.php';
    $co = $_POST['co1'];
    $ps = $_POST['ps1'];
    $query = $conexion->prepare("SELECT * FROM usuario WHERE correo=:co");
    $query->bindParam("co", $co, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        echo "<script> 
                    alert('Correo inexistente');
                    window.location.replace('../login.html');
                    </script>";
    } else {
        if (password_verify($ps, $result['contrasena'])) {
            $_SESSION['id'] = $result['id'];
                    echo "<script> 
                    window.location.replace('../usu.php');
                    </script>";;
        } else {
            echo "<script> 
                    alert('Contraseña Invalida');
                    window.location.replace('../login.html');
                    </script>";
        }
    }
?>