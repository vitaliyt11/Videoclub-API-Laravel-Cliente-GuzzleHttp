<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client as GClientVTV;
use DWES06_VTV\VTV_Operaciones as OperacionesVTV;

$cliente = new GClientVTV(
    [
        'base_uri' => 'http://localhost:8000/api/',
        'http_errors' => false,
        'headers' => [
            'Accept' => 'application/json', //Todas las respuestas esperadas son JSON
        ]
    ]
);

if (isset($_POST['listaPeliculas'])) {
    $datos = preg_split('/\r\n|\n|\r/', $_POST['listaPeliculas']);
    $numLinea = 0;
    foreach ($datos as  $linea_str) {
        $linea = str_getcsv($linea_str);
        $numLinea++;
        switch ($linea[0]) {
            case 'CREAR':
                $informe[$numLinea]['resultado'] = OperacionesVTV::VTV_OperacionCrearPelicula($cliente, $linea);
                $informe[$numLinea]['operacion'] = $linea_str;
                break;
            case 'MODIFICAR':
                $informe[$numLinea]['resultado'] = OperacionesVTV::VTV_OperacionModificarArgumento($cliente, $linea);
                $informe[$numLinea]['operacion'] = $linea_str;
                $informe[$numLinea]['caso'] = 'MODIFICAR';
                break;
            case 'BORRAR':
                $informe[$numLinea]['resultado'] = OperacionesVTV::VTV_OperacionBorrarPelicula($cliente, $linea);
                $informe[$numLinea]['operacion'] = $linea_str;
                $informe[$numLinea]['caso'] = 'BORRAR';
                break;
        }
    }
}


//Obtenemos la lista de géneros y películas
$listaDeGeneros = OperacionesVTV::VTV_OperacionObtenerListaDeGeneros($cliente);
$listaDePeliculas = OperacionesVTV::VTV_OperacionListarPelicula($cliente);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DWES06 - Vitaliy Tserkovnyuk Velichko</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <p>Operaciones:</p>
    <form action="index.php" method="post">
        <textarea name="listaPeliculas" cols="100" rows="10"></textarea>
        <br>
        <button type="submit">Enviar</button>
    </form>
    <?php if (isset($informe)) { ?>
        <h2>Informe de Operaciones</h2>
        <?php foreach ($informe as $numLinea => $resultado) { ?>
            <h3>Línea <?php echo $numLinea; ?></h3>
            <p>Operación: <?php echo $resultado['operacion']; ?></p>
            <p>Resultado: </p>
            <?php //var_dump($resultado['resultado']); 
            ?>
            <?php if ((isset($resultado['resultado']['resultado'])) && $resultado['resultado']['resultado'] == 0) { ?>
                <ul>
                    <li>Error al modificar el argumento de la película. El argumento no ha cambiado.</li>
                </ul>
            <?php } elseif ((isset($resultado['resultado']['resultado'])) && $resultado['resultado']['resultado'] == 1) { ?>
                <?php if ($resultado['caso'] == 'MODIFICAR') { ?>
                    <ul>
                        <li>Argumento de la película modificado con éxito.</li>
                    </ul>
                <?php } elseif ($resultado['caso'] == 'BORRAR') { ?>
                    <ul>
                        <li>Película borrada con éxito.</li>
                    </ul>
                <?php } ?>
                <?php } elseif (isset($resultado['resultado']['error'])) {
                foreach ($resultado['resultado']['error'] as $listaErrores) {
                    foreach ($listaErrores as $error) { ?>
                        <ul>
                            <li><?php echo $error; ?></li>
                        </ul>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <p>Película creada con exito con ID: <?php echo $resultado['resultado']; ?>.</p>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    <?php if (!isset($listaDeGeneros['error'])) { ?>
        <?php if (is_string($listaDeGeneros)) { ?>
            <p><?php echo ($listaDeGeneros . " al intentar obtener los géneros") ?></p>
        <?php } else { ?>
            <H1>Lista de Géneros Disponibles</H1>
            <table border="1">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php foreach ($listaDeGeneros as $genero) { ?>
                    <tr>
                        <td><?php echo $genero['id'] ?></td>
                        <td><?php echo $genero['nombre'] ?></td>
                        <td><?php echo $genero['descripcion'] ?></td>
                    </tr>
                <?php } ?>
                </tr>
                </tbody>
            </table>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo ($listaDeGeneros['error'][0][0] . " al intentar obtener los géneros") ?></p>
    <?php } ?>
    <?php if (!isset($listaDePeliculas['error'])) { ?>
        <?php if (is_string($listaDePeliculas)) { ?>
            <p><?php echo ($listaDePeliculas . " al intentar obtener las películas") ?></p>
        <?php } else { ?>
            <table border="1">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>ID Género</th>
                        <th>Duración</th>
                        <th>Año</th>
                        <th>Dirección</th>
                        <th>Argumento</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php foreach ($listaDePeliculas as $pelicula) { ?>
                    <tr>
                        <td><?php echo $pelicula['id'] ?></td>
                        <td><?php echo $pelicula['titulo'] ?></td>
                        <td><?php echo $pelicula['genero'] ?></td>
                        <td><?php echo $pelicula['duracion'] ?></td>
                        <td><?php echo $pelicula['anio'] ?></td>
                        <td><?php echo $pelicula['direccion'] ?></td>
                        <td><?php echo $pelicula['argumento'] ?></td>
                    </tr>
                <?php } ?>
                </tr>
                </tbody>
            </table>
        <?php } ?>
    <?php } else { ?>
        <p><?php echo ($listaDePeliculas['error'][0][0] . " al intentar obtener las películas") ?></p>
    <?php } ?>
</body>

</html>