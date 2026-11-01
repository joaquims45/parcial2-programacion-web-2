<?php

define('BASE_URL', '/parcial2-programacion-web-2');

function url_imagen(?string $imagen): string
{
    $imagen = trim((string) $imagen);

    if (preg_match('#^https?://#i', $imagen)) {
        return $imagen;
    }

    return BASE_URL . '/' . ltrim($imagen, '/');
}
