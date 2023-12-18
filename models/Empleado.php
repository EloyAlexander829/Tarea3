<?php
require 'Conexion.php';
class Empleado extends Conexion{

  private $pdo;

  public function __construct()
  {
    $this->pdo = parent::getConexion();
  }

  public function add($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_empleados_registrar(?,?,?,?,?,?)");
      $consulta->execute(
        array(
          $data['idsede'],
          $data['apellidos'],
          $data['nombres'],
          $data['nrodocumento'],
          $data['fechanac'],
          $data['telefono']
        )
      );
      
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function search($data = []){
    try{
      $consulta = $this->pdo->prepare("CALL spu_empleados_buscar(?)");
      $consulta->execute(
        array($data['nrodocumento'])
      );

      return $consulta->fetch(PDO::FETCH_ASSOC);
    }
    catch(Exception $e){
      die($e->getMessage());
    }
  }

  public function getResumenSedeEmpleado(){
    try{
      $consulta = $this->pdo->prepare("CALL spu_resumen_sedes()");
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      die($e->getMessage());
    }
  }
}