<?php

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$usuario = "root";
$password = "";
$database = "tienda_juegos";

try {
    $conexion = new mysqli(
        $host,
        $usuario,
        $password,
        $database
    );

    $conexion->set_charset("utf8mb4");

} catch (mysqli_sql_exception $e) {
    error_log("Error de conexión: " . $e->getMessage());

    http_response_code(500);
    exit("Error al conectar con la base de datos.");
}
