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
    <form action="#" name="emstest" method="post">
        <input type="text" name="no_cliente" placeholder="no.cliente">
         <input type="text" name="nombre" placeholder="nombre">
          <input type="text" name="colonia" placeholder="colonia">
          <input type="text" name="cp" placeholder="cp">
          <input type="text" name="RFC" placeholder="RFC">
          <input type="text" name="comercio" placeholder="comercio">

          <input type="submit" name="registro">
          <input type="reset">
        
    </form>
</body>
<?php
if(isset($_POST['registro'])){
    $no_cliente= $_POST['no_cliente'];
     $nombre= $_POST['nombre'];
      $colonia= $_POST['colonia'];
       $cp= $_POST['cp'];
        $RFC= $_POST['RFC'];
         $comercio= $_POST['comercio'];

       // Verificar si el ID 1 está libre
$result = mysqli_query($enlace, "SELECT id FROM clientes WHERE id = 1");
$row = mysqli_fetch_assoc($result);

if (!$row) {
    // ID 1 está libre
    $next_id = 1;
} else {
    // Buscar el siguiente hueco
    $result = mysqli_query($enlace, "SELECT MIN(t1.id + 1) AS next_id
                                       FROM clientes t1
                                       LEFT JOIN clientes t2 ON t1.id + 1 = t2.id
                                       WHERE t2.id IS NULL");
    $row = mysqli_fetch_assoc($result);
    $next_id = $row['next_id'];
}

// Insertar con ese ID
$insert = "INSERT INTO clientes (id, no_cliente, nombre, colonia, cp, RFC, comercio)
           VALUES ($next_id, '$no_cliente', '$nombre', '$colonia', '$cp', '$RFC', '$comercio')";
mysqli_query($enlace, $insert);

// Verificar si el no_cliente ya existe
$check = mysqli_query($enlace, "SELECT no_cliente FROM clientes WHERE no_cliente = '$no_cliente'");
if(mysqli_num_rows($check) > 0){

    $mensaje = "este usuario ya existe";

// Generamos el código JavaScript con PHP
echo "<script>alert('$mensaje');</script>"; 
} else {
    // Insertar el cliente
    $insert = "INSERT INTO clientes (id, no_cliente, nombre, colonia, cp, RFC, comercio)
               VALUES ($next_id, '$no_cliente', '$nombre', '$colonia', '$cp', '$RFC', '$comercio')";
    mysqli_query($enlace, $insert);
    echo "✅ Cliente insertado correctamente";

}

 
    
} 




?>
</html>
