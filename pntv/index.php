

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Punto de ventas</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajuste de las imágenes en el carrusel */
        .carousel-inner img {
            height: 500px; /* Altura fija */
            object-fit: cover; /* Asegura ajuste sin deformación */
        }

        .carousel-caption {
            background: rgba(0, 0, 0, 0.5); /* Fondo semi-transparente */
            border-radius: 10px; /* Bordes redondeados */
            padding: 10px;
        }
    </style>
</head>
<body>

<!-- Carrusel -->
<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="https://laptopmedia.com/wp-content/uploads/2021/08/Untitled.png" class="d-block w-100" alt="First Slide">
      <div class="carousel-caption d-none d-md-block">
        <h5>Asus tuf gaming f15</h5>
        <p>Computadora de una buena gama para trabajos fuertes y aplicaciones de alto rendimiento.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://sharpi.in/wp-content/uploads/2022/05/hp-banner.jpg" class="d-block w-100" alt="Second Slide">
      <div class="carousel-caption d-none d-md-block">
        <h5> Laptop hp </h5>
        <p> Laptop de 15 pulgadas, 8gb ram, 256gb ssd.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="https://www.compraderas.com.bo/wp-content/uploads/2017/11/samsung-qled-monitor.jpg.webp" class="d-block w-100" alt="Third Slide">
      <div class="carousel-caption d-none d-md-block">
        <h5> Monitor samsung </h5>
        <p>Monitor led de 24 pulgadas.</p>
      </div>
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<!-- Botones -->
<div class="d-flex flex-wrap justify-content-center gap-2 mt-4">
    <a href="ventas.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Venta</a>
    <a href="mostrar_productos.php" class="btn btn-danger btn-lg shadow-sm px-5 py-2">Productos</a>
    <a href="mostrar_empleados.php" class="btn btn-success btn-lg shadow-sm px-5 py-2">Empleados</a>
    <a href="mostrar_proveedores.php" class="btn btn-warning btn-lg shadow-sm px-5 py-2 text-white">Proveedores</a>
    <a href="mostrar_cliente.php" class="btn btn-info btn-lg shadow-sm px-5 py-2 text-white">Clientes</a>
    <a href="contactar_proveedores.php" class="btn btn-primary btn-lg shadow-sm px-5 py-2">Compra</a>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
