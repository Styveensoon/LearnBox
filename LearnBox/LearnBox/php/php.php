<?php
      require_once'conexion.php';
      $nm = $_POST['nm'];
      $ap = $_POST['ap'];
      $co= $_POST['co'];
      $ps = $_POST['ps'];
      $psv= $_POST['psv'];
      $ni = $_POST['ni'];
      $password_hash = password_hash($ps, PASSWORD_BCRYPT);
      if ($psv==$ps) {

         $query = $conexion->prepare("SELECT * FROM usuario WHERE correo=:co");
         $query->execute(['co'=> $co]);
         $result = $query->fetch(PDO::FETCH_ASSOC);
        if (!$result) {
               $query = $conexion->prepare("SELECT * FROM usuario WHERE nick=:ni");
                $query->execute(['ni'=> $ni]);
               $result = $query->fetch(PDO::FETCH_ASSOC);
               if (!$result) 
               {
                   $sql = "INSERT INTO usuario (nombre,apellido,correo,contrasena,nick) VALUES (:nm,:ap,:co,:ps,:ni)";
                   $stmt= $conexion->prepare($sql);
                   $stmt->execute([
                   'nm'=> $nm,
                   'ap'=> $ap,
                   'co'=> $co,
                   'ps'=> $password_hash,
                   'ni'=> $ni
                    ]);
                    $conexion = null;
                    
                    $message='Te has Registrado con Exito';
                    echo "<script>
                    confirm('$message');
                    window.location.replace('../login.html');
                    </script>";
              }
              else
              {
                echo "<script> 
                    alert('El correo ya esta registrado');
                    window.location.replace('../login.html');
                    </script>";
              }
      
              }
              else
              {
               echo "<script> 
                    alert('El usuario ya existe');
                    window.location.replace('../login.html');
                    </script>";
              }
      }
      else
      {
        echo "<script> 
                    alert('Las contraseñas no coiciden');
                    window.location.replace('../login.html');
                    </script>";

      }
  ?>