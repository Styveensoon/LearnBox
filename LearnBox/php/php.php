<?php
      //Dependencias de php mailer
      use PHPMailer\PHPMailer\PHPMailer;
      use PHPMailer\PHPMailer\Exception;
      use PHPMailer\PHPMailer\SMTP;

      require '../PHPMailer\Exception.php';
      require '../PHPMailer\PHPMailer.php';
      require '../PHPMailer\SMTP.php';

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

                    //Damos la vienvenida con un correo
                    //Create an instance; passing `true` enables exceptions
                   $mail = new PHPMailer(true);

                  
                   //Server settings
                   $mail->SMTPDebug = 0;                      
                   $mail->isSMTP();                                          
                   $mail->Host       = 'smtp.gmail.com';                     
                   $mail->SMTPAuth   = true;                                   
                   $mail->Username   = 'learnboxproyect@gmail.com';                     
                   $mail->Password   = 'zknfteqnxniykzqb';                               
                   $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                   $mail->Port       = 465; 

                   //Recipients
                   $mail->setFrom('learnboxproyect@gmail.com', 'LearnBox');
                   $mail->addAddress($co);     

                   //Attachments
                   $mail->addAttachment('../images/metacloud.jpeg');

                   //Content
                   $mail->isHTML(true);                                  
                   $mail->Subject = 'LearnBox Te Saluda';
                   $mailContent = "<h1>Bienvenido!!</h1>
                                   <p>Gracias por ser parte de este proyecto, a nombre de todo el equipo de metacloud te queremos agradecer por confiar en nuestra planificación y el proceso que desarrollarlo conlleva.
                                   Esperemos te quedes con nosotros y seas parte de esta nueva propuesta…</p>
                                   <h3>Un abrazo de parte de todos tras MetaCloud</h3> ";            
                  $mail->Body = $mailContent;
                  $mail->send();
            
                    
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