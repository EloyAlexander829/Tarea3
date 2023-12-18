<!doctype html>
<html lang="es">
    <head>
        <title>Buscador Empleado</title>
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
        <h1 class="text-center">Buscar Empleado</h1>
        <div class="container">
            <div class="card mt-2">
                <div class="card-body">
                    
                    <form action="" id="formBusquedaE" autocomplete="off">

                        <div class="card-header bg-secondary">
                            <input type="text" maxlength="8" placeholder="Pon el Número de Documento" id="nrodocumento" class="form-control text-center">
                            <br>
                            <button type="button" class="btn btn-info" id="buscar">Buscar:</button>
                        </div>
                        <small id="status">No hay Búsquedas Activas</small>

                        <div class="mb-3">
                            <label for="sede">Sede: </label>
                            <input type="text" id="sede" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="apellidos">Apellidos: </label>
                            <input type="text" id="apellidos" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="nombres">Nombres: </label>
                            <input type="text" id="nombres" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="fechanac">Fecha de Nacimiento: </label>
                            <input type="text" id="fechanac" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="telefono">Teléfono: </label>
                            <input type="text" id="telefono" class="form-control" readonly>
                        </div>

                    </form>
                    <button class="btn btn-success" id="volver" onclick="redirectToFile('mostrar-empleados.php');" type="submit">Volver</button>
                </div>
                </div>
            </div>
        </div>

        <script>
      document.addEventListener("DOMContentLoaded", () => {

        function $(id) {return document.querySelector(id)}

        function buscarNrod(){
          const nrodocumento = $("#nrodocumento").value

          if (nrodocumento != ""){
            const parametros  = new FormData()
            parametros.append("operacion", "search")
            parametros.append("nrodocumento", nrodocumento)
            
            $("#status").innerHTML = "Buscando, por favor espere.." 

            fetch(`../controllers/Empleado.controller.php`, {
              method: "POST",
              body: parametros
            })
              .then(respuesta => respuesta.json())
              .then(datos => {
                if (!datos){
                  $("#status").innerHTML = "No se encontró el registro"
                  $("#formBusquedaE").reset()
                  $("#nrodocumento").focus()
                }else{
                  $("#status").innerHTML = "Empleado encontrado"
                  $("#sede").value = datos.sede
                  $("#apellidos").value = datos.apellidos
                  $("#nombres").value = datos.nombres
                  $("#fechanac").value = datos.fechanac
                  $("#telefono").value = datos.telefono
                }
              })
              .catch(e => {
                console.error(e)
              })
          }
        }

        $("#nrodocumento").addEventListener("keypress", (event) => {
          if (event.keyCode == 13){
            buscarNrod()
          }
        })

        $("#buscar").addEventListener("click", buscarNrod)

      })

      function redirectToFile(file) {
        window.location.href = file;
      }
    </script>

    </body>
</html>
