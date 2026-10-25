<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Inicio</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/parcial2-programacion-web-2/styles.css">
    </head>
    
    
    <?php 
    $resultado_juegos = [
        [
            "nombre" => "Bongo Cat",
            "descripcion" => "Bongo cat necesita tu ayuda. ¡Bongo cat necesita más gorros! Cada vez que pulses una tecla, Bongo cat dará un puñetazo a tu barra de tareas. Escribe, haz clic, juega y trabaja para conseguir más puntos. ¿Qué gorros encontrarás?",
            "imagen" => "/parcial2-programacion-web-2/assets/bongo_cat.jpg"
        ],
        [
            "nombre" => "Lego Batman",
            "descripcion" => "Renace como el Caballero Oscuro y vive la historia de Batman en una atrevida aventura llena de acción y combates rompedores que se desarrolla en el mundo abierto de Gotham City, todo ello con el humor característico de LEGO que tanto gusta a los fans.",
            "imagen" => "/parcial2-programacion-web-2/assets/lego_batman.jpg"
        ],
        [
            "nombre" => "EA Sports FC 27",
            "descripcion" => "Te damos la bienvenida a The World's Game en EA SPORTS FC™ 27. Adéntrate en The Grounds, un espacio de juego donde las calles se encuentran con el estadio, y siente un mayor control en cada modo, ya que las innovaciones impulsadas por la comunidad ofrecen una jugabilidad más fiel al fútbol.",
            "imagen" => "/parcial2-programacion-web-2/assets/ea_sports.jpg"
        ]
    ];

    ?>    
    <body>
        <?php include_once("components/header/index.php"); ?>

    <main> 
        <section>
            <img src="/parcial2-programacion-web-2/assets/banner.png" alt="Banner" width="100%" height="100%">
        </section>

        <section> 

        <h2 class="titulo-juegos">Juegos destacados</h2>
        <?php foreach ($resultado_juegos as $juego): ?>

        <?php include_once("components/juegos-card/index.php"); ?>
        
            <?php endforeach; ?>
        </section>

    </main>
                        <?php include_once("components/footer/index.php"); ?>

</body>
</html>



