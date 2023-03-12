<?php
    
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require '../PHPMailer\Exception.php';
    require '../PHPMailer\PHPMailer.php';
    require '../PHPMailer\SMTP.php';

    //Captcha
    $data = array("secret" => "6Le4T_MkAAAAAEQ-mXcLxGlQoPPY7Z_vwsSAmz2Y",
              "response" => $_POST["g-recaptcha-response"],
              "ip" => $_SERVER['REMOTE_ADDR'] );

    $options = array(
    "http" => array(
        "header" => "Content-Type: application/x-www-form-urlencoded\r\n",
        "method" => "POST",
        "content" => http_build_query($data)));
    
     $context = stream_context_create($options);
     $url = "https://www.google.com/recaptcha/api/siteverify";
     $result = file_get_contents($url, false, $context);
     $json_result = json_decode($result, TRUE);
     

     //verificamos el captcha
     if ($json_result["success"])
    {
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
            //obtengo su usuario
            $query = $conexion->prepare("SELECT nick FROM usuario WHERE correo=:co");
            $query->bindParam("co", $co, PDO::PARAM_STR);
            $query->execute();
            $usuario = $query->fetchAll(PDO::FETCH_ASSOC);
            
            //ogenero su contraseña
            $caracteres='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ#$%';
            $codigo= substr(str_shuffle($caracteres),8,8);
            
            $codigo2 = password_hash($codigo, PASSWORD_BCRYPT);
            

            //Asigno la contraseña al usuario al usuario
            $query = $conexion->prepare("UPDATE usuario set contrasena= :cod WHERE correo=:co");
            $query->execute(['co'=> $co, 'cod' => "$codigo2"]);
            $result = $query->fetch(PDO::FETCH_ASSOC);
            
            
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

            //Attachments
            $mail->addAttachment('../images/regalar.png');

            //Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'LearnBox Te Saluda';
            $mailContent = "<h1>Tú pedido llego!!</h1>
            <p>Un pajarito nos dijo que no recuerdas tu contraseña así que por aquí pondremos una nueva para que puedas seguir disfrutando 
            </p>
            <h3>".$codigo."</h3> ";            
            $mail->Body = $mailContent;
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
    }
    else
    {
        echo "<script> 
        alert('No has completado el captcha');
        window.location.replace('../contraseña.html');
        </script>";
    }
   


    


   
?>