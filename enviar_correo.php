<?php
$para      = 'jegandarillaa@gmail.com';
$titulo    = 'El t�tulo';
$mensaje   = 'Hola';
$cabeceras = 'From: jesusga@aparedes.com.mx' . "\r\n" .
    'Reply-To: jesusga@aparedes.com.mx' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

mail($para, $titulo, $mensaje, $cabeceras);
?>