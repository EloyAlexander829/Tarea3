<?php 
require_once '../models/Empleado.php';

if (isset($_POST['operacion'])){

  $empleado = new Empleado();
  
  if ($_POST['operacion'] == 'search'){
    $respuesta = $empleado->search(["nrodocumento" => $_POST['nrodocumento']]);
    sleep(2);
    echo json_encode($respuesta);
  }

  if($_POST['operacion'] == 'add'){
    $datosRecibidos = [
      "idsede"          => $_POST["idsede"],
      "apellidos"       => $_POST["apellidos"],
      "nombres"         => $_POST["nombres"],
      "nrodocumento"    => $_POST["nrodocumento"],
      "fechanac"        => $_POST["fechanac"],
      "telefono"        => $_POST["telefono"]
    ];

    $idobtenido = $empleado->add($datosRecibidos);
    echo json_encode($idobtenido);
  }
}

if(isset($_GET['operacion'])){

  $empleado = new Empleado();

  if($_GET['operacion'] == 'getResumenSedeEmpleado'){
    echo json_encode($empleado->getResumenSedeEmpleado());
  }
}