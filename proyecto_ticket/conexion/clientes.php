<?php
$servidor = "localhost";   // Servidor
$user = "root";         // Usuario de MySQL
$clave = ""; // Contraseña
$baseDeDatos = "ejemplo";      // Nombre de la base de datos
      
$enlace =  mysqli_connect($servidor, $user, $clave, $baseDeDatos );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ticket</title>
</head>
<body>
    <form action="#" name="ejemplo" method="post">
          <input type="text" name="COLONIA" placeholder="COLONIA">
          <input type="text" name="CP" placeholder="CP">
          <input type="text" name="RAZONSOCIAL" placeholder="RAZONSOCIAL">
          <input type="text" name="REGIMEN" placeholder="REGIMEN">
          <input type="text" name="DOMICILIO" placeholder="DOMICILIO">
          <input type="text" name="RFC" placeholder="RFC">
          <input type="text" name="CORREO" placeholder="CORREO">
          <input type="text" name="NOMCOMERCIAL" placeholder="NOMCOMERCIAL">

          <input type="submit" name="registro">
          <input type="reset">
        
    </form>
</body>
<?php
if(isset($_POST['registro'])){    
     $COLONIA= $_POST['COLONIA'];
      $RAZONSOCIAL= $_POST['RAZONSOCIAL'];
       $REGIMEN= $_POST['REGIMEN'];
       $DOMICILIO= $_POST['DOMICILIO'];
       $RFC= $_POST['RFC'];
       $CORREO= $_POST['CORREO'];
         $NOMCOMERCIAL= $_POST['NOMCOMERCIAL'];

       // Verificar si el ID 1 está libre
$result = mysqli_query($enlace, "SELECT IDCTE FROM clientes WHERE IDCTE = 1");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    // ID 1 está libre
    $next_IDCTE = 1;
} else {
    // Buscar el siguiente hueco
    $result = mysqli_query($enlace, "SELECT MIN(t1.IDCTE + 1) AS next_IDCTE
                                       FROM clientes t1
                                       LEFT JOIN clientes t2 ON t1.IDCTE + 1 = t2.IDCTE
                                       WHERE t2.IDCTE IS NULL");
    $row = mysqli_fetch_assoc($result);
    $next_IDCTE = $row['next_IDCTE'];
}

// Insertar con ese ID
$insert = "INSERT INTO clientes (IDCTE,COLONIA,RAZONSOCIAL,REGIMEN,DOMICILIO,RFC,CORREO,NOMCOMERCIAL)
           VALUES ($next_IDCTE,'$COLONIA','$RAZONSOCIAL','$REGIMEN','$DOMICILIO','$RFC','$CORREO','$NOMCOMERCIAL' )";
mysqli_query($enlace, $insert);

// Verificar si el no_cliente ya existe
$check = mysqli_query($enlace, "SELECT next_IDCTE FROM clientes WHERE next_IDCTE = '$next_IDCTE'");
if(mysqli_num_rows($check) > 0){

    $mensaje = "este usuario ya existe";

// Generamos el código JavaScript con PHP
echo "<script>alert('$mensaje');</script>"; 
} else {
    // Insertar el cliente
    $insert = "INSERT INTO clientes (next_IDCTE, COLONIA,RAZONSOCIAL,REGIMEN,DOMICILIO,RFC,CORREO,NOMCOMERCIAL)
               VALUES ($next_IDCTE,  '$COLONIA','$RAZONSOCIAL','$REGIMEN','$DOMICILIO','$RFC','$CORREO','$NOMCOMERCIAL')";
    mysqli_query($enlace, $insert);
    echo "✅ Cliente insertado correctamente";

}

 
    
} 




?>
</html>