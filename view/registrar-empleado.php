<!doctype html>
<html lang="en">
  <head>
    <title>Registrar de Empleados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
  </head>
  <body>
    <h1 class="text-center">Registrar Empleado</h1>
    <div class="container">
      <div class="alert alert-info mt-3">
        <h5>Registro de Empleados</h5>
        <span>Completa la Información que se le pide</span>
      </div>
      
      <div class="card mt-2">
        <div class="card-body">
          <form action="" id="formEmpleado" autocomplete="off">

            <div class="mb-3">
              <label for="sede">Sede:</label>
              <select name="sede" id="sede" class="form-select" required>
                <option value="">Seleccione</option>
              </select>
            </div>

            <div class="mb-3">
              <label for="apellidos">Apellidos: </label>
              <input type="text" id="apellidos" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="nombres">Nombres: </label>
              <input type="text" id="nombres" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="nrodocumento">Número de Documento: </label>
              <input type="number" maxlength="8" id="nrodocumento" class="form-control" required>
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="fechanac">Fecha de Nacimiento: </label>
                <input type="date" id="fechanac" class="form-control" required>
              </div>
            
              <div class="col-md-5 mb-3">
                <label for="telefono">Télefono: </label>
                <input type="number" id="telefono" class="form-control text-center" required>
              </div>
            </div>

            <div class="mb-3">
              <button class="btn btn-primary" id="guardar" type="submit">Guardar Datos</button>
              <button class="btn btn-secondary" type="reset">Cancelar</button>
            </div>
          </form>
          <button class="btn btn-success" id="volver" onclick="redirectToFile('mostrar-empleados.php');" type="submit">Volver</button>
        </div>
      </div>
    </div>

    <script>
      document.addEventListener("DOMContentLoaded", () => {

        function $(id) {return document.querySelector(id)}

        (function () {
          fetch(`../controllers/Sede.controller.php?operacion=listar`,{})
            .then(respuesta => respuesta.json())
            .then(datos => {
 
              datos.forEach(element => {
                const tagOption = document.createElement("option")
                tagOption.value = element.idsede
                tagOption.innerHTML = element.sede
                $("#sede").appendChild(tagOption)
              });

            })
            .catch(e => {
              console.error(e)
            })
        })();

        $("#formEmpleado").addEventListener("submit", (event) => {
          event.preventDefault();

          if (confirm("¿Desea Registrar este Empleado?")){
            const parametros = new FormData()
            parametros.append("operacion", "add") 

            parametros.append("idsede",       $("#sede").value)
            parametros.append("apellidos",    $("#apellidos").value)
            parametros.append("nombres",      $("#nombres").value)
            parametros.append("nrodocumento", $("#nrodocumento").value)
            parametros.append("fechanac",     $("#fechanac").value)
            parametros.append("telefono",     $("#telefono").value)
            
            fetch(`../controllers/Empleado.controller.php`, {
              method: "POST",
              body: parametros
            })
              .then(respuesta => respuesta.json())
              .then(datos => {
                alert("Empleado Registrado")
                if(datos.idempleado > 0){
                  $("#formEmpleado").reset()
                  alert(`Empleado registrado con ID: ${datos.idempleado}`)
                }
              })
              .catch(error => {
                alert("No se pudo")
                 console.error('Error en la solicitud fetch:', error);
                });
          }
        })
      })

      function redirectToFile(file) {
          window.location.href = file;
        }
    </script>

  </body>
</html>
