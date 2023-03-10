<?php
session_start();
if(isset($_SESSION['id'])){

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="icon" href="images/regalar.png"> 
	<link rel="stylesheet" href="css/reset.css">
	<link rel="stylesheet" href="css/simplegrid.css">
	<link rel="stylesheet" href="css/icomoon.css">
	<link rel="stylesheet" href="css/lightcase.css">
    <link rel="stylesheet" href="js/owl-carousel/owl.carousel.css" />
    <link rel="stylesheet" href="js/owl-carousel/owl.theme.css" />
    <link rel="stylesheet" href="js/owl-carousel/owl.transitions.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="css/styles_usu.css">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Learn Box</title>
</head>
<body>
	<div id="b" align="center">
		<label>Nombre:</label><br><br>
        <label>Apellido:</label><br><br>
        <label>Correo:</label><br><br>
        <label>Contraseña:</label><br><br>
        <button>Modificar</button>
    </div>
    <div id="c" align="center">
    	<button id="d">Perfil</button><br><br>
        <button id="d">Subir cursos</button><br><br>
        <a class="btn btn-success" href="php/logout.php">Salir</a>
    </div>
</body>
</html>
<?php
}
 else{
	echo "Cerrando sesion";
header('Location: index.html');

 }
?>