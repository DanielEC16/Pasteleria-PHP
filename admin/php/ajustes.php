<form  method="POST" action="../../admin/php/peticiones_admin.php" enctype="multipart/form-data">
    <label for="">Nombre</label>
    <input type="text" name="nombre" required>
    <label for="">Apellido</label>
    <input type="text" name="apellido" required>
    <label for="">Correo</label>
    <input type="text" name="correo">
    <label for="">contraseña</label>
    <input type="password" name="password">
    <button type="submit" name="proceso" value="agregarAdmin">Agregar</button>
</form>

<?php

include '../../admin/php/peticiones_admin.php';
mostrarAdmins($conn);
?>