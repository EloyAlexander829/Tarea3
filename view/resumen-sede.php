<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <!-- Bootstrap CSS v5.2.1 -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
    crossorigin="anonymous"
    />
</head>
<body>
<style>
        #lienzo{
            position: absolute;
            width: 80vh;
            height: 40vh;
        }
    </style>

  <h1>Buscar Empleado</h1><button class="btn btn-success" id="volver" onclick="redirectToFile('mostrar-empleados.php');" type="submit">Volver</button>
  
  <div style="width: 70%; margin: auto;">
    <canvas id="lienzo"></canvas>
  </div>
  <!-- CDN de chart -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    const contexto = document.querySelector("#lienzo")
    const grafico = new Chart(contexto, {
      type: 'bar',
      data: {
        labels: ["Chincha", "Ica", "Ayacucho", "Lima", "Piura"],
        datasets: [{
          label: "Sedes",
          data: []
        }]
      }
    });

    (function (){
      fetch(`../controllers/Empleado.controller.php?operacion=getResumenSedeEmpleado`)
        .then(respuesta => respuesta.json())
        .then(datos => {
          console.log(datos) 
          grafico.data.labels = datos.map(registro => registro.idsede)
          grafico.data.datasets[0].data = datos.map(registro => registro.Total)
          grafico.update()
        })
        .catch(e => {
          console.error(e)
        })
    })();

    function redirectToFile(file) {
        window.location.href = file;
     }
  </script>

</body>
</html>