<?php
session_start();
session_destroy();
echo "Cerrando sesion";
header('Location: ../index.html');
?>