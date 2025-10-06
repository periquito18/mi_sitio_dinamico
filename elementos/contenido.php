<?php
// Estructura asociativa: producto => precio
$productos = [
  "Pan de Camas"        => 1.20,
  "Aceitunas aliñadas"  => 2.50,
  "Tortas de aceite"    => 3.00,
  "Vino Blanco"         => 3.50
];
?>

<h2 class="text-success text-center mt-4">Productos locales de Camas</h2>

<table class="table table-bordered table-striped w-75 mx-auto mt-4 text-center align-middle">
  <thead class="table-primary">
    <tr>
      <th>Producto</th>
      <th>Precio (€)</th>
    </tr>
  </thead>
  <tbody>
    <?php
      // Obtenemos las claves (nombres de productos)
      $claves = array_keys($productos);
      // Recorremos las claves para acceder a los valores (precios)
      for ($i = 0; $i < count($claves); $i++): 
      $nombre = $claves[$i];
      $precio = $productos[$nombre];
      ?>
      <tr>
        <td><?= htmlspecialchars($nombre) ?></td>
        <td><?= number_format($precio, 2, ',', '.') ?></td>
      </tr>
    <?php endfor; ?>
  </tbody>
</table>
