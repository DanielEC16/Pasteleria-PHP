<form method="POST" action="../../admin/php/peticiones_admin.php" enctype="multipart/form-data">
    <label for="">Nombre</label>
    <input type="text" name="nombre">
    <label for="">Descripcion</label>
    <input type="text" name="descripcion">
    <label for="">Precio</label>
    <input type="number" name="precio">
    <label for="">Stock</label>
    <input type="number" name="stock">
    <label for="">Categoria</label>
    <input type="text" name="categoria">
    <label for="">Imagen</label>
    <input type="file" name="imagen">
    <button type="submit" name="proceso" value="agregarProd">Agregar Producto</button>
</form>
<?php

include '../../admin/php/peticiones_admin.php';
mostrarProductos($conn);
?>