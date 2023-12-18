<?php
require("Conexion.php");

try {
    $conexion = new Conexion();
    $pdo = $conexion->getConexion();

    $consulta = $pdo->prepare("CALL spu_empleados_listar()");
    $consulta->execute();
    
    $empleados = $consulta->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>