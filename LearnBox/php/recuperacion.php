<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../PHPMailer\Exception.php';
    require '../PHPMailer\PHPMailer.php';
    require '../PHPMailer\SMTP.php';

    //Comprobar si el correo existe    
    require_once'conexion.php';
    $co = $_POST['co1'];
    $query = $conexion->prepare("SELECT * FROM usuario WHERE correo=:co");
    $query->bindParam("co", $co, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if (!$result) {
        echo "<script> 
                    alert('Tu correo No esta registrado');
                    window.location.replace('../contraseña.html');
                    </script>";
    }
     else
    {  
        //obtener su contraseña
        $query = $conexion->prepare("SELECT contrasena FROM usuario WHERE correo=:co;");
        $query->bindParam("co", $co, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        echo $result;
         
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
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

        //Content
        $mail->isHTML(true);                                  
        $mail->Subject = 'LearnBox Te Saluda';
        $mail->Body    = 'LO LOGREEEE:D';
    
        $mail->send();
            //echo 'Tu contraseña se a reenviado';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        echo "<script> 
                    alert('Tu Contraseña se a Reenviado');
                    window.location.replace('../login.html');
                    </script>";

        
    }
?>