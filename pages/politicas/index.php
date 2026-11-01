<?php require_once __DIR__ . '/../../config/base_url.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Políticas de privacidad</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/styles.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/pages/politicas/styles.css">
</head>
<body>
<?php include_once(__DIR__ . '/../../components/header/index.php'); ?>
    <main class="politicas">
        <h1>Políticas de Privacidad</h1>
        <p>Bienvenido a nuestra tienda online de videojuegos. Estas políticas de privacidad describen cómo recopilamos, usamos y protegemos la información de quienes visitan el sitio.</p>

        <h2>1. Información que recopilamos</h2>
        <p>Recopilamos únicamente los datos necesarios para el funcionamiento de la tienda: la información de los productos que administra el equipo de la tienda (nombre, descripción, precio, stock, categoría e imagen) y los datos técnicos básicos de navegación, como el tipo de navegador y la dirección IP, que el servidor registra de forma automática.</p>

        <h2>2. Uso de la información</h2>
        <p>La información se utiliza para:</p>
        <ul>
            <li>Mostrar el catálogo de juegos y permitir buscarlo y filtrarlo.</li>
            <li>Administrar el inventario y los precios desde el panel de administración.</li>
            <li>Mejorar el funcionamiento y la seguridad del sitio.</li>
        </ul>

        <h2>3. Cookies y sesiones</h2>
        <p>Usamos cookies para recordar preferencias de navegación, como la última categoría consultada, y sesiones temporales para mostrar mensajes de confirmación después de una acción. Estas cookies no contienen datos personales y puede eliminarlas en cualquier momento desde la configuración de su navegador.</p>

        <h2>4. Compartir información con terceros</h2>
        <p>No vendemos, alquilamos ni cedemos información a terceros. Solo podríamos divulgarla si una autoridad competente lo exigiera conforme a la ley.</p>

        <h2>5. Seguridad</h2>
        <p>Aplicamos medidas técnicas para proteger la información: las consultas a la base de datos son parametrizadas para evitar inyecciones SQL, y todo el contenido que se muestra en pantalla se sanitiza para prevenir ataques XSS. Ningún sistema es completamente invulnerable, pero trabajamos para reducir los riesgos.</p>

        <h2>6. Sus derechos</h2>
        <p>Usted puede solicitar el acceso, la rectificación o la eliminación de cualquier dato personal que tengamos sobre usted, conforme a la Ley 25.326 de Protección de los Datos Personales de la República Argentina.</p>

        <h2>7. Cambios en estas políticas</h2>
        <p>Podemos actualizar estas políticas en cualquier momento. La fecha de la última actualización figura al comienzo de esta página, y le recomendamos revisarla periódicamente.</p>

        <h2>8. Contacto</h2>
        <p>Si tiene consultas sobre estas políticas, puede escribirnos a <strong>contacto@gamestore.com</strong>.</p>
    </main>
<?php include_once(__DIR__ . '/../../components/footer/index.php'); ?>
</body>
</html>