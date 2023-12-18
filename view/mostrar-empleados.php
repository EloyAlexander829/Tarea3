<!doctype html>
<html lang="es">
    <head>
        <title>Mostrar Empleados</title>
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
        <div class="container">
        <h1 class="text-center">Mostrar Empleados</h1>
            <div class="card mt-2">
                <div class="card-body table-responsive overflow-auto"">
                    <table class="table caption-top">
                        <caption>Lista de Empleados</caption>
                        <thead class="table-info">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Sede</th>
                                <th scope="col">Apellidos</th>
                                <th scope="col">Nombres</th>
                                <th scope="col">Nº Documento</th>
                                <th scope="col">Fecha de Nacimiento</th>
                                <th scope="col">Telefono</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Todos los registros de la Base de Datos -->
                            <?php include_once("../models/listar.php");?>
                            <?php foreach($empleados as $empleado){?>

                                <tr>
                                    <td class="text-nowrap"> <?php echo $empleado->idempleado ?></td>
                                    <td class="text-nowrap"> <?php echo $empleado->sede ?></td>
                                    <td class="text-nowrap"> <?php echo $empleado->apellidos ?></td>
                                    <td class="text-nowrap"> <?php echo $empleado->nombres ?></td>
                                    <td class="text-nowrap"> <?php echo $empleado->nrodocumento ?></td>
                                    <td class="text-nowrap"> <?php echo $empleado->fechanac ?></td>
                                    <td class="text-nowrap"> <?php echo $empleado->telefono ?></td>
                                </tr>

                            <?php  }?>
                        </tbody>
                    </table>
                    <button class="btn btn-primary" id="buscar" onclick="redirectToFile('busca-empleado.php');" type="submit">Buscar Empleado</button>
                    <button class="btn btn-secondary" id="registrar" onclick="redirectToFile('registrar-empleado.php');" type="submit">Registrar Empleado</button>
                    <button class="btn btn-success" id="grafico" onclick="redirectToFile('resumen-sede.php');" type="submit">Grafico Empleado</button>
                </div>
            </div>
        </div>
    </body>
    <script>
    function redirectToFile(file) {
        window.location.href = file;
    }
    </script>
</html>

